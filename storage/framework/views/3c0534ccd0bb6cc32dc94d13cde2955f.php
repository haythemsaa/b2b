

<?php $__env->startSection('title', 'Gestion des Retours RMA'); ?>

<?php $__env->startSection('content'); ?>
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

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                    <h5 class="card-title"><?php echo e($stats['pending']); ?></h5>
                    <p class="card-text text-muted">En attente</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h5 class="card-title"><?php echo e($stats['approved']); ?></h5>
                    <p class="card-text text-muted">Approuvés</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-danger">
                <div class="card-body text-center">
                    <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
                    <h5 class="card-title"><?php echo e($stats['rejected']); ?></h5>
                    <p class="card-text text-muted">Refusés</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <i class="fas fa-undo fa-2x text-info mb-2"></i>
                    <h5 class="card-title"><?php echo e($stats['total']); ?></h5>
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
                            <input type="text" name="search" class="form-control" placeholder="Rechercher RMA, produit..." value="<?php echo e(request('search')); ?>">
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>En attente</option>
                                <option value="approved" <?php echo e(request('status') == 'approved' ? 'selected' : ''); ?>>Approuvé</option>
                                <option value="rejected" <?php echo e(request('status') == 'rejected' ? 'selected' : ''); ?>>Refusé</option>
                                <option value="processing" <?php echo e(request('status') == 'processing' ? 'selected' : ''); ?>>En traitement</option>
                                <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Terminé</option>
                                <option value="refunded" <?php echo e(request('status') == 'refunded' ? 'selected' : ''); ?>>Remboursé</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="user_id" class="form-select">
                                <option value="">Tous les vendeurs</option>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user->id); ?>" <?php echo e(request('user_id') == $user->id ? 'selected' : ''); ?>>
                                        <?php echo e($user->name); ?> <?php echo e($user->company_name ? '(' . $user->company_name . ')' : ''); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="date_from" class="form-control" placeholder="Date début" value="<?php echo e(request('date_from')); ?>">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="date_to" class="form-control" placeholder="Date fin" value="<?php echo e(request('date_to')); ?>">
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-outline-primary w-100">Filtrer</button>
                        </div>
                    </form>

                    <?php if($returns->count() > 0): ?>
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
                                    <?php $__currentLoopData = $returns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="return-checkbox" value="<?php echo e($return->id); ?>">
                                            </td>
                                            <td>
                                                <strong><?php echo e($return->rma_number); ?></strong>
                                                <div class="small text-muted"><?php echo e($return->created_at->format('d/m/Y H:i')); ?></div>
                                            </td>
                                            <td><?php echo e($return->created_at->format('d/m/Y')); ?></td>
                                            <td>
                                                <div>
                                                    <strong><?php echo e($return->user->name); ?></strong>
                                                    <div class="small text-muted"><?php echo e($return->user->company_name); ?></div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong><?php echo e($return->product->name); ?></strong>
                                                    <div class="small text-muted">SKU: <?php echo e($return->product->sku); ?></div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info"><?php echo e($return->quantity_returned); ?></span>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary"><?php echo e($return->reason_label); ?></span>
                                                <?php if($return->reason_details): ?>
                                                    <div class="small text-muted mt-1"><?php echo e(Str::limit($return->reason_details, 50)); ?></div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($return->status === 'pending'): ?>
                                                    <span class="badge bg-warning"><?php echo e($return->status_label); ?></span>
                                                <?php elseif($return->status === 'approved'): ?>
                                                    <span class="badge bg-success"><?php echo e($return->status_label); ?></span>
                                                <?php elseif($return->status === 'rejected'): ?>
                                                    <span class="badge bg-danger"><?php echo e($return->status_label); ?></span>
                                                <?php elseif($return->status === 'completed'): ?>
                                                    <span class="badge bg-primary"><?php echo e($return->status_label); ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary"><?php echo e($return->status_label); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($return->refund_amount): ?>
                                                    <strong class="text-success"><?php echo e(number_format($return->refund_amount, 2)); ?> MAD</strong>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo e(route('admin.returns.show', $return)); ?>"
                                                       class="btn btn-sm btn-outline-info" title="Voir">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <?php if($return->isPending()): ?>
                                                        <button type="button"
                                                                class="btn btn-sm btn-outline-success"
                                                                onclick="approveReturn(<?php echo e($return->id); ?>)"
                                                                title="Approuver">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-sm btn-outline-danger"
                                                                onclick="rejectReturn(<?php echo e($return->id); ?>)"
                                                                title="Refuser">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                    <?php if(in_array($return->status, ['pending', 'rejected'])): ?>
                                                        <button type="button"
                                                                class="btn btn-sm btn-outline-danger"
                                                                onclick="deleteReturn(<?php echo e($return->id); ?>)"
                                                                title="Supprimer">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <?php echo e($returns->withQueryString()->links()); ?>

                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-undo fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucune demande de retour trouvée</h5>
                            <p class="text-muted">Les demandes de retour des vendeurs apparaîtront ici.</p>
                        </div>
                    <?php endif; ?>
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

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\returns\index.blade.php ENDPATH**/ ?>