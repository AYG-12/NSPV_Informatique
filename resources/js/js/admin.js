const titles = {
    dashboard: 'Tableau de bord', orders: 'Commandes', products: 'Produits',
    customers: 'Clients', categories: 'Catégories', promotions: 'Promotions',
    analytics: 'Analytique', settings: 'Paramètres'
  };

  function navigate(pageId) {
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
    const page = document.getElementById('page-' + pageId);
    if (page) page.classList.add('active');
    const navItem = document.querySelector('[data-page="' + pageId + '"]');
    if (navItem) navItem.classList.add('active');
    document.getElementById('topbar-title').textContent = titles[pageId] || '';
  }

  document.querySelectorAll('.nav-item[data-page]').forEach(item => {
    item.addEventListener('click', () => navigate(item.dataset.page));
  });

  // Period tabs
  document.querySelectorAll('.period-tabs').forEach(tabs => {
    tabs.querySelectorAll('.period-tab').forEach(tab => {
      tab.addEventListener('click', () => {
        tabs.querySelectorAll('.period-tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
      });
    });
  });

  // Settings nav
  document.querySelectorAll('.settings-nav-item').forEach(item => {
    item.addEventListener('click', () => {
      document.querySelectorAll('.settings-nav-item').forEach(i => i.classList.remove('active'));
      document.querySelectorAll('.settings-section').forEach(s => s.classList.remove('active'));
      item.classList.add('active');
      const section = document.getElementById('section-' + item.dataset.section);
      if (section) section.classList.add('active');
    });
  });

  // Modals
  function openModal(id) { document.getElementById(id).classList.add('open'); }
  function closeModal(id) { document.getElementById(id).classList.remove('open'); }
  document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', e => { if (e.target === overlay) overlay.classList.remove('open'); });
  });