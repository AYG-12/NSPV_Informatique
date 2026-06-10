<div class="banner" id="banne">
    @if($active->count() > 0)
        <div class="info">
            <span>Info</span>
            <marquee>
                @foreach ($active as $promo)
                    <m class="mesDe"> {{ $promo->description }} </m> :
                    du <b>{{ $promo->starts_at->translatedFormat('l j F Y') }}</b> au <b>{{ $promo->expires_at->translatedFormat('l j F Y') }}</b>,
                    nous vous offrons un rabais de <b>{{ $promo->value }}%</b> sur tous vos achats de produits à partir de <b>{{ number_format($promo->min_order_amount, 0, ',', ' ') }} FCFA</b>.
                    @if ($promo->usage_limit > 0)
                        Offre limitée au <strong>{{ $promo->usage_limit }} premiers</strong> acheteurs utilisateurs du code promo : <i class="text-blue-600 text-bold"> {{ $promo->code }}</i>.
                    @else
                        code promo : <i class="text-blue-600 text-bold"> {{ $promo->code }}</i>.
                    @endif
                    @if (!$loop->last)
                        &nbsp;&nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;&nbsp;
                    @endif
                @endforeach
            </marquee>
        </div>
    @endif
    
    <div class="swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide flex items-center justify-center text-white">
                <div class="banner-home mt-22 h-124">
                    <p class="typewriter" data-text="{{ ($appSettings['shop_name'] ?? 'NSPV Informatique') }} — {{ $appSettings['shop_description'] ?? 'Votre partenaire de confiance pour la vente d\'ordinateurs, d\'accessoires et différents services informatiques.' }}"></p>
                    <img src="{{ Vite::asset('resources/images/logo.jpeg') }}" alt="logo">
                    <a href="#">En savoir plus</a>
                </div>
            </div>

            @if($bannerProd->count() > 1)
                @foreach($bannerProd as $product)
                    <div class="swiper-slide flex items-center justify-center text-white">
                        <div class="pro mt-22 h-124">
                            <div class="info_prod">
                                <h2>{{ $product->name }}</h2>
                                <p>{{ $product->short_description ?? Str::limit($product->description, 60) }}</p>       
                                <p>Au prix de 
                                    <span>
                                        @if($product->sale_price)
                                           {{ number_format($product->sale_price, 0, ',', ' ') }} FCFA
                                        @else
                                           {{ number_format($product->price, 0, ',', ' ') }} FCFA
                                        @endif
                                    </span> 
                                </p>

                                @if(auth()->check())
                                <form method="POST" action="{{ route('shop.cart.add') }}" style="display:inline">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn bann-ajout" >Ajouter au Panier</button>
                                </form>
                                @else
                                    <a href="{{ route('connexion') }}" class="btn bann-ajout" >Ajouter au Panier</a>
                                @endif
                            </div>
                        
                            <div class="imgProd">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                @else
                                    <img src="{{ Vite::asset('resources/images/background.jpeg') }}" alt="{{ $product->name }}">
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <!-- Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Navigation -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</div>
