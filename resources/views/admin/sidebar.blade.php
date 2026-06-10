<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="logo">
        <img src="{{asset('images/logo.jpeg')}}" alt="logo">
    </div>

    <nav class="nav-section">
        <div class="nav-label">Principal</div>
        <a href="{{ url('/welAdminnspv') }}" class="nav-item ">
            <svg class="nav-icon" viewBox="0 0 20 20" fill="currentColor"><path d="M2 11l8-8 8 8V18h-5v-5H7v5H2v-7z"/></svg>
            Tableau de bord
        </a>

        <a href="{{ url('/welAdminnspv/commandes') }}" class="nav-item" data-page="orders">
            <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 5h14M3 10h14M3 15h8"/></svg>
            Commandes
            @if($pendingOrdersCount > 0)
            <span class="badge" id="orders-badge">{{ $pendingOrdersCount }}</span>
            @endif
        </a>

        <a href="{{ url('/welAdminnspv/produits') }}" class="nav-item" data-page="products">
            <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="14" height="14" rx="2"/><path d="M7 8h6M7 12h4"/></svg>
            Produits
        </a>

        <a href="{{ url('/welAdminnspv/clients') }}" class="nav-item" data-page="customers">
            <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="10" cy="7" r="3"/><path d="M4 17c0-3.3 2.7-6 6-6s6 2.7 6 6"/></svg>
            Clients
        </a>

        <div class="nav-label">Boutique</div>

        <a href="{{ url('/welAdminnspv/categories') }}" class="nav-item">
            <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 4h12v4L10 13 4 8V4z"/></svg>
            Catégories
        </a>

        <a href="{{ url('/welAdminnspv/promotions') }}" class="nav-item">
            <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M10 3v14M5 7h10M5 13h10"/></svg>
            Promotions
        </a>

        <a href="{{ url('/welAdminnspv/visites') }}" class="nav-item">
            <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="10" cy="10" r="6"/><path d="M4 10s2-4 6-4 6 4 6 4-2 4-6 4-6-4-6-4z"/><circle cx="10" cy="10" r="2" fill="currentColor" stroke="none"/></svg>
            Visites
        </a>

        <a href="{{ url('/welAdminnspv/avis') }}" class="nav-item">
            <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M10 2l2.4 4.9 5.4.8-3.9 3.8.9 5.4L10 14.4l-4.8 2.5.9-5.4L2.2 7.7l5.4-.8z"/></svg>
            Avis clients
            @if(isset($pendingReviewsCount) && $pendingReviewsCount > 0)
            <span class="badge">{{ $pendingReviewsCount }}</span>
            @endif
        </a>

        <a href="{{ url('/welAdminnspv/analytique') }}" class="nav-item">
            <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 10h4l3-6 4 12 3-6h3"/></svg>
            Analytique
        </a>

        <a href="{{ url('/Shop') }}" target="_blank" class="nav-item">
            <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg"  fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16">
                <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5M4 15h3v-5H4zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zm3 0h-2v3h2z"/>
            </svg>
            Voir la boutique
        </a>
        

        <div class="nav-label">Système</div>

        <a href="{{ url('/welAdminnspv/parametres')}}" class="nav-item">
            <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="10" cy="10" r="3"/><path d="M10 2v2M10 16v2M2 10h2M16 10h2M4.2 4.2l1.4 1.4M14.4 14.4l1.4 1.4M4.2 15.8l1.4-1.4M14.4 5.6l1.4-1.4"/></svg>
            Paramètres
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Super Admin</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" style="margin-top:8px; color:white; hover:bg:#59a0fc; transition:0.3s;">
            @csrf
            <button type="submit" class="btn-deconnecter" style="">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Se déconnecter
            </button>
        </form>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navItems = document.querySelectorAll('a.nav-item');
        const currentPath = window.location.pathname.replace(/\/$/, '');

        let bestMatch = null;
        let bestLength = 0;

        navItems.forEach(item => {
            const href = new URL(item.getAttribute('href'), window.location.origin).pathname.replace(/\/$/, '');
            if (currentPath === href || currentPath.startsWith(href + '/')) {
                if (href.length > bestLength) {
                    bestLength = href.length;
                    bestMatch = item;
                }
            }
        });

        if (bestMatch) bestMatch.classList.add('active');
    });
</script>