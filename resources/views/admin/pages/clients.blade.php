@php $title = "Clients"; @endphp

@extends('layouts.admin')

@section('content')
    <div>
        @if(session('success'))
            <div style="background:rgba(45,204,127,.15);border:1px solid var(--success);color:var(--success);padding:10px 16px;border-radius:8px;margin-bottom:16px;font-size:13px;">{{ session('success') }}</div>
        @endif

        <div class="page-header">
            <div>
                <div class="page-heading">Clients</div>
                <div class="page-sub"><span>{{ $totalClients }}</span> clients enregistrés</div>
            </div>
            <button class="btn btn-primary" onclick="openModal('modal-client-create')">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 2v10M2 7h10"/></svg>
                Ajouter un client
            </button>
        </div>

        <form method="GET" action="{{ route('admin.clients') }}">
        <div class="filters-row">
            <input class="filter-input" name="q" placeholder="🔍  Rechercher un client…"
                   value="{{ request('q') }}" style="flex:1;min-width:200px">
            <select class="filter-select" name="segment">
                <option value="">Tous les segments</option>
                <option value="vip"      {{ request('segment') === 'vip'      ? 'selected' : '' }}>VIP (≥10 commandes)</option>
                <option value="regulier" {{ request('segment') === 'regulier' ? 'selected' : '' }}>Régulier (3–9)</option>
                <option value="nouveau"  {{ request('segment') === 'nouveau'  ? 'selected' : '' }}>Nouveau (&lt;3)</option>
            </select>
            <button type="submit" class="btn btn-ghost">Filtrer</button>
        </div>
        </form>

        <div class="card">
            <div class="data-table-wrap">
            <table>
                <thead>
                    <tr><th>Client</th><th>Email</th><th>Commandes</th><th>Total dépensé</th><th>Inscrit le</th><th>Segment</th><th>Actions</th></tr>
                </thead>
                <tbody>
                @forelse($clients as $client)
                @php
                    $initials = collect(explode(' ', $client->name))->map(fn($w) => strtoupper(substr($w,0,1)))->take(2)->implode('');
                    $orders   = $client->orders_count ?? 0;
                    if ($orders >= 10)     { $seg = ['VIP',      'pill-success']; }
                    elseif ($orders >= 3)  { $seg = ['Régulier', 'pill-info']; }
                    else                   { $seg = ['Nouveau',  'pill-warn']; }
                @endphp
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            <div class="avatar" style="width:34px;height:34px;font-size:12px">{{ $initials }}</div>
                            <div>
                                <div style="font-weight:500">{{ $client->name }}</div>
                                @if($client->phone)
                                <div style="font-size:11px;color:var(--muted)">{{ $client->phone }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td style="color:var(--muted)">{{ $client->email }}</td>
                    <td style="font-weight:600">{{ $orders }}</td>
                    <td style="font-weight:600;color:var(--success)">
                        {{ number_format($client->total_spent ?? 0, 0, ',', ' ') }} FCFA
                    </td>
                    <td style="color:var(--muted)">{{ $client->created_at->format('M Y') }}</td>
                    <td><span class="pill {{ $seg[1] }}">{{ $seg[0] }}</span></td>
                    <td style="display:flex;gap:6px;padding:12px 0">
                        <button class="btn btn-ghost" style="padding:5px 10px;font-size:12px"
                            onclick="openEditClient({{ $client->id }}, {{ json_encode($client->name) }}, {{ json_encode($client->email) }}, {{ json_encode($client->phone ?? '') }}, '{{ route('admin.clients.update', $client) }}')">
                            Éditer
                        </button>
                        <form method="POST" action="{{ route('admin.clients.destroy', $client) }}"
                              onsubmit="return confirm('Supprimer ce client ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding:5px 10px;font-size:12px">Suppr.</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;color:var(--muted);padding:24px">Aucun client trouvé.</td></tr>
                @endforelse
                </tbody>
            </table>
            </div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:20px;padding-top:16px;border-top:1px solid var(--border)">
                <span style="font-size:13px;color:var(--muted)">
                    @if($clients->total() > 0)
                        Affichage {{ $clients->firstItem() }}–{{ $clients->lastItem() }} sur {{ $clients->total() }} clients
                    @else
                        Aucun client
                    @endif
                </span>
                <div>{{ $clients->links() }}</div>
            </div>
        </div>
    </div>

{{-- ── Modal : Ajouter un client ────────────────────────────── --}}
<div class="modal-overlay" id="modal-client-create">
    <div class="modal" style="max-width:480px">
        <div class="modal-header">
            <div class="modal-title">Ajouter un client</div>
            <div class="modal-close" onclick="closeModal('modal-client-create')">✕</div>
        </div>
        <form method="POST" action="{{ route('admin.clients.store') }}">
            @csrf
            @if($errors->any())
            <div style="background:rgba(255,71,87,.12);border:1px solid var(--danger);color:var(--danger);padding:10px 14px;border-radius:8px;margin-bottom:14px;font-size:13px;">
                {{ $errors->first() }}
            </div>
            @endif
            <div class="form-grid">
                <div class="form-group full">
                    <label class="form-label">Nom complet <span style="color:var(--danger)">*</span></label>
                    <input class="form-input" name="name" value="{{ old('name') }}" placeholder="Ex: Jean Kouassi" required>
                </div>
                <div class="form-group full">
                    <label class="form-label">Adresse email <span style="color:var(--danger)">*</span></label>
                    <input class="form-input" name="email" type="email" value="{{ old('email') }}" placeholder="jean@exemple.com" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Téléphone</label>
                    <input class="form-input" name="phone" value="{{ old('phone') }}" placeholder="+225 07 00 00 00 00">
                </div>
                <div class="form-group">
                    <label class="form-label">Mot de passe <small style="color:var(--muted)">(optionnel)</small></label>
                    <input class="form-input" name="password" type="password" placeholder="Min. 8 caractères">
                </div>
            </div>
            <p style="font-size:12px;color:var(--muted);margin-top:8px">Si aucun mot de passe n'est défini, le client devra utiliser "Connexion Google" ou réinitialiser son mot de passe.</p>
            <div style="display:flex;gap:10px;margin-top:20px;justify-content:flex-end">
                <button type="button" class="btn btn-ghost" onclick="closeModal('modal-client-create')">Annuler</button>
                <button type="submit" class="btn btn-primary">Créer le client</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Modal : Modifier un client ──────────────────────────── --}}
<div class="modal-overlay" id="modal-client-edit">
    <div class="modal" style="max-width:480px">
        <div class="modal-header">
            <div class="modal-title" id="edit-client-title">Modifier le client</div>
            <div class="modal-close" onclick="closeModal('modal-client-edit')">✕</div>
        </div>
        <form method="POST" id="form-client-edit">
            @csrf @method('PUT')
            <div class="form-grid">
                <div class="form-group full">
                    <label class="form-label">Nom complet <span style="color:var(--danger)">*</span></label>
                    <input class="form-input" name="name" id="ec-name" required>
                </div>
                <div class="form-group full">
                    <label class="form-label">Adresse email <span style="color:var(--danger)">*</span></label>
                    <input class="form-input" name="email" id="ec-email" type="email" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Téléphone</label>
                    <input class="form-input" name="phone" id="ec-phone" placeholder="+225 07 00 00 00 00">
                </div>
                <div class="form-group">
                    <label class="form-label">Nouveau mot de passe <small style="color:var(--muted)">(laisser vide = inchangé)</small></label>
                    <input class="form-input" name="password" type="password" placeholder="Min. 8 caractères">
                </div>
            </div>
            <div style="display:flex;gap:10px;margin-top:20px;justify-content:flex-end">
                <button type="button" class="btn btn-ghost" onclick="closeModal('modal-client-edit')">Annuler</button>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditClient(id, name, email, phone, url) {
    document.getElementById('form-client-edit').action = url;
    document.getElementById('edit-client-title').textContent = 'Modifier · ' + name;
    document.getElementById('ec-name').value  = name;
    document.getElementById('ec-email').value = email;
    document.getElementById('ec-phone').value = phone;
    openModal('modal-client-edit');
}
</script>

@if($errors->any())
<script>document.addEventListener('DOMContentLoaded', () => openModal('modal-client-create'));</script>
@endif
@endsection
