@extends('layouts.app')

@section('title', 'Modifier Tenant - ' . $tenant->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Modifier le Tenant : {{ $tenant->name }}</h1>
                <div class="btn-group">
                    <a href="{{ route('superadmin.tenants.show', $tenant) }}" class="btn btn-outline-info">
                        <i class="bi bi-eye"></i> Voir
                    </a>
                    <a href="{{ route('superadmin.tenants.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('superadmin.tenants.update', $tenant) }}">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Informations de base -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informations de Base</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom du Tenant <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $tenant->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $tenant->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="domain" class="form-label">Domaine Personnalisé</label>
                            <input type="text" class="form-control @error('domain') is-invalid @enderror"
                                   id="domain" name="domain" value="{{ old('domain', $tenant->domain) }}"
                                   placeholder="mondomaine.com">
                            @error('domain')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Téléphone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone', $tenant->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="country" class="form-label">Pays <span class="text-danger">*</span></label>
                                <select class="form-select @error('country') is-invalid @enderror"
                                        id="country" name="country" required>
                                    <option value="TN" {{ old('country', $tenant->country) === 'TN' ? 'selected' : '' }}>Tunisie</option>
                                    <option value="MA" {{ old('country', $tenant->country) === 'MA' ? 'selected' : '' }}>Maroc</option>
                                    <option value="DZ" {{ old('country', $tenant->country) === 'DZ' ? 'selected' : '' }}>Algérie</option>
                                    <option value="FR" {{ old('country', $tenant->country) === 'FR' ? 'selected' : '' }}>France</option>
                                </select>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3">
                            <label for="address" class="form-label">Adresse</label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                      id="address" name="address" rows="2">{{ old('address', $tenant->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <label for="city" class="form-label">Ville</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror"
                                   id="city" name="city" value="{{ old('city', $tenant->city) }}">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Configuration & Quotas -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Configuration & Quotas</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="plan" class="form-label">Plan d'Abonnement <span class="text-danger">*</span></label>
                            <select class="form-select @error('plan') is-invalid @enderror"
                                    id="plan" name="plan" required>
                                <option value="starter" {{ old('plan', $tenant->plan) === 'starter' ? 'selected' : '' }}>Starter</option>
                                <option value="pro" {{ old('plan', $tenant->plan) === 'pro' ? 'selected' : '' }}>Pro</option>
                                <option value="enterprise" {{ old('plan', $tenant->plan) === 'enterprise' ? 'selected' : '' }}>Enterprise</option>
                            </select>
                            @error('plan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="max_users" class="form-label">Max Utilisateurs <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('max_users') is-invalid @enderror"
                                       id="max_users" name="max_users" value="{{ old('max_users', $tenant->max_users) }}" min="1" required>
                                @error('max_users')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="max_products" class="form-label">Max Produits <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('max_products') is-invalid @enderror"
                                       id="max_products" name="max_products" value="{{ old('max_products', $tenant->max_products) }}" min="1" required>
                                @error('max_products')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3">
                            <label for="monthly_fee" class="form-label">Tarif Mensuel (€) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('monthly_fee') is-invalid @enderror"
                                   id="monthly_fee" name="monthly_fee" value="{{ old('monthly_fee', $tenant->monthly_fee) }}" min="0" required>
                            @error('monthly_fee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <label for="trial_ends_at" class="form-label">Fin de la Période d'Essai</label>
                            <input type="date" class="form-control @error('trial_ends_at') is-invalid @enderror"
                                   id="trial_ends_at" name="trial_ends_at"
                                   value="{{ old('trial_ends_at', $tenant->trial_ends_at?->format('Y-m-d')) }}">
                            @error('trial_ends_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                       id="is_active" {{ old('is_active', $tenant->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Tenant Actif
                                </label>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="form-label">Modules Activés</label>
                            @php
                                $enabledModules = old('enabled_modules', $tenant->enabled_modules ?? []);
                            @endphp
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="enabled_modules[]" value="chat"
                                       id="module_chat" {{ in_array('chat', $enabledModules) ? 'checked' : '' }}>
                                <label class="form-check-label" for="module_chat">
                                    Chat en temps réel
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="enabled_modules[]" value="analytics"
                                       id="module_analytics" {{ in_array('analytics', $enabledModules) ? 'checked' : '' }}>
                                <label class="form-check-label" for="module_analytics">
                                    Analytics avancés
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="enabled_modules[]" value="api"
                                       id="module_api" {{ in_array('api', $enabledModules) ? 'checked' : '' }}>
                                <label class="form-check-label" for="module_api">
                                    Accès API
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="enabled_modules[]" value="custom_reports"
                                       id="module_reports" {{ in_array('custom_reports', $enabledModules) ? 'checked' : '' }}>
                                <label class="form-check-label" for="module_reports">
                                    Rapports personnalisés
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations système -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informations Système</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Slug:</strong><br>
                                <span class="text-muted">{{ $tenant->slug }}</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Créé le:</strong><br>
                                <span class="text-muted">{{ $tenant->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Modifié le:</strong><br>
                                <span class="text-muted">{{ $tenant->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Statut:</strong><br>
                                @if($tenant->is_active)
                                    <span class="badge bg-success">Actif</span>
                                @else
                                    <span class="badge bg-warning">Suspendu</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('superadmin.tenants.show', $tenant) }}" class="btn btn-outline-secondary me-2">Annuler</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Mettre à Jour
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection