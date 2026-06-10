@php $title = "Produits"; @endphp

@extends('layouts.admin')

@section('content')
<!-- ════════════════════════════════════
          PAGE: PRODUITS
      ════════════════════════════════════ -->
    <div>
        @if(session('success'))
            <div class="alert-banner success" style="background:rgba(45,204,127,.15);border:1px solid var(--success);color:var(--success);padding:10px 16px;border-radius:8px;margin-bottom:16px;font-size:13px;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert-banner" style="background:rgba(255,71,87,.15);border:1px solid var(--danger);color:var(--danger);padding:10px 16px;border-radius:8px;margin-bottom:16px;font-size:13px;">
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div style="background:rgba(255,71,87,.15);border:1px solid var(--danger);color:var(--danger);padding:10px 16px;border-radius:8px;margin-bottom:16px;font-size:13px;">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="page-header">
            <div>
                <div class="page-heading">Produits</div>
                <div class="page-sub">
                    <span>{{ $products->total() }}</span> produits ·
                    <span>{{ $totalOutOfStock }}</span> en rupture de stock
                </div>
            </div>
            <button class="btn btn-primary" onclick="openCreateModal()">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 2v10M2 7h10"/></svg>
                Ajouter un produit
            </button>
        </div>

        <form method="GET" action="{{ route('admin.produits') }}">
            <div class="filters-row">
                <input class="filter-input" name="q" placeholder="🔍  Rechercher un produit…" value="{{ request('q') }}" style="flex:1;min-width:200px">
                <select class="filter-select" name="categorie">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('categorie') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <select class="filter-select" name="stock">
                    <option value="">Tous les stocks</option>
                    <option value="en_stock"     {{ request('stock') === 'en_stock'     ? 'selected' : '' }}>En stock</option>
                    <option value="stock_faible" {{ request('stock') === 'stock_faible' ? 'selected' : '' }}>Stock faible</option>
                    <option value="rupture"      {{ request('stock') === 'rupture'      ? 'selected' : '' }}>Rupture</option>
                </select>
                <button type="submit" class="btn btn-ghost">Filtrer</button>
            </div>
        </form>

        <div class="card">
            <div class="data-table-wrap">
                <table>
                    <thead><tr><th>Produit</th><th>Catégorie</th><th>Prix</th><th>Stock</th><th>Type</th><th>Statut</th><th>Actions</th></tr></thead>
                    <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <div class="product-cell">
                                    @if($product->image)
                                        <img width="40" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                    @else
                                        <img width="40" src="{{ Vite::asset('resources/images/background.jpeg') }}" alt="{{ $product->name }}">
                                    @endif
                                    {{-- <div class="product-thumb">{{ $product->type === 'service' ? '🔧' : '🖥️' }}</div> --}}
                                    <div>
                                        <div class="product-name">{{ $product->name }}</div>
                                        <div class="product-sku">SKU: {{ $product->sku ?? '—' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="color:var(--muted)">{{ $product->category->name }}</td>
                            <td style="font-weight:600">
                                {{ number_format($product->price, 0, ',', ' ') }} FCFA
                                @if($product->sale_price)
                                    <br><small style="color:var(--accent2)">Promo: {{ number_format($product->sale_price, 0, ',', ' ') }}</small>
                                @endif
                            </td>
                            <td>
                                @if($product->stock === null)
                                    <span style="color:var(--muted)">Illimité</span>
                                @elseif($product->stock === 0)
                                    <span style="color:var(--danger);font-weight:600">0</span>
                                @elseif($product->stock <= 5)
                                    <span style="color:var(--warn);font-weight:600">{{ $product->stock }}</span>
                                @else
                                    <span style="color:var(--success);font-weight:600">{{ $product->stock }}</span>
                                @endif
                            </td>
                            <td style="color:var(--muted)">{{ $product->type === 'service' ? 'Service' : 'Produit' }}</td>
                            <td>
                                @if($product->is_active)
                                    <span class="pill pill-success">Actif</span>
                                @else
                                    <span class="pill pill-danger">Inactif</span>
                                @endif
                            </td>
                            <td style="display:flex;gap:6px;padding:12px 0">
                                <button class="btn btn-ghost" style="padding:5px 10px;font-size:12px"
                                    onclick="openEditModal({{ $product->id }}, {{ $product->toJson() }})">
                                    Éditer
                                </button>
                                <form method="POST" action="{{ route('admin.produits.destroy', $product) }}"
                                    onsubmit="return confirm('Supprimer ce produit ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding:5px 10px;font-size:12px">Suppr.</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" style="text-align:center;color:var(--muted);padding:24px">Aucun produit trouvé.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            
            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:20px;padding-top:16px;border-top:1px solid var(--border)">
                <span style="font-size:13px;color:var(--muted)">
                    Affichage {{ $products->firstItem() }}–{{ $products->lastItem() }} sur {{ $products->total() }} produits
                </span>
                <div style="display:flex;gap:6px">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Ajouter un produit -->
    <div class="modal-overlay" id="modal-product">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title" id="modal-product-title">Ajouter un produit</div>
                <div class="modal-close" onclick="closeModal('modal-product')">✕</div>
            </div>
            <form id="form-product" method="POST" action="{{ route('admin.produits.store') }}" enctype="multipart/form-data">
                @csrf
                <span id="method-field"></span>
                <div class="form-grid">
                    <div class="form-group full"><label class="form-label">Nom du produit</label><input class="form-input" name="name" id="p-name" placeholder="Ex: PC Portable HP" required></div>
                    <div class="form-group"><label class="form-label">Catégorie</label>
                        <select class="form-input" name="category_id" id="p-category" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group"><label class="form-label">Type</label>
                        <select class="form-input" name="type" id="p-type">
                            <option value="product">Produit physique</option>
                            <option value="service">Service</option>
                        </select>
                    </div>
                    <div class="form-group"><label class="form-label">Prix (FCFA)</label><input class="form-input" name="price" id="p-price" placeholder="0" type="number" min="0" required></div>
                    <div class="form-group"><label class="form-label">Prix promo (FCFA)</label><input class="form-input" name="sale_price" id="p-sale-price" placeholder="Laisser vide si aucune" type="number" min="0"></div>
                    <div class="form-group"><label class="form-label">Stock <small style="color:var(--muted)">(vide = illimité)</small></label><input class="form-input" name="stock" id="p-stock" placeholder="Ex: 10" type="number" min="0"></div>
                    <div class="form-group"><label class="form-label">SKU</label><input class="form-input" name="sku" id="p-sku" placeholder="HP-PC-001"></div>
                    <div class="form-group"><label class="form-label">Image</label><input class="form-input" name="image" type="file" accept="image/*"></div>
                    <div class="form-group full"><label class="form-label">Résumé court</label><input class="form-input" name="short_description" id="p-short-desc" placeholder="Ex: Intel i5, 8Go RAM, 256Go SSD"></div>
                    <div class="form-group full"><label class="form-label">Description</label><textarea class="form-input" name="description" id="p-desc" placeholder="Description complète…"></textarea></div>
                    <div class="form-group">
                        <label class="form-label">En vedette</label>
                        <select class="form-input" name="is_featured" id="p-featured">
                            <option value="0">Non</option>
                            <option value="1">Oui</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Statut</label>
                        <select class="form-input" name="is_active" id="p-active">
                            <option value="1">Actif</option>
                            <option value="0">Inactif</option>
                        </select>
                    </div>
                </div>
                <div style="display:flex;gap:10px;margin-top:24px;justify-content:flex-end">
                    <button type="button" class="btn btn-ghost" onclick="closeModal('modal-product')">Annuler</button>
                    <button type="submit" class="btn btn-primary" id="btn-submit-product">Ajouter le produit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    const STORE_ACTION = '{{ route('admin.produits.store') }}';

    function openCreateModal() {
        document.getElementById('modal-product-title').textContent = 'Ajouter un produit';
        document.getElementById('btn-submit-product').textContent  = 'Ajouter le produit';

        const form = document.getElementById('form-product');
        form.action = STORE_ACTION;
        document.getElementById('method-field').innerHTML = '';
        form.reset();

        openModal('modal-product');
    }

    function openEditModal(id, product) {
        document.getElementById('modal-product-title').textContent = 'Modifier le produit';
        document.getElementById('btn-submit-product').textContent  = 'Enregistrer les modifications';

        const form = document.getElementById('form-product');
        form.action = '/welAdminnspv/produits/' + id;
        document.getElementById('method-field').innerHTML = '<input type="hidden" name="_method" value="PUT">';

        document.getElementById('p-name').value        = product.name              || '';
        document.getElementById('p-category').value    = product.category_id       || '';
        document.getElementById('p-type').value        = product.type              || 'product';
        document.getElementById('p-price').value       = product.price             || '';
        document.getElementById('p-sale-price').value  = product.sale_price        || '';
        document.getElementById('p-stock').value       = product.stock !== null ? product.stock : '';
        document.getElementById('p-sku').value         = product.sku               || '';
        document.getElementById('p-short-desc').value  = product.short_description || '';
        document.getElementById('p-desc').value        = product.description       || '';
        document.getElementById('p-featured').value    = product.is_featured ? '1' : '0';
        document.getElementById('p-active').value      = product.is_active   ? '1' : '0';

        openModal('modal-product');
    }

    @if($errors->any())
    document.addEventListener('DOMContentLoaded', () => openCreateModal());
    @endif
    </script>
@endsection
