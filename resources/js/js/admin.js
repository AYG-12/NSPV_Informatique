
// ── Hamburger / Sidebar toggle ──
const hamburger      = document.getElementById('hamburger');
const sidebar        = document.querySelector('.sidebar');
const sidebarOverlay = document.getElementById('sidebar-overlay');

function openSidebar() {
  sidebar.classList.add('open');
  if (sidebarOverlay) sidebarOverlay.classList.add('open');
  if (hamburger)      hamburger.classList.add('open');
}
function closeSidebar() {
  sidebar.classList.remove('open');
  if (sidebarOverlay) sidebarOverlay.classList.remove('open');
  if (hamburger)      hamburger.classList.remove('open');
}
if (hamburger) {
  hamburger.addEventListener('click', () => {
    sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
  });
}
if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);



// Period tabs
document.querySelectorAll('.period-tabs').forEach(tabs => {
  tabs.querySelectorAll('.period-tab').forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.querySelectorAll('.period-tab').forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
    });
  });
});

// Settings nav — géré directement dans parametres.blade.php (script synchrone)
// navigateSettings reste disponible comme alias global pour compatibilité
function navigateSettings(sectionId) {
  document.querySelectorAll('.settings-nav-item').forEach(i =>
    i.classList.toggle('active', i.dataset.section === sectionId)
  );
  document.querySelectorAll('.settings-section').forEach(s =>
    s.classList.toggle('active', s.id === 'section-' + sectionId)
  );
  try { localStorage.setItem('adminActiveSection', sectionId); } catch(e) {}
}

// ── PRODUCT SEARCH AUTOCOMPLETE ──
const productCatalog = [
  { name: 'MacBook Pro 16" M3 Max',    price: '3 499 €', numPrice: 3499,  emoji: '💻' },
  { name: 'iPhone 15 Pro 256Go',        price: '1 199 €', numPrice: 1199,  emoji: '📱' },
  { name: 'Sony WH-1000XM5',            price: '349 €',   numPrice: 349,   emoji: '🎧' },
  { name: 'iPad Air 5 256Go',           price: '899 €',   numPrice: 899,   emoji: '📲' },
  { name: 'AirPods Pro 2',              price: '279 €',   numPrice: 279,   emoji: '🎵' },
  { name: 'Samsung Galaxy S24 Ultra',   price: '1 299 €', numPrice: 1299,  emoji: '📱' },
  { name: 'Dell XPS 15',                price: '1 799 €', numPrice: 1799,  emoji: '💻' },
  { name: 'ThinkPad X1 Carbon',         price: '1 599 €', numPrice: 1599,  emoji: '💻' },
  { name: 'Surface Pro 9',              price: '1 099 €', numPrice: 1099,  emoji: '📲' },
  { name: 'Canon EOS R8',               price: '1 649 €', numPrice: 1649,  emoji: '📷' },
  { name: 'Apple Watch Series 9',       price: '399 €',   numPrice: 399,   emoji: '⌚' },
  { name: 'LG OLED 65"',               price: '2 199 €', numPrice: 2199,  emoji: '📺' },
];

let selectedProducts = [];
const searchInput    = document.getElementById('product-search-input');
const dropdown       = document.getElementById('product-dropdown');
const chipsContainer = document.getElementById('product-chips');
const totalInput     = document.getElementById('order-total-input');
const namesInput     = document.getElementById('order-products-input');

function syncOrderInputs() {
  // Noms → input caché (séparés par " | ")
  namesInput.value = selectedProducts.map(p => p.name).join(' | ');
  // Prix → input montant (somme des prix numériques)
  const total = selectedProducts.reduce((sum, p) => sum + p.numPrice, 0);
  totalInput.value = total > 0 ? total.toFixed(2) : '';
}

function renderChips() {
  chipsContainer.innerHTML = selectedProducts.map((p, i) =>
    `<span class="product-chip">${p.emoji} ${p.name}<span class="chip-remove" data-index="${i}">✕</span></span>`
  ).join('');
  chipsContainer.querySelectorAll('.chip-remove').forEach(btn => {
    btn.addEventListener('click', () => {
      selectedProducts.splice(parseInt(btn.dataset.index), 1);
      renderChips();
      syncOrderInputs();
      renderDropdown(searchInput.value);
    });
  });
}

function renderDropdown(query) {
  const q = query.toLowerCase().trim();
  const available = productCatalog.filter(p => !selectedProducts.includes(p));
  const results   = q ? available.filter(p => p.name.toLowerCase().includes(q)) : available;
  if (results.length === 0) {
    dropdown.innerHTML = '<div class="product-drop-no-result">Aucun produit trouvé</div>';
  } else {
    dropdown.innerHTML = results.map(p =>
      `<div class="product-drop-item" data-name="${p.name}">
        <span class="drop-emoji">${p.emoji}</span>
        <span class="drop-name">${p.name}</span>
        <span class="drop-price">${p.price}</span>
      </div>`
    ).join('');
    dropdown.querySelectorAll('.product-drop-item').forEach(item => {
      item.addEventListener('click', () => {
        const product = productCatalog.find(p => p.name === item.dataset.name);
        if (product && !selectedProducts.includes(product)) {
          selectedProducts.push(product);
          renderChips();
          syncOrderInputs();
        }
        searchInput.value = '';
        dropdown.classList.remove('open');
      });
    });
  }
}

function resetProductSearch() {
  selectedProducts = [];
  if (chipsContainer) chipsContainer.innerHTML = '';
  if (searchInput)    searchInput.value = '';
  if (dropdown)       dropdown.classList.remove('open');
}

if (searchInput) {
  searchInput.addEventListener('input', function () {
    renderDropdown(this.value);
    dropdown.classList.add('open');
  });
  searchInput.addEventListener('focus', function () {
    renderDropdown(this.value);
    dropdown.classList.add('open');
  });
  document.addEventListener('click', function (e) {
    if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
      dropdown.classList.remove('open');
    }
  });
}
