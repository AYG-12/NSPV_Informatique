@php $title = "Panier"; @endphp

@extends('layouts.guest')

@section('content')

    @include('Shop.partials._navbar')

    <main class="cart-page">
        <div class="container">

            <!-- LEFT: PANIER -->
            <div class="cart-panel">
                <div class="panel-title">Mon panier</div>

                @if(session('success'))
                    <div style="background:rgba(45,204,127,.15);border:1px solid #2dcc7f;color:#2dcc7f;padding:10px 14px;border-radius:8px;margin-bottom:14px;font-size:13px;">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div style="background:rgba(255,71,87,.15);border:1px solid #ff4757;color:#ff4757;padding:10px 14px;border-radius:8px;margin-bottom:14px;font-size:13px;">{{ session('error') }}</div>
                @endif

                <div id="cart-items-container">
                    @forelse($cart->items as $item)
                    <div class="cart-item" id="item-{{ $item->id }}">

                        <div class="item-image" >
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" style="width:100%;height:100%;object-fit:cover;border-radius:4px; margin: 0px auto;">
                            @else
                                {{-- <svg viewBox="0 0 60 70" width="54" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="10" y="16" width="40" height="44" rx="6" fill="#3a3a3a"/>
                                    <rect x="18" y="8"  width="24" height="14" rx="4" fill="#4a4a4a"/>
                                    <rect x="16" y="30" width="28" height="18" rx="3" fill="#2a2a2a"/>
                                    <rect x="25" y="38" width="10" height="2"  rx="1" fill="#666"/>
                                    <rect x="10" y="21" width="4"  height="28" rx="2" fill="#4a4a4a"/>
                                    <rect x="46" y="21" width="4"  height="28" rx="2" fill="#4a4a4a"/>
                                </svg> --}}
                                <img src="{{ Vite::asset('resources/images/background.jpeg') }}" alt="{{ $item->product->name }}" style="width:100%;height:100%;object-fit:cover;border-radius:4px; margin: 0px auto;">
                            @endif
                        </div>

                        <div>
                            <div class="item-name">{{ $item->product->name }}</div>
                            <div class="item-unit-price">{{ number_format($item->unit_price, 0, ',', ' ') }} F CFA</div>
                        </div>

                        <!-- Contrôle quantité via formulaires -->
                        <div class="quantity-control">
                            {{-- Diminuer --}}
                            <form method="POST" action="{{ route('shop.cart.update', $item) }}" style="display:inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="quantity" value="{{ max(1, $item->quantity - 1) }}">
                                <button type="submit" class="qty-btn" aria-label="Diminuer">−</button>
                            </form>

                            <div class="qty-value">{{ $item->quantity }}</div>

                            {{-- Augmenter --}}
                            <form method="POST" action="{{ route('shop.cart.update', $item) }}" style="display:inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                <button type="submit" class="qty-btn qty-btn-plus" aria-label="Augmenter">+</button>
                            </form>
                        </div>

                        <div class="item-total">
                            {{ number_format($item->line_total, 0, ',', ' ') }} F CFA
                        </div>

                        {{-- Supprimer --}}
                        <form method="POST" action="{{ route('shop.cart.remove', $item) }}" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn" aria-label="Supprimer">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                                    <path d="M10 11v6M14 11v6M9 6V4h6v2"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                    @empty
                    @endforelse
                </div>

                <div class="empty-cart" {{ $cart->items->isNotEmpty() ? 'style=display:none' : '' }}>
                    Votre panier est vide.
                </div>

                <!-- Code promo -->
                <div class="cart-actions">
                    <div>
                        <form method="POST" action="{{ route('shop.cart.promo') }}" style="display:flex;gap:0">
                            @csrf
                            <input class="promo-input" type="text" name="code" placeholder="Code promo"
                                value="{{ $cart->promotion?->code ?? '' }}">
                            <button type="submit" class="promo-apply">Appliquer</button>
                        </form>
                        @if($cart->promotion)
                            <div class="promo-feedback">
                                <span style="color:var(--success,#2dcc7f)">Code "{{ $cart->promotion->code }}" appliqué !</span>
                            </div>
                        @endif
                    </div>
                    <div>
                        <div class="note-wrapper">
                            <textarea class="note-textarea" placeholder="Votre note pour la commande..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: RÉSUMÉ -->
            <div class="summary-panel">
                <div class="panel-title">Résumé de la commande</div>

                <div class="summary-row">
                    <span class="label">Sous-total</span>
                    <span class="value">{{ number_format($cart->subtotal, 0, ',', ' ') }} F CFA</span>
                </div>

                @if($cart->discount_amount > 0)
                <div class="summary-row">
                    <span class="label">Réduction</span>
                    <span class="value" style="color:var(--success,#2dcc7f)">−{{ number_format($cart->discount_amount, 0, ',', ' ') }} F CFA</span>
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
                        <span class="free">Le prix selon la Zone</span>
                    @endif
                </div>

                <a class="location-link">République de Côte d'Ivoire</a>

                <div class="summary-total">
                    <span>Total</span>
                    <span>{{ number_format($cart->total, 0, ',', ' ') }} F CFA</span>
                </div>

                @if($cart->items->isNotEmpty())
                    <a href="{{ route('shop.checkout') }}" class="pay-btn" style="display:block;text-align:center;text-decoration:none">
                        Commander
                    </a>
                @else
                    <button class="pay-btn" disabled style="opacity:.5;cursor:not-allowed">Commander</button>
                @endif

                <div class="secure-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2"/>
                        <path d="M7 11V7a5 5 0 0110 0v4"/>
                    </svg>
                    Paiement sécurisé
                </div>
            </div>

        </div>
    </main>

@endsection
