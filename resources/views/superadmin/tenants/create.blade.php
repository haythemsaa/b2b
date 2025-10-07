@extends('layouts.app')

@section('title', 'Créer un Tenant - Super Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Créer un Nouveau Tenant</h1>
                <a href="{{ route('superadmin.tenants.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('superadmin.tenants.store') }}">
        @csrf

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
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="domain" class="form-label">Domaine Personnalisé</label>
                            <input type="text" class="form-control @error('domain') is-invalid @enderror"
                                   id="domain" name="domain" value="{{ old('domain') }}"
                                   placeholder="mondomaine.com">
                            @error('domain')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Téléphone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="country" class="form-label">Pays <span class="text-danger">*</span></label>
                                <select class="form-select @error('country') is-invalid @enderror"
                                        id="country" name="country" required>
                                    <option value="TN" {{ old('country') === 'TN' ? 'selected' : '' }}>Tunisie</option>
                                    <option value="MA" {{ old('country') === 'MA' ? 'selected' : '' }}>Maroc</option>
                                    <option value="DZ" {{ old('country') === 'DZ' ? 'selected' : '' }}>Algérie</option>
                                    <option value="FR" {{ old('country') === 'FR' ? 'selected' : '' }}>France</option>
                                </select>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3">
                            <label for="address" class="form-label">Adresse</label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                      id="address" name="address" rows="2">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <label for="city" class="form-label">Ville</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror"
                                   id="city" name="city" value="{{ old('city') }}">
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
                                <option value="starter" {{ old('plan') === 'starter' ? 'selected' : '' }}>Starter</option>
                                <option value="pro" {{ old('plan') === 'pro' ? 'selected' : '' }}>Pro</option>
                                <option value="enterprise" {{ old('plan') === 'enterprise' ? 'selected' : '' }}>Enterprise</option>
                            </select>
                            @error('plan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="max_users" class="form-label">Max Utilisateurs <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('max_users') is-invalid @enderror"
                                       id="max_users" name="max_users" value="{{ old('max_users', 50) }}" min="1" required>
                                @error('max_users')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="max_products" class="form-label">Max Produits <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('max_products') is-invalid @enderror"
                                       id="max_products" name="max_products" value="{{ old('max_products', 1000) }}" min="1" required>
                                @error('max_products')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3">
                            <label for="monthly_fee" class="form-label">Tarif Mensuel (€) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('monthly_fee') is-invalid @enderror"
                                   id="monthly_fee" name="monthly_fee" value="{{ old('monthly_fee', 0) }}" min="0" required>
                            @error('monthly_fee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <label for="trial_ends_at" class="form-label">Fin de la Période d'Essai</label>
                            <input type="date" class="form-control @error('trial_ends_at') is-invalid @enderror"
                                   id="trial_ends_at" name="trial_ends_at" value="{{ old('trial_ends_at') }}"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                            @error('trial_ends_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <label class="form-label">Modules Activés</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="enabled_modules[]" value="chat"
                                       id="module_chat" {{ in_array('chat', old('enabled_modules', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="module_chat">
                                    Chat en temps réel
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="enabled_modules[]" value="analytics"
                                       id="module_analytics" {{ in_array('analytics', old('enabled_modules', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="module_analytics">
                                    Analytics avancés
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="enabled_modules[]" value="api"
                                       id="module_api" {{ in_array('api', old('enabled_modules', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="module_api">
                                    Accès API
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="enabled_modules[]" value="custom_reports"
                                       id="module_reports" {{ in_array('custom_reports', old('enabled_modules', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="module_reports">
                                    Rapports personnalisés
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('superadmin.tenants.index') }}" class="btn btn-outline-secondary me-2">Annuler</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Créer le Tenant
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('plan').addEventListener('change', function() {
    const plan = this.value;
    const maxUsersInput = document.getElementById('max_users');
    const maxProductsInput = document.getElementById('max_products');
    const monthlyFeeInput = document.getElementById('monthly_fee');

    // Valeurs par défaut selon le plan
    const defaults = {
        starter: { users: 10, products: 500, fee: 29.00 },
        pro: { users: 50, products: 2000, fee: 79.00 },
        enterprise: { users: 200, products: 10000, fee: 199.00 }
    };

    if (defaults[plan]) {
        maxUsersInput.value = defaults[plan].users;
        maxProductsInput.value = defaults[plan].products;
        monthlyFeeInput.value = defaults[plan].fee;
    }
});

// Auto-générer le slug depuis le nom
document.getElementById('name').addEventListener('input', function() {
    // Cette fonctionnalité sera gérée côté serveur
});
</script>
@endsection