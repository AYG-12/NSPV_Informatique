@php
    $title = 'Produits';
    $defaultSortMap = ['latest' => 'default', 'price_asc' => 'price-asc', 'popular' => 'default'];
    $jsSortDefault  = $defaultSortMap[$appSettings['default_sort'] ?? 'latest'] ?? 'default';
@endphp

@extends('layouts.guest')


@section('content')
    <!-- Appel de la barre de navigation -->
    @include('Shop.partials._navbar')
    
    <main class="content-product">

        <div class="pag">
            <aside>
                <!-- Categories -->
                <div class="filter-block">
                    <div class="sidebar-label">Catégorie</div>

                    <div class="cat-list" id="cat-list">
                        <button class="cat-btn active" data-cat="all">
                            Tout <span class="cat-count" id="count-all">0</span>
                        </button>

                        @foreach($categories as $cat)
                            <button class="cat-btn" data-cat="{{ $cat->slug }}">
                                {{ $cat->name }} <span class="cat-count" id="count-{{ $cat->slug }}">0</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Price -->
                <div class="filter-block">
                    <div class="sidebar-label">Prix</div>
                    <div class="price-range-display" id="price-display">0 F CFA — ∞</div>
                    <div class="range-inputs">
                        <div class="range-input-wrap">
                            <label>MIN</label>
                            <input type="number" id="pmin" placeholder="0" min="0">
                        </div>
                        <div class="range-input-wrap">
                            <label>MAX</label>
                            <input type="number" id="pmax" placeholder="999" min="0">
                        </div>
                    </div>
                </div>

                <button class="reset" onclick="resetAll()">// RESET FILTRES</button>
            </aside>

            <div class="products-section">
                <div class="section-header">
                    <div class="section-title">
                        TOUS LES<br><span>PRODUITS</span>
                    </div>

                    <div class="meta-info">
                        <div class="count-big" id="count-display">0</div>
                        <div class="count-label">RÉSULTATS</div>
                    </div>
                </div>

                <div class="toolbar">
                    <span class="toolbar-label">TRIER :</span>
                    <button class="sort-btn {{ $jsSortDefault === 'default' ? 'active' : '' }}" data-sort="default">DÉFAUT</button>
                    <button class="sort-btn {{ $jsSortDefault === 'price-asc' ? 'active' : '' }}" data-sort="price-asc">PRIX ↑</button>
                    <button class="sort-btn" data-sort="price-desc">PRIX ↓</button>
                    <button class="sort-btn" data-sort="name">A–Z</button>
                </div>

                <div class="grid" id="grid"></div>
                <div style="text-align:center;margin-top:24px">
                    <button id="load-more-btn" style="display:none;background:transparent;border:1px solid var(--border,#2a2a2a);color:var(--fg,#fff);padding:10px 32px;border-radius:8px;font-size:13px;cursor:pointer;letter-spacing:.05em"
                            onmouseover="this.style.borderColor='var(--accent,#e8ff47)'"
                            onmouseout="this.style.borderColor='var(--border,#2a2a2a)'"
                            onclick="currentPage++;render()">Voir plus</button>
                </div>
            </div>
        </div>

        {{-- <div class="status-bar">
            <div class="status-item">
                <div class="dot-live"></div> EN LIGNE
            </div>
            <div class="status-item">STOCK TEMPS RÉEL</div>
            <div class="status-item">MISE À JOUR : AUJOURD'HUI</div>
        </div> --}}
    </main>

    <script>
        // Données réelles injectées depuis la base de données
        @php
            $productsJson = $products->map(fn($p) => [
                'id'       => $p->id,
                'name'     => $p->name,
                'slug'     => $p->slug,
                'brand'    => $p->category->name,
                'category' => $p->category->slug,
                'price'    => (float) ($p->sale_price ?? $p->price),
                'badge'    => $p->sale_price ? 'PROMO' : ($p->is_featured ? 'VEDETTE' : ''),
                'image'    => $p->image ? asset('storage/' . $p->image) : null,
                'type'     => $p->type,
                'inStock'     => $p->isInStock(),
                'url'         => route('shop.fiche', $p->slug),
                'maxRating'   => (int) $p->reviews->where('is_approved', true)->max('rating'),
                'reviewCount' => $p->reviews->where('is_approved', true)->count(),
            ]);
        @endphp
        const products = @json($productsJson);
        const wishlistIds = new Set(@json($wishlistProductIds ?? []));
        const isLoggedIn  = {{ auth()->check() ? 'true' : 'false' }};
        const csrfToken   = document.querySelector('meta[name="csrf-token"]').content;

        const categorySlugMap = @json($categories->pluck('name', 'slug'));
        const perPage = {{ (int)($appSettings['products_per_page'] ?? 24) }};

        const allBrands = [...new Set(products.map(p => p.brand))].sort();
        let selCat     = 'all';
        let pMin       = 0, pMax = Infinity;
        let sortMode   = '{{ $jsSortDefault }}';
        let currentPage = 1;

        function updateCounts(data) {
            document.getElementById('count-all').textContent = data.length;
            @foreach($categories as $cat)
            const el_{{ Str::camel($cat->slug) }} = document.getElementById('count-{{ $cat->slug }}');
            if (el_{{ Str::camel($cat->slug) }}) {
                el_{{ Str::camel($cat->slug) }}.textContent = data.filter(p => p.category === '{{ $cat->slug }}').length;
            }
            @endforeach
        }

        document.querySelectorAll('.cat-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.cat-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                selCat = btn.dataset.cat;
                currentPage = 1;
                render();
            });
        });

        document.getElementById('pmin').addEventListener('input', e => { pMin = parseFloat(e.target.value) || 0; updatePriceDisplay(); currentPage = 1; render(); });
        document.getElementById('pmax').addEventListener('input', e => { pMax = parseFloat(e.target.value) || Infinity; updatePriceDisplay(); currentPage = 1; render(); });

        function updatePriceDisplay() {
            document.getElementById('price-display').textContent =
                `${pMin.toLocaleString('fr')} F CFA — ${pMax === Infinity ? '∞' : pMax.toLocaleString('fr') + ' F CFA'}`;
        }

        document.querySelectorAll('.sort-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.sort-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                sortMode = btn.dataset.sort;
                currentPage = 1;
                render();
            });
        });

        function getFiltered() {
            return products.filter(p => {
                if (selCat !== 'all' && p.category !== selCat) return false;
                if (p.price < pMin) return false;
                if (pMax !== Infinity && p.price > pMax) return false;
                return true;
            });
        }

        function getSorted(arr) {
            const a = [...arr];
            if (sortMode === 'price-asc')  return a.sort((x, y) => x.price - y.price);
            if (sortMode === 'price-desc') return a.sort((x, y) => y.price - x.price);
            if (sortMode === 'name')       return a.sort((x, y) => x.name.localeCompare(y.name));
            return a;
        }

        function render() {
            const filtered = getFiltered();
            const sorted   = getSorted(filtered);
            updateCounts(filtered);
            document.getElementById('count-display').textContent = sorted.length;

            const grid    = document.getElementById('grid');
            const moreBtn = document.getElementById('load-more-btn');

            if (sorted.length === 0) {
                grid.innerHTML = `<div class="empty">
                    <div class="empty-code">ERROR_404</div>
                    <div class="empty-msg">AUCUN RÉSULTAT</div>
                    <div class="empty-sub">Modifiez vos filtres pour afficher des produits.</div>
                </div>`;
                moreBtn.style.display = 'none';
                return;
            }

            const visible = sorted.slice(0, currentPage * perPage);
            moreBtn.style.display = visible.length < sorted.length ? 'block' : 'none';

            @php $wishlistEnabled = ($appSettings['wishlist_enabled'] ?? '1') === '1'; @endphp
            const wishlistEnabled = {{ $wishlistEnabled ? 'true' : 'false' }};
            const toggleUrl = '/Shop/favoris/{id}/toggle';

            grid.innerHTML = visible.map((p, i) => {
                const inWL     = wishlistIds.has(p.id);
                const heartFill = inWL ? 'currentColor' : 'none';
                const heartBtn = wishlistEnabled
                    ? (isLoggedIn
                        ? `<button class="btn_favoris${inWL ? ' in-wishlist' : ''}" data-id="${p.id}"
                                   data-url="/Shop/favoris/${p.id}/toggle"
                                   title="${inWL ? 'Retirer des favoris' : 'Ajouter aux favoris'}"
                                   onclick="toggleWishlistGrid(event, ${p.id})">
                               <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="${heartFill}" stroke="currentColor" stroke-width="2">
                                   <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                               </svg>
                           </button>`
                        : `<a href="{{ route('connexion') }}" class="btn_favoris" title="Connectez-vous">
                               <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                   <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                               </svg>
                           </a>`)
                    : '';
                return `
                <div class="prod" style="animation-delay:${i * 0.04}s">
                    <div class="img_prod">
                        ${p.image
                            ? `<img style="width:100%;height:100%;object-fit:cover;" src="${p.image}" alt="${p.name}">`
                            : `<img style="width:100%;height:100%;object-fit:cover;"  src="{{ Vite::asset('resources/images/background.jpeg') }}" alt="${p.name}">`
                            
                        }
                    </div>
                    <div class="prod_info">
                        <h3>${p.name}</h3>
                        <p>${p.brand}</p>
                        <div class="star_price">
                            <div class="prix_prod">
                                <h4>${p.price.toLocaleString('fr')} FCFA</h4>
                            </div>
                            <div class="star">
                                ${p.maxRating ? `<a href="${p.url}#avis-clients" style="display:inline-flex;align-items:center;gap:1px;text-decoration:none">
                                    ${Array.from({length:5},(_,i)=>`<span style="font-size:23px;color:${i<p.maxRating?'#fff700':'#444'};line-height:1">★</span>`).join('')}
                                </a>` : ''}
                            </div>
                        </div>
                        <a href="${p.url}" class="btn">Voir le produit</a>
                        ${heartBtn}
                    </div>
                </div>`;
            }).join('');
        }

        const DEFAULT_SORT = '{{ $jsSortDefault }}';

        function resetAll() {
            selCat      = 'all';
            pMin        = 0;
            pMax        = Infinity;
            sortMode    = DEFAULT_SORT;
            currentPage = 1;
            document.querySelectorAll('.cat-btn').forEach((b, i) => b.classList.toggle('active', i === 0));
            document.querySelectorAll('.sort-btn').forEach(b => b.classList.toggle('active', b.dataset.sort === DEFAULT_SORT));
            document.getElementById('pmin').value = '';
            document.getElementById('pmax').value = '';
            document.getElementById('price-display').textContent = '0 F CFA — ∞';
            render();
        }

        resetAll();

        async function toggleWishlistGrid(e, productId) {
            e.preventDefault();
            const btn = e.currentTarget;
            const url = btn.dataset.url;
            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                });
                const data = await res.json();
                const svg = btn.querySelector('svg');
                if (data.in_wishlist) {
                    wishlistIds.add(productId);
                    svg.setAttribute('fill', 'currentColor');
                    btn.classList.add('in-wishlist');
                    btn.title = 'Retirer des favoris';
                } else {
                    wishlistIds.delete(productId);
                    svg.setAttribute('fill', 'none');
                    btn.classList.remove('in-wishlist');
                    btn.title = 'Ajouter aux favoris';
                }
                const badge = document.getElementById('wishlist-count');
                if (badge) { badge.textContent = data.count; badge.style.display = data.count > 0 ? 'flex' : 'none'; }
            } catch (e) { window.location.href = '{{ route("connexion") }}'; }
        }
    </script>
@endsection
