@php $title = "Commandes"; @endphp

@extends('layouts.admin')

@section('content')
{{-- PAGE: COMMANDES --}}
    <div>
        @if(session('success'))
            <div style="background:rgba(45,204,127,.15);border:1px solid var(--success);color:var(--success);padding:10px 16px;border-radius:8px;margin-bottom:16px;font-size:13px;">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div style="background:rgba(255,71,87,.15);border:1px solid var(--danger);color:var(--danger);padding:10px 16px;border-radius:8px;margin-bottom:16px;font-size:13px;">{{ session('error') }}</div>
        @endif

        <div class="page-header">
            <div>
                <div class="page-heading">Commandes</div>
                <div class="page-sub">
                    <span>{{ $orders->total() }}</span> commandes ·
                    <span>{{ $pendingCount }}</span> en attente
                </div>
            </div>
            <button class="btn btn-primary" onclick="openModal('modal-order')">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 2v10M2 7h10"/></svg>
                Nouvelle commande
            </button>
        </div>

        <form method="GET" action="{{ route('admin.commandes') }}">
        <div class="filters-row">
            <input class="filter-input" name="q" placeholder="🔍  Rechercher une commande…" value="{{ request('q') }}" style="flex:1;min-width:200px">
            <select class="filter-select" name="statut">
                <option value="">Tous les statuts</option>
                <option value="pending"     {{ request('statut') === 'pending'     ? 'selected' : '' }}>En attente</option>
                <option value="confirmed"   {{ request('statut') === 'confirmed'   ? 'selected' : '' }}>Confirmé</option>
                <option value="processing"  {{ request('statut') === 'processing'  ? 'selected' : '' }}>Traitement</option>
                <option value="shipped"     {{ request('statut') === 'shipped'     ? 'selected' : '' }}>Expédié</option>
                <option value="delivered"   {{ request('statut') === 'delivered'   ? 'selected' : '' }}>Livré</option>
                <option value="cancelled"   {{ request('statut') === 'cancelled'   ? 'selected' : '' }}>Annulé</option>
            </select>
            <button type="submit" class="btn btn-ghost">Filtrer</button>
        </div>
        </form>

        <div class="card">
            <div class="data-table-wrap">
            <table>
                <thead><tr><th>N° Commande</th><th>Client</th><th>Produits</th><th>Date</th><th>Montant</th><th>Type</th><th>Statut</th><th>Actions</th></tr></thead>
                <tbody>
                @forelse($orders as $order)
                @php
                    $initials = collect(explode(' ', $order->user->name))->map(fn($w) => strtoupper(substr($w,0,1)))->take(2)->implode('');
                    $firstItem = $order->items->first();
                    $itemsLabel = $firstItem ? $firstItem->product_name . ' × ' . $firstItem->quantity : '—';
                    $extraCount = $order->items->count() - 1;

                    $statusMap = [
                        'pending'    => ['label' => 'En attente',  'pill' => 'pill-warn'],
                        'confirmed'  => ['label' => 'Confirmé',    'pill' => 'pill-info'],
                        'processing' => ['label' => 'Traitement',  'pill' => 'pill-warn'],
                        'shipped'    => ['label' => 'Expédié',     'pill' => 'pill-info'],
                        'delivered'  => ['label' => 'Livré',       'pill' => 'pill-success'],
                        'cancelled'  => ['label' => 'Annulé',      'pill' => 'pill-danger'],
                    ];
                    $s = $statusMap[$order->status] ?? ['label' => $order->status, 'pill' => 'pill-warn'];
                @endphp
                <tr>
                    <td style="font-weight:600;color:var(--accent)">{{ $order->order_number }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px">
                            <div class="avatar" style="width:28px;height:28px;font-size:11px">{{ $initials }}</div>
                            {{ $order->user->name }}
                        </div>
                    </td>
                    <td style="color:var(--muted)">
                        {{ $itemsLabel }}
                        @if($extraCount > 0)<small> +{{ $extraCount }} autre{{ $extraCount > 1 ? 's' : '' }}</small>@endif
                    </td>
                    <td style="color:var(--muted)">{{ $order->created_at->format('d M Y') }}</td>
                    <td style="font-weight:600">{{ number_format($order->total, 0, ',', ' ') }} FCFA</td>
                    <td>
                        @if(($order->delivery_type ?? 'delivery') === 'pickup')
                            <span class="pill pill-info" style="font-size:11px">🏪 Retrait</span>
                        @else
                            <span class="pill" style="font-size:11px;background:rgba(255,255,255,.06);color:var(--muted)">🚚 Livraison</span>
                        @endif
                    </td>
                    <td><span class="pill {{ $s['pill'] }}">{{ $s['label'] }}</span></td>
                    <td style="display:flex;gap:6px;padding:12px 0">
                        @if($order->status !== 'cancelled')
                        <button class="btn btn-ghost" style="padding:5px 10px;font-size:12px"
                            onclick="openStatusModal({{ $order->id }}, '{{ $order->order_number }}', '{{ $order->status }}')">
                            Statut
                        </button>
                        @else
                        <span style="font-size:12px;color:var(--muted);padding:5px 10px">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" style="text-align:center;color:var(--muted);padding:24px">Aucune commande trouvée.</td></tr>
                @endforelse
                </tbody>
            </table>
            </div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:20px;padding-top:16px;border-top:1px solid var(--border)">
                <span style="font-size:13px;color:var(--muted)">
                    @if($orders->total() > 0)
                        Affichage {{ $orders->firstItem() }}–{{ $orders->lastItem() }} sur {{ $orders->total() }} commandes
                    @else
                        Aucune commande
                    @endif
                </span>
                <div style="display:flex;gap:6px">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Changer le statut -->
    <div class="modal-overlay" id="modal-status">
        <div class="modal" style="max-width:420px">
            <div class="modal-header">
                <div class="modal-title" id="modal-status-title">Mettre à jour le statut</div>
                <div class="modal-close" onclick="closeModal('modal-status')">✕</div>
            </div>
            <form id="form-status" method="POST" action="">
                @csrf
                @method('PATCH')
                <div class="form-group" style="margin-top:8px">
                    <label class="form-label">Nouveau statut</label>
                    <select class="form-input" name="status" id="s-status">
                        <option value="pending">En attente</option>
                        <option value="confirmed">Confirmé</option>
                        <option value="processing">Traitement</option>
                        <option value="shipped">Expédié</option>
                        <option value="delivered">Livré</option>
                        <option value="cancelled">Annulé</option>
                    </select>
                </div>
                <div style="display:flex;gap:10px;margin-top:24px;justify-content:flex-end">
                    <button type="button" class="btn btn-ghost" onclick="closeModal('modal-status')">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Modal : Nouvelle commande ──────────────────────────── --}}
    <div class="modal-overlay" id="modal-order">
        <div class="modal" style="max-width:680px">
            <div class="modal-header">
                <div class="modal-title">Nouvelle commande manuelle</div>
                <div class="modal-close" onclick="closeModal('modal-order')">✕</div>
            </div>
            <form method="POST" action="{{ route('admin.commandes.store') }}">
                @csrf
                @if($errors->any())
                <div style="background:rgba(255,71,87,.12);border:1px solid var(--danger);color:var(--danger);padding:10px 14px;border-radius:8px;margin-bottom:14px;font-size:13px;">
                    {{ $errors->first() }}
                </div>
                @endif

                <div class="form-grid">
                    {{-- Source --}}
                    <div class="form-group">
                        <label class="form-label">Source <span style="color:var(--danger)">*</span></label>
                        <select class="form-input" name="source" required>
                            <option value="phone">📞 Commande téléphonique</option>
                            <option value="store">🏪 Passage en boutique</option>
                        </select>
                    </div>

                    {{-- Statut initial --}}
                    <div class="form-group">
                        <label class="form-label">Statut initial <span style="color:var(--danger)">*</span></label>
                        <select class="form-input" name="status" required>
                            <option value="confirmed">Confirmé</option>
                            <option value="processing">En traitement</option>
                            <option value="pending">En attente</option>
                            <option value="delivered">Livré</option>
                        </select>
                    </div>

                    {{-- Client --}}
                    <div class="form-group full">
                        <label class="form-label">Client <span style="color:var(--danger)">*</span></label>
                        <input type="text" id="client-search" class="form-input" placeholder="🔍 Rechercher un client par nom ou email…"
                               oninput="filterClients(this.value)" autocomplete="off"
                               style="margin-bottom:6px">
                        <select class="form-input" name="user_id" id="client-select" size="4"
                                style="height:auto;padding:4px" required>
                            @foreach($clients as $client)
                            <option value="{{ $client->id }}"
                                    data-label="{{ strtolower($client->name) }} {{ strtolower($client->email) }}">
                                {{ $client->name }}
                                @if($client->phone) · {{ $client->phone }} @endif
                                — {{ $client->email }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Notes --}}
                    <div class="form-group full">
                        <label class="form-label">Notes <small style="color:var(--muted)">(optionnel)</small></label>
                        <input class="form-input" name="notes" placeholder="Ex: client demande livraison samedi matin…">
                    </div>
                </div>

                {{-- Lignes produits --}}
                <div style="margin-top:16px">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px">
                        <label class="form-label" style="margin:0">Produits <span style="color:var(--danger)">*</span></label>
                        <button type="button" class="btn btn-ghost" style="padding:4px 10px;font-size:12px" onclick="addLine()">
                            + Ajouter un produit
                        </button>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 70px 130px 32px;gap:6px;margin-bottom:6px;font-size:11px;color:var(--muted);padding:0 4px">
                        <span>Produit</span><span>Qté</span><span>Prix unitaire (FCFA)</span><span></span>
                    </div>

                    <div id="order-lines"></div>

                    <div style="display:flex;justify-content:flex-end;margin-top:10px;padding-top:10px;border-top:1px solid var(--border)">
                        <span style="font-size:13px;color:var(--muted)">Total estimé :</span>
                        <span id="order-total" style="font-size:15px;font-weight:700;color:var(--success);margin-left:10px">0 FCFA</span>
                    </div>
                </div>

                <div style="display:flex;gap:10px;margin-top:20px;justify-content:flex-end">
                    <button type="button" class="btn btn-ghost" onclick="closeModal('modal-order')">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer la commande</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function openStatusModal(id, orderNumber, currentStatus) {
        document.getElementById('modal-status-title').textContent = 'Statut · ' + orderNumber;
        document.getElementById('form-status').action = '/welAdminnspv/commandes/' + id + '/statut';
        document.getElementById('s-status').value = currentStatus;
        openModal('modal-status');
    }

    // ── Commande manuelle ──────────────────────────────────────
    @php
        $productsJs = $products->map(fn($p) => [
            'id'    => $p->id,
            'name'  => $p->name,
            'price' => (float)($p->sale_price ?? $p->price),
            'stock' => $p->stock,
        ]);
    @endphp
    const PRODUCTS = {!! json_encode($productsJs) !!};

    let lineIdx = 0;

    function addLine() {
        lineIdx++;
        const idx  = lineIdx;
        const opts = PRODUCTS.map(p =>
            `<option value="${p.id}" data-price="${p.price}">${p.name} (${p.price.toLocaleString('fr-FR')} FCFA)</option>`
        ).join('');

        const div = document.createElement('div');
        div.id    = 'line-' + idx;
        div.style.cssText = 'display:grid;grid-template-columns:1fr 70px 130px 32px;gap:6px;margin-bottom:6px;align-items:center';
        div.innerHTML = `
            <select class="form-input" name="items[${idx}][product_id]"
                    onchange="fillPrice(this,${idx})" required style="padding:7px 10px">
                <option value="">— Produit —</option>
                ${opts}
            </select>
            <input class="form-input" name="items[${idx}][quantity]" id="qty-${idx}"
                   type="number" min="1" value="1" required
                   oninput="calcTotal()" style="padding:7px 8px;text-align:center">
            <input class="form-input" name="items[${idx}][unit_price]" id="price-${idx}"
                   type="number" min="0" step="any" placeholder="0" required
                   oninput="calcTotal()" style="padding:7px 10px">
            <button type="button" onclick="removeLine(${idx})"
                    style="width:32px;height:32px;border-radius:8px;border:1px solid var(--border);background:var(--surface);color:var(--danger);cursor:pointer;font-size:16px;display:grid;place-items:center">×</button>
        `;
        document.getElementById('order-lines').appendChild(div);
    }

    function fillPrice(select, idx) {
        const opt = select.options[select.selectedIndex];
        document.getElementById('price-' + idx).value = opt.dataset.price || '';
        calcTotal();
    }

    function removeLine(idx) {
        const el = document.getElementById('line-' + idx);
        if (el) el.remove();
        calcTotal();
    }

    function calcTotal() {
        let total = 0;
        document.querySelectorAll('#order-lines > div').forEach(line => {
            const qty   = parseFloat(line.querySelector('[name*="[quantity]"]').value)   || 0;
            const price = parseFloat(line.querySelector('[name*="[unit_price]"]').value) || 0;
            total += qty * price;
        });
        document.getElementById('order-total').textContent =
            new Intl.NumberFormat('fr-FR').format(total) + ' FCFA';
    }

    function filterClients(val) {
        const q = val.toLowerCase();
        document.querySelectorAll('#client-select option').forEach(opt => {
            opt.hidden = q.length > 0 && !opt.dataset.label.includes(q);
        });
    }

    // Ajouter une ligne vide à l'ouverture du modal
    document.getElementById('modal-order').addEventListener('click', function(e) {
        if (e.target === this && document.getElementById('order-lines').children.length === 0) addLine();
    });
    document.querySelector('[onclick="openModal(\'modal-order\')"]')?.addEventListener('click', () => {
        if (document.getElementById('order-lines').children.length === 0) addLine();
    });

    @if($errors->any())
    document.addEventListener('DOMContentLoaded', () => { openModal('modal-order'); addLine(); });
    @endif
    </script>
@endsection
