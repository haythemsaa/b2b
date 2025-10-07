@extends('layouts.app')

@section('title', 'Tableau de Bord Super-Admin')

@section('content')
<div class="container-fluid">
    <!-- Header avec actions rapides -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Tableau de Bord Super-Admin</h1>
                <div class="btn-group">
                    <a href="{{ route('superadmin.tenants.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Nouveau Tenant
                    </a>
                    <a href="{{ route('superadmin.tenants.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-building"></i> Gérer Tenants
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertes système -->
    @if(!empty($alerts))
    <div class="row mb-4">
        <div class="col-12">
            @foreach($alerts as $alert)
            <div class="alert alert-{{ $alert['type'] === 'warning' ? 'warning' : 'info' }} alert-dismissible fade show" role="alert">
                <i class="bi bi-{{ $alert['type'] === 'warning' ? 'exclamation-triangle' : 'info-circle' }}"></i>
                {{ $alert['message'] }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Métriques principales -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <i class="bi bi-building fs-1 mb-2"></i>
                    <h3>{{ $totalTenants }}</h3>
                    <p class="mb-0">Total Tenants</p>
                    @if($tenantGrowth > 0)
                        <small class="badge bg-success">+{{ $tenantGrowth }} ce mois</small>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <i class="bi bi-check-circle fs-1 mb-2"></i>
                    <h3>{{ $activeTenants }}</h3>
                    <p class="mb-0">Tenants Actifs</p>
                    <small>{{ round(($activeTenants / max($totalTenants, 1)) * 100, 1) }}% actifs</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <i class="bi bi-people fs-1 mb-2"></i>
                    <h3>{{ $totalUsers }}</h3>
                    <p class="mb-0">Total Utilisateurs</p>
                    <small>{{ round($totalUsers / max($totalTenants, 1), 1) }} par tenant</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <i class="bi bi-box fs-1 mb-2"></i>
                    <h3>{{ number_format($totalProducts) }}</h3>
                    <p class="mb-0">Total Produits</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-secondary text-white">
                <div class="card-body text-center">
                    <i class="bi bi-cart fs-1 mb-2"></i>
                    <h3>{{ number_format($totalOrders) }}</h3>
                    <p class="mb-0">Total Commandes</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <i class="bi bi-currency-euro fs-1 mb-2"></i>
                    <h3>{{ number_format($monthlyRevenue, 0) }}€</h3>
                    <p class="mb-0">Revenus/Mois</p>
                    <small>{{ number_format($monthlyRevenue * 12, 0) }}€ annuel</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Graphique des revenus -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Évolution des Revenus (12 derniers mois)</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <!-- Répartition par plan -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Répartition par Plan</h5>
                </div>
                <div class="card-body">
                    @foreach($planStats as $plan)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="mb-0">{{ ucfirst($plan->plan) }}</h6>
                            <small class="text-muted">{{ $plan->count }} tenant(s)</small>
                        </div>
                        <div class="text-end">
                            <strong>{{ number_format($plan->revenue, 0) }}€</strong>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Top tenants -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Top 5 Tenants (Revenus)</h5>
                </div>
                <div class="card-body">
                    @forelse($topTenants as $tenant)
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div>
                            <h6 class="mb-1">{{ $tenant->name }}</h6>
                            <small class="text-muted">
                                {{ $tenant->users_count }} utilisateurs • {{ $tenant->products_count }} produits
                            </small>
                        </div>
                        <div class="text-end">
                            <strong>{{ number_format($tenant->monthly_fee, 0) }}€/mois</strong>
                            <br>
                            <span class="badge bg-{{ $tenant->plan === 'enterprise' ? 'success' : ($tenant->plan === 'pro' ? 'primary' : 'secondary') }}">
                                {{ ucfirst($tenant->plan) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted">Aucun tenant trouvé</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Utilisation des quotas -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Utilisation Moyenne des Quotas</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Utilisateurs</span>
                            <span>{{ number_format($quotaStats['users_avg'] ?? 0, 1) }}%</span>
                        </div>
                        <div class="progress mb-2">
                            <div class="progress-bar bg-primary" role="progressbar"
                                 style="width: {{ $quotaStats['users_avg'] ?? 0 }}%"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Produits</span>
                            <span>{{ number_format($quotaStats['products_avg'] ?? 0, 1) }}%</span>
                        </div>
                        <div class="progress mb-2">
                            <div class="progress-bar bg-warning" role="progressbar"
                                 style="width: {{ $quotaStats['products_avg'] ?? 0 }}%"></div>
                        </div>
                    </div>

                    <div class="row text-center">
                        <div class="col-6">
                            <h5 class="text-primary">{{ $activeTenants }}</h5>
                            <small class="text-muted">Tenants Actifs</small>
                        </div>
                        <div class="col-6">
                            <h5 class="text-success">{{ number_format(($activeTenants / max($totalTenants, 1)) * 100, 1) }}%</h5>
                            <small class="text-muted">Taux d'Activité</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tenants récents -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Tenants Récents</h5>
                    <a href="{{ route('superadmin.tenants.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Plan</th>
                                    <th>Utilisateurs</th>
                                    <th>Revenus</th>
                                    <th>Créé le</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTenants as $tenant)
                                <tr>
                                    <td>
                                        <strong>{{ $tenant->name }}</strong><br>
                                        <small class="text-muted">{{ $tenant->email }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $tenant->plan === 'enterprise' ? 'success' : ($tenant->plan === 'pro' ? 'primary' : 'secondary') }}">
                                            {{ ucfirst($tenant->plan) }}
                                        </span>
                                    </td>
                                    <td>{{ $tenant->users->count() }}/{{ $tenant->max_users }}</td>
                                    <td>{{ number_format($tenant->monthly_fee, 0) }}€/mois</td>
                                    <td>{{ $tenant->created_at->diffForHumans() }}</td>
                                    <td>
                                        @if($tenant->is_active)
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-warning">Suspendu</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('superadmin.tenants.show', $tenant) }}"
                                           class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Aucun tenant trouvé</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Graphique des revenus
const ctx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode(collect($revenueChart)->pluck('month')) !!},
        datasets: [{
            label: 'Revenus Mensuels (€)',
            data: {!! json_encode(collect($revenueChart)->pluck('revenue')) !!},
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return value + '€';
                    }
                }
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        }
    }
});

// Auto-refresh des données toutes les 5 minutes
setInterval(function() {
    location.reload();
}, 300000);
</script>
@endsection