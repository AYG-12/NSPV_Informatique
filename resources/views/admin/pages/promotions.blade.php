@php $title = "Promotions"; @endphp

@extends('layouts.admin')

@section('content')
<div>
    @if(session('success'))
        <div style="background:rgba(45,204,127,.15);border:1px solid var(--success);color:var(--success);padding:10px 16px;border-radius:8px;margin-bottom:16px;font-size:13px;">{{ session('success') }}</div>
    @endif

    <div class="page-header">
        <div>
            <div class="page-heading">Promotions</div>
            <div class="page-sub"><span>{{ $activeCount }}</span> promotions actives</div>
        </div>
        <button class="btn btn-primary" onclick="openModal('modal-promo-create')">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 2v10M2 7h10"/></svg>
            Créer une promo
        </button>
    </div>

    <div class="card" style="margin-bottom:16px">
        <div class="card-header"><div class="card-title">Promotions actives</div></div>
        @forelse($active as $promo)
            <div class="promo-card">
                <div class="promo-badge" style="background:rgba(232,255,71,.1);color:var(--accent)">
                    {{ $promo->type === 'percent' ? '-'.rtrim(rtrim(number_format($promo->value,2,'.',''),'0'),'.').'%' : '-'.number_format($promo->value,0,',',' ').' F' }}
                </div>
                <div class="promo-info">
                    <div class="promo-name">{{ $promo->description }}</div>
                    <div class="promo-details">
                        Code: <strong>{{ $promo->code }}</strong>
                        @if($promo->expires_at) · Jusqu'au {{ $promo->expires_at->format('d M Y') }} @else · Permanent @endif
                        · Utilisé {{ $promo->usage_count }} fois
                        @if($promo->usage_limit) / {{ $promo->usage_limit }} @endif
                        @if($promo->min_order_amount) · Minimum {{ number_format($promo->min_order_amount,0,',',' ') }} FCFA @endif
                    </div>
                </div>
                <span class="pill pill-success">Active</span>
                <div class="promo-actions">
                    <button class="btn btn-ghost" style="padding:5px 10px;font-size:12px"
                        onclick="editPromo({{ json_encode($promo) }}, '{{ route('admin.promotions.update', $promo) }}')">Éditer</button>
                    <form method="POST" action="{{ route('admin.promotions.toggle', $promo) }}" style="display:inline">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-danger" style="padding:5px 10px;font-size:12px">Désactiver</button>
                    </form>
                    <form method="POST" action="{{ route('admin.promotions.destroy', $promo) }}"
                        onsubmit="return confirm('Supprimer « {{ $promo->code }} » ?')" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="padding:5px 10px;font-size:12px">Suppr.</button>
                    </form>
                </div>
            </div>
        @empty
            <div style="padding:24px;text-align:center;color:var(--muted);font-size:13px">Aucune promotion active.</div>
        @endforelse
    </div>

    <div class="card">
        <div class="card-header"><div class="card-title">Promotions expirées / inactives</div></div>
        @forelse($expired as $promo)
        <div class="promo-card" style="opacity:.55">
            <div class="promo-badge" style="background:var(--surface2);color:var(--muted)">
                {{ $promo->type === 'percent' ? '-'.rtrim(rtrim(number_format($promo->value,2,'.',''),'0'),'.').'%' : '-'.number_format($promo->value,0,',',' ').' F' }}
            </div>
            <div class="promo-info">
                <div class="promo-name">{{ $promo->description }}</div>
                <div class="promo-details">
                    Code: <strong>{{ $promo->code }}</strong>
                    @if($promo->expires_at) · Expiré le {{ $promo->expires_at->format('d M Y') }} @else · Désactivée manuellement @endif
                    · Utilisé {{ $promo->usage_count }} fois
                </div>
            </div>
            <span class="pill pill-danger">{{ $promo->expires_at && $promo->expires_at->lt(now()) ? 'Expirée' : 'Inactive' }}</span>
            <div class="promo-actions">
                <form method="POST" action="{{ route('admin.promotions.toggle', $promo) }}" style="display:inline">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-ghost" style="padding:5px 10px;font-size:12px">Réactiver</button>
                </form>
                <form method="POST" action="{{ route('admin.promotions.destroy', $promo) }}"
                      onsubmit="return confirm('Supprimer « {{ $promo->code }} » ?')" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="padding:5px 10px;font-size:12px">Suppr.</button>
                </form>
            </div>
        </div>
        @empty
        <div style="padding:24px;text-align:center;color:var(--muted);font-size:13px">Aucune promotion expirée.</div>
        @endforelse
    </div>
</div>

{{-- ── Modal: Créer une promotion ───────────────────────────────── --}}
<div class="modal-overlay" id="modal-promo-create">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Créer une promotion</div>
            <div class="modal-close" onclick="closeModal('modal-promo-create')">✕</div>
        </div>
        <form method="POST" action="{{ route('admin.promotions.store') }}">
            @csrf
            @if($errors->any() && old('_form') === 'create')
            <div style="background:rgba(255,80,80,.1);border:1px solid #f55;color:#f55;padding:10px 14px;border-radius:8px;margin-bottom:12px;font-size:12px">
                {{ $errors->first() }}
            </div>
            @endif
            <input type="hidden" name="_form" value="create">
            <div class="form-grid">
                <div class="form-group full">
                    <label class="form-label">Description</label>
                    <input class="form-input" name="description" value="{{ old('description') }}" placeholder="Ex: Soldes Printemps" required maxlength="100">
                </div>
                <div class="form-group">
                    <label class="form-label">Code promo</label>
                    <input class="form-input" name="code" value="{{ old('code') }}" placeholder="EX: SPRING20" required maxlength="50" style="text-transform:uppercase">
                </div>
                <div class="form-group">
                    <label class="form-label">Type de réduction</label>
                    <select class="form-input" name="type" required>
                        <option value="percent" {{ old('type') === 'fixed' ? '' : 'selected' }}>Pourcentage (%)</option>
                        <option value="fixed"   {{ old('type') === 'fixed' ? 'selected' : '' }}>Montant fixe (FCFA)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Valeur</label>
                    <input class="form-input" name="value" value="{{ old('value') }}" placeholder="20" type="number" step="any" min="0" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Montant minimum commande</label>
                    <input class="form-input" name="min_order_amount" value="{{ old('min_order_amount') }}" placeholder="Aucun" type="number" step="any" min="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Utilisations max.</label>
                    <input class="form-input" name="usage_limit" value="{{ old('usage_limit') }}" placeholder="Illimité" type="number" min="1">
                </div>
                <div class="form-group">
                    <label class="form-label">Date de début</label>
                    <input class="form-input" name="starts_at" value="{{ old('starts_at') }}" type="date">
                </div>
                <div class="form-group">
                    <label class="form-label">Date de fin</label>
                    <input class="form-input" name="expires_at" value="{{ old('expires_at') }}" type="date">
                </div>
                <div class="form-group full">
                    <label class="form-label" style="display:flex;align-items:center;gap:8px;cursor:pointer;font-weight:normal">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }} style="width:auto">
                        Activer immédiatement
                    </label>
                </div>
            </div>
            <div style="display:flex;gap:10px;margin-top:24px;justify-content:flex-end">
                <button type="button" class="btn btn-ghost" onclick="closeModal('modal-promo-create')">Annuler</button>
                <button type="submit" class="btn btn-primary">Créer la promotion</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Modal: Éditer une promotion ──────────────────────────────── --}}
<div class="modal-overlay" id="modal-promo-edit">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Modifier la promotion</div>
            <div class="modal-close" onclick="closeModal('modal-promo-edit')">✕</div>
        </div>
        <form method="POST" id="form-promo-edit">
            @csrf @method('PUT')
            <div class="form-grid">
                <div class="form-group full">
                    <label class="form-label">Description</label>
                    <input class="form-input" name="description" id="edit-description" required maxlength="100">
                </div>
                <div class="form-group">
                    <label class="form-label">Code promo</label>
                    <input class="form-input" name="code" id="edit-code" required maxlength="50" style="text-transform:uppercase">
                </div>
                <div class="form-group">
                    <label class="form-label">Type de réduction</label>
                    <select class="form-input" name="type" id="edit-type" required>
                        <option value="percent">Pourcentage (%)</option>
                        <option value="fixed">Montant fixe (FCFA)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Valeur</label>
                    <input class="form-input" name="value" id="edit-value" type="number" step="any" min="0" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Montant minimum commande</label>
                    <input class="form-input" name="min_order_amount" id="edit-min_order_amount" type="number" step="any" min="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Utilisations max.</label>
                    <input class="form-input" name="usage_limit" id="edit-usage_limit" type="number" min="1">
                </div>
                <div class="form-group">
                    <label class="form-label">Date de début</label>
                    <input class="form-input" name="starts_at" id="edit-starts_at" type="date">
                </div>
                <div class="form-group">
                    <label class="form-label">Date de fin</label>
                    <input class="form-input" name="expires_at" id="edit-expires_at" type="date">
                </div>
                <div class="form-group full">
                    <label class="form-label" style="display:flex;align-items:center;gap:8px;cursor:pointer;font-weight:normal">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="edit-is_active" value="1" style="width:auto">
                        Active
                    </label>
                </div>
            </div>
            <div style="display:flex;gap:10px;margin-top:24px;justify-content:flex-end">
                <button type="button" class="btn btn-ghost" onclick="closeModal('modal-promo-edit')">Annuler</button>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<script>
function editPromo(promo, url) {
    document.getElementById('form-promo-edit').action = url;
    document.getElementById('edit-description').value      = promo.description   || '';
    document.getElementById('edit-code').value             = promo.code          || '';
    document.getElementById('edit-type').value             = promo.type          || 'percent';
    document.getElementById('edit-value').value            = promo.value         || '';
    document.getElementById('edit-min_order_amount').value = promo.min_order_amount || '';
    document.getElementById('edit-usage_limit').value      = promo.usage_limit   || '';
    document.getElementById('edit-starts_at').value        = promo.starts_at     ? promo.starts_at.substring(0, 10) : '';
    document.getElementById('edit-expires_at').value       = promo.expires_at    ? promo.expires_at.substring(0, 10) : '';
    document.getElementById('edit-is_active').checked      = !!promo.is_active;
    openModal('modal-promo-edit');
}

@if($errors->any() && old('_form') === 'create')
document.addEventListener('DOMContentLoaded', () => openModal('modal-promo-create'));
@endif
</script>
@endsection
