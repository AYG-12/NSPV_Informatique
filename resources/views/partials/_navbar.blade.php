<header>
    <div class="logo">
        @php
            $shopName  = $appSettings['shop_name'] ?? 'NSPV Informatique';
            $nameParts = explode(' ', $shopName, 2);
        @endphp
        <a href="{{ url('/') }}">
            <img src="/images/logo.jpeg" alt="Logo {{ $shopName }}">
            <span><span>{{ $nameParts[0] }}</span>{{ isset($nameParts[1]) ? ' '.$nameParts[1] : '' }}</span>
        </a>
    </div>

    <nav>
        <button class="nav-toggle" id="nav-toggle" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>
    
        <div class="menu" id="nav-menu">
            <ul class="flex space-x-8 items-center">
                <li><a href="{{ url('/') }}">Accueil</a></li>
                <li><a href="{{ url('/contact') }}">Contacts</a></li>
                <li><a href="{{ url('/Shop') }}">Boutique</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="{{ url('/Apropos') }}">Apropos</a></li>
    
                {{-- Compte / Déconnexion --}}
                <li>
                    @if(auth()->check())
                        <div class="nav-use">
                            <form class="nav-use-name" method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">Se déconnecter</button>
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

<script>
    document.getElementById('nav-toggle').addEventListener('click', function () {
        this.classList.toggle('open');
        document.getElementById('nav-menu').classList.toggle('open');
    });
</script>