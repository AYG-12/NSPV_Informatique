@php $title = "Avis clients"; @endphp

@extends('layouts.admin')

@section('content')
<div>
    @if(session('success'))
        <div style="background:rgba(45,204,127,.15);border:1px solid var(--success);color:var(--success);padding:10px 16px;border-radius:8px;margin-bottom:16px;font-size:13px;">{{ session('success') }}</div>
    @endif

    <div class="page-header">
        <div>
            <div class="page-heading">Avis clients</div>
            <div class="page-sub">
                <span>{{ $reviews->total() }}</span> avis ·
                <span>{{ $pendingCount }}</span> en attente de validation
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.avis') }}">
    <div class="filters-row">
        <input class="filter-input" name="q" placeholder="🔍  Rechercher par produit ou client…"
               value="{{ request('q') }}" style="flex:1;min-width:200px">
        <select class="filter-select" name="statut">
            <option value="">Tous les avis</option>
            <option value="pending"  {{ request('statut') === 'pending'  ? 'selected' : '' }}>En attente</option>
            <option value="approved" {{ request('statut') === 'approved' ? 'selected' : '' }}>Approuvés</option>
        </select>
        <button type="submit" class="btn btn-ghost">Filtrer</button>
    </div>
    </form>

    <div class="card">
        <div class="data-table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Client</th>
                    <th>Note</th>
                    <th>Commentaire</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($reviews as $review)
            @php
                $initials = collect(explode(' ', $review->user->name))
                    ->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('');
            @endphp
            <tr>
                {{-- Produit --}}
                <td style="font-weight:600;max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                    {{ $review->product->name ?? '—' }}
                </td>

                {{-- Client --}}
                <td>
                    <div style="display:flex;align-items:center;gap:8px">
                        <div class="avatar" style="width:28px;height:28px;font-size:11px">{{ $initials }}</div>
                        <div>
                            <div style="font-weight:500;font-size:13px">{{ $review->user->name }}</div>
                            <div style="font-size:11px;color:var(--muted)">{{ $review->user->email }}</div>
                        </div>
                    </div>
                </td>

                {{-- Note étoiles --}}
                <td style="white-space:nowrap">
                    @for($i = 1; $i <= 5; $i++)
                    <span style="color:{{ $i <= $review->rating ? '#e8ff47' : 'var(--muted)' }};font-size:15px">★</span>
                    @endfor
                    <span style="font-size:12px;color:var(--muted);margin-left:4px">{{ $review->rating }}/5</span>
                </td>

                {{-- Commentaire --}}
                <td style="max-width:260px;color:var(--muted);font-size:13px">
                    @if($review->comment)
                        <span title="{{ $review->comment }}">
                            {{ Str::limit($review->comment, 80) }}
                        </span>
                    @else
                        <em style="color:var(--muted);font-size:12px">Aucun commentaire</em>
                    @endif
                </td>

                {{-- Date --}}
                <td style="color:var(--muted);font-size:13px">{{ $review->created_at->format('d M Y') }}</td>

                {{-- Statut --}}
                <td>
                    @if($review->is_approved)
                        <span class="pill pill-success">Approuvé</span>
                    @else
                        <span class="pill pill-warn">En attente</span>
                    @endif
                </td>

                {{-- Actions --}}
                <td style="display:flex;gap:6px;padding:12px 0">
                    @if($review->is_approved)
                    <form method="POST" action="{{ route('admin.avis.disapprove', $review) }}">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-ghost" style="padding:5px 10px;font-size:12px">
                            Désapprouver
                        </button>
                    </form>
                    @else
                    <form method="POST" action="{{ route('admin.avis.approve', $review) }}">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-primary" style="padding:5px 10px;font-size:12px">
                            ✓ Réapprouver
                        </button>
                    </form>
                    @endif
                    <form method="POST" action="{{ route('admin.avis.destroy', $review) }}"
                          onsubmit="return confirm('Supprimer cet avis définitivement ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="padding:5px 10px;font-size:12px">
                            Suppr.
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;color:var(--muted);padding:24px">
                    Aucun avis trouvé.
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:20px;padding-top:16px;border-top:1px solid var(--border)">
            <span style="font-size:13px;color:var(--muted)">
                @if($reviews->total() > 0)
                    Affichage {{ $reviews->firstItem() }}–{{ $reviews->lastItem() }} sur {{ $reviews->total() }} avis
                @else
                    Aucun avis
                @endif
            </span>
            <div style="display:flex;gap:6px">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
