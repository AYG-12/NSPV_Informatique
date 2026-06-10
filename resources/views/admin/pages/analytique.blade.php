@php
    $title = "Analytiques";

    function fmtAmount(float|int $v): string {
        if ($v >= 1_000_000) return number_format($v / 1_000_000, 1, '.', '') . 'M';
        if ($v >= 1_000)     return number_format($v / 1_000,     1, '.', '') . 'k';
        return number_format($v, 0, ',', ' ');
    }
@endphp

@extends('layouts.admin')

@section('content')
<div>
    <div class="page-header">
        <div>
            <div class="page-heading">Analytique</div>
            <div class="page-sub">30 derniers jours</div>
        </div>
    </div>

    {{-- KPI cards --}}
    <div class="stats-grid">
        <div class="stat-card green">
            <div class="stat-header">
                <div class="stat-icon green">
                    <svg viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 14l3-5 3 2 3-4 3 3"/></svg>
                </div>
            </div>
            <div class="stat-value">{{ number_format($revenueTotal, 0, ',', ' ') }} <small style="font-size:.45em;font-weight:400">FCFA</small></div>
            <div class="stat-label">Revenus totaux (30 j.)</div>
        </div>
        <div class="stat-card yellow">
            <div class="stat-header">
                <div class="stat-icon yellow">
                    <svg viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 5h12l-1.5 8H4.5L3 5z"/><circle cx="7" cy="15" r="1"/><circle cx="12" cy="15" r="1"/></svg>
                </div>
            </div>
            <div class="stat-value">{{ number_format($avgCart, 0, ',', ' ') }} <small style="font-size:.45em;font-weight:400">FCFA</small></div>
            <div class="stat-label">Panier moyen</div>
        </div>
        <div class="stat-card orange">
            <div class="stat-header">
                <div class="stat-icon orange">
                    <svg viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 2a5 5 0 100 14A5 5 0 009 2zm0 0v7l4 2"/></svg>
                </div>
            </div>
            <div class="stat-value">{{ $totalReviews }}</div>
            <div class="stat-label">Avis clients</div>
        </div>
        <div class="stat-card purple">
            <div class="stat-header">
                <div class="stat-icon purple">
                    <svg viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 2l2 4 5 .7-3.5 3.4.8 5L9 13l-4.3 2.1.8-5L2 6.7 7 6z"/></svg>
                </div>
            </div>
            <div class="stat-value">{{ $avgRating > 0 ? number_format($avgRating, 1, '.', '') : '—' }} <small style="font-size:.55em;color:var(--warn)">★</small></div>
            <div class="stat-label">Note moyenne</div>
        </div>
    </div>

    <div class="analytics-grid">
        {{-- Bar chart: revenus 7 derniers jours --}}
        <div class="card">
            <div class="card-header"><div class="card-title">Revenus par jour (7 j.)</div></div>
            <div class="bar-chart-wrap">
                @foreach($days as $day)
                @php
                    $pct   = $maxDay > 0 ? max(4, round(($day['total'] / $maxDay) * 100)) : 4;
                    $isMax = $day['total'] == $maxDay && $maxDay > 0;
                @endphp
                <div class="bar-col">
                    <div class="bar-val">{{ fmtAmount((float)$day['total']) }}</div>
                    <div class="bar-fill" style="height:{{ $pct }}%;background:{{ $isMax ? 'var(--accent)' : 'var(--accent3)' }}"></div>
                    <div class="bar-label">{{ $day['label'] }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Avis clients --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">Avis clients</div>
                @if($totalReviews > 0)
                <div style="font-family:'Syne',sans-serif;font-size:28px;font-weight:800;color:var(--warn)">
                    {{ number_format($avgRating, 1, '.', '') }} ★
                </div>
                @endif
            </div>
            @if($totalReviews === 0)
            <div style="text-align:center;color:var(--muted);padding:20px;font-size:13px">Aucun avis pour l'instant.</div>
            @else
            <div>
                @for($r = 5; $r >= 1; $r--)
                @php
                    $cnt  = $ratingDist->get($r)?->count ?? 0;
                    $pct  = $totalReviews > 0 ? round($cnt / $totalReviews * 100) : 0;
                    $full = str_repeat('★', $r);
                    $empty= str_repeat('☆', 5 - $r);
                @endphp
                <div class="rating-row">
                    <span class="rating-stars">{{ $full }}{{ $empty }}</span>
                    <div class="rating-bar-bg"><div class="rating-bar-fill" style="width:{{ $pct }}%"></div></div>
                    <span class="rating-count">{{ $pct }}%</span>
                </div>
                @endfor
            </div>
            @endif
        </div>
    </div>

    <div class="analytics-grid">
        {{-- Top produits --}}
        <div class="card">
            <div class="card-header"><div class="card-title">Top produits par revenus</div></div>
            @if($topProducts->isEmpty())
            <div style="text-align:center;color:var(--muted);padding:20px;font-size:13px">Aucune vente enregistrée.</div>
            @else
            <table>
                <thead>
                    <tr><th>#</th><th>Produit</th><th>Qté vendue</th><th>Revenus</th></tr>
                </thead>
                <tbody>
                @foreach($topProducts as $i => $product)
                @php
                    $colors = ['var(--accent)', 'var(--accent3)', 'var(--accent2)', 'var(--muted)', 'var(--muted)'];
                    $color  = $colors[$i] ?? 'var(--muted)';
                @endphp
                <tr>
                    <td style="color:{{ $color }};font-weight:700">{{ $i + 1 }}</td>
                    <td>
                        <div class="product-cell">
                            @if($product->product_image)
                                <img src="{{ asset('storage/' . $product->product_image) }}"
                                     alt="{{ $product->product_name }}"
                                     class="product-thumb"
                                     style="width:36px;height:36px;object-fit:cover;border-radius:6px;flex-shrink:0">
                            @else
                                <div class="product-thumb">📦</div>
                            @endif
                            <div class="product-name">{{ $product->product_name }}</div>
                        </div>
                    </td>
                    <td>{{ number_format($product->qty, 0, ',', ' ') }}</td>
                    <td style="font-weight:600">{{ number_format($product->revenue, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endforeach
                </tbody>
            </table>
            @endif
        </div>

        {{-- Période résumée --}}
        <div class="card">
            <div class="card-header"><div class="card-title">Résumé de la période</div></div>
            <div style="display:flex;flex-direction:column;gap:16px;margin-top:8px">
                <div>
                    <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:6px">
                        <span>Revenus totaux (30 j.)</span>
                        <span style="font-weight:600">{{ number_format($revenueTotal, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div style="height:6px;background:var(--border);border-radius:3px">
                        <div style="height:100%;width:100%;background:var(--success);border-radius:3px"></div>
                    </div>
                </div>
                <div>
                    <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:6px">
                        <span>Panier moyen</span>
                        <span style="font-weight:600">{{ number_format($avgCart, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div style="height:6px;background:var(--border);border-radius:3px">
                        <div style="height:100%;width:60%;background:var(--accent3);border-radius:3px"></div>
                    </div>
                </div>
                <div style="padding-top:8px;border-top:1px solid var(--border)">
                    <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:4px">
                        <span style="color:var(--muted)">Total avis</span>
                        <span style="font-weight:600">{{ $totalReviews }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:13px">
                        <span style="color:var(--muted)">Note moyenne</span>
                        <span style="font-weight:600;color:var(--warn)">{{ $avgRating > 0 ? number_format($avgRating, 1) . ' / 5' : '—' }}</span>
                    </div>
                </div>
                @if($topProducts->isNotEmpty())
                @php $best = $topProducts->first(); @endphp
                <div style="padding-top:8px;border-top:1px solid var(--border)">
                    <div style="font-size:12px;color:var(--muted);margin-bottom:8px">Meilleure vente</div>
                    <div style="display:flex;align-items:center;gap:10px">
                        @if($best->product_image)
                            <img src="{{ asset('storage/' . $best->product_image) }}"
                                 alt="{{ $best->product_name }}"
                                 style="width:40px;height:40px;object-fit:cover;border-radius:8px;flex-shrink:0">
                        @else
                            <div style="width:40px;height:40px;border-radius:8px;background:var(--surface2);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0">📦</div>
                        @endif
                        <div>
                            <div style="font-size:13px;font-weight:500">{{ $best->product_name }}</div>
                            <div style="font-size:12px;color:var(--muted)">{{ number_format($best->revenue, 0, ',', ' ') }} FCFA · {{ number_format($best->qty) }} unités</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
