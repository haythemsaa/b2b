@extends('layouts.admin')

@section('title', 'Gestion des Retours RMA')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Gestion des Retours RMA</h1>
                <div>
                    <button class="btn btn-outline-success" onclick="exportReturns()">
                        <i class="fas fa-download"></i> Exporter CSV
                    </button>
                </div>
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
                    <p class="card-text text-muted">Total retours</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Liste des Demandes de Retour</h5>
                </div>
                <div class="card-body">
                    <!-- Filtres -->
                    <form method="GET" class="row g-3 mb-4">
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control" placeholder="Rechercher RMA, produit..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
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
                            <select name="user_id" class="form-select">
                                <option value="">Tous les vendeurs</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} {{ $user->company_name ? '(' . $user->company_name . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="date_from" class="form-control" placeholder="Date début" value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="date_to" class="form-control" placeholder="Date fin" value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-outline-primary w-100">Filtrer</button>
                        </div>
                    </form>

                    @if($returns->count() > 0)
                        <!-- Actions en lot -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                                <label class="form-check-label" for="selectAll">
                                    Sélectionner tout
                                </label>
                            </div>
                            <div class="btn-group" id="bulkActions" style="display: none;">
                                <button type="button" class="btn btn-success btn-sm" onclick="bulkAction('approve')">
                                    <i class="fas fa-check"></i> Approuver
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="bulkAction('reject')">
                                    <i class="fas fa-times"></i> Refuser
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="bulkAction('delete')">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="30">
                                            <input type="checkbox" id="selectAllHeader">
                                        </th>
                                        <th>N° RMA</th>
                                        <th>Date</th>
                                        <th>Vendeur</th>
                                        <th>Produit</th>
                                        <th>Quantité</th>
                                        <th>Raison</th>
                                        <th>Statut</th>
                                        <th>Montant</th>
                                        <th width="120">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($returns as $return)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="return-checkbox" value="{{ $return->id }}">
                                            </td>
                                            <td>
                                                <strong>{{ $return->rma_number }}</strong>
                                                <div class="small text-muted">{{ $return->created_at->format('d/m/Y H:i') }}</div>
                                            </td>
                                            <td>{{ $return->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <div>
                                                    <strong>{{ $return->user->name }}</strong>
                                                    <div class="small text-muted">{{ $return->user->company_name }}</div>
                                                </div>
                                            </td>
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
                                                    <div class="small text-muted mt-1">{{ Str::limit($return->reason_details, 50) }}</div>
                                                @endif
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
                                                @else
                                                    <span class="badge bg-secondary">{{ $return->status_label }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($return->refund_amount)
                                                    <strong class="text-success">{{ number_format($return->refund_amount, 2) }} MAD</strong>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.returns.show', $return) }}"
                                                       class="btn btn-sm btn-outline-info" title="Voir">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($return->isPending())
                                                        <button type="button"
                                                                class="btn btn-sm btn-outline-success"
                                                                onclick="approveReturn({{ $return->id }})"
                                                                title="Approuver">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-sm btn-outline-danger"
                                                                onclick="rejectReturn({{ $return->id }})"
                                                                title="Refuser">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    @endif
                                                    @if(in_array($return->status, ['pending', 'rejected']))
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
                            <p class="text-muted">Les demandes de retour des vendeurs apparaîtront ici.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'approbation -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approuver le retour</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="approveForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Montant du remboursement (optionnel)</label>
                        <input type="number" name="refund_amount" class="form-control" step="0.01" min="0">
                        <div class="form-text">Laissez vide pour un remboursement complet</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes administratives (optionnel)</label>
                        <textarea name="admin_notes" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">Approuver</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de refus -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Refuser le retour</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Raison du refus <span class="text-danger">*</span></label>
                        <textarea name="admin_notes" class="form-control" rows="4" required></textarea>
                        <div class="form-text">Expliquez pourquoi cette demande est refusée</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Refuser</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const selectAllHeader = document.getElementById('selectAllHeader');
    const checkboxes = document.querySelectorAll('.return-checkbox');
    const bulkActions = document.getElementById('bulkActions');

    // Synchronisation des cases à cocher "tout sélectionner"
    [selectAll, selectAllHeader].forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const isChecked = this.checked;
            checkboxes.forEach(cb => cb.checked = isChecked);
            selectAll.checked = isChecked;
            selectAllHeader.checked = isChecked;
            toggleBulkActions();
        });
    });

    // Gestion des cases individuelles
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedCount = document.querySelectorAll('.return-checkbox:checked').length;
            selectAll.checked = checkedCount === checkboxes.length;
            selectAllHeader.checked = checkedCount === checkboxes.length;
            toggleBulkActions();
        });
    });

    function toggleBulkActions() {
        const checkedCount = document.querySelectorAll('.return-checkbox:checked').length;
        bulkActions.style.display = checkedCount > 0 ? 'block' : 'none';
    }
});

let currentReturnId = null;

function approveReturn(returnId) {
    currentReturnId = returnId;
    new bootstrap.Modal(document.getElementById('approveModal')).show();
}

function rejectReturn(returnId) {
    currentReturnId = returnId;
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}

// Gestion du formulaire d'approbation
document.getElementById('approveForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch(`/admin/returns/${currentReturnId}/approve`, {
        method: 'POST',
        body: formData,
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
            alert('Une erreur est survenue');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Une erreur est survenue');
    });
});

// Gestion du formulaire de refus
document.getElementById('rejectForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch(`/admin/returns/${currentReturnId}/reject`, {
        method: 'POST',
        body: formData,
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
            alert('Une erreur est survenue');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Une erreur est survenue');
    });
});

function deleteReturn(returnId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette demande de retour ?')) {
        fetch(`/admin/returns/${returnId}`, {
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
                alert('Une erreur est survenue');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue');
        });
    }
}

function bulkAction(action) {
    const checkedBoxes = document.querySelectorAll('.return-checkbox:checked');
    const returnIds = Array.from(checkedBoxes).map(cb => cb.value);

    if (returnIds.length === 0) {
        alert('Veuillez sélectionner au moins un retour');
        return;
    }

    let confirmMessage;
    switch (action) {
        case 'approve':
            confirmMessage = `Approuver ${returnIds.length} retour(s) sélectionné(s) ?`;
            break;
        case 'reject':
            confirmMessage = `Refuser ${returnIds.length} retour(s) sélectionné(s) ?`;
            break;
        case 'delete':
            confirmMessage = `Supprimer ${returnIds.length} retour(s) sélectionné(s) ?`;
            break;
    }

    if (confirm(confirmMessage)) {
        let adminNotes = '';
        if (action === 'reject') {
            adminNotes = prompt('Raison du refus:');
            if (!adminNotes) return;
        }

        fetch('/admin/returns/bulk-action', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                action: action,
                return_ids: returnIds,
                admin_notes: adminNotes
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                location.reload();
            } else {
                alert('Une erreur est survenue');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue');
        });
    }
}

function exportReturns() {
    const params = new URLSearchParams(window.location.search);
    window.open('/admin/returns/export?' + params.toString());
}
</script>
@endpush
@endsection
