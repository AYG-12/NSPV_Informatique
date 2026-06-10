<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $appSettings['shop_description'] ?? 'NSPV Informatique est votre partenaire de confiance pour la vente d\'ordinateurs et de services informatiques.' }}">
    <meta name="keywords" content="{{ ($appSettings['shop_name'] ?? 'NSPV Informatique') }}, vente d'ordinateurs, services informatiques, produits informatiques">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | {{ $appSettings['shop_name'] ?? 'NSPV Informatique' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">

    @vite('resources/css/css/admin.css')
</head>
<body>

<!-- ════════════════════════════════════
    SIDE_BAR
════════════════════════════════════ -->
  
    @include('admin.sidebar')


<!-- ════════════════════════════════════
    CONTENT
════════════════════════════════════ -->

    <main class="main">
        <div class="topbar">
            <div class="hamburger" id="hamburger" aria-label="Menu">
                <span></span><span></span><span></span>
            </div>
            <div class="topbar-title" > {{$title}} </div>
            <!-- <div class="search-box">
                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="7" cy="7" r="4.5"/><path d="M10.5 10.5l3 3"/></svg>
                <input type="text" placeholder="Rechercher…">
            </div> -->
            <div class="topbar-actions" style="position:relative">

                {{-- Cloche notifications --}}
                <div class="icon-btn" id="notif-toggle" style="position:relative;cursor:pointer" onclick="toggleNotifDropdown()">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M8 2a4.5 4.5 0 014.5 4.5c0 2.5.8 4 1.5 5H2c.7-1 1.5-2.5 1.5-5A4.5 4.5 0 018 2zM6.5 13.5a1.5 1.5 0 003 0"/></svg>
                    <span id="notif-badge" style="display:none;position:absolute;top:-4px;right:-4px;background:#ff4757;color:#fff;font-size:10px;font-weight:700;min-width:17px;height:17px;border-radius:999px;align-items:center;justify-content:center;padding:0 4px;line-height:1">0</span>
                </div>

                {{-- Dropdown notifications --}}
                <div id="notif-dropdown"
                     style="display:none;position:absolute;top:56px;right:20px;width:340px;background:var(--card,#1a1a1a);border:1px solid var(--border,#2a2a2a);border-radius:12px;box-shadow:0 8px 32px rgba(0,0,0,.5);z-index:1000;overflow:hidden">
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 16px;border-bottom:1px solid var(--border,#2a2a2a)">
                        <span style="font-weight:600;font-size:14px">Notifications</span>
                        <button onclick="markAllRead()" style="font-size:12px;color:var(--accent,#e8ff47);background:none;border:none;cursor:pointer;padding:0">Tout marquer lu</button>
                    </div>
                    <div id="notif-list" style="max-height:360px;overflow-y:auto">
                        <div style="padding:24px;text-align:center;color:var(--muted,#888);font-size:13px">Chargement…</div>
                    </div>
                </div>

                {{-- Menu admin avec déconnexion --}}
                <div class="admin-user-menu">
                    <div class="avatar" style="width:36px;height:36px;font-size:12px;border-radius:10px;cursor:pointer;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="admin-dropdown">
                        <div class="admin-dropdown-header">
                            <strong>{{ auth()->user()->name }}</strong>
                            <span>{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            @yield('content')
        </div>
    </main>



    <!-- JS -->
    @vite('resources/js/js/admin.js')

    <script>
    // ── Notifications ────────────────────────────────────────────
    const NOTIF_URL      = '{{ route("admin.notifications") }}';
    const NOTIF_READ_URL = '{{ url("welAdminnspv/notifications") }}';
    const CSRF           = document.querySelector('meta[name="csrf-token"]').content;
    let   notifOpen      = false;

    async function loadNotifications() {
        try {
            const res  = await fetch(NOTIF_URL, { headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF } });
            const data = await res.json();

            // Badge
            const badge = document.getElementById('notif-badge');
            if (data.unread > 0) {
                badge.textContent = data.unread > 99 ? '99+' : data.unread;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }

            // Liste
            const list = document.getElementById('notif-list');
            if (!data.notifications.length) {
                list.innerHTML = `<div style="padding:24px;text-align:center;color:var(--muted,#888);font-size:13px">Aucune notification</div>`;
                return;
            }

            const icons = {
                order:  `<svg viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.8" width="16" height="16"><path d="M3 5h12l-1.5 8H4.5L3 5z"/><circle cx="7" cy="15" r="1"/><circle cx="12" cy="15" r="1"/></svg>`,
                review: `<svg viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.8" width="16" height="16"><path d="M9 2l2 5h5l-4 3 1.5 5L9 12l-4.5 3L6 10 2 7h5z"/></svg>`,
                stock:  `<svg viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.8" width="16" height="16"><path d="M9 3v6l4 2"/><circle cx="9" cy="9" r="7"/></svg>`,
            };

            list.innerHTML = data.notifications.map(n => `
                <a href="${n.data.url || '#'}" onclick="markRead('${n.id}', event, '${n.data.url || ''}')"
                   style="display:flex;align-items:flex-start;gap:12px;padding:12px 16px;border-bottom:1px solid var(--border,#2a2a2a);text-decoration:none;background:${n.read ? 'transparent' : 'rgba(232,255,71,.04)'};transition:background .15s"
                   onmouseover="this.style.background='rgba(255,255,255,.04)'"
                   onmouseout="this.style.background='${n.read ? 'transparent' : 'rgba(232,255,71,.04)'}'">
                    <div style="width:32px;height:32px;border-radius:8px;background:${n.data.icon === 'order' ? 'rgba(45,204,127,.15)' : n.data.icon === 'review' ? 'rgba(232,255,71,.12)' : 'rgba(255,71,87,.12)'};color:${n.data.icon === 'order' ? '#2dcc7f' : n.data.icon === 'review' ? 'var(--accent,#e8ff47)' : '#ff4757'};display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        ${icons[n.data.icon] ?? icons.order}
                    </div>
                    <div style="flex:1;min-width:0">
                        <div style="font-size:13px;font-weight:${n.read ? '400' : '600'};color:var(--fg,#fff);margin-bottom:2px">${n.data.title}</div>
                        <div style="font-size:12px;color:var(--muted,#888);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${n.data.message}</div>
                        <div style="font-size:11px;color:var(--muted,#666);margin-top:3px">${n.time}</div>
                    </div>
                    ${n.read ? '' : '<div style="width:7px;height:7px;border-radius:50%;background:var(--accent,#e8ff47);flex-shrink:0;margin-top:4px"></div>'}
                </a>
            `).join('');
        } catch(e) { console.error('Notifications:', e); }
    }

    function toggleNotifDropdown() {
        const dd = document.getElementById('notif-dropdown');
        notifOpen = !notifOpen;
        dd.style.display = notifOpen ? 'block' : 'none';
        if (notifOpen) loadNotifications();
    }

    async function markRead(id, e, url) {
        e.preventDefault();
        await fetch(`${NOTIF_READ_URL}/${id}/read`, {
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        });
        if (url && url !== '#') window.location.href = url;
    }

    async function markAllRead() {
        await fetch(`${NOTIF_READ_URL}/read-all`, {
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        });
        loadNotifications();
    }

    // Fermer le dropdown en cliquant dehors
    document.addEventListener('click', e => {
        if (notifOpen && !document.getElementById('notif-toggle').contains(e.target)
                      && !document.getElementById('notif-dropdown').contains(e.target)) {
            notifOpen = false;
            document.getElementById('notif-dropdown').style.display = 'none';
        }
    });

    // Polling toutes les 60 secondes pour mettre à jour le badge
    loadNotifications();
    setInterval(loadNotifications, 60000);

    // ── Modals ────────────────────────────────────────────────────
        // Modals
        function openModal(id) {
            document.getElementById(id).classList.add('open');
            // Réinitialiser l'autocomplete à chaque ouverture du modal commande
            if (id === 'modal-order') resetProductSearch();
        }
        function closeModal(id) { document.getElementById(id).classList.remove('open'); }
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', e => { if (e.target === overlay) overlay.classList.remove('open'); });
        });
    </script>
</body>
</html>