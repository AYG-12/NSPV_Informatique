<header class="scroll">
    <div class="logo logo_1">
        @php
            $navShopName = $appSettings['shop_name'] ?? 'NSPV Informatique';
            $navParts    = explode(' ', $navShopName, 2);
        @endphp
        <a href="{{ url('/') }}">
            <img src="/images/logo.jpeg" alt="Logo {{ $navShopName }}">
            <span><span>{{ $navParts[0] }}</span> <span>{{ $navParts[1] ?? '' }}</span></span>
        </a>
    </div>
    <nav>
    
        <button class="nav-toggle" id="nav-toggle" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>
    
        <div class="menu" id="nav-menu">
            <div class="logo logo_2">
                @php 
                    $navShopName = $appSettings['shop_name'] ?? 'NSPV Informatique';
                    $navParts    = explode(' ', $navShopName, 2);
                @endphp
                <a href="{{ url('/') }}">
                    <img src="/images/logo.jpeg" alt="Logo {{ $navShopName }}">
                    <span><span>{{ $navParts[0] }}</span> <span>{{ $navParts[1] ?? '' }}</span></span>
                </a>
            </div>
    
            <ul class="flex space-x-8 items-center">
                <li class="liAcc"><a href="{{ url('/Shop') }}">Accueil</a></li>
                <li class="liPro"><a href="{{ url('/Shop/produits') }}">Catégories</a></li>
    
                {{-- Favoris --}}
                @if(($appSettings['wishlist_enabled'] ?? '1') === '1')
                    <li class="liFav">
                        <a href="{{ route('shop.favoris') }}" style="position:relative;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="{{ auth()->check() && ($wishlistCount ?? 0) > 0 ? 'currentColor' : 'none' }}"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                            @if(auth()->check() && ($wishlistCount ?? 0) > 0)
                                <span id="wishlist-count" style="position:absolute;top:-6px;right:-8px;background:#e53e3e;color:#fff;border-radius:50%;width:16px;height:16px;font-size:10px;display:flex;align-items:center;justify-content:center;font-weight:700">{{ $wishlistCount }}</span>
                            @else
                                <span id="wishlist-count" style="display:none;position:absolute;top:-6px;right:-8px;background:#e53e3e;color:#fff;border-radius:50%;width:16px;height:16px;font-size:10px;align-items:center;justify-content:center;font-weight:700">0</span>
                            @endif
                        </a>
                    </li>
                @endif
    
                {{-- Panier avec compteur --}}
                <li class="liPan">
                    <a href="{{ url('/Shop/cart') }}" class="cart">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                        </svg>
    
                        @if (auth()->check())
                            @if ((auth()->user()->cartCount()) > 0 )
                                <div><span id="cart-count">{{auth()->user()->cartCount()}}</span></div>
                            @else
                                
                            @endif
                        @endif
                        {{-- <div><span id="cart-count">{{ auth()->check() ? auth()->user()->cartCount() : 0 }}</span></div> --}}
                    </a>
                </li>
    
                {{-- Compte / Déconnexion --}}
                <li class="liConn">
                    @if(auth()->check())
                        <div class="nav-use">
                            <form class="nav-use-name" method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button >Se déconnecter</button>
                            </form>
                            {{-- <span class="nav-user-name">{{ auth()->user()->name }}</span> --}}
                            <div class="nav-use-dropdown">
                                <a href="{{ route('shop.profil') }}">Mon compte</a>
                                <a href="{{ route('shop.cart') }}">Mon panier</a>
                                <a href="{{ route('shop.commandes') }}">Mes commandes</a>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ url('/welAdminnspv') }}">Administration</a>
                                @endif
                            </div>
                        </div>
                    @else
                        <a href="{{ url('/connexion') }}">Inscription / Connexion</a>
                    @endif
                </li>
            </ul>
        </div>
    </nav>
</header>


{{-- Mobile navigation --}}

<section class="navbar2">
    <ul class="flex space-x-8 items-center">
        <li>
            <a href="{{ url('/Shop') }}">
                <span>Accueil</span>
            </a>
        </li>

        <li>
            <a href="{{ url('/Shop/produits') }}">
                <span>Catégories</span>
            </a>
        </li>

        {{-- Panier avec compteur --}}
        <li>
            <a href="{{ url('/Shop/cart') }}" class="cart">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                </svg>
                <span>Panier</span>
            </a>
        </li>

        <li>
            <a href="#">
                <span>Mo Compte</span>
            </a>
        </li>
    </ul>
</section>

<script>
    document.getElementById('nav-toggle').addEventListener('click', function () {
        this.classList.toggle('open');
        document.getElementById('nav-menu').classList.toggle('open');
    });
</script>

