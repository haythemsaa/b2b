<?php $__env->startSection('title', 'Demande de Retour - ' . $return->rma_number); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Demande de Retour</h1>
                <div>
                    <a href="<?php echo e(route('returns.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Retour à la liste
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
            <!-- Informations principales -->
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
                    <?php elseif($return->status === 'refunded'): ?>
                        <span class="badge bg-success fs-6"><?php echo e($return->status_label); ?></span>
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
                                    <a href="<?php echo e(route('orders.show', $return->order)); ?>" class="text-primary">
                                        <?php echo e($return->order->order_number); ?>

                                    </a>
                                    <div class="small text-muted">Livrée le <?php echo e($return->order->delivered_at->format('d/m/Y')); ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Type de retour demandé</label>
                                <div>
                                    <span class="badge bg-info"><?php echo e($return->return_type_label); ?></span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Raison du retour</label>
                                <div>
                                    <span class="badge bg-secondary"><?php echo e($return->reason_label); ?></span>
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

                    <?php if($return->reason_details): ?>
                    <div class="mb-0">
                        <label class="form-label text-muted">Détails supplémentaires</label>
                        <div class="border rounded p-3 bg-light">
                            <?php echo e($return->reason_details); ?>

                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Informations produit -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Produit Retourné</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
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
                    <h5 class="card-title mb-0">Photos Jointes</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php $__currentLoopData = $return->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <img src="<?php echo e(asset('storage/' . $image)); ?>"
                                     class="img-thumbnail w-100"
                                     alt="Photo produit retourné"
                                     style="cursor: pointer; height: 200px; object-fit: cover;"
                                     onclick="showImageModal(this.src)">
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Réponse admin -->
            <?php if($return->admin_notes && in_array($return->status, ['approved', 'rejected'])): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <?php if($return->status === 'approved'): ?>
                            <i class="fas fa-check-circle text-success"></i> Réponse de l'administration
                        <?php else: ?>
                            <i class="fas fa-times-circle text-danger"></i> Réponse de l'administration
                        <?php endif; ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert <?php echo e($return->status === 'approved' ? 'alert-success' : 'alert-danger'); ?> mb-0">
                        <?php echo e($return->admin_notes); ?>

                    </div>
                    <div class="text-muted mt-2 small">
                        <?php if($return->status === 'approved' && $return->approved_at): ?>
                            Approuvé le <?php echo e($return->approved_at->format('d/m/Y à H:i')); ?>

                        <?php elseif($return->status === 'rejected' && $return->rejected_at): ?>
                            Refusé le <?php echo e($return->rejected_at->format('d/m/Y à H:i')); ?>

                        <?php endif; ?>
                        <?php if($return->approver): ?>
                            par <?php echo e($return->approver->name); ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Historique de statut -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Suivi de la Demande</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Demande créée</h6>
                                <p class="timeline-description">
                                    <?php echo e($return->created_at->format('d/m/Y à H:i')); ?>

                                    <br><span class="text-muted">Votre demande a été soumise et est en attente de traitement</span>
                                </p>
                            </div>
                        </div>

                        <?php if($return->approved_at): ?>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Demande approuvée</h6>
                                <p class="timeline-description">
                                    <?php echo e($return->approved_at->format('d/m/Y à H:i')); ?>

                                    <?php if($return->approver): ?>
                                        par <?php echo e($return->approver->name); ?>

                                    <?php endif; ?>
                                    <br><span class="text-muted">Votre demande a été acceptée</span>
                                </p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if($return->rejected_at): ?>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-danger"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Demande refusée</h6>
                                <p class="timeline-description">
                                    <?php echo e($return->rejected_at->format('d/m/Y à H:i')); ?>

                                    <?php if($return->approver): ?>
                                        par <?php echo e($return->approver->name); ?>

                                    <?php endif; ?>
                                    <br><span class="text-muted">Votre demande a été refusée</span>
                                </p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if($return->status === 'processing'): ?>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">En traitement</h6>
                                <p class="timeline-description">
                                    <span class="text-muted">Votre retour est actuellement en cours de traitement</span>
                                </p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if($return->completed_at): ?>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Retour terminé</h6>
                                <p class="timeline-description">
                                    <?php echo e($return->completed_at->format('d/m/Y à H:i')); ?>

                                    <br><span class="text-muted">Le processus de retour est terminé</span>
                                </p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if($return->status === 'refunded'): ?>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Remboursement effectué</h6>
                                <p class="timeline-description">
                                    <span class="text-muted">Le remboursement a été traité</span>
                                </p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Résumé -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Résumé</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-12 mb-3">
                            <div class="border-bottom pb-3">
                                <h4 class="text-primary mb-1"><?php echo e(number_format($return->orderItem->unit_price * $return->quantity_returned, 2)); ?></h4>
                                <small class="text-muted">Montant total</small>
                            </div>
                        </div>
                        <?php if($return->refund_amount): ?>
                        <div class="col-12">
                            <div class="pt-3">
                                <h4 class="text-success mb-1"><?php echo e(number_format($return->refund_amount, 2)); ?></h4>
                                <small class="text-muted">Remboursement accordé</small>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- État actuel -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">État Actuel</h6>
                </div>
                <div class="card-body text-center">
                    <?php if($return->status === 'pending'): ?>
                        <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                        <h6>En attente de traitement</h6>
                        <p class="text-muted mb-0">Votre demande sera examinée dans les 48h</p>
                    <?php elseif($return->status === 'approved'): ?>
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h6>Demande approuvée</h6>
                        <p class="text-muted mb-0">Votre retour a été accepté</p>
                    <?php elseif($return->status === 'rejected'): ?>
                        <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                        <h6>Demande refusée</h6>
                        <p class="text-muted mb-0">Consultez les raisons ci-dessus</p>
                    <?php elseif($return->status === 'processing'): ?>
                        <i class="fas fa-cog fa-spin fa-3x text-info mb-3"></i>
                        <h6>En cours de traitement</h6>
                        <p class="text-muted mb-0">Votre retour est en cours de traitement</p>
                    <?php elseif($return->status === 'completed'): ?>
                        <i class="fas fa-check fa-3x text-primary mb-3"></i>
                        <h6>Retour terminé</h6>
                        <p class="text-muted mb-0">Le processus est terminé</p>
                    <?php elseif($return->status === 'refunded'): ?>
                        <i class="fas fa-money-bill-wave fa-3x text-success mb-3"></i>
                        <h6>Remboursement effectué</h6>
                        <p class="text-muted mb-0">Le remboursement a été traité</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Actions</h6>
                </div>
                <div class="card-body d-grid gap-2">
                    <?php if($return->status === 'pending'): ?>
                        <button class="btn btn-outline-danger" onclick="deleteReturn()">
                            <i class="fas fa-trash"></i> Supprimer la demande
                        </button>
                    <?php endif; ?>

                    <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                        <i class="fas fa-print"></i> Imprimer
                    </button>

                    <a href="<?php echo e(route('returns.create')); ?>" class="btn btn-outline-primary">
                        <i class="fas fa-plus"></i> Nouvelle demande
                    </a>
                </div>
            </div>
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
    margin-bottom: 25px;
}

.timeline-item:last-child {
    margin-bottom: 0;
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
    font-size: 14px;
    line-height: 1.4;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function showImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}

function deleteReturn() {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette demande de retour ?\n\nCette action est irréversible.')) {
        fetch(`/returns/<?php echo e($return->id); ?>`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                window.location.href = '<?php echo e(route("returns.index")); ?>';
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
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\returns\show.blade.php ENDPATH**/ ?>