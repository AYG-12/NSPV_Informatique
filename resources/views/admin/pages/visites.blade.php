@php $title = "Visites"; @endphp

@extends('layouts.admin')

@section('content')
<div>
    @if(session('success'))
        <div style="background:rgba(45,204,127,.15);border:1px solid var(--success);color:var(--success);padding:10px 16px;border-radius:8px;margin-bottom:16px;font-size:13px;">{{ session('success') }}</div>
    @endif

    <div class="page-header">
        <div>
            <div class="page-heading">Visites du site</div>
            <div class="page-sub">Visiteurs uniques par session · une entrée par jour</div>
        </div>
    </div>

    {{-- Cartes résumé --}}
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px">
        <div class="card" style="padding:20px">
            <div style="font-size:12px;color:var(--muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:6px">Aujourd'hui</div>
            <div style="font-size:28px;font-weight:800;color:var(--accent)">{{ number_format($todayCount, 0, ',', ' ') }}</div>
        </div>
        <div class="card" style="padding:20px">
            <div style="font-size:12px;color:var(--muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:6px">Ce mois</div>
            <div style="font-size:28px;font-weight:800">{{ number_format($monthCount, 0, ',', ' ') }}</div>
        </div>
        <div class="card" style="padding:20px">
            <div style="font-size:12px;color:var(--muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:6px">Total</div>
            <div style="font-size:28px;font-weight:800">{{ number_format($totalAll, 0, ',', ' ') }}</div>
        </div>
    </div>

    {{-- Mini-graphe 30 jours --}}
    <div class="card" style="margin-bottom:24px;padding:20px">
        <div style="font-weight:600;font-size:14px;margin-bottom:16px">Activité des 30 derniers jours</div>
        @php
            $last30Indexed = $last30->keyBy(fn($v) => $v->date->toDateString());
            $maxBar = $last30->max('count') ?: 1;
        @endphp
        <div style="display:flex;align-items:flex-end;gap:3px;height:80px">
            @for($d = 29; $d >= 0; $d--)
                @php
                    $day   = now()->subDays($d)->toDateString();
                    $val   = $last30Indexed[$day]->count ?? 0;
                    $pct   = round($val / $maxBar * 100);
                    $isToday = $day === now()->toDateString();
                @endphp
                <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:3px;height:100%">
                    <div style="flex:1;width:100%;display:flex;align-items:flex-end">
                        <div title="{{ $day }} · {{ $val }} visite{{ $val > 1 ? 's' : '' }}"
                             style="width:100%;height:{{ max($pct,2) }}%;border-radius:3px 3px 0 0;
                                    background:{{ $isToday ? 'var(--accent,#e8ff47)' : 'rgba(232,255,71,.35)' }};
                                    transition:background .2s;cursor:default"
                             onmouseover="this.style.background='var(--accent,#e8ff47)'"
                             onmouseout="this.style.background='{{ $isToday ? 'var(--accent,#e8ff47)' : 'rgba(232,255,71,.35)' }}'">
                        </div>
                    </div>
                </div>
            @endfor
        </div>
        <div style="display:flex;justify-content:space-between;margin-top:6px;font-size:10px;color:var(--muted)">
            <span>{{ now()->subDays(29)->format('d M') }}</span>
            <span>{{ now()->format('d M') }}</span>
        </div>
    </div>

    {{-- Filtre par mois --}}
    <form method="GET" action="{{ route('admin.visites') }}">
    <div class="filters-row" style="margin-bottom:20px">
        <input class="filter-input" type="month" name="mois"
               value="{{ request('mois', now()->format('Y-m')) }}"
               style="max-width:200px">
        <button type="submit" class="btn btn-ghost">Filtrer</button>
        @if(request('mois'))
        <a href="{{ route('admin.visites') }}" class="btn btn-ghost">Tout voir</a>
        @endif
    </div>
    </form>

    {{-- Tableau --}}
    <div class="card">
        <div class="data-table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Jour</th>
                    <th>Visites</th>
                    <th>Proportion</th>
                </tr>
            </thead>
            <tbody>
            @forelse($visits as $visit)
            @php $isToday = $visit->date->isToday(); @endphp
            <tr>
                <td style="font-weight:600;{{ $isToday ? 'color:var(--accent)' : '' }}">
                    {{ $visit->date->format('d M Y') }}
                    @if($isToday)
                    <span style="font-size:11px;background:rgba(232,255,71,.15);color:var(--accent);padding:2px 7px;border-radius:4px;margin-left:6px">Aujourd'hui</span>
                    @endif
                </td>
                <td style="color:var(--muted);text-transform:capitalize">
                    {{ $visit->date->translatedFormat('l') }}
                </td>
                <td style="font-weight:700;font-size:15px">
                    {{ number_format($visit->count, 0, ',', ' ') }}
                </td>
                <td style="width:220px">
                    <div style="display:flex;align-items:center;gap:10px">
                        <div style="flex:1;height:6px;background:var(--border,#2a2a2a);border-radius:999px;overflow:hidden">
                            <div style="height:100%;width:{{ round($visit->count / $maxDay * 100) }}%;background:var(--accent,#e8ff47);border-radius:999px"></div>
                        </div>
                        <span style="font-size:11px;color:var(--muted);width:32px;text-align:right">{{ round($visit->count / $maxDay * 100) }}%</span>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center;color:var(--muted);padding:24px">
                    Aucune visite enregistrée pour cette période.
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:20px;padding-top:16px;border-top:1px solid var(--border)">
            <span style="font-size:13px;color:var(--muted)">
                @if($visits->total() > 0)
                    Affichage {{ $visits->firstItem() }}–{{ $visits->lastItem() }} sur {{ $visits->total() }} jours
                @else
                    Aucune donnée
                @endif
            </span>
            {{ $visits->links() }}
        </div>
    </div>
</div>
@endsection
