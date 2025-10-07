

<?php $__env->startSection('title', 'Commande #' . $order->order_number); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Commande #<?php echo e($order->order_number); ?></h1>
                <div>
                    <?php
                        $statusClass = [
                            'pending' => 'warning',
                            'confirmed' => 'info',
                            'processing' => 'primary',
                            'shipped' => 'secondary',
                            'delivered' => 'success',
                            'cancelled' => 'danger'
                        ][$order->status] ?? 'secondary';

                        $statusText = [
                            'pending' => 'En attente',
                            'confirmed' => 'Confirmée',
                            'processing' => 'En traitement',
                            'shipped' => 'Expédiée',
                            'delivered' => 'Livrée',
                            'cancelled' => 'Annulée'
                        ][$order->status] ?? ucfirst($order->status);
                    ?>
                    <span class="badge bg-<?php echo e($statusClass); ?> fs-6 me-2"><?php echo e($statusText); ?></span>
                    <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-outline-secondary">
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
            <!-- Informations de la commande -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Détails de la Commande</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Numéro de Commande</label>
                                <div class="fw-bold"><?php echo e($order->order_number); ?></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Date de Commande</label>
                                <div><?php echo e($order->created_at->format('d/m/Y à H:i')); ?></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Statut</label>
                                <div>
                                    <span class="badge bg-<?php echo e($statusClass); ?>"><?php echo e($statusText); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Montant Total</label>
                                <div class="fw-bold text-success fs-4"><?php echo e(number_format($order->total_amount, 2)); ?> MAD</div>
                            </div>

                            <?php if($order->notes): ?>
                            <div class="mb-3">
                                <label class="form-label text-muted">Notes</label>
                                <div class="border rounded p-2 bg-light"><?php echo e($order->notes); ?></div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations client -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informations Client</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Nom</label>
                                <div class="fw-bold"><?php echo e($order->user->name); ?></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Email</label>
                                <div><?php echo e($order->user->email); ?></div>
                            </div>

                            <?php if($order->user->company_name): ?>
                            <div class="mb-3">
                                <label class="form-label text-muted">Entreprise</label>
                                <div><?php echo e($order->user->company_name); ?></div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <?php if($order->user->phone): ?>
                            <div class="mb-3">
                                <label class="form-label text-muted">Téléphone</label>
                                <div><?php echo e($order->user->phone); ?></div>
                            </div>
                            <?php endif; ?>

                            <?php if($order->user->address): ?>
                            <div class="mb-3">
                                <label class="form-label text-muted">Adresse</label>
                                <div>
                                    <?php echo e($order->user->address); ?>

                                    <?php if($order->user->city): ?>
                                        <br><?php echo e($order->user->city); ?>

                                        <?php if($order->user->postal_code): ?>
                                            <?php echo e($order->user->postal_code); ?>

                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Articles commandés -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Articles Commandés (<?php echo e($order->items->count()); ?>)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead class="table-light">
                                <tr>
                                    <th>Produit</th>
                                    <th width="100" class="text-center">Quantité</th>
                                    <th width="120" class="text-end">Prix Unitaire</th>
                                    <th width="120" class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div>
                                                <strong><?php echo e($item->product->name); ?></strong>
                                                <div class="small text-muted">SKU: <?php echo e($item->product->sku); ?></div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark"><?php echo e($item->quantity); ?></span>
                                        </td>
                                        <td class="text-end"><?php echo e(number_format($item->price, 2)); ?> MAD</td>
                                        <td class="text-end fw-bold"><?php echo e(number_format($item->quantity * $item->price, 2)); ?> MAD</td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="3" class="text-end">Total de la Commande :</th>
                                    <th class="text-end text-success fs-5"><?php echo e(number_format($order->total_amount, 2)); ?> MAD</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Actions</h6>
                </div>
                <div class="card-body">
                    <?php if($order->status !== 'cancelled' && $order->status !== 'delivered'): ?>
                        <div class="d-grid gap-2 mb-3">
                            <?php if($order->status === 'pending'): ?>
                                <button type="button" class="btn btn-info update-status" data-status="confirmed">
                                    <i class="fas fa-check"></i> Confirmer la Commande
                                </button>
                            <?php endif; ?>

                            <?php if(in_array($order->status, ['pending', 'confirmed'])): ?>
                                <button type="button" class="btn btn-primary update-status" data-status="processing">
                                    <i class="fas fa-cog"></i> Mettre en Traitement
                                </button>
                            <?php endif; ?>

                            <?php if(in_array($order->status, ['confirmed', 'processing'])): ?>
                                <button type="button" class="btn btn-secondary update-status" data-status="shipped">
                                    <i class="fas fa-truck"></i> Marquer comme Expédiée
                                </button>
                            <?php endif; ?>

                            <?php if($order->status === 'shipped'): ?>
                                <button type="button" class="btn btn-success update-status" data-status="delivered">
                                    <i class="fas fa-check-circle"></i> Marquer comme Livrée
                                </button>
                            <?php endif; ?>
                        </div>

                        <hr>
                    <?php endif; ?>

                    <div class="d-grid gap-2">
                        <?php if($order->status !== 'cancelled'): ?>
                            <button type="button" class="btn btn-outline-danger update-status" data-status="cancelled">
                                <i class="fas fa-times"></i> Annuler la Commande
                            </button>
                        <?php endif; ?>

                        <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#notesModal">
                            <i class="fas fa-sticky-note"></i> Ajouter une Note
                        </button>

                        <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                            <i class="fas fa-print"></i> Imprimer
                        </button>
                    </div>
                </div>
            </div>

            <!-- Historique -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Historique</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-0">Commande créée</h6>
                                <small class="text-muted"><?php echo e($order->created_at->format('d/m/Y à H:i')); ?></small>
                            </div>
                        </div>

                        <?php if($order->updated_at != $order->created_at): ?>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="mb-0">Dernière mise à jour</h6>
                                <small class="text-muted"><?php echo e($order->updated_at->format('d/m/Y à H:i')); ?></small>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour ajouter des notes -->
<div class="modal fade" id="notesModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter une Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="notesForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="notes" class="form-label">Note</label>
                        <textarea class="form-control" id="notes" name="notes" rows="4" placeholder="Ajouter une note à cette commande..."><?php echo e($order->notes); ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
}

.timeline-item:before {
    content: '';
    position: absolute;
    left: -25px;
    top: 20px;
    height: calc(100% - 20px);
    width: 2px;
    background: #e9ecef;
}

.timeline-item:last-child:before {
    display: none;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 0;
    width: 10px;
    height: 10px;
    border-radius: 50%;
}

.timeline-content h6 {
    margin-bottom: 5px;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusButtons = document.querySelectorAll('.update-status');
    const notesForm = document.getElementById('notesForm');

    statusButtons.forEach(button => {
        button.addEventListener('click', function() {
            const newStatus = this.dataset.status;
            const statusText = this.textContent.trim();

            if (confirm(`Êtes-vous sûr de vouloir ${statusText.toLowerCase()} ?`)) {
                fetch(`/admin/orders/<?php echo e($order->id); ?>/update-status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
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
        });
    });

    notesForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch(`/admin/orders/<?php echo e($order->id); ?>/add-notes`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
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
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>