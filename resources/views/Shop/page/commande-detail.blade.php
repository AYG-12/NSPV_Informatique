@php $title = "Commande " . $order->order_number; @endphp

@extends('layouts.guest')

@section('content')
    @include('Shop.partials._navbar')

    <main class="" style="padding:100px">
        <div style="max-width:780px;margin:0 auto;">

            @if(session('success'))
            <div style="background:rgba(45,204,127,.15);border:1px solid #2dcc7f;color:#2dcc7f;padding:14px 20px;border-radius:10px;margin-bottom:24px;font-size:14px;display:flex;align-items:center;gap:10px">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
            </div>
            @endif

            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px">
                <div>
                    <h1 style="font-size:22px;font-weight:700;margin:5px">{{ $order->order_number }}</h1>
                    <div style="color:var(--muted,#888);font-size:13px;margin-top:4px">Passée le {{ $order->created_at->format('d M Y à H:i') }}</div>
                </div>
                @php
                    $statusMap = [
                        'pending'    => ['label' => 'En attente',   'color' => '#f39c12'],
                        'confirmed'  => ['label' => 'Confirmée',    'color' => '#3498db'],
                        'processing' => ['label' => 'Traitement',   'color' => '#9b59b6'],
                        'shipped'    => ['label' => 'Expédiée',     'color' => '#1abc9c'],
                        'delivered'  => ['label' => 'Livrée',       'color' => '#2dcc7f'],
                        'cancelled'  => ['label' => 'Annulée',      'color' => '#ff4757'],
                    ];
                    $s = $statusMap[$order->status] ?? ['label' => $order->status, 'color' => '#888'];
                @endphp
                <span style="background:{{ $s['color'] }}22;color:{{ $s['color'] }};border:1px solid {{ $s['color'] }};padding:5px 14px;border-radius:20px;font-size:13px;font-weight:600">
                    {{ $s['label'] }}
                </span>
            </div>

            {{-- Articles --}}
            <div style="background:var(--card,#1a1a1a);border:1px solid var(--border,#2a2a2a);border-radius:12px;padding:20px;margin-bottom:20px">
                <div style="font-weight:600;margin-bottom:16px">Articles commandés</div>
                @foreach($order->items as $item)
                <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--border,#2a2a2a);font-size:14px">
                    <div>
                        <div style="font-weight:500">{{ $item->product_name }}</div>
                        <div style="color:var(--muted,#888);font-size:12px">× {{ $item->quantity }} · {{ number_format($item->unit_price, 0, ',', ' ') }} F CFA / unité</div>
                    </div>
                    <div style="font-weight:600">{{ number_format($item->total_price, 0, ',', ' ') }} F CFA</div>
                </div>
                @endforeach

                <div style="margin-top:14px;display:flex;flex-direction:column;gap:6px;font-size:14px">
                    <div style="display:flex;justify-content:space-between">
                        <span style="color:var(--muted,#888)">Sous-total</span>
                        <span>{{ number_format($order->subtotal, 0, ',', ' ') }} F CFA</span>
                    </div>
                    @if($order->discount_amount > 0)
                    <div style="display:flex;justify-content:space-between">
                        <span style="color:var(--muted,#888)">Réduction{{ $order->promotion ? ' (' . $order->promotion->code . ')' : '' }}</span>
                        <span style="color:#2dcc7f">−{{ number_format($order->discount_amount, 0, ',', ' ') }} F CFA</span>
                    </div>
                    @endif
                    <div style="display:flex;justify-content:space-between;font-weight:700;font-size:16px;padding-top:8px;border-top:1px solid var(--border,#2a2a2a)">
                        <span>Total</span>
                        <span>{{ number_format($order->total, 0, ',', ' ') }} F CFA</span>
                    </div>
                </div>
            </div>

            {{-- Adresse de livraison --}}
            @if($order->address)
            <div style="background:var(--card,#1a1a1a);border:1px solid var(--border,#2a2a2a);border-radius:12px;padding:20px;margin-bottom:20px">
                <div style="font-weight:600;margin-bottom:12px">Adresse de livraison</div>
                <div style="font-size:14px;line-height:1.8">
                    <div style="font-weight:500">{{ $order->address->full_name }}</div>
                    <div style="color:var(--muted,#888)">{{ $order->address->phone }}</div>
                    <div style="color:var(--muted,#888)">{{ $order->address->address_line }}, {{ $order->address->quartier ? $order->address->quartier . ', ' : '' }}{{ $order->address->city }}</div>
                </div>
            </div>
            @endif

            @if($order->notes)
            <div style="background:var(--card,#1a1a1a);border:1px solid var(--border,#2a2a2a);border-radius:12px;padding:20px;margin-bottom:20px">
                <div style="font-weight:600;margin-bottom:8px">Note</div>
                <p style="font-size:14px;color:var(--muted,#888);margin:0">{{ $order->notes }}</p>
            </div>
            @endif

            {{-- Section avis : visible uniquement si la commande est livrée --}}
            @if($order->status === 'delivered')
            <div style="background:var(--card,#1a1a1a);border:1px solid var(--border,#2a2a2a);border-radius:12px;padding:20px;margin-bottom:20px">
                <div style="font-weight:600;font-size:16px;margin-bottom:4px">Vos avis produits</div>
                <div style="font-size:13px;color:var(--muted,#888);margin-bottom:20px">Partagez votre expérience pour chaque article reçu.</div>

                @foreach($order->items as $item)
                @php $review = $reviews->get($item->product_id); @endphp
                <div style="padding:16px 0;border-top:1px solid var(--border,#2a2a2a)">
                    <div style="font-weight:600;font-size:14px;margin-bottom:12px">{{ $item->product_name }}</div>

                    @if($review)
                    {{-- Avis déjà soumis --}}
                    <div style="display:flex;gap:4px;margin-bottom:8px">
                        @for($i = 1; $i <= 5; $i++)
                        <span style="font-size:22px;color:{{ $i <= $review->rating ? 'var(--accent,#e8ff47)' : 'var(--muted,#555)' }}">★</span>
                        @endfor
                    </div>
                    @if($review->comment)
                    <p style="font-size:13px;color:var(--muted,#bbb);margin:0 0 8px">{{ $review->comment }}</p>
                    @endif
                    {{-- @if($review->is_approved) --}}
                    <span style="font-size:11px;background:rgba(45,204,127,.12);color:#2dcc7f;border:1px solid #2dcc7f55;padding:3px 10px;border-radius:20px">✓ Avis publié</span>
                    {{-- @else
                    <span style="font-size:11px;background:rgba(255,71,87,.12);color:#ff4757;border:1px solid #ff475755;padding:3px 10px;border-radius:20px">Avis masqué par l'administrateur</span>
                    @endif --}}

                    @else
                    {{-- Formulaire de saisie --}}
                    <form method="POST" action="{{ route('shop.review.store', [$order, $item]) }}">
                        @csrf
                        <div style="display:flex;gap:6px;margin-bottom:12px;cursor:pointer" id="stars-{{ $item->id }}">
                            @for($i = 1; $i <= 5; $i++)
                            <span class="star star-{{ $item->id }}"
                                data-val="{{ $i }}"
                                onclick="setRating({{ $item->id }}, {{ $i }})"
                                onmouseenter="hoverRating({{ $item->id }}, {{ $i }})"
                                onmouseleave="resetRating({{ $item->id }})"
                                style="font-size:28px;color:var(--muted,#555);transition:color .1s;user-select:none">★</span>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating-{{ $item->id }}" value="0">

                        <textarea name="comment" placeholder="Partagez votre avis (optionnel)…"
                            style="width:100%;min-height:70px;resize:vertical;background:var(--surface,#111);border:1px solid var(--border,#2a2a2a);border-radius:8px;padding:10px 14px;color:inherit;font-size:13px;box-sizing:border-box;margin-bottom:10px"
                            maxlength="1000">{{ old('comment') }}</textarea>

                        <button type="submit"
                            style="padding:8px 20px;background:var(--accent,#e8ff47);color:#000;font-weight:700;border:none;border-radius:8px;font-size:13px;cursor:pointer"
                            onclick="return validateRating({{ $item->id }})">
                            Envoyer mon avis
                        </button>
                    </form>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            <div style="display:flex;gap:12px;justify-content:center;margin-top:24px;flex-wrap:wrap">
                <a href="{{ route('shop.commandes') }}" class="btn btn-ghost" style="padding:10px 20px;border-radius:8px;font-size:14px;text-decoration:none">← Mes commandes</a>
                <a href="{{ route('shop.home') }}" class="pay-btn" style="width:60%;padding:10px 24px;border-radius:8px;font-size:14px;text-decoration:none;display:inline-block;text-align:center;">Continuer mes achats</a>
            </div>

            @if($order->status === 'pending')
            <div style="margin-top:20px;border-top:1px solid var(--border,#2a2a2a);padding-top:20px;text-align:center">
                <p style="font-size:13px;color:var(--muted,#888);margin-bottom:12px">
                    Votre commande est encore en attente de confirmation. Vous pouvez l'annuler.
                </p>
                <form method="POST" action="{{ route('shop.commandes.cancel', $order) }}"
                    onsubmit="return confirm('Confirmer l\'annulation de la commande {{ $order->order_number }} ?')">
                    @csrf @method('PATCH')
                    <button type="submit"
                            style="background:rgba(255,71,87,.1);border:1px solid #ff4757;color:#ff4757;padding:10px 28px;border-radius:8px;font-size:14px;cursor:pointer;font-family:inherit;transition:background .2s"
                            onmouseover="this.style.background='rgba(255,71,87,.2)'"
                            onmouseout="this.style.background='rgba(255,71,87,.1)'">
                        Annuler la commande
                    </button>
                </form>
            </div>
            @endif

        </div>
    </main>

    @if($order->status === 'delivered')
        <script>
            function setRating(itemId, val) {
                document.getElementById('rating-' + itemId).value = val;
                document.querySelectorAll('.star-' + itemId).forEach((s, i) => {
                    s.style.color = i < val ? 'var(--accent,#e8ff47)' : 'var(--muted,#555)';
                });
            }
            function hoverRating(itemId, val) {
                document.querySelectorAll('.star-' + itemId).forEach((s, i) => {
                    s.style.color = i < val ? 'var(--accent,#e8ff47)' : 'var(--muted,#555)';
                });
            }
            function resetRating(itemId) {
                const current = parseInt(document.getElementById('rating-' + itemId).value) || 0;
                document.querySelectorAll('.star-' + itemId).forEach((s, i) => {
                    s.style.color = i < current ? 'var(--accent,#e8ff47)' : 'var(--muted,#555)';
                });
            }
            function validateRating(itemId) {
                if (!parseInt(document.getElementById('rating-' + itemId).value)) {
                    alert('Veuillez sélectionner une note avant d\'envoyer.');
                    return false;
                }
                return true;
            }
        </script>
    @endif
@endsection
