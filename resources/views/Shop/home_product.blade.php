@php $title = "Boutique"; @endphp

@extends('layouts.guest')


@section('content')
    <!-- Appel de la barre de navigation -->
    @include('Shop.partials._navbar')

    <!-- Appel du banner -->
    @include('Shop.partials._banner')
    
    <main class="main-content">
        <!-- Partie Produit -->
        <div class="produits">
            <h2>Nos Produits</h2>

            <div class="pro-grid">

                {{-- Premier produit en grand (classe .pro) --}}
                @if($featuredProducts->isNotEmpty())
                    @include('Shop.partials._product_card', [
                        'product'  => $featuredProducts->first(),
                        'featured' => true,
                    ])
                @endif

                {{-- Reste des produits en grille --}}
                @if($featuredProducts->count() > 1)
                    <div class="prod_grid">
                        @foreach($featuredProducts->skip(1) as $product)
                            @include('Shop.partials._product_card', ['product' => $product])
                        @endforeach
                    </div>
                @endif

            </div>

            <a href="{{ route('shop.produits') }}" class="btn btn1">Plus de produit...</a>
        </div>
    </main>

    <script>
        async function toggleWishlistCard(productId, url, btn) {
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
                if (badge) { badge.textContent = data.count; badge.style.display = data.count > 0 ? '' : 'none'; }
            } catch (e) { window.location.href = '{{ route("connexion") }}'; }
        }
    </script>
@endsection
