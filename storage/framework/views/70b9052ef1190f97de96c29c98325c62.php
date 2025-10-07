<?php $__env->startSection('title', 'Tableau de Bord Admin'); ?>
<?php $__env->startSection('page-title', 'Tableau de Bord'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Tableau de Bord Administrateur</h1>
                <div class="text-muted"><?php echo e(now()->format('d/m/Y H:i')); ?></div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Statistiques rapides -->
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Vendeurs Actifs</h6>
                            <h3><?php echo e($stats['active_vendors'] ?? 0); ?></h3>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-people fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Commandes du Mois</h6>
                            <h3><?php echo e($stats['orders_this_month'] ?? 0); ?></h3>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-cart3 fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Produits</h6>
                            <h3><?php echo e($stats['total_products'] ?? 0); ?></h3>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-box-seam fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">CA du Mois</h6>
                            <h3><?php echo e(number_format($stats['revenue_this_month'] ?? 0)); ?>€</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-graph-up fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Commandes récentes -->
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Commandes Récentes</h5>
                    <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-sm btn-outline-primary">Voir tout</a>
                </div>
                <div class="card-body">
                    <?php if(isset($recent_orders) && $recent_orders->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>N° Commande</th>
                                        <th>Client</th>
                                        <th>Montant</th>
                                        <th>Statut</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $recent_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo e(route('admin.orders.show', $order->order_number)); ?>" class="text-decoration-none">
                                                <?php echo e($order->order_number); ?>

                                            </a>
                                        </td>
                                        <td><?php echo e($order->user->company_name ?? $order->user->name); ?></td>
                                        <td><?php echo e(number_format($order->total_amount, 2)); ?>€</td>
                                        <td>
                                            <span class="badge bg-<?php echo e($order->status === 'pending' ? 'warning' : ($order->status === 'confirmed' ? 'success' : 'secondary')); ?>">
                                                <?php echo e(ucfirst($order->status)); ?>

                                            </span>
                                        </td>
                                        <td><?php echo e($order->created_at->format('d/m/Y')); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Aucune commande récente.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Actions Rapides</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-outline-primary">
                            <i class="bi bi-person-plus"></i> Nouveau Vendeur
                        </a>
                        <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-outline-success">
                            <i class="bi bi-plus-circle"></i> Nouveau Produit
                        </a>
                        <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-outline-warning">
                            <i class="bi bi-list-check"></i> Gérer Commandes
                        </a>
                        <a href="<?php echo e(route('admin.messages.index')); ?>" class="btn btn-outline-info">
                            <i class="bi bi-chat-dots"></i> Messages
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\dashboard.blade.php ENDPATH**/ ?>