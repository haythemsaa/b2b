@extends('layouts.admin')

@section('title', 'Créer un Attribut')
@section('page-title', 'Créer un Attribut')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-plus-circle me-2"></i>Nouvel Attribut
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.attributes.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nom de l'attribut <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                               placeholder="Ex: Couleur, Taille, Matière..."
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Type d'attribut <span class="text-danger">*</span></label>
                        <select class="form-select @error('type') is-invalid @enderror"
                                id="type"
                                name="type"
                                required>
                            <option value="">Sélectionnez un type</option>
                            @foreach($types as $key => $label)
                                <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Le type détermine comment l'attribut sera affiché et utilisé</small>
                    </div>

                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Ordre d'affichage</label>
                        <input type="number"
                               class="form-control @error('sort_order') is-invalid @enderror"
                               id="sort_order"
                               name="sort_order"
                               value="{{ old('sort_order', 0) }}"
                               min="0">
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Les attributs sont triés par ordre croissant</small>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="is_required"
                                   name="is_required"
                                   {{ old('is_required') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_required">
                                <strong>Attribut requis</strong>
                            </label>
                        </div>
                        <small class="text-muted">Les attributs requis doivent être renseignés pour chaque produit</small>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="is_filterable"
                                   name="is_filterable"
                                   {{ old('is_filterable', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_filterable">
                                <strong>Filtrable</strong>
                            </label>
                        </div>
                        <small class="text-muted">Les attributs filtrables peuvent être utilisés pour filtrer les produits</small>
                    </div>

                    <hr>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Note :</strong> Après avoir créé l'attribut, vous pourrez ajouter des valeurs si nécessaire (pour les types : liste déroulante, sélection multiple, couleur).
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.attributes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                        <button type="submit" class="btn btn-admin-primary">
                            <i class="fas fa-save me-2"></i>Créer l'attribut
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Type Descriptions -->
        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-question-circle me-2"></i>Types d'attributs
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h6><span class="badge bg-secondary">Texte</span></h6>
                        <p class="small text-muted mb-0">Champ texte libre. Utilisé pour des descriptions ou valeurs uniques.</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6><span class="badge bg-primary">Liste déroulante</span></h6>
                        <p class="small text-muted mb-0">Sélection unique parmi plusieurs valeurs prédéfinies.</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6><span class="badge bg-info">Sélection multiple</span></h6>
                        <p class="small text-muted mb-0">Possibilité de sélectionner plusieurs valeurs.</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6><span class="badge bg-warning">Nombre</span></h6>
                        <p class="small text-muted mb-0">Valeur numérique (poids, dimensions, etc.).</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6><span class="badge bg-success">Oui/Non</span></h6>
                        <p class="small text-muted mb-0">Attribut booléen simple (oui/non, vrai/faux).</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6><span class="badge bg-danger">Couleur</span></h6>
                        <p class="small text-muted mb-0">Sélecteur de couleur avec valeurs prédéfinies.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
