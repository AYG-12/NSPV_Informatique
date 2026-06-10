@php $title = "Favoris"; @endphp

@extends('layouts.guest')

@section('content')
    @include('Shop.partials._navbar')

    <main class="content-favoris">

        @if(session('success'))
            <div style="max-width:900px;margin:16px auto;background:rgba(45,204,127,.15);border:1px solid #2dcc7f;color:#2dcc7f;padding:10px 16px;border-radius:8px;font-size:13px;">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="title">Mes favoris</h2>

        <div class="favoris">
            @forelse($items as $item)
                @php $product = $item->product; @endphp
                @if($product)
                    <div class="pro_favoris" id="fav-{{ $product->id }}">
                        <div class="cont_favoris">
                            <div class="favoris_pro_img">
                                <a href="{{ route('shop.fiche', $product->slug) }}" title="Détail du produit">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                    @else
                                        <img src="{{ Vite::asset('resources/images/panier.jpg') }}" alt="{{ $product->name }}">
                                    @endif
                                </a>
                            </div>
                            <div class="favoris_pro_info">
                                <h2>{{ $product->name }}</h2>
                                <p>{{ number_format($product->sale_price ?? $product->price, 0, ',', ' ') }} F CFA</p>
                                @if($product->category)
                                    <small>{{ $product->category->name }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="act_favoris">
                            <button class="fav_btn_sup" onclick="toggleWishlist({{ $product->id }}, '{{ route('shop.wishlist.toggle', $product) }}')">
                                Supprimer
                            </button>
                            @if($product->isInStock())
                            <form method="POST" action="{{ route('shop.cart.add') }}" style="display:inline">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="fav_btn_ajou">Ajouter au panier</button>
                            </form>
                            @else
                                <span class="fav_btn_ajou" style="opacity:.5;cursor:not-allowed">Rupture de stock</span>
                            @endif
                        </div>
                    </div>
                @endif
            @empty
                <div style="text-align:center;padding:60px 20px;color:var(--muted,#aaa)" class="fav_vide">
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin-bottom:16px;opacity:.4">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg> --}}
                    <p style="font-size:16px;margin-bottom:8px">Votre liste de favoris est vide</p>
                    <a href="{{ route('shop.produits') }}" style="color:var(--primary,#3b82f6)">Découvrir les produits →</a>
                </div>
            @endforelse
        </div>
    </main>

    <script>
        async function toggleWishlist(productId, url) {
            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                });
                const data = await res.json();
                if (!data.in_wishlist) {
                    const el = document.getElementById('fav-' + productId);
                    if (el) el.remove();
                    // Update navbar count
                    const badge = document.getElementById('wishlist-count');
                    if (badge) badge.textContent = data.count;
                    if (data.count === 0) {
                        document.querySelector('.favoris').innerHTML = `
                            <div style="text-align:center;padding:60px 20px;color:#aaa">
                                <p style="font-size:16px;margin-bottom:8px">Votre liste de favoris est vide</p>
                                <a href="{{ route('shop.produits') }}" style="color:#3b82f6">Découvrir les produits →</a>
                            </div>`;
                    }
                }
            } catch (e) {
                window.location.reload();
            }
        }
    </script>
@endsection
