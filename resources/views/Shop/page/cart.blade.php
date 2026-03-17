@php $title = "Panier"; @endphp

@extends('layouts.guest')

@section('content')

<!-- Appel de la barre de navigation -->
@include('Shop.partials._navbar')

<main class="cart-page">

    <div class="container">

        <!-- LEFT: PANIER -->
        <div class="cart-panel">
            <div class="panel-title">Mon panier</div>

            <div id="cart-items-container">
                <div class="cart-item" id="item-1">
                    <div class="item-image">
                        <svg viewBox="0 0 60 70" width="54" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="10" y="16" width="40" height="44" rx="6" fill="#3a3a3a"/>
                            <rect x="18" y="8"  width="24" height="14" rx="4" fill="#4a4a4a"/>
                            <rect x="16" y="30" width="28" height="18" rx="3" fill="#2a2a2a"/>
                            <rect x="25" y="38" width="10" height="2"  rx="1" fill="#666"/>
                            <rect x="10" y="21" width="4"  height="28" rx="2" fill="#4a4a4a"/>
                            <rect x="46" y="21" width="4"  height="28" rx="2" fill="#4a4a4a"/>
                        </svg>
                    </div>

                    <div>
                        <div class="item-name">Nom de l'article</div>
                        <div class="item-unit-price">130,00 F CFA</div>
                    </div>

                    <div class="quantity-control">
                        <button class="qty-btn" onclick="changeQty('item-1', -1)" aria-label="Diminuer">−</button>
                            <div class="qty-value" id="qty-item-1">1</div>
                        <button class="qty-btn qty-btn-plus" onclick="changeQty('item-1', 1)" aria-label="Augmenter">+</button>
                    </div>

                    <div class="item-total" id="total-item-1"> F CFA</div>

                    <button class="delete-btn" onclick="removeItem('item-1')" aria-label="Supprimer">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                            <path d="M10 11v6M14 11v6M9 6V4h6v2"/>
                        </svg>
                    </button>
                </div>

                <div class="cart-item" id="item-2">
                    <div class="item-image">
                        <svg viewBox="0 0 60 70" width="54" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="10" y="16" width="40" height="44" rx="6" fill="#3a3a3a"/>
                            <rect x="18" y="8"  width="24" height="14" rx="4" fill="#4a4a4a"/>
                            <rect x="16" y="30" width="28" height="18" rx="3" fill="#2a2a2a"/>
                            <rect x="25" y="38" width="10" height="2"  rx="1" fill="#666"/>
                            <rect x="10" y="21" width="4"  height="28" rx="2" fill="#4a4a4a"/>
                            <rect x="46" y="21" width="4"  height="28" rx="2" fill="#4a4a4a"/>
                        </svg>
                    </div>

                    <div>
                        <div class="item-name">Nom de l'article</div>
                        <div class="item-unit-price">100,00 F CFA</div>
                    </div>

                    <div class="quantity-control">
                        <button class="qty-btn" onclick="changeQty('item-2', -1)" aria-label="Diminuer">−</button>
                            <div class="qty-value" id="qty-item-2">1</div>
                        <button class="qty-btn qty-btn-plus" onclick="changeQty('item-2', 1)" aria-label="Augmenter">+</button>
                    </div>

                    <div class="item-total" id="total-item-2">130,00 F CFA</div>

                    <button class="delete-btn" onclick="removeItem('item-2')" aria-label="Supprimer">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                            <path d="M10 11v6M14 11v6M9 6V4h6v2"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="empty-cart" id="empty-cart">Votre panier est vide.</div>

            <div class="cart-actions">
                <div>
                    <!-- <a class="action-link" onclick="togglePromo()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/>
                            <line x1="7" y1="7" x2="7.01" y2="7"/>
                        </svg>
                        Saisir un code promo
                    </a> -->
                    <div class="promo-input-wrapper" id="promo-wrapper">
                        <input class="promo-input" type="text" id="promo-input" placeholder="Code promo">
                        <button class="promo-apply" onclick="applyPromo()">Appliquer</button>
                    </div>
                    <div class="promo-feedback" id="promo-feedback"></div>
                </div>

                <div>
                    <!-- <a class="action-link" onclick="toggleNote()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        Ajouter une note
                    </a> -->
                    <div class="note-wrapper" id="note-wrapper">
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
            <span class="value" id="subtotal"> F CFA</span>
        </div>

        <div class="summary-row">
            <span class="label">Livraison</span>
            <span class="free">Le prix selon la Zone</span>
        </div>

        <a class="location-link">République de Côte d'Ivoire</a>

        <div class="summary-total">
            <span>Total</span>
            <span id="grand-total"> F CFA</span>
        </div>

        <button class="pay-btn" onclick="handlePayment(event)">Commander</button>

        <div class="secure-badge">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="11" width="18" height="11" rx="2"/>
                <path d="M7 11V7a5 5 0 0110 0v4"/>
            </svg>
            Paiement sécurisé
        </div>
    </div>

    </div>

    <!-- <div class="toast" id="toast"></div> -->

    <div class="modal-overlay" id="payment-modal">
        <div class="modal">
            <h3>Redirection vers le paiement</h3>
            <p>Vous allez être redirigé vers notre page de paiement sécurisée. Veuillez patienter...</p>
            <button class="modal-close" onclick="closeModal()">Fermer</button>
        </div>
    </div>

  
    
</main>

@vite('resources/js/mod/cart.js')

@endsection