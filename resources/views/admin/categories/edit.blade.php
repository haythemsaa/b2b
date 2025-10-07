@extends('layouts.admin')

@section('title', 'Modifier une Catégorie')
@section('page-title', 'Modifier une Catégorie')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit me-2"></i>Modifier la catégorie : {{ $category->name }}
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nom de la catégorie <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name', $category->name) }}"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="parent_id" class="form-label">Catégorie Parent</label>
                        <select class="form-select @error('parent_id') is-invalid @enderror"
                                id="parent_id"
                                name="parent_id">
                            <option value="">Aucune (Catégorie racine)</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Laissez vide pour créer une catégorie principale</small>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description"
                                  name="description"
                                  rows="3">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Ordre d'affichage</label>
                        <input type="number"
                               class="form-control @error('sort_order') is-invalid @enderror"
                               id="sort_order"
                               name="sort_order"
                               value="{{ old('sort_order', $category->sort_order) }}"
                               min="0">
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Les catégories sont triées par ordre croissant</small>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="is_active"
                                   name="is_active"
                                   {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Catégorie active
                            </label>
                        </div>
                        <small class="text-muted">Les catégories inactives ne sont pas visibles sur le site</small>
                    </div>

                    <hr>

                    <!-- Info sur les sous-catégories et produits -->
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Informations :</strong>
                        <ul class="mb-0 mt-2">
                            <li>Cette catégorie contient <strong>{{ $category->children->count() }}</strong> sous-catégorie(s)</li>
                            <li>Cette catégorie contient <strong>{{ $category->products->count() }}</strong> produit(s)</li>
                        </ul>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                        <button type="submit" class="btn btn-admin-primary">
                            <i class="fas fa-save me-2"></i>Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
