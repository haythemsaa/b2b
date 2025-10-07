

<?php $__env->startSection('title', 'Détail Retour RMA - ' . $return->rma_number); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Détail Retour RMA</h1>
                <div>
                    <?php if($return->isPending()): ?>
                        <button class="btn btn-success" onclick="approveReturn()">
                            <i class="fas fa-check"></i> Approuver
                        </button>
                        <button class="btn btn-danger" onclick="rejectReturn()">
                            <i class="fas fa-times"></i> Refuser
                        </button>
                    <?php endif; ?>
                    <a href="<?php echo e(route('admin.returns.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
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

    <div class="row">
        <div class="col-lg-8">
            <!-- Informations générales -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Informations de la Demande</h5>
                    <?php if($return->status === 'pending'): ?>
                        <span class="badge bg-warning fs-6"><?php echo e($return->status_label); ?></span>
                    <?php elseif($return->status === 'approved'): ?>
                        <span class="badge bg-success fs-6"><?php echo e($return->status_label); ?></span>
                    <?php elseif($return->status === 'rejected'): ?>
                        <span class="badge bg-danger fs-6"><?php echo e($return->status_label); ?></span>
                    <?php elseif($return->status === 'completed'): ?>
                        <span class="badge bg-primary fs-6"><?php echo e($return->status_label); ?></span>
                    <?php else: ?>
                        <span class="badge bg-secondary fs-6"><?php echo e($return->status_label); ?></span>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Numéro RMA</label>
                                <div class="fw-bold fs-5"><?php echo e($return->rma_number); ?></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Date de demande</label>
                                <div><?php echo e($return->created_at->format('d/m/Y à H:i')); ?></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Commande associée</label>
                                <div>
                                    <a href="<?php echo e(route('admin.orders.show', $return->order)); ?>" class="text-primary">
                                        <?php echo e($return->order->order_number); ?>

                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Type de retour</label>
                                <div>
                                    <span class="badge bg-info"><?php echo e($return->return_type_label); ?></span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Raison du retour</label>
                                <div>
                                    <span class="badge bg-secondary"><?php echo e($return->reason_label); ?></span>
                                    <?php if($return->reason_details): ?>
                                        <div class="mt-2 text-muted"><?php echo e($return->reason_details); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">État du produit</label>
                                <div>
                                    <span class="badge bg-light text-dark"><?php echo e($return->condition_label); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations vendeur -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Vendeur Demandeur</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-tie fa-3x text-primary me-3"></i>
                        <div>
                            <h6 class="mb-1"><?php echo e($return->user->name); ?></h6>
                            <?php if($return->user->company_name): ?>
                                <div class="text-muted"><?php echo e($return->user->company_name); ?></div>
                            <?php endif; ?>
                            <div class="small text-muted">
                                <i class="fas fa-envelope"></i> <?php echo e($return->user->email); ?>

                                <?php if($return->user->phone): ?>
                                    | <i class="fas fa-phone"></i> <?php echo e($return->user->phone); ?>

                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations produit -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Produit Retourné</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h6><?php echo e($return->product->name); ?></h6>
                            <div class="text-muted mb-2">SKU: <?php echo e($return->product->sku); ?></div>
                            <?php if($return->product->description): ?>
                                <div class="text-muted"><?php echo e(Str::limit($return->product->description, 200)); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="mb-2">
                                <span class="badge bg-info fs-6">Quantité: <?php echo e($return->quantity_returned); ?></span>
                            </div>
                            <div class="mb-2">
                                <strong>Prix unitaire:</strong> <?php echo e(number_format($return->orderItem->unit_price, 2)); ?> MAD
                            </div>
                            <div>
                                <strong>Total:</strong> <?php echo e(number_format($return->orderItem->unit_price * $return->quantity_returned, 2)); ?> MAD
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Photos du produit -->
            <?php if($return->images && count($return->images) > 0): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Photos du Produit</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php $__currentLoopData = $return->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-3 mb-3">
                                <img src="<?php echo e(asset('storage/' . $image)); ?>"
                                     class="img-thumbnail"
                                     alt="Photo produit retourné"
                                     style="cursor: pointer;"
                                     onclick="showImageModal(this.src)">
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Historique des actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Historique</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Demande créée</h6>
                                <p class="timeline-description">
                                    <?php echo e($return->created_at->format('d/m/Y à H:i')); ?>

                                    par <?php echo e($return->user->name); ?>

                                </p>
                            </div>
                        </div>

                        <?php if($return->approved_at): ?>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Retour approuvé</h6>
                                <p class="timeline-description">
                                    <?php echo e($return->approved_at->format('d/m/Y à H:i')); ?>

                                    <?php if($return->approver): ?>
                                        par <?php echo e($return->approver->name); ?>

                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if($return->rejected_at): ?>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-danger"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Retour refusé</h6>
                                <p class="timeline-description">
                                    <?php echo e($return->rejected_at->format('d/m/Y à H:i')); ?>

                                    <?php if($return->approver): ?>
                                        par <?php echo e($return->approver->name); ?>

                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if($return->completed_at): ?>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Retour terminé</h6>
                                <p class="timeline-description">
                                    <?php echo e($return->completed_at->format('d/m/Y à H:i')); ?>

                                </p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Résumé financier -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Résumé Financier</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-12 mb-3">
                            <div class="border-bottom pb-3">
                                <h5 class="text-primary mb-0"><?php echo e(number_format($return->orderItem->unit_price * $return->quantity_returned, 2)); ?></h5>
                                <small class="text-muted">Montant total</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="pt-3">
                                <h5 class="text-success mb-0">
                                    <?php if($return->refund_amount): ?>
                                        <?php echo e(number_format($return->refund_amount, 2)); ?>

                                    <?php else: ?>
                                        <?php echo e(number_format($return->orderItem->unit_price * $return->quantity_returned, 2)); ?>

                                    <?php endif; ?>
                                </h5>
                                <small class="text-muted">Remboursement</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes administratives -->
            <?php if($return->admin_notes): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Notes Administratives</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-0">
                        <?php echo e($return->admin_notes); ?>

                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Changement de statut -->
            <?php if(in_array($return->status, ['approved', 'processing'])): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Gestion du Retour</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <?php if($return->status === 'approved'): ?>
                            <button class="btn btn-primary" onclick="updateStatus('processing')">
                                <i class="fas fa-cog"></i> Marquer en traitement
                            </button>
                        <?php endif; ?>
                        <?php if($return->status === 'processing'): ?>
                            <button class="btn btn-success" onclick="updateStatus('completed')">
                                <i class="fas fa-check-circle"></i> Marquer comme terminé
                            </button>
                            <button class="btn btn-outline-success" onclick="updateStatus('refunded')">
                                <i class="fas fa-money-bill-wave"></i> Marquer comme remboursé
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Actions -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Actions</h6>
                </div>
                <div class="card-body d-grid gap-2">
                    <?php if($return->isPending()): ?>
                        <button class="btn btn-success" onclick="approveReturn()">
                            <i class="fas fa-check"></i> Approuver
                        </button>
                        <button class="btn btn-danger" onclick="rejectReturn()">
                            <i class="fas fa-times"></i> Refuser
                        </button>
                    <?php endif; ?>

                    <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                        <i class="fas fa-print"></i> Imprimer
                    </button>

                    <?php if(in_array($return->status, ['pending', 'rejected'])): ?>
                        <button class="btn btn-outline-danger" onclick="deleteReturn()">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
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
                        <label class="form-label">Montant du remboursement</label>
                        <input type="number"
                               name="refund_amount"
                               class="form-control"
                               step="0.01"
                               min="0"
                               max="<?php echo e($return->orderItem->unit_price * $return->quantity_returned); ?>"
                               value="<?php echo e($return->orderItem->unit_price * $return->quantity_returned); ?>">
                        <div class="form-text">Montant maximum: <?php echo e(number_format($return->orderItem->unit_price * $return->quantity_returned, 2)); ?> MAD</div>
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
                        <div class="form-text">Expliquez clairement pourquoi cette demande est refusée</div>
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

<!-- Modal d'affichage d'image -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Photo du produit retourné</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" alt="Photo produit">
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -37px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 0 0 3px #dee2e6;
}

.timeline-title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 5px;
}

.timeline-description {
    color: #6c757d;
    margin-bottom: 0;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function approveReturn() {
    new bootstrap.Modal(document.getElementById('approveModal')).show();
}

function rejectReturn() {
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}

function showImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}

// Gestion du formulaire d'approbation
document.getElementById('approveForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch(`/admin/returns/<?php echo e($return->id); ?>/approve`, {
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

    fetch(`/admin/returns/<?php echo e($return->id); ?>/reject`, {
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

function updateStatus(status) {
    let confirmMessage = '';
    switch (status) {
        case 'processing':
            confirmMessage = 'Marquer ce retour comme en traitement ?';
            break;
        case 'completed':
            confirmMessage = 'Marquer ce retour comme terminé ?';
            break;
        case 'refunded':
            confirmMessage = 'Marquer ce retour comme remboursé ?';
            break;
    }

    if (confirm(confirmMessage)) {
        fetch(`/admin/returns/<?php echo e($return->id); ?>/update-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status: status
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

function deleteReturn() {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette demande de retour ?\n\nCette action est irréversible.')) {
        fetch(`/admin/returns/<?php echo e($return->id); ?>`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                window.location.href = '<?php echo e(route("admin.returns.index")); ?>';
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
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\returns\show.blade.php ENDPATH**/ ?>