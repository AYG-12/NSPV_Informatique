@php $title = "Tableau de bord"; @endphp

@extends('layouts.admin')

@section('content')
    <div>
        <div class="stats-grid">

            <div class="stat-card green">
                <div class="stat-header">
                    <div class="stat-icon green">
                        <svg viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 14l3-5 3 2 3-4 3 3"/></svg>
                    </div>
                    <span class="stat-change {{ $revenuePct >= 0 ? 'up' : 'down' }}">{{ $revenuePct >= 0 ? '↑' : '↓' }} {{ abs($revenuePct) }}%</span>
                </div>
                <div class="stat-value">{{ number_format($revenueThisMonth, 0, ',', ' ') }} F</div>
                <div class="stat-label">Revenus ce mois</div>
            </div>

            <div class="stat-card yellow">
                <div class="stat-header">
                    <div class="stat-icon yellow">
                        <svg viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 5h12l-1.5 8H4.5L3 5z"/><circle cx="7" cy="15" r="1"/><circle cx="12" cy="15" r="1"/></svg>
                    </div>
                    <span class="stat-change {{ $ordersPct >= 0 ? 'up' : 'down' }}">{{ $ordersPct >= 0 ? '↑' : '↓' }} {{ abs($ordersPct) }}%</span>
                </div>
                <div class="stat-value">{{ $ordersThisMonth }}</div>
                <div class="stat-label">Commandes ce mois · <strong>{{ $pendingCount }}</strong> en attente</div>
            </div>

            <div class="stat-card orange">
                <div class="stat-header">
                    <div class="stat-icon orange">
                        <svg viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="6" r="3"/><path d="M4 16c0-2.8 2.2-5 5-5s5 2.2 5 5"/></svg>
                    </div>
                    <span class="stat-change {{ $clientsPct >= 0 ? 'up' : 'down' }}">{{ $clientsPct >= 0 ? '↑' : '↓' }} {{ abs($clientsPct) }}%</span>
                </div>
                <div class="stat-value">{{ $clientsThisMonth }}</div>
                <div class="stat-label">Nouveaux clients ce mois</div>
            </div>

            <div class="stat-card purple">
                <div class="stat-header">
                    <div class="stat-icon purple">
                        <svg viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 14h10M4 10h10M4 6h6"/></svg>
                    </div>
                </div>
                <div class="stat-value">{{ $lowStock->count() }}</div>
                <div class="stat-label">Produits stock faible (≤5)</div>
            </div>

            <div class="stat-card" style="border-color:rgba(56,189,248,.25)">
                <div class="stat-header">
                    <div class="stat-icon" style="background:rgba(56,189,248,.15);color:#38bdf8">
                        <svg viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="9" r="6"/><path d="M3.5 9h11M9 3.5C7 6 7 12 9 14.5M9 3.5C11 6 11 12 9 14.5"/></svg>
                    </div>
                    <span class="stat-change {{ $visitsPct >= 0 ? 'up' : 'down' }}">{{ $visitsPct >= 0 ? '↑' : '↓' }} {{ abs($visitsPct) }}%</span>
                </div>
                <div class="stat-value">{{ number_format($visitsThisMonth, 0, ',', ' ') }}</div>
                <div class="stat-label">
                    Visites ce mois ·
                    <strong>{{ number_format($visitsToday, 0, ',', ' ') }}</strong> aujourd'hui
                    <span style="display:block;font-size:11px;margin-top:2px;color:var(--muted)">Total : {{ number_format($visitsTotal, 0, ',', ' ') }}</span>
                    <a href="{{ route('admin.visites') }}" style="display:inline-block;margin-top:6px;font-size:11px;color:#38bdf8;text-decoration:none">Voir le détail →</a>
                </div>
            </div>

        </div>

        <div class="bottom-row">

            {{-- Commandes récentes --}}
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Commandes récentes</div>
                        <div class="card-subtitle">{{ $pendingCount }} en attente de traitement</div>
                    </div>
                    <a href="{{ route('admin.commandes') }}" style="font-size:13px;color:var(--accent);text-decoration:none;font-weight:500">Voir tout →</a>
                </div>
                <table>
                    <thead><tr><th>N° Commande</th><th>Client</th><th>Montant</th><th>Statut</th></tr></thead>
                    <tbody>
                    @forelse($recentOrders as $order)
                    @php
                        $statusMap = ['pending'=>['En attente','pill-warn'],'confirmed'=>['Confirmée','pill-info'],'processing'=>['Traitement','pill-warn'],'shipped'=>['Expédiée','pill-info'],'delivered'=>['Livrée','pill-success'],'cancelled'=>['Annulée','pill-danger']];
                        [$slabel, $spill] = $statusMap[$order->status] ?? [$order->status, 'pill-warn'];
                    @endphp
                    <tr>
                        <td>
                            <div class="product-cell">
                                <div class="product-thumb">📦</div>
                                <div>
                                    <div class="product-name">{{ $order->order_number }}</div>
                                    <div class="product-sku">{{ $order->created_at->format('d M Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="color:var(--muted)">{{ $order->user->name }}</td>
                        <td style="font-weight:600">{{ number_format($order->total, 0, ',', ' ') }} F</td>
                        <td><span class="pill {{ $spill }}">{{ $slabel }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center;color:var(--muted);padding:24px">Aucune commande.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Produits stock faible + ventes par catégorie --}}
            <div style="display:flex;flex-direction:column;gap:20px">

                <div class="card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Stock faible</div>
                            <div class="card-subtitle">Produits à réapprovisionner</div>
                        </div>
                        <a href="{{ route('admin.produits') }}" style="font-size:13px;color:var(--accent);text-decoration:none;font-weight:500">Gérer →</a>
                    </div>
                    @forelse($lowStock as $p)
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid var(--border);font-size:13px">
                        <div class="product-name">{{ $p->name }}</div>
                        <span class="pill {{ $p->stock === 0 ? 'pill-danger' : 'pill-warn' }}">{{ $p->stock }} restant{{ $p->stock > 1 ? 's' : '' }}</span>
                    </div>
                    @empty
                    <div style="color:var(--muted);font-size:13px;padding:12px 0">Tous les stocks sont suffisants.</div>
                    @endforelse
                </div>

                <div class="card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Ventes par catégorie</div>
                            <div class="card-subtitle">Chiffre d'affaires cumulé</div>
                        </div>
                    </div>
                    @php $maxCat = $salesByCategory->max('total') ?: 1; @endphp
                    @forelse($salesByCategory as $cat)
                    <div style="margin-bottom:10px">
                        <div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:4px">
                            <span>{{ $cat->name }}</span>
                            <span style="font-weight:600">{{ number_format($cat->total, 0, ',', ' ') }} F</span>
                        </div>
                        <div style="background:var(--border);border-radius:4px;height:5px">
                            <div style="background:var(--accent);border-radius:4px;height:5px;width:{{ round($cat->total / $maxCat * 100) }}%"></div>
                        </div>
                    </div>
                    @empty
                    <div style="color:var(--muted);font-size:13px;padding:12px 0">Aucune vente enregistrée.</div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>

    <div class="sidebar-overlay" id="sidebar-overlay"></div>
@endsection
