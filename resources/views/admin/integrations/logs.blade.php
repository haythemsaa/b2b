@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-history"></i> Logs de Synchronisation
            </h1>
            <p class="text-muted">{{ $integration->name }}</p>
        </div>
        <div>
            <a href="{{ route('admin.integrations.show', $integration) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter"></i> Filtres</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.integrations.logs', $integration) }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <label for="status" class="form-label">Statut</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Tous</option>
                            <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Succès</option>
                            <option value="error" {{ request('status') === 'error' ? 'selected' : '' }}>Erreur</option>
                            <option value="running" {{ request('status') === 'running' ? 'selected' : '' }}>En cours</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="sync_type" class="form-label">Type de sync</label>
                        <select name="sync_type" id="sync_type" class="form-select">
                            <option value="">Tous</option>
                            <option value="manual" {{ request('sync_type') === 'manual' ? 'selected' : '' }}>Manuel</option>
                            <option value="scheduled" {{ request('sync_type') === 'scheduled' ? 'selected' : '' }}>Planifié</option>
                            <option value="automatic" {{ request('sync_type') === 'automatic' ? 'selected' : '' }}>Automatique</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="date_from" class="form-label">Date de début</label>
                        <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="date_to" class="form-label">Date de fin</label>
                        <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Filtrer
                        </button>
                        <a href="{{ route('admin.integrations.logs', $integration) }}" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Réinitialiser
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <h3 class="mb-0">{{ $logs->total() }}</h3>
                    <small class="text-muted">Total des logs</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <h3 class="mb-0 text-success">{{ $integration->successful_syncs }}</h3>
                    <small class="text-muted">Synchronisations réussies</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-danger">
                <div class="card-body text-center">
                    <h3 class="mb-0 text-danger">{{ $integration->failed_syncs }}</h3>
                    <small class="text-muted">Synchronisations échouées</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <h3 class="mb-0 text-info">
                        {{ $integration->total_syncs > 0 ? round(($integration->successful_syncs / $integration->total_syncs) * 100, 1) : 0 }}%
                    </h3>
                    <small class="text-muted">Taux de succès</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Table des logs -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-list"></i> Historique des Synchronisations</h5>
            <span class="badge bg-secondary">{{ $logs->total() }} logs</span>
        </div>
        <div class="card-body p-0">
            @if($logs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th style="width: 15%">Date & Heure</th>
                                <th style="width: 10%">Type</th>
                                <th style="width: 10%">Statut</th>
                                <th style="width: 10%">Durée</th>
                                <th style="width: 35%">Message</th>
                                <th style="width: 10%">Éléments</th>
                                <th style="width: 10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td>
                                        <small>
                                            {{ $log->created_at->format('d/m/Y') }}<br>
                                            <strong>{{ $log->created_at->format('H:i:s') }}</strong>
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ ucfirst($log->sync_type) }}</span>
                                    </td>
                                    <td>
                                        @if($log->status === 'success')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check"></i> Succès
                                            </span>
                                        @elseif($log->status === 'error')
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times"></i> Erreur
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-spinner fa-spin"></i> En cours
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($log->duration)
                                            <span class="badge bg-info">{{ number_format($log->duration, 2) }}s</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($log->error_message)
                                            <span class="text-danger">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                {{ Str::limit($log->error_message, 80) }}
                                            </span>
                                        @else
                                            <span class="text-success">
                                                <i class="fas fa-check-circle"></i>
                                                Synchronisation réussie
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($log->items_count)
                                            <span class="badge bg-primary">{{ $log->items_count }} éléments</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info"
                                                onclick="showLogDetails({{ $log->id }})"
                                                data-log='@json($log)'>
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="card-footer">
                    {{ $logs->links() }}
                </div>
            @else
                <div class="p-5 text-center text-muted">
                    <i class="fas fa-inbox fa-4x mb-3"></i>
                    <h5>Aucun log trouvé</h5>
                    <p>Aucune synchronisation n'a été effectuée avec les filtres sélectionnés.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal détails log -->
<div class="modal fade" id="logModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle"></i> Détails de la Synchronisation
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="logModalBody">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-calendar"></i> Informations Générales</h6>
                        <table class="table table-sm">
                            <tr>
                                <th style="width: 40%">Date & Heure:</th>
                                <td id="log-date"></td>
                            </tr>
                            <tr>
                                <th>Type de sync:</th>
                                <td id="log-type"></td>
                            </tr>
                            <tr>
                                <th>Statut:</th>
                                <td id="log-status"></td>
                            </tr>
                            <tr>
                                <th>Durée:</th>
                                <td id="log-duration"></td>
                            </tr>
                            <tr>
                                <th>Éléments traités:</th>
                                <td id="log-items"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-chart-pie"></i> Résultats</h6>
                        <div id="log-results"></div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <h6><i class="fas fa-exclamation-triangle"></i> Message d'erreur</h6>
                        <div id="log-error" class="alert alert-danger" style="display: none;"></div>
                        <div id="log-success" class="alert alert-success" style="display: none;">
                            Synchronisation effectuée avec succès
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-upload"></i> Requête Envoyée</h6>
                        <pre id="log-request" class="bg-light p-3 rounded" style="max-height: 300px; overflow-y: auto;"></pre>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-download"></i> Réponse Reçue</h6>
                        <pre id="log-response" class="bg-light p-3 rounded" style="max-height: 300px; overflow-y: auto;"></pre>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<script>
function showLogDetails(logId) {
    const modal = new bootstrap.Modal(document.getElementById('logModal'));

    // Récupérer les données du log depuis le bouton
    const button = event.target.closest('button');
    const log = JSON.parse(button.getAttribute('data-log'));

    // Remplir les informations générales
    document.getElementById('log-date').textContent = new Date(log.created_at).toLocaleString('fr-FR');
    document.getElementById('log-type').innerHTML = `<span class="badge bg-secondary">${log.sync_type}</span>`;

    // Statut
    let statusBadge = '';
    if (log.status === 'success') {
        statusBadge = '<span class="badge bg-success"><i class="fas fa-check"></i> Succès</span>';
        document.getElementById('log-success').style.display = 'block';
        document.getElementById('log-error').style.display = 'none';
    } else if (log.status === 'error') {
        statusBadge = '<span class="badge bg-danger"><i class="fas fa-times"></i> Erreur</span>';
        document.getElementById('log-error').style.display = 'block';
        document.getElementById('log-error').textContent = log.error_message || 'Erreur inconnue';
        document.getElementById('log-success').style.display = 'none';
    } else {
        statusBadge = '<span class="badge bg-warning"><i class="fas fa-spinner"></i> En cours</span>';
        document.getElementById('log-success').style.display = 'none';
        document.getElementById('log-error').style.display = 'none';
    }
    document.getElementById('log-status').innerHTML = statusBadge;

    // Durée
    document.getElementById('log-duration').textContent = log.duration ? `${log.duration.toFixed(2)} secondes` : 'N/A';

    // Éléments
    document.getElementById('log-items').textContent = log.items_count || '0';

    // Résultats
    let resultsHtml = '<div class="text-muted">Aucune donnée détaillée disponible</div>';
    if (log.items_count) {
        resultsHtml = `
            <div class="progress" style="height: 25px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 100%">
                    ${log.items_count} éléments traités
                </div>
            </div>
        `;
    }
    document.getElementById('log-results').innerHTML = resultsHtml;

    // Requête
    if (log.request_data) {
        try {
            const requestData = typeof log.request_data === 'string' ? JSON.parse(log.request_data) : log.request_data;
            document.getElementById('log-request').textContent = JSON.stringify(requestData, null, 2);
        } catch (e) {
            document.getElementById('log-request').textContent = log.request_data || 'Aucune donnée de requête';
        }
    } else {
        document.getElementById('log-request').textContent = 'Aucune donnée de requête';
    }

    // Réponse
    if (log.response_data) {
        try {
            const responseData = typeof log.response_data === 'string' ? JSON.parse(log.response_data) : log.response_data;
            document.getElementById('log-response').textContent = JSON.stringify(responseData, null, 2);
        } catch (e) {
            document.getElementById('log-response').textContent = log.response_data || 'Aucune donnée de réponse';
        }
    } else {
        document.getElementById('log-response').textContent = 'Aucune donnée de réponse';
    }

    modal.show();
}
</script>

<style>
pre {
    font-size: 0.85rem;
    white-space: pre-wrap;
    word-wrap: break-word;
}
</style>
@endsection
