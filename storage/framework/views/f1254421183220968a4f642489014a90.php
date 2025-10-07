<?php $__env->startSection('title', 'Mes Demandes de Retour'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Mes Demandes de Retour</h1>
                <a href="<?php echo e(route('returns.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouvelle Demande
                </a>
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
                            <input type="text" name="search" class="form-control" placeholder="Rechercher RMA ou produit..." value="<?php echo e(request('search')); ?>">
                        </div>
                        <div class="col-md-3">
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
                            <button type="submit" class="btn btn-outline-primary w-100">Filtrer</button>
                        </div>
                        <div class="col-md-2">
                            <a href="<?php echo e(route('returns.index')); ?>" class="btn btn-outline-secondary w-100">Reset</a>
                        </div>
                        <div class="col-md-1">
                            <a href="<?php echo e(route('returns.create')); ?>" class="btn btn-primary w-100">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </form>

                    <?php if($returns->count() > 0): ?>
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
                                    <?php $__currentLoopData = $returns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo e($return->rma_number); ?></strong>
                                                <div class="small text-muted"><?php echo e($return->created_at->format('d/m/Y H:i')); ?></div>
                                            </td>
                                            <td><?php echo e($return->created_at->format('d/m/Y')); ?></td>
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
                                                    <div class="small text-muted mt-1" title="<?php echo e($return->reason_details); ?>">
                                                        <?php echo e(Str::limit($return->reason_details, 30)); ?>

                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark"><?php echo e($return->return_type_label); ?></span>
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
                                                <?php elseif($return->status === 'refunded'): ?>
                                                    <span class="badge bg-success"><?php echo e($return->status_label); ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary"><?php echo e($return->status_label); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo e(route('returns.show', $return)); ?>"
                                                       class="btn btn-sm btn-outline-info" title="Voir détails">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <?php if($return->status === 'pending'): ?>
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
                            <p class="text-muted">Vous n'avez pas encore fait de demande de retour.</p>
                            <a href="<?php echo e(route('returns.create')); ?>" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Créer une Demande
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\returns\index.blade.php ENDPATH**/ ?>