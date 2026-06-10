@php $title = "Finaliser la commande"; @endphp

@extends('layouts.guest')

@section('content')
    @include('Shop.partials._navbar')

    <main class="cart-page">
        <div class="container">

            {{-- LEFT : ADRESSE + CONFIRMATION --}}
            <div class="cart-panel">
                <div class="panel-title">Livraison</div>

                @php
                    $hasPickup      = ($appSettings['store_pickup'] ?? '0') === '1';
                    $selectedType   = old('delivery_type', 'delivery');
                @endphp

                {{-- Choix du mode de réception --}}
                @if($hasPickup)
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:24px">
                    <label id="lbl-delivery"
                        style="display:flex;align-items:center;gap:10px;padding:14px 16px;border:1px solid {{ $selectedType === 'delivery' ? 'var(--accent,#e8ff47)' : 'var(--border,#2a2a2a)' }};border-radius:10px;cursor:pointer;transition:border-color .2s"
                        onclick="setDeliveryType('delivery')">
                        <input type="radio" name="delivery_type" value="delivery" form="checkout-form"
                            {{ $selectedType === 'delivery' ? 'checked' : '' }}
                            style="accent-color:var(--accent,#e8ff47)">
                        <div>
                            <div style="font-weight:600;font-size:14px;color:#00fbff;">🚚 Livraison</div>
                            <div style="font-size:12px;color:var(--muted,#888);margin-top:2px">À votre adresse</div>
                        </div>
                    </label>
                    <label id="lbl-pickup"
                        style="display:flex;align-items:center;gap:10px;padding:14px 16px;border:1px solid {{ $selectedType === 'pickup' ? 'var(--accent,#e8ff47)' : 'var(--border,#2a2a2a)' }};border-radius:10px;cursor:pointer;transition:border-color .2s"
                        onclick="setDeliveryType('pickup')">
                        <input type="radio" name="delivery_type" value="pickup" form="checkout-form"
                            {{ $selectedType === 'pickup' ? 'checked' : '' }}
                            style="accent-color:var(--accent,#e8ff47)">
                        <div>
                            <div style="font-weight:600;font-size:14px;color:#00fbff;">🏪 Retrait boutique</div>
                            <div style="font-size:12px;color:var(--muted,#888);margin-top:2px">Récupérer en magasin</div>
                        </div>
                    </label>
                </div>
                @else
                <input type="hidden" name="delivery_type" value="delivery" form="checkout-form">
                @endif

                @if(session('success'))
                    <div style="background:rgba(45,204,127,.15);border:1px solid #2dcc7f;color:#2dcc7f;padding:10px 16px;border-radius:8px;margin-bottom:16px;font-size:13px;">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div style="background:rgba(255,71,87,.15);border:1px solid #ff4757;color:#ff4757;padding:10px 16px;border-radius:8px;margin-bottom:16px;font-size:13px;">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div style="background:rgba(255,71,87,.15);border:1px solid #ff4757;color:#ff4757;padding:10px 16px;border-radius:8px;margin-bottom:16px;font-size:13px;">
                        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                    </div>
                @endif

                <form id="checkout-form" method="POST" action="{{ route('shop.checkout.store') }}">
                    @csrf

                    {{-- Sélection d'adresse --}}
                    <div id="address-section" style="{{ $selectedType === 'pickup' ? 'display:none' : '' }}">
                        @if($addresses->isNotEmpty())
                            <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:20px">
                                @foreach($addresses as $addr)
                                    <label style="display:flex;align-items:flex-start;gap:12px;padding:14px 16px;border:1px solid {{ old('address_id') == $addr->id || ($loop->first && !old('address_id')) ? 'var(--accent,#e8ff47)' : 'var(--border,#2a2a2a)' }};border-radius:10px;cursor:pointer;">
                                        <input type="radio" name="address_id" value="{{ $addr->id }}"
                                            {{ old('address_id') == $addr->id || ($loop->first && !old('address_id')) ? 'checked' : '' }}
                                            style="margin-top:3px;accent-color:var(--accent,#e8ff47)">
                                        <div>
                                            <div style="font-weight:600;font-size:14px;color:#00fbff;">{{ $addr->full_name }}
                                                @if($addr->is_default)<span style="font-size:11px;background:rgba(232,255,71,.15);color:#e8ff47;padding:2px 8px;border-radius:4px;margin-left:6px">Par défaut</span>@endif
                                            </div>
                                            <div style="font-size:13px;color:#000000;margin-top:2px">{{ $addr->phone }}</div>
                                            <div style="font-size:13px;color:var(--muted,#888)">{{ $addr->address_line }}, {{ $addr->quartier ? $addr->quartier . ', ' : '' }}{{ $addr->city }}</div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <p style="color:var(--muted,#be0606);font-size:13px;margin-bottom:16px">Aucune adresse enregistrée. Ajoutez-en une ci-dessous.</p>
                        @endif

                    </div>{{-- /address-section --}}

                    {{-- Message retrait boutique --}}
                    <div id="pickup-info" style="{{ $selectedType !== 'pickup' ? 'display:none' : '' }};background:rgba(232,255,71,.07);border:1px solid rgba(232,255,71,.25);border-radius:10px;padding:16px;margin-bottom:20px">
                        <div style="font-weight:600;font-size:14px;margin-bottom:4px">🏪 Retrait en boutique</div>
                        <div style="font-size:13px;color:var(--muted,#00ff0d)">Votre commande sera prête à récupérer en magasin. Vous serez contacté dès qu'elle est disponible.</div>
                    </div>

                    <div class="form-group" style="margin-bottom:20px">
                        <label class="form-label" style="font-size:13px;color:var(--muted,#0051ff)">Note pour la commande (optionnel)</label>
                        <textarea name="notes" class="promo-input" style="width:100%;min-height:70px;resize:vertical" placeholder="Instructions de livraison, remarques…">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit" id="submit-btn" class="pay-btn"
                        {{ ($selectedType === 'delivery' && $addresses->isEmpty()) ? 'disabled' : '' }}
                        style="{{ ($selectedType === 'delivery' && $addresses->isEmpty()) ? 'opacity:.5;cursor:not-allowed' : '' }}">
                        Confirmer la commande
                    </button>
                </form>

                {{-- Formulaire ajout adresse --}}
                <div style="margin-top:28px;border-top:1px solid var(--border,#2a2a2a);padding-top:20px">
                    <div style="color:#ff4757;font-size:14px;font-weight:600;margin-bottom:14px;cursor:pointer" onclick="toggleAddrForm()">
                        + Ajouter une nouvelle adresse
                    </div>
                    <form method="POST" action="{{ route('shop.checkout.address') }}"
                        id="addr-form"
                        style="display:{{ $addresses->isEmpty() ? 'block' : 'none' }}">
                        @csrf
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                            <div>
                                <label style="font-size:12px;color:var(--muted,#888)">Nom complet</label>
                                <input name="full_name" class="promo-input" style="width:100%;margin-top:4px" placeholder="Ex: Kouamé Yao" required>
                            </div>
                            <div>
                                <label style="font-size:12px;color:var(--muted,#888)">Téléphone</label>
                                <input name="phone" class="promo-input" style="width:100%;margin-top:4px" placeholder="07 00 00 00 00" required>
                            </div>
                            <div>
                                <label style="font-size:12px;color:var(--muted,#888)">Ville</label>
                                <input name="city" class="promo-input" style="width:100%;margin-top:4px" placeholder="Abidjan" required>
                            </div>
                            <div>
                                <label style="font-size:12px;color:var(--muted,#888)">Quartier</label>
                                <input name="quartier" class="promo-input" style="width:100%;margin-top:4px" placeholder="Cocody, Plateau…">
                            </div>
                            <div style="grid-column:span 2">
                                <label style="font-size:12px;color:var(--muted,#888)">Adresse complète</label>
                                <input name="address_line" class="promo-input" style="width:100%;margin-top:4px" placeholder="Rue, n°, résidence…" required>
                            </div>
                            <div style="grid-column:span 2;display:flex;align-items:center;gap:8px">
                                <input type="checkbox" name="is_default" value="1" id="chk-default" style="accent-color:var(--accent,#e8ff47)">
                                <label for="chk-default" style="font-size:13px;cursor:pointer">Définir comme adresse par défaut</label>
                            </div>
                        </div>
                        <button type="submit" class="promo-apply" style="margin-top:14px;width:100%">Enregistrer l'adresse</button>
                    </form>
                </div>
            </div>

            {{-- RIGHT : RÉSUMÉ COMMANDE --}}
            <div class="summary-panel">
                <div class="panel-title">Votre commande</div>

                @foreach($cart->items as $item)
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid var(--border,#2a2a2a);font-size:13px">
                    <div>
                        <div style="font-weight:500;color:#0015ff;">{{ $item->product->name }}</div>
                        <div style="color:#00aeff;font-size:12px">× {{ $item->quantity }} · {{ number_format($item->unit_price, 0, ',', ' ') }} F CFA</div>
                    </div>
                    <div style="font-weight:600;white-space:nowrap;color:#ff5500;">{{ number_format($item->line_total, 0, ',', ' ') }} F CFA</div>
                </div>
                @endforeach

                <div class="summary-row" style="margin-top:12px">
                    <span class="label">Sous-total</span>
                    <span class="value">{{ number_format($cart->subtotal, 0, ',', ' ') }} F CFA</span>
                </div>

                @if($cart->discount_amount > 0)
                <div class="summary-row">
                    <span class="label">Réduction ({{ $cart->promotion->code }})</span>
                    <span class="value" style="color:#2dcc7f">−{{ number_format($cart->discount_amount, 0, ',', ' ') }} F CFA</span>
                </div>
                @endif

                <div class="summary-row">
                    <span class="label">Livraison</span>
                    @php $threshold = (int)($appSettings['free_shipping_threshold'] ?? 0); @endphp
                    @if($threshold > 0 && $cart->total >= $threshold)
                        <span class="free" style="color:#2dcc7f">Gratuite ✓</span>
                    @elseif($threshold > 0)
                        <span class="free">Selon la zone
                            <small style="display:block;color:var(--muted);font-size:11px">Gratuite dès {{ number_format($threshold, 0, ',', ' ') }} F CFA</small>
                        </span>
                    @else
                        <span class="free">Selon la zone</span>
                    @endif
                </div>

                @if(!empty($appSettings['shipping_delay']))
                <div class="summary-row">
                    <span class="label" style="color:var(--muted,#888)">Délai estimé</span>
                    <span class="value" style="font-size:12px;color:var(--muted,#888)">{{ $appSettings['shipping_delay'] }}</span>
                </div>
                @endif

                <div class="summary-total">
                    <span>Total</span>
                    <span>{{ number_format($cart->total, 0, ',', ' ') }} F CFA</span>
                </div>

                @php $hasExpress = ($appSettings['express_shipping'] ?? '0') === '1'; @endphp
                @if($hasExpress)
                <div style="margin-top:12px">
                    <div style="font-size:11px;background:rgba(232,255,71,.08);border:1px solid rgba(232,255,71,.3);color:var(--accent,#e8ff47);padding:4px 10px;border-radius:6px;display:inline-block">
                        ⚡ Livraison express disponible
                    </div>
                </div>
                @endif

                {{-- Méthodes de paiement acceptées --}}
                @php
                    $payMethods = [
                        'payment_cod'          => ['label' => 'Paiement à la livraison', 'icon' => '💵'],
                        'payment_mobile_money' => ['label' => 'Mobile Money',             'icon' => '📱'],
                        'payment_stripe'       => ['label' => 'Carte bancaire',           'icon' => '💳'],
                        'payment_paypal'       => ['label' => 'PayPal',                   'icon' => '🅿️'],
                    ];
                    $activeMethods = array_filter($payMethods, fn($k) => ($appSettings[$k] ?? '0') === '1', ARRAY_FILTER_USE_KEY);
                @endphp
                @if(count($activeMethods) > 0)
                <div style="margin-top:14px;border-top:1px solid var(--border,#2a2a2a);padding-top:12px">
                    <div style="font-size:11px;color:var(--muted,#888);margin-bottom:8px;text-transform:uppercase;letter-spacing:.05em">Paiements acceptés</div>
                    <div style="display:flex;flex-wrap:wrap;gap:6px">
                        @foreach($activeMethods as $m)
                            <div class="secure-badge" style="font-size:12px;padding:5px 10px">
                                {{ $m['icon'] }} {{ $m['label'] }}
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

        </div>
    </main>

    <script>
        function toggleAddrForm() {
            const f = document.getElementById('addr-form');
            f.style.display = f.style.display === 'none' ? 'block' : 'none';
        }

        function setDeliveryType(type) {
            const isPickup        = type === 'pickup';
            const accentBorder    = 'var(--accent,#e8ff47)';
            const defaultBorder   = 'var(--border,#2a2a2a)';

            document.getElementById('lbl-delivery').style.borderColor = isPickup ? defaultBorder : accentBorder;
            document.getElementById('lbl-pickup').style.borderColor   = isPickup ? accentBorder  : defaultBorder;

            document.getElementById('address-section').style.display = isPickup ? 'none' : '';
            document.getElementById('pickup-info').style.display     = isPickup ? '' : 'none';

            const btn        = document.getElementById('submit-btn');
            const hasAddress = document.querySelector('input[name="address_id"]') !== null;
            btn.disabled     = !isPickup && !hasAddress;
            btn.style.opacity        = btn.disabled ? '.5' : '1';
            btn.style.cursor         = btn.disabled ? 'not-allowed' : '';
        }
    </script>
@endsection
