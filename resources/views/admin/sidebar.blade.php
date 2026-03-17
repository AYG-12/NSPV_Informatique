<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="logo">
        <img src="{{asset('images/logo.jpeg')}}" alt="logo">
    </div>

    <nav class="nav-section">
        <div class="nav-label">Principal</div>
        <div class="nav-item active" data-page="dashboard">
            <svg class="nav-icon" viewBox="0 0 20 20" fill="currentColor"><path d="M2 11l8-8 8 8V18h-5v-5H7v5H2v-7z"/></svg>
            Tableau de bord
        </div>

        <div class="nav-item" data-page="orders">
            <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 5h14M3 10h14M3 15h8"/></svg>
            Commandes
            <span class="badge" id="orders-badge">14</span>
        </div>

        <div class="nav-item" data-page="products">
            <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="14" height="14" rx="2"/><path d="M7 8h6M7 12h4"/></svg>
            Produits
        </div>

        <div class="nav-item" data-page="customers">
            <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="10" cy="7" r="3"/><path d="M4 17c0-3.3 2.7-6 6-6s6 2.7 6 6"/></svg>
            Clients
        </div>

        <div class="nav-label">Boutique</div>

        <div class="nav-item" data-page="categories">
            <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 4h12v4L10 13 4 8V4z"/></svg>
            Catégories
        </div>

        <div class="nav-item" data-page="promotions">
            <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M10 3v14M5 7h10M5 13h10"/></svg>
            Promotions
        </div>

        <div class="nav-item" data-page="analytics">
            <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 10h4l3-6 4 12 3-6h3"/></svg>
            Analytique
        </div>

        <div class="nav-label">Système</div>

        <div class="nav-item" data-page="settings">
            <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="10" cy="10" r="3"/><path d="M10 2v2M10 16v2M2 10h2M16 10h2M4.2 4.2l1.4 1.4M14.4 14.4l1.4 1.4M4.2 15.8l1.4-1.4M14.4 5.6l1.4-1.4"/></svg>
            Paramètres
        </div>
    </nav>

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="avatar">A</div>
            <div class="user-info">
                <div class="user-name">Administrateur</div>
                <div class="user-role">Super Admin</div>
            </div>
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="#6b6b80" stroke-width="1.8"><path d="M5 3l4 4-4 4"/></svg>
        </div>
    </div>
</aside>
