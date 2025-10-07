@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0"><i class="fas fa-plug"></i> Intégrations ERP/Comptabilité</h1>
            <p class="text-muted">Gérez vos connexions avec les systèmes externes</p>
        </div>
        <a href="{{ route('admin.integrations.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouvelle Intégration
        </a>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Intégrations</p>
                            <h3 class="mb-0">{{ $stats['total_integrations'] }}</h3>
                        </div>
                        <div class="text-primary">
                            <i class="fas fa-plug fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Intégrations Actives</p>
                            <h3 class="mb-0 text-success">{{ $stats['active_integrations'] }}</h3>
                        </div>
                        <div class="text-success">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Synchronisations</p>
                            <h3 class="mb-0">{{ number_format($stats['total_syncs']) }}</h3>
                        </div>
                        <div class="text-info">
                            <i class="fas fa-sync fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Taux de Succès</p>
                            <h3 class="mb-0">{{ $stats['success_rate'] }}%</h3>
                        </div>
                        <div class="text-warning">
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des intégrations -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-list"></i> Liste des Intégrations</h5>
        </div>
        <div class="card-body">
            @if($integrations->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-plug fa-4x text-muted mb-3"></i>
                    <p class="text-muted">Aucune intégration configurée</p>
                    <a href="{{ route('admin.integrations.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Créer la première intégration
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Type</th>
                                <th>Statut</th>
                                <th>Direction</th>
                                <th>Fréquence</th>
                                <th>Dernière Sync</th>
                                <th>Taux Succès</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($integrations as $integration)
                                <tr>
                                    <td>
                                        <strong>{{ $integration->name }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $integration->getTypeName() }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $integration->getStatusBadge() }}">
                                            {{ ucfirst($integration->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <i class="fas fa-arrow-{{ $integration->sync_direction === 'export' ? 'up' : ($integration->sync_direction === 'import' ? 'down' : 'left-right') }}"></i>
                                        {{ ucfirst($integration->sync_direction) }}
                                    </td>
                                    <td>
                                        <i class="fas fa-clock"></i>
                                        {{ ucfirst($integration->sync_frequency) }}
                                    </td>
                                    <td>
                                        @if($integration->last_sync_at)
                                            <small>{{ $integration->last_sync_at->diffForHumans() }}</small>
                                        @else
                                            <small class="text-muted">Jamais</small>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $successRate = $integration->getSuccessRate();
                                            $badgeClass = $successRate >= 80 ? 'success' : ($successRate >= 50 ? 'warning' : 'danger');
                                        @endphp
                                        <span class="badge bg-{{ $badgeClass }}">
                                            {{ $successRate }}%
                                        </span>
                                        <small class="text-muted d-block">
                                            {{ $integration->successful_syncs }}/{{ $integration->total_syncs }}
                                        </small>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.integrations.show', $integration) }}"
                                               class="btn btn-sm btn-outline-primary" title="Détails">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if($integration->canSync())
                                                <form action="{{ route('admin.integrations.sync', $integration) }}"
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-success"
                                                            title="Synchroniser maintenant">
                                                        <i class="fas fa-sync"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('admin.integrations.test', $integration) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-info"
                                                        title="Tester connexion">
                                                    <i class="fas fa-vial"></i>
                                                </button>
                                            </form>

                                            <a href="{{ route('admin.integrations.edit', $integration) }}"
                                               class="btn btn-sm btn-outline-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.integrations.destroy', $integration) }}"
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette intégration ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                @if($integration->last_error)
                                    <tr>
                                        <td colspan="8" class="bg-danger bg-opacity-10">
                                            <small class="text-danger">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                <strong>Dernière erreur:</strong> {{ $integration->last_error }}
                                            </small>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Logs récents -->
    @if(!$integrations->isEmpty())
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-history"></i> Activité Récente</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Intégration</th>
                                <th>Action</th>
                                <th>Statut</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($integrations as $integration)
                                @foreach($integration->logs->take(3) as $log)
                                    <tr>
                                        <td>
                                            <small><strong>{{ $integration->name }}</strong></small>
                                        </td>
                                        <td>
                                            <small>
                                                <i class="fas fa-{{ $log->direction === 'export' ? 'arrow-up' : 'arrow-down' }}"></i>
                                                {{ ucfirst($log->action) }} {{ $log->entity_type }}
                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $log->getStatusBadge() }}">
                                                {{ ucfirst($log->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <small>{{ $log->created_at->diffForHumans() }}</small>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
