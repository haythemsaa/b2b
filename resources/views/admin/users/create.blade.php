@extends('layouts.admin')

@section('title', 'Créer un Vendeur')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Créer un Vendeur</h1>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informations du Vendeur</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nom Complet <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Mot de Passe <span class="text-danger">*</span></label>
                                <input type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="password"
                                       name="password"
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirmer le Mot de Passe <span class="text-danger">*</span></label>
                                <input type="password"
                                       class="form-control"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="company_name" class="form-label">Nom de l'Entreprise</label>
                                <input type="text"
                                       class="form-control @error('company_name') is-invalid @enderror"
                                       id="company_name"
                                       name="company_name"
                                       value="{{ old('company_name') }}">
                                @error('company_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Téléphone</label>
                                <input type="text"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       id="phone"
                                       name="phone"
                                       value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Adresse</label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                      id="address"
                                      name="address"
                                      rows="2">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">Ville</label>
                                <input type="text"
                                       class="form-control @error('city') is-invalid @enderror"
                                       id="city"
                                       name="city"
                                       value="{{ old('city') }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="postal_code" class="form-label">Code Postal</label>
                                <input type="text"
                                       class="form-control @error('postal_code') is-invalid @enderror"
                                       id="postal_code"
                                       name="postal_code"
                                       value="{{ old('postal_code') }}">
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="preferred_language" class="form-label">Langue Préférée <span class="text-danger">*</span></label>
                            <select class="form-select @error('preferred_language') is-invalid @enderror"
                                    id="preferred_language"
                                    name="preferred_language"
                                    required>
                                <option value="">Sélectionner une langue</option>
                                <option value="fr" {{ old('preferred_language') === 'fr' ? 'selected' : '' }}>Français</option>
                                <option value="ar" {{ old('preferred_language') === 'ar' ? 'selected' : '' }}>العربية</option>
                            </select>
                            @error('preferred_language')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Attribution aux Groupes de Clients</label>
                            <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                @if($customerGroups->count() > 0)
                                    @foreach($customerGroups as $group)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   name="customer_groups[]"
                                                   value="{{ $group->id }}"
                                                   id="group_{{ $group->id }}"
                                                   {{ in_array($group->id, old('customer_groups', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="group_{{ $group->id }}">
                                                <strong>{{ $group->name }}</strong>
                                                @if($group->discount_percentage > 0)
                                                    <span class="badge bg-success ms-1">-{{ $group->discount_percentage }}%</span>
                                                @endif
                                                <div class="small text-muted">{{ $group->description }}</div>
                                            </label>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-muted text-center py-3">
                                        <i class="fas fa-users-slash"></i>
                                        Aucun groupe de clients disponible
                                        <div class="mt-2">
                                            <a href="{{ route('admin.groups.create') }}" class="btn btn-outline-primary btn-sm">
                                                Créer un groupe
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <small class="form-text text-muted">Le vendeur peut appartenir à plusieurs groupes</small>
                            @error('customer_groups')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Créer le Vendeur
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Aide</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6><i class="fas fa-info-circle text-info"></i> Création de Vendeur</h6>
                        <p class="small text-muted">
                            Créez un compte vendeur avec accès au catalogue et aux commandes.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6><i class="fas fa-shield-alt text-warning"></i> Sécurité</h6>
                        <p class="small text-muted">
                            Le mot de passe doit contenir au minimum 8 caractères. Il sera automatiquement chiffré.
                        </p>
                    </div>

                    <div>
                        <h6><i class="fas fa-users text-primary"></i> Groupes</h6>
                        <p class="small text-muted">
                            Assignez le vendeur aux groupes appropriés pour lui appliquer les tarifs et conditions spécifiques.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
