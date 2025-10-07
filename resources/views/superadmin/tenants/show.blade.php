@extends('layouts.app')

@section('title', 'Tenant - ' . $tenant->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>{{ $tenant->name }}
                    @if($tenant->trashed())
                        <span class="badge bg-danger ms-2">Supprimé</span>
                    @elseif($tenant->is_active)
                        <span class="badge bg-success ms-2">Actif</span>
                    @else
                        <span class="badge bg-warning ms-2">Suspendu</span>
                    @endif
                </h1>
                <div class="btn-group">
                    @if(!$tenant->trashed())
                        <a href="{{ route('superadmin.tenants.edit', $tenant) }}" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> Modifier
                        </a>
                        @if($tenant->is_active)
                            <button type="button" class="btn btn-warning"
                                    onclick="suspendTenant({{ $tenant->id }})">
                                <i class="bi bi-pause"></i> Suspendre
                            </button>
                        @else
                            <button type="button" class="btn btn-success"
                                    onclick="activateTenant({{ $tenant->id }})">
                                <i class="bi bi-play"></i> Activer
                            </button>
                        @endif
                    @else
                        <button type="button" class="btn btn-success"
                                onclick="restoreTenant({{ $tenant->id }})">
                            <i class="bi bi-arrow-clockwise"></i> Restaurer
                        </button>
                    @endif
                    <a href="{{ route('superadmin.tenants.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>Utilisateurs</h5>
                            <h2>{{ $stats['users_count'] }}/{{ $tenant->max_users }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-people fs-1"></i>
                        </div>
                    </div>
                    <div class="progress mt-2" style="height: 5px;">
                        <div class="progress-bar bg-light" role="progressbar"
                             style="width: {{ $stats['quota_users_used'] }}%"
                             aria-valuenow="{{ $stats['quota_users_used'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small>{{ $stats['quota_users_used'] }}% utilisé</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>Produits</h5>
                            <h2>{{ $stats['products_count'] }}/{{ $tenant->max_products }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-box fs-1"></i>
                        </div>
                    </div>
                    <div class="progress mt-2" style="height: 5px;">
                        <div class="progress-bar bg-light" role="progressbar"
                             style="width: {{ $stats['quota_products_used'] }}%"
                             aria-valuenow="{{ $stats['quota_products_used'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small>{{ $stats['quota_products_used'] }}% utilisé</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>Commandes</h5>
                            <h2>{{ $stats['orders_count'] ?? 0 }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-cart fs-1"></i>
                        </div>
                    </div>
                    <small>Total des commandes</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>Revenus</h5>
                            <h2>{{ number_format($tenant->monthly_fee, 2) }}€</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-currency-euro fs-1"></i>
                        </div>
                    </div>
                    <small>Par mois</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Informations générales -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informations Générales</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <th>Nom:</th>
                                <td>{{ $tenant->name }}</td>
                            </tr>
                            <tr>
                                <th>Slug:</th>
                                <td><code>{{ $tenant->slug }}</code></td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>
                                    <a href="mailto:{{ $tenant->email }}">{{ $tenant->email }}</a>
                                </td>
                            </tr>
                            <tr>
                                <th>Téléphone:</th>
                                <td>{{ $tenant->phone ?: 'Non renseigné' }}</td>
                            </tr>
                            <tr>
                                <th>Domaine:</th>
                                <td>
                                    @if($tenant->domain)
                                        <a href="https://{{ $tenant->domain }}" target="_blank">{{ $tenant->domain }}</a>
                                    @else
                                        Non configuré
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Adresse:</th>
                                <td>{{ $tenant->address ?: 'Non renseignée' }}</td>
                            </tr>
                            <tr>
                                <th>Ville:</th>
                                <td>{{ $tenant->city ?: 'Non renseignée' }}</td>
                            </tr>
                            <tr>
                                <th>Pays:</th>
                                <td>{{ $tenant->country }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modules activés -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Modules Activés</h5>
                </div>
                <div class="card-body">
                    @php
                        $modules = [
                            'chat' => 'Chat en temps réel',
                            'analytics' => 'Analytics avancés',
                            'api' => 'Accès API',
                            'custom_reports' => 'Rapports personnalisés'
                        ];
                        $enabledModules = $tenant->enabled_modules ?? [];
                    @endphp

                    @if(empty($enabledModules))
                        <p class="text-muted">Aucun module activé</p>
                    @else
                        @foreach($modules as $key => $name)
                            @if(in_array($key, $enabledModules))
                                <span class="badge bg-success me-1 mb-1">{{ $name }}</span>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <!-- Configuration & Plan -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Configuration & Plan</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <th>Plan:</th>
                                <td>
                                    <span class="badge bg-{{ $tenant->plan === 'enterprise' ? 'success' : ($tenant->plan === 'pro' ? 'primary' : 'secondary') }}">
                                        {{ ucfirst($tenant->plan) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Max Utilisateurs:</th>
                                <td>{{ $tenant->max_users }}</td>
                            </tr>
                            <tr>
                                <th>Max Produits:</th>
                                <td>{{ $tenant->max_products }}</td>
                            </tr>
                            <tr>
                                <th>Tarif Mensuel:</th>
                                <td><strong>{{ number_format($tenant->monthly_fee, 2) }}€</strong></td>
                            </tr>
                            <tr>
                                <th>Période d'essai:</th>
                                <td>
                                    @if($tenant->trial_ends_at)
                                        {{ $tenant->trial_ends_at->format('d/m/Y') }}
                                        @if($tenant->trial_ends_at->isFuture())
                                            <span class="badge bg-info">En cours</span>
                                        @else
                                            <span class="badge bg-secondary">Terminée</span>
                                        @endif
                                    @else
                                        Pas de période d'essai
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Créé le:</th>
                                <td>{{ $tenant->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Dernière connexion:</th>
                                <td>
                                    @if($stats['last_login'])
                                        {{ $stats['last_login']->diffForHumans() }}
                                    @else
                                        Jamais
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Actions Rapides</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($tenant->domain)
                            <a href="https://{{ $tenant->domain }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-box-arrow-up-right"></i> Visiter le site
                            </a>
                        @endif
                        <a href="/t/{{ $tenant->slug }}" target="_blank" class="btn btn-outline-info btn-sm">
                            <i class="bi bi-box-arrow-up-right"></i> Interface Tenant
                        </a>
                        <button class="btn btn-outline-danger btn-sm" onclick="deleteTenant({{ $tenant->id }})">
                            <i class="bi bi-trash"></i> Supprimer le tenant
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formulaires cachés pour les actions -->
<form id="suspendForm" method="POST" style="display: none;">
    @csrf
    @method('PATCH')
</form>

<form id="activateForm" method="POST" style="display: none;">
    @csrf
    @method('PATCH')
</form>

<form id="restoreForm" method="POST" style="display: none;">
    @csrf
    @method('PATCH')
</form>

<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('scripts')
<script>
function suspendTenant(tenantId) {
    if (confirm('Êtes-vous sûr de vouloir suspendre ce tenant ? Ses utilisateurs ne pourront plus accéder à la plateforme.')) {
        const form = document.getElementById('suspendForm');
        form.action = `/superadmin/tenants/${tenantId}/suspend`;
        form.submit();
    }
}

function activateTenant(tenantId) {
    if (confirm('Êtes-vous sûr de vouloir activer ce tenant ?')) {
        const form = document.getElementById('activateForm');
        form.action = `/superadmin/tenants/${tenantId}/activate`;
        form.submit();
    }
}

function restoreTenant(tenantId) {
    if (confirm('Êtes-vous sûr de vouloir restaurer ce tenant ?')) {
        const form = document.getElementById('restoreForm');
        form.action = `/superadmin/tenants/${tenantId}/restore`;
        form.submit();
    }
}

function deleteTenant(tenantId) {
    if (confirm('⚠️ ATTENTION : Cette action supprimera définitivement le tenant et toutes ses données.\n\nTapez "SUPPRIMER" pour confirmer :')) {
        const confirmation = prompt('Tapez "SUPPRIMER" pour confirmer la suppression :');
        if (confirmation === 'SUPPRIMER') {
            const form = document.getElementById('deleteForm');
            form.action = `/superadmin/tenants/${tenantId}`;
            form.submit();
        }
    }
}
</script>
@endsection