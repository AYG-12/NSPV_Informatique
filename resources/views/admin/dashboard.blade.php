@extends('layouts.admin')

@section('content')

  <!-- MAIN -->
  <main class="main">
    <div class="topbar">
      <div class="hamburger" id="hamburger" aria-label="Menu">
        <span></span><span></span><span></span>
      </div>
      <div class="topbar-title" id="topbar-title">Tableau de bord <a href="{{ route('pages.index') }}">welcom</a> </div>
      <!-- <div class="search-box">
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="7" cy="7" r="4.5"/><path d="M10.5 10.5l3 3"/></svg>
        <input type="text" placeholder="Rechercher…">
      </div> -->
      <div class="topbar-actions">
        <div class="icon-btn">
          <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M8 2a4.5 4.5 0 014.5 4.5c0 2.5.8 4 1.5 5H2c.7-1 1.5-2.5 1.5-5A4.5 4.5 0 018 2zM6.5 13.5a1.5 1.5 0 003 0"/></svg>
          <span class="notif-dot"></span>
        </div>
        <div class="avatar" style="width:36px;height:36px;font-size:12px;border-radius:10px;cursor:pointer;">A</div>
      </div>
    </div>

    <div class="content">

      <!-- ════════════════════════════════════
          PAGE: DASHBOARD
      ════════════════════════════════════ -->
      <div class="page active" id="page-dashboard">
        <div class="stats-grid">

          <div class="stat-card green">
            <div class="stat-header">
              <div class="stat-icon green"><svg viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 14l3-5 3 2 3-4 3 3"/></svg></div>
              <span class="stat-change up">↑ 12.4%</span>
            </div>
            <div class="stat-value">€ 48 290</div>
            <div class="stat-label">Revenus ce mois</div>
            <div class="sparkline">
              <div class="spark-bar" style="height:35%"></div><div class="spark-bar" style="height:55%"></div><div class="spark-bar" style="height:40%"></div><div class="spark-bar" style="height:70%"></div><div class="spark-bar" style="height:50%"></div><div class="spark-bar" style="height:85%"></div><div class="spark-bar hi" style="height:100%"></div>
            </div>
          </div>

          <div class="stat-card yellow">
            <div class="stat-header">
              <div class="stat-icon yellow"><svg viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 5h12l-1.5 8H4.5L3 5z"/><circle cx="7" cy="15" r="1"/><circle cx="12" cy="15" r="1"/></svg></div>
              <span class="stat-change up">↑ 8.1%</span>
            </div>
            <div class="stat-value">1 247</div>
            <div class="stat-label">Nouvelles commandes</div>
            <div class="sparkline">
              <div class="spark-bar" style="height:45%"></div><div class="spark-bar" style="height:60%"></div><div class="spark-bar" style="height:30%"></div><div class="spark-bar" style="height:75%"></div><div class="spark-bar" style="height:55%"></div><div class="spark-bar" style="height:90%"></div><div class="spark-bar hi" style="height:80%"></div>
            </div>
          </div>

          <div class="stat-card orange">
            <div class="stat-header">
              <div class="stat-icon orange"><svg viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="6" r="3"/><path d="M4 16c0-2.8 2.2-5 5-5s5 2.2 5 5"/></svg></div>
              <span class="stat-change up">↑ 5.7%</span>
            </div>
            <div class="stat-value">3 841</div>
            <div class="stat-label">Nouveaux clients</div>
            <div class="sparkline">
              <div class="spark-bar" style="height:55%"></div><div class="spark-bar" style="height:40%"></div><div class="spark-bar" style="height:70%"></div><div class="spark-bar" style="height:50%"></div><div class="spark-bar" style="height:80%"></div><div class="spark-bar" style="height:60%"></div><div class="spark-bar hi" style="height:90%"></div>
            </div>
          </div>

          <div class="stat-card purple">
            <div class="stat-header">
              <div class="stat-icon purple"><svg viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 2l2.1 4.3 4.7.7-3.4 3.3.8 4.7L9 12.5l-4.2 2.5.8-4.7L2.2 7l4.7-.7L9 2z"/></svg></div>
              <span class="stat-change down">↓ 2.3%</span>
            </div>
            <div class="stat-value">4.7 / 5</div>
            <div class="stat-label">Note moyenne</div>
            <div class="sparkline">
              <div class="spark-bar" style="height:80%"></div><div class="spark-bar" style="height:75%"></div><div class="spark-bar" style="height:90%"></div><div class="spark-bar" style="height:70%"></div><div class="spark-bar" style="height:85%"></div><div class="spark-bar" style="height:65%"></div><div class="spark-bar hi" style="height:72%"></div>
            </div>
          </div>

        </div>

        <div class="charts-row">

          <div class="card">

            <div class="card-header">
              <div><div class="card-title">Ventes & Revenus</div><div class="card-subtitle">Évolution sur les derniers mois</div></div>
              <div class="period-tabs">
                <div class="period-tab">7J</div><div class="period-tab active">30J</div><div class="period-tab">90J</div>
              </div>
            </div>

            <div class="chart-wrap">
              <svg class="chart-svg" viewBox="0 0 600 180" preserveAspectRatio="none">
                <defs>
                  <linearGradient id="g1" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#e8ff47" stop-opacity=".2"/><stop offset="100%" stop-color="#e8ff47" stop-opacity="0"/></linearGradient>
                  <linearGradient id="g2" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#7c6dff" stop-opacity=".15"/><stop offset="100%" stop-color="#7c6dff" stop-opacity="0"/></linearGradient>
                </defs>
                <line x1="0" y1="45" x2="600" y2="45" stroke="#222230" stroke-width="1"/>
                <line x1="0" y1="90" x2="600" y2="90" stroke="#222230" stroke-width="1"/>
                <line x1="0" y1="135" x2="600" y2="135" stroke="#222230" stroke-width="1"/>
                <path d="M0,140 C80,100 160,120 240,55 C320,30 400,50 480,35 C540,20 570,25 600,15 L600,180 L0,180Z" fill="url(#g1)"/>
                <path d="M0,155 C80,140 160,145 240,105 C320,85 400,100 480,85 C540,70 570,72 600,65 L600,180 L0,180Z" fill="url(#g2)"/>
                <path d="M0,140 C80,100 160,120 240,55 C320,30 400,50 480,35 C540,20 570,25 600,15" fill="none" stroke="#e8ff47" stroke-width="2.5" stroke-linecap="round"/>
                <path d="M0,155 C80,140 160,145 240,105 C320,85 400,100 480,85 C540,70 570,72 600,65" fill="none" stroke="#7c6dff" stroke-width="2" stroke-linecap="round"/>
                <circle cx="240" cy="55" r="4" fill="#e8ff47"/><circle cx="480" cy="35" r="4" fill="#e8ff47"/>
              </svg>
            </div>

            <div style="display:flex;gap:20px;margin-top:14px">
              <div style="display:flex;align-items:center;gap:7px;font-size:12px"><div style="width:24px;height:2.5px;background:#e8ff47;border-radius:2px"></div><span style="color:var(--muted)">Revenus</span></div>
              <div style="display:flex;align-items:center;gap:7px;font-size:12px"><div style="width:24px;height:2.5px;background:#7c6dff;border-radius:2px"></div><span style="color:var(--muted)">Commandes</span></div>
            </div>

          </div>

          <div class="card">
            <div class="card-header"><div><div class="card-title">Catégories</div><div class="card-subtitle">Répartition des ventes</div></div></div>
            
            <div class="donut-wrap">

              <div class="donut-svg-wrap">
                <svg class="donut-svg" viewBox="0 0 100 100">
                  <circle cx="50" cy="50" r="38" fill="none" stroke="#222230" stroke-width="14"/>
                  <circle cx="50" cy="50" r="38" fill="none" stroke="#e8ff47" stroke-width="14" stroke-dasharray="90.8 148.4" stroke-dashoffset="0" stroke-linecap="round"/>
                  <circle cx="50" cy="50" r="38" fill="none" stroke="#7c6dff" stroke-width="14" stroke-dasharray="66.9 172.3" stroke-dashoffset="-91" stroke-linecap="round"/>
                  <circle cx="50" cy="50" r="38" fill="none" stroke="#ff6b35" stroke-width="14" stroke-dasharray="47.8 191.4" stroke-dashoffset="-158" stroke-linecap="round"/>
                  <circle cx="50" cy="50" r="38" fill="none" stroke="#2dcc7f" stroke-width="14" stroke-dasharray="33.5 205.7" stroke-dashoffset="-206" stroke-linecap="round"/>
                </svg>
                <div class="donut-center"><div class="donut-total">3.8k</div><div class="donut-total-label">ventes</div></div>
              </div>

              <div class="legend">
                <div class="legend-item"><div class="legend-left"><div class="legend-dot" style="background:#e8ff47"></div><span class="legend-name">Électronique</span></div><span style="font-weight:600;font-size:13px">38%</span></div>
                <div class="legend-item"><div class="legend-left"><div class="legend-dot" style="background:#7c6dff"></div><span class="legend-name">Mode</span></div><span style="font-weight:600;font-size:13px">28%</span></div>
                <div class="legend-item"><div class="legend-left"><div class="legend-dot" style="background:#ff6b35"></div><span class="legend-name">Maison</span></div><span style="font-weight:600;font-size:13px">20%</span></div>
                <div class="legend-item"><div class="legend-left"><div class="legend-dot" style="background:#2dcc7f"></div><span class="legend-name">Autres</span></div><span style="font-weight:600;font-size:13px">14%</span></div>
              </div>
            </div>
          </div>

        </div>

        <div class="bottom-row">
          <div class="card">
            <div class="card-header"><div><div class="card-title">Commandes récentes</div><div class="card-subtitle">14 commandes en attente</div></div><a href="" onclick="navigate('orders');return false" style="font-size:13px;color:var(--accent);text-decoration:none;font-weight:500">Voir tout →</a></div>
            <table>
              <thead>
                <tr>
                  <th>Produit</th> <th>Client</th> <th>Montant</th> <th>Statut</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <div class="product-cell"> <div class="product-thumb">📱</div> <div><div class="product-name">iPhone 15 Pro</div><div class="product-sku">#CMD-4821</div></div></div>
                  </td>

                  <td style="color:var(--muted)">Sophie M.</td>

                  <td style="font-weight:600">€ 1 199</td>

                  <td><span class="pill pill-success">Livré</span></td>
                </tr>

                <tr>
                  <td>
                    <div class="product-cell"><div class="product-thumb">👟</div><div><div class="product-name">Air Jordan 1</div><div class="product-sku">#CMD-4820</div></div></div></td>

                    <td style="color:var(--muted)">Karim B.</td>

                    <td style="font-weight:600">€ 185</td>

                    <td><span class="pill pill-warn">En transit</span></td>
                </tr>

                <tr>
                  <td><div class="product-cell"><div class="product-thumb">💻</div><div><div class="product-name">MacBook Air M3</div><div class="product-sku">#CMD-4819</div></div></div></td>

                  <td style="color:var(--muted)">Lucie P.</td>

                  <td style="font-weight:600">€ 1 449</td>

                  <td><span class="pill pill-warn">Préparation</span></td>
                </tr>

                <tr>
                  <td><div class="product-cell"><div class="product-thumb">🎧</div><div><div class="product-name">Sony WH-1000XM5</div><div class="product-sku">#CMD-4818</div></div></div></td>

                  <td style="color:var(--muted)">Marc D.</td>

                  <td style="font-weight:600">€ 349</td>

                  <td><span class="pill pill-danger">Annulé</span></td>
                </tr>

                <tr>
                  <td><div class="product-cell"><div class="product-thumb">⌚</div><div><div class="product-name">Apple Watch Ultra 2</div><div class="product-sku">#CMD-4817</div></div></div></td>
                  
                  <td style="color:var(--muted)">Emma V.</td>

                  <td style="font-weight:600">€ 849</td>
                  
                  <td><span class="pill pill-success">Livré</span></td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="card">
            <div class="card-header"><div><div class="card-title">Activité récente</div><div class="card-subtitle">Événements du système</div></div></div>
            <div class="activity-feed">
              <div class="activity-item"><div class="activity-dot" style="background:var(--success)"></div><div class="activity-content"><div class="activity-msg"><strong>Nouvelle commande</strong> de Sophie M. pour €1 199</div><div class="activity-time">il y a 3 min</div></div></div>
              <div class="activity-item"><div class="activity-dot" style="background:var(--accent3)"></div><div class="activity-content"><div class="activity-msg"><strong>Produit ajouté</strong> : Samsung Galaxy S25 Ultra</div><div class="activity-time">il y a 18 min</div></div></div>
              <div class="activity-item"><div class="activity-dot" style="background:var(--warn)"></div><div class="activity-content"><div class="activity-msg"><strong>Stock faible</strong> — Nike Air Max 90 (3 restants)</div><div class="activity-time">il y a 45 min</div></div></div>
              <div class="activity-item"><div class="activity-dot" style="background:var(--danger)"></div><div class="activity-content"><div class="activity-msg"><strong>Remboursement</strong> demandé par Marc D.</div><div class="activity-time">il y a 1h</div></div></div>
              <div class="activity-item"><div class="activity-dot" style="background:var(--accent)"></div><div class="activity-content"><div class="activity-msg"><strong>Promo activée</strong> : -20% sur l'électronique</div><div class="activity-time">il y a 2h</div></div></div>
            </div>
          </div>
        </div>
      </div>

      <!-- ════════════════════════════════════
          PAGE: COMMANDES
      ════════════════════════════════════ -->
      <div class="page" id="page-orders">
        <div class="page-header">
          <div><div class="page-heading">Commandes</div><div class="page-sub"> <span>1 247</span> commandes ce mois · <span>14</span> en attente</div></div>
          <button class="btn btn-primary" onclick="openModal('modal-order')">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 2v10M2 7h10"/></svg>
            Nouvelle commande
          </button>
        </div>
        <div class="filters-row">
          <input class="filter-input" placeholder="🔍  Rechercher une commande…" style="flex:1;min-width:200px">
          <select class="filter-select"><option>Tous les statuts</option><option>Livré</option><option>En transit</option><option>Préparation</option><option>Annulé</option></select>
          <select class="filter-select"><option>Toutes les dates</option><option>Aujourd'hui</option><option>Cette semaine</option><option>Ce mois</option></select>
          <button class="btn btn-ghost">Exporter CSV</button>
        </div>
        <div class="card">
          <div class="data-table-wrap">
            <table>
              <thead><tr><th>N° Commande</th><th>Client</th><th>Produits</th><th>Date</th><th>Montant</th><th>Statut</th><th>Actions</th></tr></thead>
              <tbody>
                <tr><td style="font-weight:600;color:var(--accent)">#CMD-4821</td><td><div style="display:flex;align-items:center;gap:8px"><div class="avatar" style="width:28px;height:28px;font-size:11px">SM</div>Sophie M.</div></td><td style="color:var(--muted)">iPhone 15 Pro × 1</td><td style="color:var(--muted)">05 mars 2026</td><td style="font-weight:600">€ 1 199</td><td><span class="pill pill-success">Livré</span></td><td><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Voir</button></td></tr>
                <tr><td style="font-weight:600;color:var(--accent)">#CMD-4820</td><td><div style="display:flex;align-items:center;gap:8px"><div class="avatar" style="width:28px;height:28px;font-size:11px">KB</div>Karim B.</div></td><td style="color:var(--muted)">Air Jordan 1 × 2</td><td style="color:var(--muted)">05 mars 2026</td><td style="font-weight:600">€ 370</td><td><span class="pill pill-warn">En transit</span></td><td><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Voir</button></td></tr>
                <tr><td style="font-weight:600;color:var(--accent)">#CMD-4819</td><td><div style="display:flex;align-items:center;gap:8px"><div class="avatar" style="width:28px;height:28px;font-size:11px">LP</div>Lucie P.</div></td><td style="color:var(--muted)">MacBook Air M3 × 1</td><td style="color:var(--muted)">04 mars 2026</td><td style="font-weight:600">€ 1 449</td><td><span class="pill pill-warn">Préparation</span></td><td><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Voir</button></td></tr>
                <tr><td style="font-weight:600;color:var(--accent)">#CMD-4818</td><td><div style="display:flex;align-items:center;gap:8px"><div class="avatar" style="width:28px;height:28px;font-size:11px">MD</div>Marc D.</div></td><td style="color:var(--muted)">Sony WH-1000XM5 × 1</td><td style="color:var(--muted)">04 mars 2026</td><td style="font-weight:600">€ 349</td><td><span class="pill pill-danger">Annulé</span></td><td><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Voir</button></td></tr>
                <tr><td style="font-weight:600;color:var(--accent)">#CMD-4817</td><td><div style="display:flex;align-items:center;gap:8px"><div class="avatar" style="width:28px;height:28px;font-size:11px">EV</div>Emma V.</div></td><td style="color:var(--muted)">Apple Watch Ultra 2 × 1</td><td style="color:var(--muted)">03 mars 2026</td><td style="font-weight:600">€ 849</td><td><span class="pill pill-success">Livré</span></td><td><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Voir</button></td></tr>
                <tr><td style="font-weight:600;color:var(--accent)">#CMD-4816</td><td><div style="display:flex;align-items:center;gap:8px"><div class="avatar" style="width:28px;height:28px;font-size:11px">AT</div>Amine T.</div></td><td style="color:var(--muted)">iPad Pro M4 × 1</td><td style="color:var(--muted)">03 mars 2026</td><td style="font-weight:600">€ 1 299</td><td><span class="pill pill-info">Traitement</span></td><td><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Voir</button></td></tr>
                <tr><td style="font-weight:600;color:var(--accent)">#CMD-4815</td><td><div style="display:flex;align-items:center;gap:8px"><div class="avatar" style="width:28px;height:28px;font-size:11px">NB</div>Nadia B.</div></td><td style="color:var(--muted)">Parfum Dior × 3</td><td style="color:var(--muted)">02 mars 2026</td><td style="font-weight:600">€ 420</td><td><span class="pill pill-success">Livré</span></td><td><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Voir</button></td></tr>
              </tbody>
            </table>
          </div>
          <div style="display:flex;align-items:center;justify-content:space-between;margin-top:20px;padding-top:16px;border-top:1px solid var(--border)">
            <span style="font-size:13px;color:var(--muted)">Affichage 1–7 sur 1 247 commandes</span>
            <div style="display:flex;gap:6px">
              <button class="btn btn-ghost" style="padding:6px 12px">← Préc.</button>
              <button class="btn btn-primary" style="padding:6px 12px">1</button>
              <button class="btn btn-ghost" style="padding:6px 12px">2</button>
              <button class="btn btn-ghost" style="padding:6px 12px">3</button>
              <button class="btn btn-ghost" style="padding:6px 12px">Suiv. →</button>
            </div>
          </div>
        </div>
      </div>

      <!-- ════════════════════════════════════
          PAGE: PRODUITS
      ════════════════════════════════════ -->
      <div class="page" id="page-products">
        <div class="page-header">
          <div><div class="page-heading">Produits</div><div class="page-sub"><span>284</span> produits · <span>12</span> en rupture de stock</div></div>
          <button class="btn btn-primary" onclick="openModal('modal-product')">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 2v10M2 7h10"/></svg>
            Ajouter un produit
          </button>
        </div>
        <div class="filters-row">
          <input class="filter-input" placeholder="🔍  Rechercher un produit…" style="flex:1;min-width:200px">
          <select class="filter-select"><option>Toutes les catégories</option><option>Électronique</option><option>Mode</option><option>Maison</option><option>Sport</option></select>
          <select class="filter-select"><option>Tous les stocks</option><option>En stock</option><option>Stock faible</option><option>Rupture</option></select>
          <select class="filter-select"><option>Trier par</option><option>Prix ↑</option><option>Prix ↓</option><option>Stock ↑</option><option>Ventes ↓</option></select>
        </div>
        <div class="card">
          <div class="data-table-wrap">
            <table>
              <thead><tr><th>Produit</th><th>Catégorie</th><th>Prix</th><th>Stock</th><th>Ventes</th><th>Statut</th><th>Actions</th></tr></thead>
              <tbody>
                <tr><td><div class="product-cell"><div class="product-thumb">📱</div><div><div class="product-name">iPhone 15 Pro 256Go</div><div class="product-sku">SKU: APL-IP15P-256</div></div></div></td><td style="color:var(--muted)">Électronique</td><td style="font-weight:600">€ 1 199</td><td><span style="color:var(--success);font-weight:600">142</span></td><td style="color:var(--muted)">1 204</td><td><span class="pill pill-success">Actif</span></td><td style="display:flex;gap:6px;padding:12px 0"><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Éditer</button><button class="btn btn-danger" style="padding:5px 10px;font-size:12px">Suppr.</button></td></tr>
                <tr><td><div class="product-cell"><div class="product-thumb">💻</div><div><div class="product-name">MacBook Air M3 13"</div><div class="product-sku">SKU: APL-MBA-M3-13</div></div></div></td><td style="color:var(--muted)">Électronique</td><td style="font-weight:600">€ 1 449</td><td><span style="color:var(--success);font-weight:600">58</span></td><td style="color:var(--muted)">892</td><td><span class="pill pill-success">Actif</span></td><td style="display:flex;gap:6px;padding:12px 0"><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Éditer</button><button class="btn btn-danger" style="padding:5px 10px;font-size:12px">Suppr.</button></td></tr>
                <tr><td><div class="product-cell"><div class="product-thumb">👟</div><div><div class="product-name">Nike Air Jordan 1 Retro</div><div class="product-sku">SKU: NK-AJ1-RET-42</div></div></div></td><td style="color:var(--muted)">Mode</td><td style="font-weight:600">€ 185</td><td><span style="color:var(--warn);font-weight:600">3</span></td><td style="color:var(--muted)">2 107</td><td><span class="pill pill-warn">Stock faible</span></td><td style="display:flex;gap:6px;padding:12px 0"><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Éditer</button><button class="btn btn-danger" style="padding:5px 10px;font-size:12px">Suppr.</button></td></tr>
                <tr><td><div class="product-cell"><div class="product-thumb">🎧</div><div><div class="product-name">Sony WH-1000XM5</div><div class="product-sku">SKU: SNY-WH1000XM5</div></div></div></td><td style="color:var(--muted)">Électronique</td><td style="font-weight:600">€ 349</td><td><span style="color:var(--danger);font-weight:600">0</span></td><td style="color:var(--muted)">634</td><td><span class="pill pill-danger">Rupture</span></td><td style="display:flex;gap:6px;padding:12px 0"><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Éditer</button><button class="btn btn-danger" style="padding:5px 10px;font-size:12px">Suppr.</button></td></tr>
                <tr><td><div class="product-cell"><div class="product-thumb">🛋️</div><div><div class="product-name">Canapé Nordic 3 places</div><div class="product-sku">SKU: MBL-CNRD-3P</div></div></div></td><td style="color:var(--muted)">Maison</td><td style="font-weight:600">€ 899</td><td><span style="color:var(--success);font-weight:600">24</span></td><td style="color:var(--muted)">318</td><td><span class="pill pill-success">Actif</span></td><td style="display:flex;gap:6px;padding:12px 0"><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Éditer</button><button class="btn btn-danger" style="padding:5px 10px;font-size:12px">Suppr.</button></td></tr>
                <tr><td><div class="product-cell"><div class="product-thumb">⌚</div><div><div class="product-name">Apple Watch Ultra 2</div><div class="product-sku">SKU: APL-AWU2-49</div></div></div></td><td style="color:var(--muted)">Électronique</td><td style="font-weight:600">€ 849</td><td><span style="color:var(--success);font-weight:600">77</span></td><td style="color:var(--muted)">521</td><td><span class="pill pill-success">Actif</span></td><td style="display:flex;gap:6px;padding:12px 0"><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Éditer</button><button class="btn btn-danger" style="padding:5px 10px;font-size:12px">Suppr.</button></td></tr>
              </tbody>
            </table>
          </div>
          <div style="display:flex;align-items:center;justify-content:space-between;margin-top:20px;padding-top:16px;border-top:1px solid var(--border)">
            <span style="font-size:13px;color:var(--muted)">Affichage 1–6 sur 284 produits</span>
            <div style="display:flex;gap:6px">
              <button class="btn btn-ghost" style="padding:6px 12px">← Préc.</button>
              <button class="btn btn-primary" style="padding:6px 12px">1</button>
              <button class="btn btn-ghost" style="padding:6px 12px">2</button>
              <button class="btn btn-ghost" style="padding:6px 12px">Suiv. →</button>
            </div>
          </div>
        </div>
      </div>

      <!-- ════════════════════════════════════
          PAGE: CLIENTS
      ════════════════════════════════════ -->
      <div class="page" id="page-customers">
        <div class="page-header">
          <div><div class="page-heading">Clients</div><div class="page-sub"> <span>3 841</span> Clients actifs</div></div>
          <button class="btn btn-primary" onclick="openModal('modal-customer')">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 2v10M2 7h10"/></svg>
            Ajouter un client
          </button>
        </div>
        <div class="filters-row">
          <input class="filter-input" placeholder="🔍  Rechercher un client…" style="flex:1;min-width:200px">
          <select class="filter-select"><option>Tous les segments</option><option>VIP</option><option>Régulier</option><option>Nouveau</option><option>Inactif</option></select>
          <select class="filter-select"><option>Trier par</option><option>Commandes ↓</option><option>Dépenses ↓</option><option>Date d'inscription ↓</option></select>
        </div>
        <div class="card">
          <div class="data-table-wrap">
            <table>
              <thead><tr><th>Client</th><th>Email</th><th>Commandes</th><th>Total dépensé</th><th>Inscrit le</th><th>Segment</th><th>Actions</th></tr></thead>
              <tbody>
                <tr><td><div style="display:flex;align-items:center;gap:10px"><div class="avatar" style="width:34px;height:34px;font-size:12px">SM</div><div><div style="font-weight:500">Sophie Martin</div><div style="font-size:11px;color:var(--muted)">+33 6 12 34 56 78</div></div></div></td><td style="color:var(--muted)">sophie.martin@gmail.com</td><td style="font-weight:600">47</td><td style="font-weight:600;color:var(--success)">€ 12 840</td><td style="color:var(--muted)">Jan 2024</td><td><span class="pill pill-success">VIP</span></td><td><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Profil</button></td></tr>
                <tr><td><div style="display:flex;align-items:center;gap:10px"><div class="avatar" style="width:34px;height:34px;font-size:12px;background:linear-gradient(135deg,#ff6b35,#ffa502)">KB</div><div><div style="font-weight:500">Karim Benzara</div><div style="font-size:11px;color:var(--muted)">+33 7 98 76 54 32</div></div></div></td><td style="color:var(--muted)">k.benzara@outlook.com</td><td style="font-weight:600">32</td><td style="font-weight:600;color:var(--success)">€ 8 210</td><td style="color:var(--muted)">Mar 2024</td><td><span class="pill pill-success">VIP</span></td><td><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Profil</button></td></tr>
                <tr><td><div style="display:flex;align-items:center;gap:10px"><div class="avatar" style="width:34px;height:34px;font-size:12px;background:linear-gradient(135deg,#2dcc7f,#00b894)">LP</div><div><div style="font-weight:500">Lucie Petit</div><div style="font-size:11px;color:var(--muted)">+33 6 45 67 89 01</div></div></div></td><td style="color:var(--muted)">lucie.petit@yahoo.fr</td><td style="font-weight:600">18</td><td style="font-weight:600">€ 4 590</td><td style="color:var(--muted)">Juin 2024</td><td><span class="pill pill-info">Régulier</span></td><td><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Profil</button></td></tr>
                <tr><td><div style="display:flex;align-items:center;gap:10px"><div class="avatar" style="width:34px;height:34px;font-size:12px;background:linear-gradient(135deg,#e8ff47,#ffa502)">MD</div><div><div style="font-weight:500">Marc Dupont</div><div style="font-size:11px;color:var(--muted)">+33 6 23 45 67 89</div></div></div></td><td style="color:var(--muted)">marc.dupont@free.fr</td><td style="font-weight:600">5</td><td style="font-weight:600">€ 920</td><td style="color:var(--muted)">Nov 2025</td><td><span class="pill pill-warn">Nouveau</span></td><td><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Profil</button></td></tr>
                <tr><td><div style="display:flex;align-items:center;gap:10px"><div class="avatar" style="width:34px;height:34px;font-size:12px;background:linear-gradient(135deg,#7c6dff,#a29bfe)">EV</div><div><div style="font-weight:500">Emma Vidal</div><div style="font-size:11px;color:var(--muted)">+33 7 12 34 56 78</div></div></div></td><td style="color:var(--muted)">emma.vidal@gmail.com</td><td style="font-weight:600">29</td><td style="font-weight:600">€ 6 140</td><td style="color:var(--muted)">Sep 2023</td><td><span class="pill pill-info">Régulier</span></td><td><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Profil</button></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ════════════════════════════════════
          PAGE: CATÉGORIES
      ════════════════════════════════════ -->
      <div class="page" id="page-categories">
        <div class="page-header">
          <div><div class="page-heading">Catégories</div><div class="page-sub"><span>8</span> catégories actives</div></div>
          <button class="btn btn-primary" onclick="openModal('modal-category')">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 2v10M2 7h10"/></svg>
            Nouvelle catégorie
          </button>
        </div>
        <div class="cat-grid">
          <div class="cat-card"><div class="cat-icon" style="background:rgba(232,255,71,.1)">📱</div><div class="cat-info"><div class="cat-name">Électronique</div><div class="cat-count">128 produits · 1 448 ventes</div></div><span class="pill pill-success" style="margin-left:auto">Actif</span></div>
          <div class="cat-card"><div class="cat-icon" style="background:rgba(124,109,255,.1)">👗</div><div class="cat-info"><div class="cat-name">Mode</div><div class="cat-count">94 produits · 1 064 ventes</div></div><span class="pill pill-success" style="margin-left:auto">Actif</span></div>
          <div class="cat-card"><div class="cat-icon" style="background:rgba(255,107,53,.1)">🛋️</div><div class="cat-info"><div class="cat-name">Maison & Déco</div><div class="cat-count">62 produits · 760 ventes</div></div><span class="pill pill-success" style="margin-left:auto">Actif</span></div>
          <div class="cat-card"><div class="cat-icon" style="background:rgba(45,204,127,.1)">⚽</div><div class="cat-info"><div class="cat-name">Sport & Loisirs</div><div class="cat-count">47 produits · 532 ventes</div></div><span class="pill pill-success" style="margin-left:auto">Actif</span></div>
          <div class="cat-card"><div class="cat-icon" style="background:rgba(255,71,87,.1)">💄</div><div class="cat-info"><div class="cat-name">Beauté & Parfums</div><div class="cat-count">38 produits · 418 ventes</div></div><span class="pill pill-success" style="margin-left:auto">Actif</span></div>
          <div class="cat-card"><div class="cat-icon" style="background:rgba(255,165,2,.1)">📚</div><div class="cat-info"><div class="cat-name">Livres & Culture</div><div class="cat-count">29 produits · 214 ventes</div></div><span class="pill pill-warn" style="margin-left:auto">Faible</span></div>
          <div class="cat-card"><div class="cat-icon" style="background:rgba(0,184,148,.1)">🧸</div><div class="cat-info"><div class="cat-name">Jouets & Enfants</div><div class="cat-count">22 produits · 196 ventes</div></div><span class="pill pill-success" style="margin-left:auto">Actif</span></div>
          <div class="cat-card"><div class="cat-icon" style="background:rgba(108,92,231,.1)">🎮</div><div class="cat-info"><div class="cat-name">Jeux Vidéo</div><div class="cat-count">18 produits · 308 ventes</div></div><span class="pill pill-danger" style="margin-left:auto">Inactif</span></div>
        </div>

        <div class="card">
          <div class="card-header"><div class="card-title">Toutes les catégories</div></div>
          <table>
            <thead><tr><th>Catégorie</th><th>Produits</th><th>Ventes ce mois</th><th>Revenus</th><th>Statut</th><th>Actions</th></tr></thead>
            <tbody>
              <tr><td><div class="product-cell"><div class="product-thumb">📱</div><div class="product-name">Électronique</div></div></td><td>128</td><td style="color:var(--success)">1 448</td><td style="font-weight:600">€ 28 400</td><td><span class="pill pill-success">Actif</span></td><td style="display:flex;gap:6px;padding:12px 0"><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Éditer</button><button class="btn btn-danger" style="padding:5px 10px;font-size:12px">Suppr.</button></td></tr>
              <tr><td><div class="product-cell"><div class="product-thumb">👗</div><div class="product-name">Mode</div></div></td><td>94</td><td style="color:var(--success)">1 064</td><td style="font-weight:600">€ 12 800</td><td><span class="pill pill-success">Actif</span></td><td style="display:flex;gap:6px;padding:12px 0"><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Éditer</button><button class="btn btn-danger" style="padding:5px 10px;font-size:12px">Suppr.</button></td></tr>
              <tr><td><div class="product-cell"><div class="product-thumb">🛋️</div><div class="product-name">Maison & Déco</div></div></td><td>62</td><td>760</td><td style="font-weight:600">€ 9 100</td><td><span class="pill pill-success">Actif</span></td><td style="display:flex;gap:6px;padding:12px 0"><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Éditer</button><button class="btn btn-danger" style="padding:5px 10px;font-size:12px">Suppr.</button></td></tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- ════════════════════════════════════
          PAGE: PROMOTIONS
      ════════════════════════════════════ -->
      <div class="page" id="page-promotions">
        <div class="page-header">
          <div><div class="page-heading">Promotions</div><div class="page-sub"><span>5</span> promotions actives</div></div>
          <button class="btn btn-primary" onclick="openModal('modal-promo')">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 2v10M2 7h10"/></svg>
            Créer une promo
          </button>
        </div>
        <div class="card" style="margin-bottom:16px">
          <div class="card-header"><div class="card-title">Promotions actives</div></div>
          <div class="promo-card">
            <div class="promo-badge" style="background:rgba(232,255,71,.1);color:var(--accent)">-20%</div>
            <div class="promo-info">
              <div class="promo-name">Soldes Électronique Printemps</div>
              <div class="promo-details">Code: ELEC20 · Valable jusqu'au 10 mars 2026 · Utilisé 847 fois</div>
            </div>
            <span class="pill pill-success">Active</span>
            <div class="promo-actions"><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Éditer</button><button class="btn btn-danger" style="padding:5px 10px;font-size:12px">Désactiver</button></div>
          </div>
          <div class="promo-card">
            <div class="promo-badge" style="background:rgba(124,109,255,.1);color:var(--accent3)">-15%</div>
            <div class="promo-info">
              <div class="promo-name">Mode Femme — Collection Été</div>
              <div class="promo-details">Code: MODE15 · Valable jusqu'au 31 mars 2026 · Utilisé 312 fois</div>
            </div>
            <span class="pill pill-success">Active</span>
            <div class="promo-actions"><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Éditer</button><button class="btn btn-danger" style="padding:5px 10px;font-size:12px">Désactiver</button></div>
          </div>
          <div class="promo-card">
            <div class="promo-badge" style="background:rgba(255,107,53,.1);color:var(--accent2)">-30%</div>
            <div class="promo-info">
              <div class="promo-name">Flash Sale Weekend</div>
              <div class="promo-details">Code: FLASH30 · Valable 7–8 mars 2026 · Utilisé 1 204 fois</div>
            </div>
            <span class="pill pill-success">Active</span>
            <div class="promo-actions"><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Éditer</button><button class="btn btn-danger" style="padding:5px 10px;font-size:12px">Désactiver</button></div>
          </div>
          <div class="promo-card">
            <div class="promo-badge" style="background:rgba(45,204,127,.1);color:var(--success)">-10%</div>
            <div class="promo-info">
              <div class="promo-name">Bienvenue Nouveaux Clients</div>
              <div class="promo-details">Code: BIENVENUE · Permanent · Utilisé 4 203 fois</div>
            </div>
            <span class="pill pill-success">Active</span>
            <div class="promo-actions"><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Éditer</button><button class="btn btn-danger" style="padding:5px 10px;font-size:12px">Désactiver</button></div>
          </div>
        </div>
        <div class="card">
          <div class="card-header"><div class="card-title">Promotions expirées</div></div>
          <div class="promo-card" style="opacity:.5">
            <div class="promo-badge" style="background:var(--surface2);color:var(--muted)">-25%</div>
            <div class="promo-info">
              <div class="promo-name">Black Friday 2025</div>
              <div class="promo-details">Code: BF25 · Expiré le 30 nov. 2025 · Utilisé 8 940 fois</div>
            </div>
            <span class="pill pill-danger">Expirée</span>
            <div class="promo-actions"><button class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Dupliquer</button></div>
          </div>
        </div>
      </div>

      <!-- ════════════════════════════════════
          PAGE: ANALYTIQUE
      ════════════════════════════════════ -->
      <div class="page" id="page-analytics">
        <div class="page-header">
          <div><div class="page-heading">Analytique</div><div class="page-sub">Données du 1er au 5 mars 2026</div></div>
          <div class="period-tabs"><div class="period-tab">7J</div><div class="period-tab active">30J</div><div class="period-tab">90J</div><div class="period-tab">1 an</div></div>
        </div>
        <div class="stats-grid">
          <div class="stat-card green"><div class="stat-header"><div class="stat-icon green"><svg viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 14l3-5 3 2 3-4 3 3"/></svg></div><span class="stat-change up">↑ 12.4%</span></div><div class="stat-value">€ 48 290</div><div class="stat-label">Revenus totaux</div></div>
          <div class="stat-card yellow"><div class="stat-header"><div class="stat-icon yellow"><svg viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 5h12l-1.5 8H4.5L3 5z"/><circle cx="7" cy="15" r="1"/><circle cx="12" cy="15" r="1"/></svg></div><span class="stat-change up">↑ 8.1%</span></div><div class="stat-value">€ 38.74</div><div class="stat-label">Panier moyen</div></div>
          <div class="stat-card orange"><div class="stat-header"><div class="stat-icon orange"><svg viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 3h12v4L9 12 3 7V3z"/></svg></div><span class="stat-change up">↑ 3.2%</span></div><div class="stat-value">68.4%</div><div class="stat-label">Taux de conversion</div></div>
          <div class="stat-card purple"><div class="stat-header"><div class="stat-icon purple"><svg viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 9h12M9 3v12"/></svg></div><span class="stat-change down">↓ 1.8%</span></div><div class="stat-value">2.8%</div><div class="stat-label">Taux d'abandon</div></div>
        </div>
        <div class="analytics-grid">
          <div class="card">
            <div class="card-header"><div class="card-title">Revenus par jour</div></div>
            <div class="bar-chart-wrap">
              <div class="bar-col"><div class="bar-val">1.2k</div><div class="bar-fill" style="height:45%;background:var(--accent3)"></div><div class="bar-label">Lun</div></div>
              <div class="bar-col"><div class="bar-val">2.1k</div><div class="bar-fill" style="height:70%;background:var(--accent3)"></div><div class="bar-label">Mar</div></div>
              <div class="bar-col"><div class="bar-val">1.8k</div><div class="bar-fill" style="height:60%;background:var(--accent3)"></div><div class="bar-label">Mer</div></div>
              <div class="bar-col"><div class="bar-val">2.9k</div><div class="bar-fill" style="height:90%;background:var(--accent)"></div><div class="bar-label">Jeu</div></div>
              <div class="bar-col"><div class="bar-val">3.2k</div><div class="bar-fill" style="height:100%;background:var(--accent)"></div><div class="bar-label">Ven</div></div>
              <div class="bar-col"><div class="bar-val">2.5k</div><div class="bar-fill" style="height:78%;background:var(--accent3)"></div><div class="bar-label">Sam</div></div>
              <div class="bar-col"><div class="bar-val">1.4k</div><div class="bar-fill" style="height:44%;background:var(--accent3)"></div><div class="bar-label">Dim</div></div>
            </div>
          </div>
          <div class="card">
            <div class="card-header"><div class="card-title">Avis clients</div><div style="font-family:'Syne',sans-serif;font-size:28px;font-weight:800;color:var(--warn)">4.7 ★</div></div>
            <div>
              <div class="rating-row"><span class="rating-stars">★★★★★</span><div class="rating-bar-bg"><div class="rating-bar-fill" style="width:62%"></div></div><span class="rating-count">62%</span></div>
              <div class="rating-row"><span class="rating-stars">★★★★☆</span><div class="rating-bar-bg"><div class="rating-bar-fill" style="width:24%"></div></div><span class="rating-count">24%</span></div>
              <div class="rating-row"><span class="rating-stars">★★★☆☆</span><div class="rating-bar-bg"><div class="rating-bar-fill" style="width:9%"></div></div><span class="rating-count">9%</span></div>
              <div class="rating-row"><span class="rating-stars">★★☆☆☆</span><div class="rating-bar-bg"><div class="rating-bar-fill" style="width:3%"></div></div><span class="rating-count">3%</span></div>
              <div class="rating-row"><span class="rating-stars">★☆☆☆☆</span><div class="rating-bar-bg"><div class="rating-bar-fill" style="width:2%"></div></div><span class="rating-count">2%</span></div>
            </div>
          </div>
        </div>
        <div class="analytics-grid">
          <div class="card">
            <div class="card-header"><div class="card-title">Top produits vendus</div></div>
            <table>
              <thead><tr><th>#</th><th>Produit</th><th>Ventes</th><th>Revenus</th></tr></thead>
              <tbody>
                <tr><td style="color:var(--accent);font-weight:700">1</td><td><div class="product-cell"><div class="product-thumb">📱</div><div class="product-name">iPhone 15 Pro</div></div></td><td>1 204</td><td style="font-weight:600">€ 24 490</td></tr>
                <tr><td style="color:var(--accent3);font-weight:700">2</td><td><div class="product-cell"><div class="product-thumb">👟</div><div class="product-name">Air Jordan 1</div></div></td><td>2 107</td><td style="font-weight:600">€ 18 420</td></tr>
                <tr><td style="color:var(--accent2);font-weight:700">3</td><td><div class="product-cell"><div class="product-thumb">💻</div><div class="product-name">MacBook Air M3</div></div></td><td>892</td><td style="font-weight:600">€ 16 910</td></tr>
                <tr><td style="color:var(--muted);font-weight:700">4</td><td><div class="product-cell"><div class="product-thumb">⌚</div><div class="product-name">Apple Watch Ultra 2</div></div></td><td>521</td><td style="font-weight:600">€ 11 730</td></tr>
              </tbody>
            </table>
          </div>
          <div class="card">
            <div class="card-header"><div class="card-title">Sources de trafic</div></div>
            <div style="display:flex;flex-direction:column;gap:12px;margin-top:8px">
              <div><div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:6px"><span>Google / SEO</span><span style="font-weight:600">42%</span></div><div style="height:6px;background:var(--border);border-radius:3px"><div style="height:100%;width:42%;background:var(--accent);border-radius:3px"></div></div></div>
              <div><div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:6px"><span>Réseaux sociaux</span><span style="font-weight:600">28%</span></div><div style="height:6px;background:var(--border);border-radius:3px"><div style="height:100%;width:28%;background:var(--accent3);border-radius:3px"></div></div></div>
              <div><div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:6px"><span>Email marketing</span><span style="font-weight:600">18%</span></div><div style="height:6px;background:var(--border);border-radius:3px"><div style="height:100%;width:18%;background:var(--accent2);border-radius:3px"></div></div></div>
              <div><div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:6px"><span>Trafic direct</span><span style="font-weight:600">12%</span></div><div style="height:6px;background:var(--border);border-radius:3px"><div style="height:100%;width:12%;background:var(--success);border-radius:3px"></div></div></div>
            </div>
          </div>
        </div>
      </div>

      <!-- ════════════════════════════════════
          PAGE: PARAMÈTRES
      ════════════════════════════════════ -->
      <div class="page" id="page-settings">
        <div class="page-header">
          <div><div class="page-heading">Paramètres</div><div class="page-sub">Configuration de la boutique</div></div>
          <button class="btn btn-primary">Sauvegarder les modifications</button>
        </div>
        <div class="settings-grid">
          <div class="settings-nav">
            <div class="settings-nav-item active" data-section="general">Général</div>
            <div class="settings-nav-item" data-section="boutique">Boutique</div>
            <div class="settings-nav-item" data-section="paiement">Paiement</div>
            <div class="settings-nav-item" data-section="livraison">Livraison</div>
            <div class="settings-nav-item" data-section="notifications">Notifications</div>
            <div class="settings-nav-item" data-section="securite">Sécurité</div>
          </div>
          <div>
            <div class="settings-section active card" id="section-general">
              <div class="section-title">Informations générales</div>
              <div class="section-sub">Paramètres de base de votre boutique</div>
              <div class="form-grid">
                <div class="form-group"><label class="form-label">Nom de la boutique</label><input class="form-input" value="ShopCore"></div>
                <div class="form-group"><label class="form-label">Email de contact</label><input class="form-input" value="contact@shopcore.fr"></div>
                <div class="form-group"><label class="form-label">Téléphone</label><input class="form-input" value="+33 1 23 45 67 89"></div>
                <div class="form-group"><label class="form-label">Devise</label><select class="form-input"><option>EUR — Euro (€)</option><option>USD — Dollar ($)</option><option>GBP — Livre (£)</option></select></div>
                <div class="form-group full"><label class="form-label">Adresse</label><input class="form-input" value="12 Rue de la Paix, 75001 Paris, France"></div>
                <div class="form-group full"><label class="form-label">Description</label><textarea class="form-input">Votre boutique en ligne de confiance pour l'électronique, la mode et bien plus encore.</textarea></div>
              </div>
            </div>
            <div class="settings-section card" id="section-boutique">
              <div class="section-title">Configuration boutique</div>
              <div class="section-sub">Paramètres d'affichage et de comportement</div>
              <div class="form-grid" style="margin-bottom:20px">
                <div class="form-group"><label class="form-label">Produits par page</label><select class="form-input"><option>12</option><option selected>24</option><option>48</option></select></div>
                <div class="form-group"><label class="form-label">Tri par défaut</label><select class="form-input"><option>Nouveautés</option><option>Prix croissant</option><option selected>Popularité</option></select></div>
              </div>
              <div class="divider"></div>
              <div class="toggle-row"><div class="toggle-info"><div class="toggle-name">Avis clients</div><div class="toggle-desc">Afficher les avis sur les fiches produits</div></div><div class="toggle on" onclick="this.classList.toggle('on')"></div></div>
              <div class="toggle-row"><div class="toggle-info"><div class="toggle-name">Stock visible</div><div class="toggle-desc">Afficher la quantité en stock aux clients</div></div><div class="toggle on" onclick="this.classList.toggle('on')"></div></div>
              <div class="toggle-row"><div class="toggle-info"><div class="toggle-name">Liste de souhaits</div><div class="toggle-desc">Permettre aux clients de sauvegarder des produits</div></div><div class="toggle" onclick="this.classList.toggle('on')"></div></div>
            </div>
            <div class="settings-section card" id="section-paiement">
              <div class="section-title">Méthodes de paiement</div>
              <div class="section-sub">Configurez les modes de paiement acceptés</div>
              <div class="toggle-row"><div class="toggle-info"><div class="toggle-name">Stripe (Carte bancaire)</div><div class="toggle-desc">Visa, Mastercard, American Express</div></div><div class="toggle on" onclick="this.classList.toggle('on')"></div></div>
              <div class="toggle-row"><div class="toggle-info"><div class="toggle-name">PayPal</div><div class="toggle-desc">Paiement via compte PayPal</div></div><div class="toggle on" onclick="this.classList.toggle('on')"></div></div>
              <div class="toggle-row"><div class="toggle-info"><div class="toggle-name">Apple Pay</div><div class="toggle-desc">Paiement rapide sur appareils Apple</div></div><div class="toggle" onclick="this.classList.toggle('on')"></div></div>
              <div class="toggle-row"><div class="toggle-info"><div class="toggle-name">Virement bancaire</div><div class="toggle-desc">Paiement par virement SEPA</div></div><div class="toggle" onclick="this.classList.toggle('on')"></div></div>
              <div class="divider"></div>
              <div class="form-grid">
                <div class="form-group"><label class="form-label">Clé publique Stripe</label><input class="form-input" value="pk_live_••••••••••••••••" type="password"></div>
                <div class="form-group"><label class="form-label">Clé secrète Stripe</label><input class="form-input" value="sk_live_••••••••••••••••" type="password"></div>
              </div>
            </div>
            <div class="settings-section card" id="section-livraison">
              <div class="section-title">Livraison</div>
              <div class="section-sub">Zones et tarifs de livraison</div>
              <div class="form-grid" style="margin-bottom:20px">
                <div class="form-group"><label class="form-label">Livraison gratuite à partir de</label><input class="form-input" value="50" type="number"><span style="font-size:12px;color:var(--muted);margin-top:4px">euros</span></div>
                <div class="form-group"><label class="form-label">Délai estimé (standard)</label><input class="form-input" value="3-5 jours ouvrés"></div>
              </div>
              <div class="toggle-row"><div class="toggle-info"><div class="toggle-name">Livraison express disponible</div><div class="toggle-desc">Proposer une option 24h (supplément automatique)</div></div><div class="toggle on" onclick="this.classList.toggle('on')"></div></div>
              <div class="toggle-row"><div class="toggle-info"><div class="toggle-name">Click & Collect</div><div class="toggle-desc">Retrait en magasin</div></div><div class="toggle" onclick="this.classList.toggle('on')"></div></div>
            </div>
            <div class="settings-section card" id="section-notifications">
              <div class="section-title">Notifications</div>
              <div class="section-sub">Alertes et emails automatiques</div>
              <div class="toggle-row"><div class="toggle-info"><div class="toggle-name">Nouvelle commande</div><div class="toggle-desc">Recevoir un email à chaque nouvelle commande</div></div><div class="toggle on" onclick="this.classList.toggle('on')"></div></div>
              <div class="toggle-row"><div class="toggle-info"><div class="toggle-name">Stock faible</div><div class="toggle-desc">Alerte quand le stock passe sous le seuil critique</div></div><div class="toggle on" onclick="this.classList.toggle('on')"></div></div>
              <div class="toggle-row"><div class="toggle-info"><div class="toggle-name">Avis client reçu</div><div class="toggle-desc">Notification lors d'un nouvel avis</div></div><div class="toggle" onclick="this.classList.toggle('on')"></div></div>
              <div class="toggle-row"><div class="toggle-info"><div class="toggle-name">Rapport hebdomadaire</div><div class="toggle-desc">Résumé des performances chaque lundi</div></div><div class="toggle on" onclick="this.classList.toggle('on')"></div></div>
            </div>
            <div class="settings-section card" id="section-securite">
              <div class="section-title">Sécurité</div>
              <div class="section-sub">Accès et authentification</div>
              <div class="form-grid" style="margin-bottom:20px">
                <div class="form-group"><label class="form-label">Mot de passe actuel</label><input class="form-input" type="password" placeholder="••••••••"></div>
                <div class="form-group"></div>
                <div class="form-group"><label class="form-label">Nouveau mot de passe</label><input class="form-input" type="password" placeholder="••••••••"></div>
                <div class="form-group"><label class="form-label">Confirmer le mot de passe</label><input class="form-input" type="password" placeholder="••••••••"></div>
              </div>
              <div class="divider"></div>
              <div class="toggle-row"><div class="toggle-info"><div class="toggle-name">Authentification 2FA</div><div class="toggle-desc">Sécurité renforcée par double facteur</div></div><div class="toggle" onclick="this.classList.toggle('on')"></div></div>
              <div class="toggle-row"><div class="toggle-info"><div class="toggle-name">Sessions actives</div><div class="toggle-desc">Déconnecter les autres appareils automatiquement</div></div><div class="toggle on" onclick="this.classList.toggle('on')"></div></div>
              <div style="margin-top:16px"><button class="btn btn-danger">Révoquer toutes les sessions</button></div>
            </div>
          </div>
        </div>
      </div>

    </div><!-- /content -->
  </main>
   
<!-- ════════════════════════════════════
  MODAL
════════════════════════════════════ -->

<!-- Modal: Nouvelle commande -->
<div class="modal-overlay" id="modal-order">
  <div class="modal">
    <div class="modal-header"><div class="modal-title">Nouvelle commande</div><div class="modal-close" onclick="closeModal('modal-order')">✕</div></div>
    
    <form action="" method="">
      <div class="form-grid">
        <div class="form-group">
          <label class="form-label">Client</label>
          <select name="client" class="form-input">
            <option value="">Sélectionner un client…</option>
            <option value="id">Sophie Martin</option>
            <option value="id">Karim Benzara</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Statut</label>
          <select name="statut" class="form-input">
            <option value="">Traitement</option>
            <option value="">Préparation</option>
            <option value="">En transit</option>
            <option value="">Livré</option>
          </select>
        </div>

        <div class="form-group full">
          <label class="form-label">Produits</label>
          <div class="product-search-wrap">
            <div class="product-chips" id="product-chips"></div>
            <input class="form-input" id="product-search-input" placeholder="Rechercher des produits…" autocomplete="off">
            <input type="hidden" id="order-products-input" name="produits">
            <div class="product-dropdown" id="product-dropdown"></div>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Montant total</label>
          <input type="number" id="order-total-input" name="montant" class="form-input" placeholder="0.00" step="0.01" readonly>
        </div>

        <div class="form-group">
          <label class="form-label">Mode de paiement</label>
          <select name="modpai" class="form-input">
            <option value="">Carte bancaire</option>
            <option value="">PayPal</option>
            <option value="">Virement</option>
          </select>
        </div>

        <div class="form-group full">
          <label class="form-label">Adresse de livraison</label>
          <input type="text" name="address" class="form-input" placeholder="12 Rue de la Paix, 75001 Paris">
        </div>
      </div>

      <div style="display:flex;gap:10px;margin-top:24px;justify-content:flex-end">
        <button class="btn btn-ghost" onclick="closeModal('modal-order')">Annuler</button>
        <button class="btn btn-primary" type="submit">Créer la commande</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal: Nouveau produit -->
<div class="modal-overlay" id="modal-product">
  <div class="modal">
      <div class="modal-header"><div class="modal-title">Ajouter un produit</div><div class="modal-close" onclick="closeModal('modal-product')">✕</div></div>
      <div class="form-grid">
      <div class="form-group full"><label class="form-label">Nom du produit</label><input class="form-input" placeholder="Ex: iPhone 15 Pro 256Go"></div>
      <div class="form-group"><label class="form-label">Prix (€)</label><input class="form-input" placeholder="0.00" type="number"></div>
      <div class="form-group"><label class="form-label">Stock initial</label><input class="form-input" placeholder="0" type="number"></div>
      <div class="form-group"><label class="form-label">Catégorie</label><select class="form-input"><option>Électronique</option><option>Mode</option><option>Maison</option><option>Sport</option></select></div>
      <div class="form-group"><label class="form-label">SKU</label><input class="form-input" placeholder="EX-SKU-001"></div>
      <div class="form-group full"><label class="form-label">Description</label><textarea class="form-input" placeholder="Description du produit…"></textarea></div>
      <div class="form-group"><label class="form-label">Statut</label><select class="form-input"><option>Actif</option><option>Inactif</option><option>Brouillon</option></select></div>
      <div class="form-group"><label class="form-label">Seuil stock faible</label><input class="form-input" value="5" type="number"></div>
      </div>
      <div style="display:flex;gap:10px;margin-top:24px;justify-content:flex-end">
      <button class="btn btn-ghost" onclick="closeModal('modal-product')">Annuler</button>
      <button class="btn btn-primary">Ajouter le produit</button>
      </div>
  </div>
</div>

<!-- Modal: Nouveau client -->
<div class="modal-overlay" id="modal-customer">
    <div class="modal">
        <div class="modal-header"><div class="modal-title">Ajouter un client</div><div class="modal-close" onclick="closeModal('modal-customer')">✕</div></div>
        <div class="form-grid">
        <div class="form-group"><label class="form-label">Prénom</label><input class="form-input" placeholder="Sophie"></div>
        <div class="form-group"><label class="form-label">Nom</label><input class="form-input" placeholder="Martin"></div>
        <div class="form-group"><label class="form-label">Email</label><input class="form-input" placeholder="sophie@example.com" type="email"></div>
        <div class="form-group"><label class="form-label">Téléphone</label><input class="form-input" placeholder="+33 6 00 00 00 00"></div>
        <div class="form-group full"><label class="form-label">Adresse</label><input class="form-input" placeholder="Adresse complète"></div>
        <div class="form-group"><label class="form-label">Segment</label><select class="form-input"><option>Nouveau</option><option>Régulier</option><option>VIP</option></select></div>
        <div class="form-group"><label class="form-label">Mot de passe</label><input class="form-input" placeholder="••••••••" type="password"></div>
        </div>
        <div style="display:flex;gap:10px;margin-top:24px;justify-content:flex-end">
        <button class="btn btn-ghost" onclick="closeModal('modal-customer')">Annuler</button>
        <button class="btn btn-primary">Créer le compte</button>
        </div>
    </div>
</div>

<!-- Modal: Nouvelle catégorie -->
<div class="modal-overlay" id="modal-category">
    <div class="modal">
        <div class="modal-header"><div class="modal-title">Nouvelle catégorie</div><div class="modal-close" onclick="closeModal('modal-category')">✕</div></div>
        <div class="form-grid">
        <div class="form-group full"><label class="form-label">Nom de la catégorie</label><input class="form-input" placeholder="Ex: Électronique"></div>
        <div class="form-group"><label class="form-label">Icône (emoji)</label><input class="form-input" placeholder="📱"></div>
        <div class="form-group"><label class="form-label">Statut</label><select class="form-input"><option>Actif</option><option>Inactif</option></select></div>
        <div class="form-group full"><label class="form-label">Description</label><textarea class="form-input" placeholder="Description de la catégorie…"></textarea></div>
        <div class="form-group"><label class="form-label">Catégorie parente</label><select class="form-input"><option>Aucune (niveau racine)</option><option>Électronique</option><option>Mode</option></select></div>
        <div class="form-group"><label class="form-label">Ordre d'affichage</label><input class="form-input" value="0" type="number"></div>
        </div>
        <div style="display:flex;gap:10px;margin-top:24px;justify-content:flex-end">
        <button class="btn btn-ghost" onclick="closeModal('modal-category')">Annuler</button>
        <button class="btn btn-primary">Créer la catégorie</button>
        </div>
    </div>
</div>

<!-- Modal: Nouvelle promo -->
<div class="modal-overlay" id="modal-promo">
    <div class="modal">
        <div class="modal-header"><div class="modal-title">Créer une promotion</div><div class="modal-close" onclick="closeModal('modal-promo')">✕</div></div>
        <div class="form-grid">
        <div class="form-group full"><label class="form-label">Nom de la promotion</label><input class="form-input" placeholder="Ex: Soldes Printemps"></div>
        <div class="form-group"><label class="form-label">Code promo</label><input class="form-input" placeholder="EX: SPRING20"></div>
        <div class="form-group"><label class="form-label">Type de réduction</label><select class="form-input"><option>Pourcentage (%)</option><option>Montant fixe (€)</option></select></div>
        <div class="form-group"><label class="form-label">Valeur</label><input class="form-input" placeholder="20" type="number"></div>
        <div class="form-group"><label class="form-label">Date de début</label><input class="form-input" type="date"></div>
        <div class="form-group"><label class="form-label">Date de fin</label><input class="form-input" type="date"></div>
        <div class="form-group"><label class="form-label">Utilisations max.</label><input class="form-input" placeholder="Illimité" type="number"></div>
        <div class="form-group"><label class="form-label">Applicable à</label><select class="form-input"><option>Tous les produits</option><option>Catégorie spécifique</option><option>Produits sélectionnés</option></select></div>
        </div>
        <div style="display:flex;gap:10px;margin-top:24px;justify-content:flex-end">
        <button class="btn btn-ghost" onclick="closeModal('modal-promo')">Annuler</button>
        <button class="btn btn-primary">Créer la promotion</button>
        </div>
    </div>
</div>

<div class="sidebar-overlay" id="sidebar-overlay"></div>

<script>
  // ── Hamburger / Sidebar toggle ──
  const hamburger = document.getElementById('hamburger');
  const sidebar   = document.querySelector('.sidebar');
  const sidebarOverlay = document.getElementById('sidebar-overlay');

  function openSidebar() {
    sidebar.classList.add('open');
    sidebarOverlay.classList.add('open');
    hamburger.classList.add('open');
  }
  function closeSidebar() {
    sidebar.classList.remove('open');
    sidebarOverlay.classList.remove('open');
    hamburger.classList.remove('open');
  }
  hamburger.addEventListener('click', () => {
    sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
  });
  sidebarOverlay.addEventListener('click', closeSidebar);

  const titles = {
    dashboard: 'Tableau de bord', orders: 'Commandes', products: 'Produits',
    customers: 'Clients', categories: 'Catégories', promotions: 'Promotions',
    analytics: 'Analytique', settings: 'Paramètres'
  };

  function navigate(pageId) {
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
    const page = document.getElementById('page-' + pageId);
    if (page) page.classList.add('active');
    const navItem = document.querySelector('[data-page="' + pageId + '"]');
    if (navItem) navItem.classList.add('active');
    document.getElementById('topbar-title').textContent = titles[pageId] || '';
    localStorage.setItem('adminActivePage', pageId);
  }

  document.querySelectorAll('.nav-item[data-page]').forEach(item => {
    item.addEventListener('click', () => {
      navigate(item.dataset.page);
      if (window.innerWidth <= 1024) closeSidebar();
    });
  });

  // Restore active page on reload
  const savedPage = localStorage.getItem('adminActivePage');
  if (savedPage && document.getElementById('page-' + savedPage)) {
    navigate(savedPage);
  }

  // Period tabs
  document.querySelectorAll('.period-tabs').forEach(tabs => {
    tabs.querySelectorAll('.period-tab').forEach(tab => {
      tab.addEventListener('click', () => {
        tabs.querySelectorAll('.period-tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
      });
    });
  });

  // Settings nav
  function navigateSettings(sectionId) {
    document.querySelectorAll('.settings-nav-item').forEach(i => i.classList.remove('active'));
    document.querySelectorAll('.settings-section').forEach(s => s.classList.remove('active'));
    const item = document.querySelector('.settings-nav-item[data-section="' + sectionId + '"]');
    if (item) item.classList.add('active');
    const section = document.getElementById('section-' + sectionId);
    if (section) section.classList.add('active');
    localStorage.setItem('adminActiveSection', sectionId);
  }

  document.querySelectorAll('.settings-nav-item').forEach(item => {
    item.addEventListener('click', () => navigateSettings(item.dataset.section));
  });

  // Restore active settings section on reload
  const savedSection = localStorage.getItem('adminActiveSection');
  if (savedSection && document.getElementById('section-' + savedSection)) {
    navigateSettings(savedSection);
  }

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

  // ── PRODUCT SEARCH AUTOCOMPLETE ──
  const productCatalog = [
    { name: 'MacBook Pro 16" M3 Max',    price: '3 499 €', numPrice: 3499,  emoji: '💻' },
    { name: 'iPhone 15 Pro 256Go',        price: '1 199 €', numPrice: 1199,  emoji: '📱' },
    { name: 'Sony WH-1000XM5',            price: '349 €',   numPrice: 349,   emoji: '🎧' },
    { name: 'iPad Air 5 256Go',           price: '899 €',   numPrice: 899,   emoji: '📲' },
    { name: 'AirPods Pro 2',              price: '279 €',   numPrice: 279,   emoji: '🎵' },
    { name: 'Samsung Galaxy S24 Ultra',   price: '1 299 €', numPrice: 1299,  emoji: '📱' },
    { name: 'Dell XPS 15',                price: '1 799 €', numPrice: 1799,  emoji: '💻' },
    { name: 'ThinkPad X1 Carbon',         price: '1 599 €', numPrice: 1599,  emoji: '💻' },
    { name: 'Surface Pro 9',              price: '1 099 €', numPrice: 1099,  emoji: '📲' },
    { name: 'Canon EOS R8',               price: '1 649 €', numPrice: 1649,  emoji: '📷' },
    { name: 'Apple Watch Series 9',       price: '399 €',   numPrice: 399,   emoji: '⌚' },
    { name: 'LG OLED 65"',               price: '2 199 €', numPrice: 2199,  emoji: '📺' },
  ];

  let selectedProducts = [];
  const searchInput    = document.getElementById('product-search-input');
  const dropdown       = document.getElementById('product-dropdown');
  const chipsContainer = document.getElementById('product-chips');
  const totalInput     = document.getElementById('order-total-input');
  const namesInput     = document.getElementById('order-products-input');

  function syncOrderInputs() {
    // Noms → input caché (séparés par " | ")
    namesInput.value = selectedProducts.map(p => p.name).join(' | ');
    // Prix → input montant (somme des prix numériques)
    const total = selectedProducts.reduce((sum, p) => sum + p.numPrice, 0);
    totalInput.value = total > 0 ? total.toFixed(2) : '';
  }

  function renderChips() {
    chipsContainer.innerHTML = selectedProducts.map((p, i) =>
      `<span class="product-chip">${p.emoji} ${p.name}<span class="chip-remove" data-index="${i}">✕</span></span>`
    ).join('');
    chipsContainer.querySelectorAll('.chip-remove').forEach(btn => {
      btn.addEventListener('click', () => {
        selectedProducts.splice(parseInt(btn.dataset.index), 1);
        renderChips();
        syncOrderInputs();
        renderDropdown(searchInput.value);
      });
    });
  }

  function renderDropdown(query) {
    const q = query.toLowerCase().trim();
    const available = productCatalog.filter(p => !selectedProducts.includes(p));
    const results   = q ? available.filter(p => p.name.toLowerCase().includes(q)) : available;
    if (results.length === 0) {
      dropdown.innerHTML = '<div class="product-drop-no-result">Aucun produit trouvé</div>';
    } else {
      dropdown.innerHTML = results.map(p =>
        `<div class="product-drop-item" data-name="${p.name}">
          <span class="drop-emoji">${p.emoji}</span>
          <span class="drop-name">${p.name}</span>
          <span class="drop-price">${p.price}</span>
        </div>`
      ).join('');
      dropdown.querySelectorAll('.product-drop-item').forEach(item => {
        item.addEventListener('click', () => {
          const product = productCatalog.find(p => p.name === item.dataset.name);
          if (product && !selectedProducts.includes(product)) {
            selectedProducts.push(product);
            renderChips();
            syncOrderInputs();
          }
          searchInput.value = '';
          dropdown.classList.remove('open');
        });
      });
    }
  }

  function resetProductSearch() {
    selectedProducts = [];
    if (chipsContainer) chipsContainer.innerHTML = '';
    if (searchInput)    searchInput.value = '';
    if (dropdown)       dropdown.classList.remove('open');
  }

  if (searchInput) {
    searchInput.addEventListener('input', function () {
      renderDropdown(this.value);
      dropdown.classList.add('open');
    });
    searchInput.addEventListener('focus', function () {
      renderDropdown(this.value);
      dropdown.classList.add('open');
    });
    document.addEventListener('click', function (e) {
      if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.classList.remove('open');
      }
    });
  }
</script>
@endsection