@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-plug"></i> {{ $integration->name }}
            </h1>
            <p class="text-muted">
                <span class="badge bg-{{ $integration->status === 'active' ? 'success' : ($integration->status === 'error' ? 'danger' : 'secondary') }}">
                    {{ ucfirst($integration->status) }}
                </span>
                <span class="ms-2">{{ ucfirst(str_replace('_', ' ', $integration->type)) }}</span>
            </p>
        </div>
        <div>
            <a href="{{ route('admin.integrations.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
            <a href="{{ route('admin.integrations.edit', $integration) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Modifier
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Informations principales -->
        <div class="col-lg-8">
            <!-- Carte Informations -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informations Générales</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nom:</strong> {{ $integration->name }}</p>
                            <p><strong>Type:</strong> {{ ucfirst(str_replace('_', ' ', $integration->type)) }}</p>
                            <p><strong>Statut:</strong>
                                <span class="badge bg-{{ $integration->status === 'active' ? 'success' : ($integration->status === 'error' ? 'danger' : 'secondary') }}">
                                    {{ ucfirst($integration->status) }}
                                </span>
                            </p>
                            <p><strong>Direction de sync:</strong>
                                @if($integration->sync_direction === 'export')
                                    <span class="badge bg-primary">Export (B2B → ERP)</span>
                                @elseif($integration->sync_direction === 'import')
                                    <span class="badge bg-info">Import (ERP → B2B)</span>
                                @else
                                    <span class="badge bg-success">Bidirectionnel</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Fréquence:</strong> {{ ucfirst($integration->sync_frequency) }}</p>
                            <p><strong>Auto-sync:</strong>
                                <span class="badge bg-{{ $integration->auto_sync ? 'success' : 'secondary' }}">
                                    {{ $integration->auto_sync ? 'Activée' : 'Désactivée' }}
                                </span>
                            </p>
                            <p><strong>Créé le:</strong> {{ $integration->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Dernière modification:</strong> {{ $integration->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    @if($integration->sync_entities && count($integration->sync_entities) > 0)
                        <hr>
                        <p><strong>Entités synchronisées:</strong></p>
                        <div>
                            @foreach($integration->sync_entities as $entity)
                                <span class="badge bg-primary me-1">{{ ucfirst($entity) }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Statistiques de Synchronisation -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-line"></i> Statistiques de Synchronisation</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <h4 class="mb-0">{{ $integration->total_syncs }}</h4>
                                <small class="text-muted">Total syncs</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <h4 class="mb-0 text-success">{{ $integration->successful_syncs }}</h4>
                                <small class="text-muted">Réussies</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <h4 class="mb-0 text-danger">{{ $integration->failed_syncs }}</h4>
                                <small class="text-muted">Échouées</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <h4 class="mb-0 text-info">
                                    {{ $integration->total_syncs > 0 ? round(($integration->successful_syncs / $integration->total_syncs) * 100, 1) : 0 }}%
                                </h4>
                                <small class="text-muted">Taux de succès</small>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Dernière synchronisation:</strong></p>
                            <p class="text-muted">
                                {{ $integration->last_sync_at ? $integration->last_sync_at->format('d/m/Y H:i:s') : 'Jamais' }}
                                @if($integration->last_sync_at)
                                    <small>({{ $integration->last_sync_at->diffForHumans() }})</small>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Prochaine synchronisation:</strong></p>
                            <p class="text-muted">
                                @if($integration->auto_sync && $integration->status === 'active' && $integration->next_sync_at)
                                    {{ $integration->next_sync_at->format('d/m/Y H:i:s') }}
                                    <small>({{ $integration->next_sync_at->diffForHumans() }})</small>
                                @else
                                    Manuel uniquement
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($integration->last_error)
                        <div class="alert alert-danger mt-3 mb-0">
                            <strong><i class="fas fa-exclamation-triangle"></i> Dernière erreur:</strong><br>
                            {{ $integration->last_error }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Configuration Connexion (masquée pour sécurité) -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-key"></i> Configuration de Connexion</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-shield-alt"></i> Les identifiants de connexion sont chiffrés et ne peuvent pas être affichés pour des raisons de sécurité.
                    </div>

                    @php
                        $credentials = $integration->credentials ?? [];
                    @endphp

                    @if(isset($credentials['api_url']))
                        <p><strong>URL API:</strong> {{ $credentials['api_url'] }}</p>
                    @endif

                    @if(isset($credentials['api_key']))
                        <p><strong>Clé API:</strong> <span class="badge bg-success">Configurée</span></p>
                    @endif

                    @if(isset($credentials['api_secret']))
                        <p><strong>Secret API:</strong> <span class="badge bg-success">Configuré</span></p>
                    @endif

                    @if(isset($credentials['username']))
                        <p><strong>Nom d'utilisateur:</strong> {{ $credentials['username'] }}</p>
                    @endif

                    @if(isset($credentials['password']))
                        <p><strong>Mot de passe:</strong> <span class="badge bg-success">Configuré</span></p>
                    @endif

                    @if(isset($credentials['database']))
                        <p><strong>Base de données:</strong> {{ $credentials['database'] }}</p>
                    @endif

                    <a href="{{ route('admin.integrations.edit', $integration) }}" class="btn btn-sm btn-warning mt-2">
                        <i class="fas fa-edit"></i> Modifier les identifiants
                    </a>
                </div>
            </div>

            <!-- Logs récents -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-history"></i> Logs Récents (10 derniers)</h5>
                    <a href="{{ route('admin.integrations.logs', $integration) }}" class="btn btn-sm btn-primary">
                        Voir tous les logs
                    </a>
                </div>
                <div class="card-body p-0">
                    @if($integration->logs && $integration->logs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Statut</th>
                                        <th>Durée</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($integration->logs->take(10) as $log)
                                        <tr>
                                            <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                            <td>
                                                <span class="badge bg-secondary">{{ ucfirst($log->sync_type) }}</span>
                                            </td>
                                            <td>
                                                @if($log->status === 'success')
                                                    <span class="badge bg-success">Succès</span>
                                                @elseif($log->status === 'error')
                                                    <span class="badge bg-danger">Erreur</span>
                                                @else
                                                    <span class="badge bg-warning">En cours</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($log->duration)
                                                    {{ number_format($log->duration, 2) }}s
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-info" onclick="showLogDetails({{ $log->id }})">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <p>Aucun log disponible</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="col-lg-4">
            <!-- Actions rapides -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-bolt"></i> Actions</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.integrations.test', $integration) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-info w-100">
                            <i class="fas fa-vial"></i> Tester la connexion
                        </button>
                    </form>

                    @if($integration->status === 'active')
                        <form action="{{ route('admin.integrations.sync', $integration) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-sync"></i> Synchroniser maintenant
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('admin.integrations.logs', $integration) }}" class="btn btn-outline-secondary w-100 mb-2">
                        <i class="fas fa-history"></i> Voir tous les logs
                    </a>

                    <a href="{{ route('admin.integrations.edit', $integration) }}" class="btn btn-warning w-100 mb-2">
                        <i class="fas fa-edit"></i> Modifier
                    </a>

                    <hr>

                    <form action="{{ route('admin.integrations.toggle', $integration) }}" method="POST" class="mb-2">
                        @csrf
                        @if($integration->status === 'active')
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="fas fa-pause"></i> Désactiver
                            </button>
                        @else
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-play"></i> Activer
                            </button>
                        @endif
                    </form>

                    <form action="{{ route('admin.integrations.destroy', $integration) }}"
                          method="POST"
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette intégration ? Cette action est irréversible.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>

            <!-- Informations système -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informations</h5>
                </div>
                <div class="card-body">
                    <h6>Type d'intégration</h6>
                    <p class="small">
                        @switch($integration->type)
                            @case('sap_b1')
                                SAP Business One - ERP complet pour PME
                                @break
                            @case('dynamics_365')
                                Microsoft Dynamics 365 - Suite ERP/CRM
                                @break
                            @case('sage')
                                Sage - Gestion comptable et commerciale
                                @break
                            @case('quickbooks')
                                QuickBooks - Comptabilité en ligne
                                @break
                            @case('odoo')
                                Odoo - Suite open-source
                                @break
                            @case('xero')
                                Xero - Comptabilité cloud
                                @break
                            @case('netsuite')
                                Oracle NetSuite - ERP cloud entreprise
                                @break
                            @case('custom_api')
                                API Personnalisée
                                @break
                        @endswitch
                    </p>

                    <h6 class="mt-3">Synchronisation</h6>
                    <p class="small">
                        @if($integration->auto_sync && $integration->status === 'active')
                            <span class="text-success"><i class="fas fa-check-circle"></i> Synchronisation automatique activée</span><br>
                            Fréquence: {{ $integration->sync_frequency }}
                        @else
                            <span class="text-muted"><i class="fas fa-hand-paper"></i> Synchronisation manuelle uniquement</span>
                        @endif
                    </p>

                    <h6 class="mt-3">Sécurité</h6>
                    <p class="small mb-0">
                        <i class="fas fa-lock"></i> Tous les identifiants sont chiffrés avec AES-256
                    </p>
                </div>
            </div>

            <!-- Aide -->
            <div class="card">
                <div class="card-header bg-warning">
                    <h5 class="mb-0"><i class="fas fa-question-circle"></i> Besoin d'aide ?</h5>
                </div>
                <div class="card-body">
                    <p class="small">
                        Consultez la <a href="/documentation/integrations" target="_blank">documentation complète</a> pour plus d'informations sur :
                    </p>
                    <ul class="small">
                        <li>Configuration avancée</li>
                        <li>Mapping des champs</li>
                        <li>Résolution des erreurs</li>
                        <li>Meilleures pratiques</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal détails log -->
<div class="modal fade" id="logModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails du log</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="logModalBody">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showLogDetails(logId) {
    const modal = new bootstrap.Modal(document.getElementById('logModal'));
    modal.show();

    // TODO: Charger les détails via AJAX
    document.getElementById('logModalBody').innerHTML = '<p>Fonctionnalité à implémenter</p>';
}
</script>
@endsection
