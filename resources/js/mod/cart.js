document.addEventListener('DOMContentLoaded', () => {
    updateTotals();
});

function parsePrice(priceString) {
    // Supprime le symbole '€', remplace la virgule par un point, et convertit en nombre.
    return parseFloat(priceString.replace('F CFA', '').replace(',', '.').trim());
}

function formatPrice(price) {
    // Formate le nombre en chaîne de caractères avec 2 décimales, une virgule et le symbole 'F CFA'.
    return price.toFixed(2).replace('.', ',') + ' F CFA';
}

function updateTotals() {
    const items = document.querySelectorAll('.cart-item');
    let subtotal = 0;

    if (items.length === 0) {
        document.getElementById('empty-cart').style.display = 'block';
        // Hide the panels if you want to
        // document.querySelector('.cart-panel').style.display = 'none';
        // document.querySelector('.summary-panel').style.display = 'none';

    } else {
            document.getElementById('empty-cart').style.display = 'none';
            // document.querySelector('.cart-panel').style.display = 'block';
        // document.querySelector('.summary-panel').style.display = 'block';
    }


    items.forEach(item => {
        const unitPriceText = item.querySelector('.item-unit-price').textContent;
        if (unitPriceText) {
            const unitPrice = parsePrice(unitPriceText);
            const quantity = parseInt(item.querySelector('.qty-value').textContent);
            const itemTotal = unitPrice * quantity;

            item.querySelector('.item-total').textContent = formatPrice(itemTotal);
            subtotal += itemTotal;
        }
    });

    const promoCode = document.getElementById('promo-input').value.trim();
    let discount = 0;
    if (promoCode === 'PROMO10' && document.getElementById('promo-feedback').style.color === 'green') {
        discount = subtotal * 0.10;
    }

    const grandTotal = subtotal - discount;

    document.getElementById('subtotal').textContent = formatPrice(subtotal);
    document.getElementById('grand-total').textContent = formatPrice(grandTotal);

    
}

function changeQty(itemId, delta) {
    const qtyElem = document.getElementById(`qty-${itemId}`);
    const currentQty = parseInt(qtyElem.textContent);
    const newQty = Math.max(1, currentQty + delta);
    qtyElem.textContent = newQty;
    updateTotals();
};
window.changeQty = changeQty;

function removeItem(itemId) {
    const itemElem = document.getElementById(itemId);
    if(itemElem) {
        itemElem.remove();
    }
    updateTotals();
};
window.removeItem = removeItem;

function togglePromo() {
    const wrapper = document.getElementById('promo-wrapper');
    wrapper.style.display = wrapper.style.display === 'block' ? 'none' : 'block';
};
window.togglePromo = togglePromo;

function applyPromo() {
    const code = document.getElementById('promo-input').value.trim();
    const feedback = document.getElementById('promo-feedback');
    if (code === 'PROMO10') {
        feedback.textContent = 'Code promo appliqué ! 10% de réduction.';
        feedback.style.color = 'green';
    } else {
        feedback.textContent = 'Code promo invalide.';
        feedback.style.color = 'red';
    }
    updateTotals();
};
window.applyPromo = applyPromo;

function toggleNote() {
    const wrapper = document.getElementById('note-wrapper');
    wrapper.style.display = wrapper.style.display === 'block' ? 'none' : 'block';
};
window.toggleNote = toggleNote;

function handlePayment(event) {
    event.preventDefault();
    document.getElementById('payment-modal').style.display = 'flex';
};
window.handlePayment = handlePayment;

function closeModal() {
    document.getElementById('payment-modal').style.display = 'none';
};
window.closeModal = closeModal;
