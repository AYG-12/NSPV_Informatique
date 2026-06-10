@php $title = "Paramètres"; @endphp

@extends('layouts.admin')

@section('content')

{{-- ── Toast de notification (position fixe) ─────────────────────── --}}
<style>
#param-toast {
    position: fixed; top: 24px; right: 24px; z-index: 9999;
    display: flex; align-items: center; gap: 10px;
    padding: 12px 18px; border-radius: 10px;
    font-size: 13px; font-weight: 500; max-width: 380px;
    opacity: 0; transform: translateY(-10px);
    transition: opacity .25s ease, transform .25s ease;
    pointer-events: none;
}
#param-toast.visible { opacity: 1; transform: translateY(0); pointer-events: auto; }
#param-toast[data-type="success"] {
    background: rgba(45,204,127,.12);
    border: 1px solid #2dcc7f;
    color: #2dcc7f;
}
#param-toast[data-type="error"] {
    background: rgba(255,71,87,.12);
    border: 1px solid #ff4757;
    color: #ff4757;
}
</style>

<div id="param-toast" data-type="success">
    <span id="param-toast-icon"></span>
    <span id="param-toast-msg"></span>
</div>

<div>
    <div class="page-header">
        <div>
            <div class="page-heading">Paramètres</div>
            <div class="page-sub">Configuration de la boutique</div>
        </div>
    </div>

    @php
        $sections = ['general','boutique','paiement','livraison','notifications','securite'];
        $labels   = ['Général','Boutique','Paiement','Livraison','Notifications','Sécurité'];
    @endphp

    <div class="settings-grid">
        <div class="settings-nav">
            @foreach($sections as $i => $sec)
            <div class="settings-nav-item {{ $activeSection === $sec ? 'active' : '' }}" data-section="{{ $sec }}">{{ $labels[$i] }}</div>
            @endforeach
        </div>

        <div>
            {{-- ── Général ─────────────────────────────────────────── --}}
            <div class="settings-section {{ $activeSection === 'general' ? 'active' : '' }} card" id="section-general">
                <div class="section-title">Informations générales</div>
                <div class="section-sub">Paramètres de base de votre boutique</div>
                <form method="POST" action="{{ route('admin.parametres.general') }}" style="margin-top:16px">
                    @csrf @method('PUT')
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nom de la boutique</label>
                            <input class="form-input" name="shop_name" value="{{ $s['shop_name'] ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email de contact</label>
                            <input class="form-input" name="shop_email" type="email" value="{{ $s['shop_email'] ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Téléphone</label>
                            <input class="form-input" name="shop_phone" value="{{ $s['shop_phone'] ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Devise</label>
                            <input class="form-input" value="FCFA" disabled style="opacity:.5">
                        </div>
                        <div class="form-group full">
                            <label class="form-label">Adresse</label>
                            <input class="form-input" name="shop_address" value="{{ $s['shop_address'] ?? '' }}">
                        </div>
                        <div class="form-group full">
                            <label class="form-label">Description</label>
                            <textarea class="form-input" name="shop_description" rows="3">{{ $s['shop_description'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <div style="margin-top:16px">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>

            {{-- ── Boutique ─────────────────────────────────────────── --}}
            <div class="settings-section {{ $activeSection === 'boutique' ? 'active' : '' }} card" id="section-boutique">
                <div class="section-title">Configuration boutique</div>
                <div class="section-sub">Paramètres d'affichage et de comportement</div>
                <form method="POST" action="{{ route('admin.parametres.boutique') }}" style="margin-top:16px">
                    @csrf @method('PUT')
                    <div class="form-grid" style="margin-bottom:20px">
                        <div class="form-group">
                            <label class="form-label">Produits par page</label>
                            <select class="form-input" name="products_per_page">
                                @foreach(['12','24','48'] as $n)
                                <option value="{{ $n }}" {{ ($s['products_per_page'] ?? '24') === $n ? 'selected' : '' }}>{{ $n }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tri par défaut</label>
                            <select class="form-input" name="default_sort">
                                <option value="latest"    {{ ($s['default_sort'] ?? '') === 'latest'    ? 'selected' : '' }}>Nouveautés</option>
                                <option value="price_asc" {{ ($s['default_sort'] ?? '') === 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                                <option value="popular"   {{ ($s['default_sort'] ?? '') === 'popular'   ? 'selected' : '' }}>Popularité</option>
                            </select>
                        </div>
                    </div>
                    <div class="divider"></div>
                    @php
                        $togglesBoutique = [
                            ['show_reviews',     'Avis clients',      'Afficher les avis sur les fiches produits'],
                            ['show_stock',       'Stock visible',     'Afficher la quantité en stock aux clients'],
                            ['wishlist_enabled', 'Liste de souhaits', 'Permettre aux clients de sauvegarder des produits'],
                        ];
                    @endphp
                    @foreach($togglesBoutique as [$key, $label, $desc])
                    <div class="toggle-row">
                        <div class="toggle-info">
                            <div class="toggle-name">{{ $label }}</div>
                            <div class="toggle-desc">{{ $desc }}</div>
                        </div>
                        <label style="cursor:pointer;display:flex;align-items:center">
                            <input type="hidden" name="{{ $key }}" value="0">
                            <input type="checkbox" name="{{ $key }}" value="1"
                                   {{ ($s[$key] ?? '0') === '1' ? 'checked' : '' }}
                                   style="display:none" class="toggle-cb">
                            <div class="toggle {{ ($s[$key] ?? '0') === '1' ? 'on' : '' }}"
                                 onclick="toggleSetting(this, event)"></div>
                        </label>
                    </div>
                    @endforeach
                    <div style="margin-top:20px"><button type="submit" class="btn btn-primary">Enregistrer</button></div>
                </form>
            </div>

            {{-- ── Paiement ─────────────────────────────────────────── --}}
            <div class="settings-section {{ $activeSection === 'paiement' ? 'active' : '' }} card" id="section-paiement">
                <div class="section-title">Méthodes de paiement</div>
                <div class="section-sub">Configurez les modes de paiement acceptés</div>
                <form method="POST" action="{{ route('admin.parametres.paiement') }}" style="margin-top:16px">
                    @csrf @method('PUT')
                    @php
                        $togglesPaiement = [
                            ['payment_mobile_money', 'Mobile Money (MTN / Orange)', 'Paiement via portefeuille mobile'],
                            ['payment_stripe',       'Stripe (Carte bancaire)',      'Visa, Mastercard, American Express'],
                            ['payment_paypal',       'PayPal',                       'Paiement via compte PayPal'],
                            ['payment_cod',          'Paiement à la livraison',      'Régler en espèces à réception'],
                        ];
                    @endphp
                    @foreach($togglesPaiement as [$key, $label, $desc])
                    <div class="toggle-row">
                        <div class="toggle-info">
                            <div class="toggle-name">{{ $label }}</div>
                            <div class="toggle-desc">{{ $desc }}</div>
                        </div>
                        <label style="cursor:pointer;display:flex;align-items:center">
                            <input type="hidden" name="{{ $key }}" value="0">
                            <input type="checkbox" name="{{ $key }}" value="1" {{ ($s[$key] ?? '0') === '1' ? 'checked' : '' }} style="display:none" class="toggle-cb">
                            <div class="toggle {{ ($s[$key] ?? '0') === '1' ? 'on' : '' }}" onclick="toggleSetting(this, event)"></div>
                        </label>
                    </div>
                    @endforeach
                    <div style="margin-top:20px"><button type="submit" class="btn btn-primary">Enregistrer</button></div>
                </form>
            </div>

            {{-- ── Livraison ─────────────────────────────────────────── --}}
            <div class="settings-section {{ $activeSection === 'livraison' ? 'active' : '' }} card" id="section-livraison">
                <div class="section-title">Livraison</div>
                <div class="section-sub">Zones et tarifs de livraison</div>
                <form method="POST" action="{{ route('admin.parametres.livraison') }}" style="margin-top:16px">
                    @csrf @method('PUT')
                    <div class="form-grid" style="margin-bottom:20px">
                        <div class="form-group">
                            <label class="form-label">Livraison gratuite à partir de</label>
                            <input class="form-input" name="free_shipping_threshold" type="number" min="0"
                                   value="{{ $s['free_shipping_threshold'] ?? '0' }}">
                            <span style="font-size:12px;color:var(--muted);margin-top:4px;display:block">FCFA (0 = toujours payante)</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Délai estimé (standard)</label>
                            <input class="form-input" name="shipping_delay" value="{{ $s['shipping_delay'] ?? '' }}">
                        </div>
                    </div>
                    <div class="divider"></div>
                    @php
                        $togglesLivraison = [
                            ['express_shipping', 'Livraison express disponible', 'Proposer une option 24h'],
                            ['store_pickup',     'Retrait en boutique',          'Retrait sur place à Abidjan'],
                        ];
                    @endphp
                    @foreach($togglesLivraison as [$key, $label, $desc])
                    <div class="toggle-row">
                        <div class="toggle-info">
                            <div class="toggle-name">{{ $label }}</div>
                            <div class="toggle-desc">{{ $desc }}</div>
                        </div>
                        <label style="cursor:pointer;display:flex;align-items:center">
                            <input type="hidden" name="{{ $key }}" value="0">
                            <input type="checkbox" name="{{ $key }}" value="1" style="display:none" {{ ($s[$key] ?? '0') === '1' ? 'checked' : '' }} class="toggle-cb">
                            <div class="toggle {{ ($s[$key] ?? '0') === '1' ? 'on' : '' }}" onclick="toggleSetting(this, event)"></div>
                        </label>
                    </div>
                    @endforeach
                    <div style="margin-top:20px"><button type="submit" class="btn btn-primary">Enregistrer</button></div>
                </form>
            </div>

            {{-- ── Notifications ────────────────────────────────────── --}}
            <div class="settings-section {{ $activeSection === 'notifications' ? 'active' : '' }} card" id="section-notifications">
                <div class="section-title">Notifications</div>
                <div class="section-sub">Alertes et emails automatiques</div>
                <form method="POST" action="{{ route('admin.parametres.notifications') }}" style="margin-top:16px">
                    @csrf @method('PUT')
                    @php
                        $togglesNotif = [
                            ['notif_new_order',     'Nouvelle commande',    'Recevoir un email à chaque nouvelle commande'],
                            ['notif_low_stock',     'Stock faible',         'Alerte quand le stock passe sous 5 unités'],
                            ['notif_new_review',    'Avis client reçu',     'Notification lors d\'un nouvel avis'],
                            ['notif_weekly_report', 'Rapport hebdomadaire', 'Résumé des performances chaque lundi'],
                        ];
                    @endphp
                    @foreach($togglesNotif as [$key, $label, $desc])
                    <div class="toggle-row">
                        <div class="toggle-info">
                            <div class="toggle-name">{{ $label }}</div>
                            <div class="toggle-desc">{{ $desc }}</div>
                        </div>
                        <label style="cursor:pointer;display:flex;align-items:center">
                            <input type="hidden" name="{{ $key }}" value="0">
                            <input type="checkbox" name="{{ $key }}" value="1"
                                   {{ ($s[$key] ?? '0') === '1' ? 'checked' : '' }}
                                   style="display:none" class="toggle-cb">
                            <div class="toggle {{ ($s[$key] ?? '0') === '1' ? 'on' : '' }}"
                                 onclick="toggleSetting(this, event)"></div>
                        </label>
                    </div>
                    @endforeach
                    <div style="margin-top:20px"><button type="submit" class="btn btn-primary">Enregistrer</button></div>
                </form>
            </div>

            {{-- ── Sécurité ─────────────────────────────────────────── --}}
            <div class="settings-section {{ $activeSection === 'securite' ? 'active' : '' }} card" id="section-securite">
                <div class="section-title">Sécurité</div>
                <div class="section-sub">Modifier le mot de passe administrateur</div>
                <div id="param-error-securite" style="display:none;background:rgba(255,80,80,.1);border:1px solid #f55;color:#f55;padding:10px 14px;border-radius:8px;margin:14px 0;font-size:13px;"></div>
                <form method="POST" action="{{ route('admin.parametres.password') }}" style="margin-top:16px">
                    @csrf @method('PUT')
                    <div class="form-grid" style="margin-bottom:20px">
                        <div class="form-group">
                            <label class="form-label">Mot de passe actuel</label>
                            <input class="form-input" type="password" name="current_password" placeholder="••••••••" required>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <label class="form-label">Nouveau mot de passe</label>
                            <input class="form-input" type="password" name="password" placeholder="••••••••" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirmer le mot de passe</label>
                            <input class="form-input" type="password" name="password_confirmation" placeholder="••••••••" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Mettre à jour le mot de passe</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// ── Toast ─────────────────────────────────────────────────────────
const _toast    = document.getElementById('param-toast');
const _toastMsg = document.getElementById('param-toast-msg');
const _toastIco = document.getElementById('param-toast-icon');
let   _toastTimer;

function showToast(msg, type) {
    type = type || 'success';
    _toastMsg.textContent = msg;
    _toastIco.textContent = type === 'success' ? '✓' : '✕';
    _toast.dataset.type   = type;
    _toast.classList.add('visible');
    clearTimeout(_toastTimer);
    _toastTimer = setTimeout(function () { _toast.classList.remove('visible'); }, 3500);
}

// ── Navigation sans rechargement ──────────────────────────────────
document.querySelectorAll('.settings-nav-item').forEach(function (el) {
    el.addEventListener('click', function () {
        var id = el.dataset.section;
        document.querySelectorAll('.settings-nav-item').forEach(function (i) {
            i.classList.toggle('active', i.dataset.section === id);
        });
        document.querySelectorAll('.settings-section').forEach(function (s) {
            s.classList.toggle('active', s.id === 'section-' + id);
        });
    });
});

// ── Toggles : synchronise le visuel et la checkbox ────────────────
function toggleSetting(el, e) {
    e.stopPropagation(); // empêche le label de cocher/décocher une deuxième fois
    el.classList.toggle('on');
    var cb = el.closest('label').querySelector('.toggle-cb');
    // if (cb) cb.checked = el.classList.contains('on');
}

// ── Soumission AJAX de tous les formulaires ───────────────────────
var csrfToken = document.querySelector('meta[name="csrf-token"]').content;

document.querySelectorAll('.settings-section form').forEach(function (form) {
    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        var btn      = form.querySelector('[type="submit"]');
        var origText = btn.textContent;
        btn.disabled    = true;
        btn.textContent = 'Enregistrement…';

        // Réinitialise l'erreur inline (section sécurité)
        var errBox = document.getElementById('param-error-securite');
        if (errBox) errBox.style.display = 'none';

        try {
            var res  = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept':       'application/json',
                },
                body: new FormData(form),
            });

            var data = await res.json();

            if (res.ok) {
                showToast(data.success || 'Enregistré avec succès.');
                // Vide les champs de mot de passe après succès
                form.querySelectorAll('[type="password"]').forEach(function (i) { i.value = ''; });
            } else {
                var firstError = data.errors
                    ? Object.values(data.errors)[0][0]
                    : (data.message || 'Une erreur est survenue.');

                // Erreur inline pour le formulaire sécurité, toast pour les autres
                if (errBox && form.closest('#section-securite')) {
                    errBox.textContent    = firstError;
                    errBox.style.display  = 'block';
                } else {
                    showToast(firstError, 'error');
                }
            }
        } catch (_) {
            showToast('Erreur réseau. Vérifiez votre connexion.', 'error');
        } finally {
            btn.disabled    = false;
            btn.textContent = origText;
        }
    });
});
</script>
@endsection
