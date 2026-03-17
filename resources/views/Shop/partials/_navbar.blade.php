<nav>
    <div class="logo">
        <a href="{{ url('/') }}">
            <img src="/images/logo.jpeg" alt="Logo NSPV Informatique">
            <span><span>NSPV</span> <span>Informatique</span></span>
        </a>
    </div>

    <button class="nav-toggle" id="nav-toggle" aria-label="Menu">
        <span></span><span></span><span></span>
    </button>

    <div class="menu" id="nav-menu">
        <ul class="flex space-x-8 items-center">
            <li><a href="{{ url('/Shop') }}">Accueil</a></li>
            <li><a href="{{ url('/Shop/produits') }}">Produits</a></li>
            <li>
                <a href="{{ url('/Shop/favoris') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
                    </svg>
                </a>
            </li>
            <li>
                <a href="{{ url('/Shop/cart') }}" class="cart">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                    </svg>
                    <div><span>20</span></div>
                </a>
            </li>
            <li><a href="{{ url('/connexion') }}">Inscription/Connexion</a></li>
        </ul>
    </div>
</nav>
<script>
    document.getElementById('nav-toggle').addEventListener('click', function () {
        this.classList.toggle('open');
        document.getElementById('nav-menu').classList.toggle('open');
    });
</script>

<!-- <nav>
    <div class="logo">
        <a href="{{ url('/') }}">
            <img src="/images/logo.jpeg" alt="Logo NSPV Informatique">
            <span><span>NSPV</span> <span>Informatique</span></span>
        </a>    
    </div>
    
    <div class="menu">
        <ul class="flex space-x-8 items-center">
            <li><a href="{{ url('/Shop') }}">Accueil</a></li>
            <li><a href="{{ url('/Shop/produits') }}">Produits</a></li>
            <li><a href="{{ url('/Shop/favoris') }}">Favoris</a></li>
            <li>
                <a href="{{ url('/Shop/cart') }}" class="cart">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
                        <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l.5 2H5V5zM6 5v2h2V5zm3 0v2h2V5zm3 0v2h1.36l.5-2zm1.11 3H12v2h.61zM11 8H9v2h2zM8 8H6v2h2zM5 8H3.89l.5 2H5zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm6 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                    </svg>
                    <span id="cart-count">
                        @auth
                            {{ auth()->user()->cartCount() }}
                        @else
                            0
                        @endauth
                    </span>
                </a>
            </li>
            <li>
                @auth
                    <a href="{{ url('/profil') }}">Mon Compte</a>
                @else
                    <a href="{{ url('/connexion') }}">Inscription / Connexion</a>
                @endauth
            </li>
        </ul>
    </div>
</nav>

<script>
    // Fonction globale pour incrémenter le compteur du panier
    function updateCartCount(quantity = 1) {
        const cartCount = document.getElementById('cart-count');

        if (cartCount) {
            const currentCount = parseInt(cartCount.textContent.trim()) || 0;
            const newCount = currentCount + quantity;

            cartCount.textContent = newCount;

            // Animation visuelle lors de la mise à jour
            cartCount.classList.add('cart-updated');
            setTimeout(() => cartCount.classList.remove('cart-updated'), 500);
        }
    }

    // Écoute l'événement global "addToCart" déclenché depuis n'importe quelle page
    document.addEventListener('addToCart', function (e) {
        const quantity = e.detail?.quantity ?? 1;
        updateCartCount(quantity);
    });
</script>

<style>
    #cart-count {
        transition: transform 0.2s ease, background-color 0.2s ease;
    }

    .cart-updated {
        transform: scale(1.4);
        background-color: #e74c3c !important;
    }
</style> -->