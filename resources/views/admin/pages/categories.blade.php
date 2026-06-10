@php $title = "Catégories"; @endphp

@extends('layouts.admin')

@section('content')
    <!-- ════════════════════════════════════
        PAGE: CATÉGORIES
    ════════════════════════════════════ -->
    <div>
        @if(session('success'))
            <div style="background:rgba(45,204,127,.15);border:1px solid var(--success);color:var(--success);padding:10px 16px;border-radius:8px;margin-bottom:16px;font-size:13px;">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div style="background:rgba(255,71,87,.15);border:1px solid var(--danger);color:var(--danger);padding:10px 16px;border-radius:8px;margin-bottom:16px;font-size:13px;">{{ session('error') }}</div>
        @endif

        <div class="page-header">
            <div>
                <div class="page-heading">Catégories</div>
                <div class="page-sub"><span>{{ $categories->where('is_active', true)->count() }}</span> catégories actives</div>
            </div>
            <button class="btn btn-primary" onclick="openModal('modal-category')">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 2v10M2 7h10"/></svg>
                Nouvelle catégorie
            </button>
        </div>

        <div class="cat-grid">
            @foreach($categories as $cat)
            <div class="cat-card">
                <div class="cat-icon" style="background:rgba(232,255,71,.1)">🗂️</div>
                <div class="cat-info">
                    <div class="cat-name">{{ $cat->name }}</div>
                    <div class="cat-count">{{ $cat->products_count }} produit{{ $cat->products_count > 1 ? 's' : '' }}</div>
                </div>
                <span class="pill {{ $cat->is_active ? 'pill-success' : 'pill-danger' }}" style="margin-left:auto">
                    {{ $cat->is_active ? 'Actif' : 'Inactif' }}
                </span>
            </div>
            @endforeach
        </div>

        <div class="card">
            <div class="card-header"><div class="card-title">Toutes les catégories</div></div>
            <table>
                <thead><tr><th>Catégorie</th><th>Produits</th><th>Description</th><th>Statut</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse($categories as $cat)
                    <tr>
                        <td><div class="product-cell"><div class="product-thumb">🗂️</div><div class="product-name">{{ $cat->name }}</div></div></td>
                        <td>{{ $cat->products_count }}</td>
                        <td style="color:var(--muted)">{{ Str::limit($cat->description, 50) ?? '—' }}</td>
                        <td><span class="pill {{ $cat->is_active ? 'pill-success' : 'pill-danger' }}">{{ $cat->is_active ? 'Actif' : 'Inactif' }}</span></td>
                        <td style="display:flex;gap:6px;padding:12px 0">
                            <button class="btn btn-ghost" style="padding:5px 10px;font-size:12px"
                                onclick="openEditCat({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ addslashes($cat->description ?? '') }}', {{ $cat->is_active ? 1 : 0 }})">
                                Éditer
                            </button>
                            <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
                                  onsubmit="return confirm('Supprimer cette catégorie ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding:5px 10px;font-size:12px">Suppr.</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align:center;color:var(--muted);padding:24px">Aucune catégorie.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal: Catégorie (ajout + édition) -->
    <div class="modal-overlay" id="modal-category">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title" id="modal-cat-title">Nouvelle catégorie</div>
                <div class="modal-close" onclick="closeModal('modal-category')">✕</div>
            </div>
            <form id="form-category" method="POST" action="{{ route('admin.categories.store') }}">
                @csrf
                <span id="cat-method-field"></span>
                <div class="form-grid">
                    <div class="form-group full"><label class="form-label">Nom de la catégorie</label><input class="form-input" name="name" id="c-name" placeholder="Ex: Ordinateurs" required></div>
                    <div class="form-group"><label class="form-label">Catégorie parente</label>
                        <select class="form-input" name="parent_id" id="c-parent">
                            <option value="">Aucune (niveau racine)</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group"><label class="form-label">Statut</label>
                        <select class="form-input" name="is_active" id="c-active">
                            <option value="1">Actif</option>
                            <option value="0">Inactif</option>
                        </select>
                    </div>
                    <div class="form-group full"><label class="form-label">Description</label><textarea class="form-input" name="description" id="c-desc" placeholder="Description de la catégorie…"></textarea></div>
                </div>
                <div style="display:flex;gap:10px;margin-top:24px;justify-content:flex-end">
                    <button type="button" class="btn btn-ghost" onclick="closeModal('modal-category')">Annuler</button>
                    <button type="submit" class="btn btn-primary" id="btn-submit-cat">Créer la catégorie</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function openEditCat(id, name, description, isActive) {
        document.getElementById('modal-cat-title').textContent   = 'Modifier la catégorie';
        document.getElementById('btn-submit-cat').textContent    = 'Enregistrer';
        document.getElementById('form-category').action         = '/welAdminnspv/categories/' + id;
        document.getElementById('cat-method-field').innerHTML   = '<input type="hidden" name="_method" value="PUT">';
        document.getElementById('c-name').value    = name;
        document.getElementById('c-desc').value    = description;
        document.getElementById('c-active').value  = isActive;
        openModal('modal-category');
    }
    </script>
@endsection
