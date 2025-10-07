@extends('layouts.app')

@section('title', 'Mes Demandes de Retour')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Mes Demandes de Retour</h1>
                <a href="{{ route('returns.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouvelle Demande
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                    <h5 class="card-title">{{ $stats['pending'] }}</h5>
                    <p class="card-text text-muted">En attente</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h5 class="card-title">{{ $stats['approved'] }}</h5>
                    <p class="card-text text-muted">Approuvés</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-danger">
                <div class="card-body text-center">
                    <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
                    <h5 class="card-title">{{ $stats['rejected'] }}</h5>
                    <p class="card-text text-muted">Refusés</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <i class="fas fa-undo fa-2x text-info mb-2"></i>
                    <h5 class="card-title">{{ $stats['total'] }}</h5>
                    <p class="card-text text-muted">Total</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Historique des Demandes</h5>
                </div>
                <div class="card-body">
                    <!-- Filtres -->
                    <form method="GET" class="row g-3 mb-4">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Rechercher RMA ou produit..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approuvé</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Refusé</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>En traitement</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Terminé</option>
                                <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Remboursé</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-outline-primary w-100">Filtrer</button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('returns.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                        </div>
                        <div class="col-md-1">
                            <a href="{{ route('returns.create') }}" class="btn btn-primary w-100">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </form>

                    @if($returns->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>N° RMA</th>
                                        <th>Date</th>
                                        <th>Produit</th>
                                        <th>Quantité</th>
                                        <th>Raison</th>
                                        <th>Type</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($returns as $return)
                                        <tr>
                                            <td>
                                                <strong>{{ $return->rma_number }}</strong>
                                                <div class="small text-muted">{{ $return->created_at->format('d/m/Y H:i') }}</div>
                                            </td>
                                            <td>{{ $return->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <div>
                                                    <strong>{{ $return->product->name }}</strong>
                                                    <div class="small text-muted">SKU: {{ $return->product->sku }}</div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $return->quantity_returned }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $return->reason_label }}</span>
                                                @if($return->reason_details)
                                                    <div class="small text-muted mt-1" title="{{ $return->reason_details }}">
                                                        {{ Str::limit($return->reason_details, 30) }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $return->return_type_label }}</span>
                                            </td>
                                            <td>
                                                @if($return->status === 'pending')
                                                    <span class="badge bg-warning">{{ $return->status_label }}</span>
                                                @elseif($return->status === 'approved')
                                                    <span class="badge bg-success">{{ $return->status_label }}</span>
                                                @elseif($return->status === 'rejected')
                                                    <span class="badge bg-danger">{{ $return->status_label }}</span>
                                                @elseif($return->status === 'completed')
                                                    <span class="badge bg-primary">{{ $return->status_label }}</span>
                                                @elseif($return->status === 'refunded')
                                                    <span class="badge bg-success">{{ $return->status_label }}</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $return->status_label }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('returns.show', $return) }}"
                                                       class="btn btn-sm btn-outline-info" title="Voir détails">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($return->status === 'pending')
                                                        <button type="button"
                                                                class="btn btn-sm btn-outline-danger"
                                                                onclick="deleteReturn({{ $return->id }})"
                                                                title="Supprimer">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $returns->withQueryString()->links() }}
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-undo fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucune demande de retour trouvée</h5>
                            <p class="text-muted">Vous n'avez pas encore fait de demande de retour.</p>
                            <a href="{{ route('returns.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Créer une Demande
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function deleteReturn(returnId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette demande de retour ?\n\nVous ne pourrez plus la récupérer.')) {
        fetch(`/returns/${returnId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                location.reload();
            } else {
                alert(data.error || 'Une erreur est survenue');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue');
        });
    }
}
</script>
@endpush
@endsection