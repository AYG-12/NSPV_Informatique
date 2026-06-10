@php $title = $product->name; @endphp

@extends('layouts.guest')


@section('content')
    @include('Shop.partials._navbar')
    
    <main class="content-main">
        <div class="container">
            <div class="img_squares">
                <div class="img_squa_top">
                    @if($product->image)
                        <img id="imageBox" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <img id="imageBox" src="{{ Vite::asset('resources/images/background.jpeg') }}" alt="{{ $product->name }}">
                    @endif
                </div>

                <div class="img_square">
                    {{-- @if($product->image)
                        <div class="im_square"><img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" onclick="myFunction(this)"></div>
                    @else
                        <div class="im_square"><img src="{{ Vite::asset('resources/images/slide.jpeg') }}" alt="" onclick="myFunction(this)"></div>
                    @endif --}}
                    @foreach($product->images->take(3) as $img)
                        <div class="im_square"><img src="{{ asset('storage/' . $img->path) }}" alt="{{ $product->name }}" onclick="myFunction(this)"></div>
                    @endforeach
                </div>
            </div>

            <div class="info_fiche_produit">
                <h3>{{ $product->category->name }}</h3>
                <h1>{{ $product->name }}</h1>

                @php
                    $approvedReviews = $product->reviews->where('is_approved', true);
                    $maxRating       = $approvedReviews->max('rating');
                    $reviewCount     = $approvedReviews->count();
                @endphp
                @if($maxRating)
                <div style="display:flex;align-items:center;gap:12px;margin:6px 0 14px;flex-wrap:wrap">
                    <a href="#avis-clients" style="display:inline-flex;align-items:center;gap:5px;text-decoration:none">
                        @for($i = 1; $i <= 5; $i++)
                        <span style="font-size:20px;color:{{ $i <= $maxRating ? '#fff700' : '#444' }};line-height:1">★</span>
                        @endfor
                        <span style="font-size:13px;color:var(--muted,#888);margin-left:2px">
                            {{ $maxRating }}/5
                            <span style="margin-left:4px">({{ $reviewCount }} avis)</span>
                        </span>
                    </a>
                    <a href="{{ route('shop.produit.avis', $product->slug) }}"
                       style="font-size:12px;color:var(--accent,#e8ff47);text-decoration:none;border:1px solid rgba(232,255,71,.3);padding:3px 10px;border-radius:20px;transition:background .2s"
                       onmouseover="this.style.background='rgba(232,255,71,.1)'"
                       onmouseout="this.style.background='transparent'">
                        Voir tous les avis →
                    </a>
                </div>
                @endif

                @if($product->sale_price)
                    <p class="font-bold"><span>{{ number_format($product->sale_price, 0, ',', ' ') }}</span> F CFA
                        <small style="text-decoration:line-through;opacity:.5;margin-left:8px">{{ number_format($product->price, 0, ',', ' ') }} F CFA</small>
                    </p>
                @else
                    <p><span>{{ number_format($product->price, 0, ',', ' ') }}</span> F CFA</p>
                @endif

                @if($product->type === 'service')
                    <p>Type : <span>Service</span></p>
                @elseif(($appSettings['show_stock'] ?? '1') === '1')
                    @if($product->stock === null)
                        <p>Stock disponible : <span>Illimité</span></p>
                    @elseif($product->stock > 0)
                        <p>Stock disponible : 
                            @if($product->stock <= 5)
                                <span style="color:var(--danger,#ff4757);font-weight:600">{{ $product->stock }}</span>
                            @else
                                <span style="color: #2dcc7f; font-weight:600;">{{ $product->stock }}</span>
                            @endif
                        </p>
                    @else
                        <p style="color:var(--danger,#ff4757)">Rupture de stock</p>
                    @endif
                @else
                    @if($product->stock !== null && $product->stock <= 0)
                        <p style="color:var(--danger,#ff4757)">Rupture de stock</p>
                    @endif
                @endif

                <div style="margin-top: 15px;" class="flex justify-center gap-4 items-center">
                
                    @if(auth()->check())
                        @if($product->type === 'service' || $product->stock === null || $product->stock > 0)
                            <form method="POST" action="{{ route('shop.cart.add') }}" style="display:inline">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn cursor-pointer" style="margin-left: -120px">Ajouter au panier</button>
                            </form>

                            @if(($appSettings['wishlist_enabled'] ?? '1') === '1')
                                @php $inWishlist = in_array($product->id, $wishlistProductIds ?? []); @endphp
                                <button class="btn_favoris {{ $inWishlist ? 'in-wishlist' : '' }}" id="fiche-wishlist-btn" title="{{ $inWishlist ? 'Retirer des favoris' : 'Ajouter aux favoris' }}" onclick="toggleWishlistFiche({{ $product->id }}, '{{ route('shop.wishlist.toggle', $product) }}', this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ $inWishlist ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                    </svg>
                                </button>
                            @endif
                        @else
                            <button disabled style="opacity:.5;cursor:not-allowed; color: #ff0000; font-weight: bold;">Rupture de stock</button>
                        @endif

                        
                    @else
                        <a href="{{ route('connexion') }}" style="padding: 4px 13px; transition: background-color 0.5s;" class="text-white font-bold bg-red-500 hover:bg-red-600 rounded-2xl">Se connecter pour commander</a>
                    @endif
                </div>

                @if($product->short_description)
                <div class="descrip" style="margin-top:16px">
                    <p>{{ $product->short_description }}</p>
                </div>
                @endif

                @if($product->description)
                <div class="descrip">
                    <h2>Description</h2>
                    <p>{{ $product->description }}</p>
                </div>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div style="max-width:700px;margin:16px auto;background:rgba(45,204,127,.15);border:1px solid #2dcc7f;color:#2dcc7f;padding:10px 16px;border-radius:8px;font-size:13px;">
                {{ session('success') }}
            </div>
        @endif

        {{-- Section avis clients (affichée selon le paramètre show_reviews) --}}
        @if(($appSettings['show_reviews'] ?? '1') === '1')
        @php $approvedReviews = $product->reviews->where('is_approved', true); @endphp
        <div id="avis-clients" style="max-width:900px;margin:32px auto;border-top:1px solid var(--border,#2a2a2a);padding-top:28px">
            <h2 style="font-size:16px;font-weight:700;margin-bottom:4px">
                Avis clients
                <span style="font-size:13px;font-weight:400;color:var(--muted,#888);margin-left:6px">({{ $approvedReviews->count() }})</span>
            </h2>
            @if($approvedReviews->isEmpty())
                <p style="color:var(--muted,#888);font-size:13px;margin-top:12px">Aucun avis pour ce produit.</p>
            @else
                <div style="display:flex;flex-direction:column;gap:16px;margin-top:16px">
                @foreach($approvedReviews as $review)
                <div style="border:1px solid var(--border,#2a2a2a);border-radius:10px;padding:14px 16px">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px">
                        <span style="font-weight:600;font-size:13px">{{ $review->user->name ?? 'Client' }}</span>
                        <span style="font-size:12px;color:var(--muted,#888)">{{ $review->created_at->format('d M Y') }}</span>
                    </div>
                    @if($review->rating)
                    <div style="color:var(--accent,#e8ff47);font-size:14px;letter-spacing:2px;margin-bottom:6px">
                        @for($i = 1; $i <= 5; $i++){{ $i <= $review->rating ? '★' : '☆' }}@endfor
                        <span style="font-size:12px;color:var(--muted,#888);margin-left:4px">{{ $review->rating }}/5</span>
                    </div>
                    @endif
                    @if($review->comment)
                    <p style="font-size:13px;color:var(--muted,#aaa);margin:0">{{ $review->comment }}</p>
                    @endif
                </div>
                @endforeach
                </div>
            @endif
        </div>
        @endif
    </main>

    <script>
        function myFunction(smallImg) {
            document.getElementById("imageBox").src = smallImg.src;
        }

        async function toggleWishlistFiche(productId, url, btn) {
            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                });
                const data = await res.json();
                const svg = btn.querySelector('svg');
                if (data.in_wishlist) {
                    svg.setAttribute('fill', 'currentColor');
                    btn.classList.add('in-wishlist');
                    btn.title = 'Retirer des favoris';
                } else {
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
