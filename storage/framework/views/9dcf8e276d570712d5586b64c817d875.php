

<?php $__env->startSection('title', 'Gestion des Commandes'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Gestion des Commandes</h1>
                <div>
                    <span class="badge bg-info"><?php echo e($orders->total()); ?> commandes</span>
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
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Liste des Commandes</h5>
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3 mb-4">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="N° commande ou nom client..." value="<?php echo e(request('search')); ?>">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>En attente</option>
                                <option value="confirmed" <?php echo e(request('status') === 'confirmed' ? 'selected' : ''); ?>>Confirmée</option>
                                <option value="processing" <?php echo e(request('status') === 'processing' ? 'selected' : ''); ?>>En traitement</option>
                                <option value="shipped" <?php echo e(request('status') === 'shipped' ? 'selected' : ''); ?>>Expédiée</option>
                                <option value="delivered" <?php echo e(request('status') === 'delivered' ? 'selected' : ''); ?>>Livrée</option>
                                <option value="cancelled" <?php echo e(request('status') === 'cancelled' ? 'selected' : ''); ?>>Annulée</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-outline-primary w-100">Filtrer</button>
                        </div>
                        <div class="col-md-2">
                            <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-outline-secondary w-100">Reset</a>
                        </div>
                    </form>

                    <?php if($orders->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>N° Commande</th>
                                        <th>Client</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Statut</th>
                                        <th width="120">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <strong class="text-primary"><?php echo e($order->order_number); ?></strong>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong><?php echo e($order->user->name); ?></strong>
                                                    <div class="small text-muted">
                                                        <?php echo e($order->user->company_name ?: $order->user->email); ?>

                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div><?php echo e($order->created_at->format('d/m/Y')); ?></div>
                                                <div class="small text-muted"><?php echo e($order->created_at->format('H:i')); ?></div>
                                            </td>
                                            <td>
                                                <strong><?php echo e(number_format($order->total_amount, 2)); ?> MAD</strong>
                                            </td>
                                            <td>
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
                                                <span class="badge bg-<?php echo e($statusClass); ?>"><?php echo e($statusText); ?></span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo e(route('admin.orders.show', $order->order_number)); ?>"
                                                       class="btn btn-sm btn-outline-info" title="Voir détails">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                                type="button" data-bs-toggle="dropdown" title="Changer statut">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <?php if($order->status !== 'cancelled'): ?>
                                                                <li><a class="dropdown-item update-status"
                                                                       data-order-id="<?php echo e($order->id); ?>"
                                                                       data-status="confirmed" href="#">
                                                                    <i class="fas fa-check text-info"></i> Confirmer
                                                                </a></li>
                                                                <li><a class="dropdown-item update-status"
                                                                       data-order-id="<?php echo e($order->id); ?>"
                                                                       data-status="processing" href="#">
                                                                    <i class="fas fa-cog text-primary"></i> En traitement
                                                                </a></li>
                                                                <li><a class="dropdown-item update-status"
                                                                       data-order-id="<?php echo e($order->id); ?>"
                                                                       data-status="shipped" href="#">
                                                                    <i class="fas fa-truck text-secondary"></i> Expédier
                                                                </a></li>
                                                                <li><a class="dropdown-item update-status"
                                                                       data-order-id="<?php echo e($order->id); ?>"
                                                                       data-status="delivered" href="#">
                                                                    <i class="fas fa-check-circle text-success"></i> Livrer
                                                                </a></li>
                                                                <li><hr class="dropdown-divider"></li>
                                                            <?php endif; ?>
                                                            <li><a class="dropdown-item update-status"
                                                                   data-order-id="<?php echo e($order->id); ?>"
                                                                   data-status="cancelled" href="#">
                                                                <i class="fas fa-times text-danger"></i> Annuler
                                                            </a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <?php echo e($orders->withQueryString()->links()); ?>

                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucune commande trouvée</h5>
                            <?php if(request()->filled('search') || request()->filled('status')): ?>
                                <p class="text-muted">Aucun résultat pour les critères sélectionnés.</p>
                                <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-outline-primary">
                                    Voir toutes les commandes
                                </a>
                            <?php else: ?>
                                <p class="text-muted">Les commandes des vendeurs apparaîtront ici.</p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusButtons = document.querySelectorAll('.update-status');

    statusButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const orderId = this.dataset.orderId;
            const newStatus = this.dataset.status;
            const statusText = this.textContent.trim();

            if (confirm(`Êtes-vous sûr de vouloir changer le statut de cette commande ?`)) {
                fetch(`/admin/orders/${orderId}/update-status`, {
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
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\orders\index.blade.php ENDPATH**/ ?>