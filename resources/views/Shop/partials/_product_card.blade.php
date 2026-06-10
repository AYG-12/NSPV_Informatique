{{-- Utilisation : @include('Shop.partials._product_card', ['product' => $product, 'featured' => false]) --}}
@php $inWishlist = in_array($product->id, $wishlistProductIds ?? []); @endphp
<div class="prod {{ $featured ?? false ? 'pro' : '' }}">
    <div class="img_prod">
        <a href="{{ route('shop.fiche', $product->slug) }}" title="Détail du produit">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            @else
                <img src="{{ Vite::asset('resources/images/background.jpeg') }}" alt="{{ $product->name }}">
            @endif
        </a>
    </div>

    <div class="prod_info">
        <h3>{{ $product->name }}</h3>
        <p>{{ $product->short_description ?? Str::limit($product->description, 60) }}</p>
        <div class="star_price">
            <div class="prix_prod">
                @if($product->sale_price)
                    <h4>{{ number_format($product->sale_price, 0, ',', ' ') }} FCFA</h4>
                @else
                    <h4>{{ number_format($product->price, 0, ',', ' ') }} FCFA</h4>
                @endif
            </div>
            
            <div class="star">
                @php
                   $approvedReviews = $product->reviews->where('is_approved', true);
                   $maxRating       = $approvedReviews->max('rating');
                   $reviewCount     = $approvedReviews->count();
               @endphp

               @if($maxRating)
                   <a href="#avis-clients" style="display:inline-flex;align-items:center;gap:2px;margin:6px 0 14px;text-decoration:none">
                       @for($i = 1; $i <= 5; $i++)
                       <span style="font-size:25px;color:{{ $i <= $maxRating ? '#fff700' : '#444' }};line-height:1">★</span>
                       @endfor
                   </a>
               @endif
            </div>
        </div>

        @if(auth()->check())
            <form method="POST" action="{{ route('shop.cart.add') }}" style="display:inline">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn_ajout" >Ajouter au Panier</button>
            </form>
        @else
            <a href="{{ route('connexion') }}" class="btn">Ajouter au Panier</a>
        @endif

        @if(($appSettings['wishlist_enabled'] ?? '1') === '1')
            @if(auth()->check())
                <button class="btn_favoris {{ $inWishlist ? 'in-wishlist' : '' }}" title="{{ $inWishlist ? 'Retirer des favoris' : 'Ajouter aux favoris' }}" onclick="toggleWishlistCard({{ $product->id }}, '{{ route('shop.wishlist.toggle', $product) }}', this)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ $inWishlist ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                </button>
            @else
                <a href="{{ route('connexion') }}" class="btn_favoris" title="Connectez-vous pour ajouter aux favoris">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                </a>
            @endif
        @endif
    </div>
</div>
