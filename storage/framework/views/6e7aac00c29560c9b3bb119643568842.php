<?php $__env->startSection('title', 'Rapport Clients'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="bi bi-people me-2 text-info"></i>
                Rapport Clients
            </h1>
            <p class="text-muted">Analyse de votre clientèle et performance</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?php echo e(route('admin.reports.export', 'customers')); ?>" class="btn btn-success">
                <i class="bi bi-download me-2"></i>Exporter CSV
            </a>
            <a href="<?php echo e(route('admin.reports.index')); ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Retour
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="text-white-50">Total Clients</h6>
                    <h2 class="mb-0"><?php echo e($totalCustomers); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="text-white-50">Clients Actifs</h6>
                    <h2 class="mb-0"><?php echo e($activeCustomers); ?></h2>
                    <small class="text-white-50"><?php echo e(number_format(($activeCustomers / max($totalCustomers, 1)) * 100, 1)); ?>%</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="text-white-50">Nouveaux Clients (30j)</h6>
                    <h2 class="mb-0"><?php echo e($newCustomers); ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Customers -->
    <?php if($topCustomers->count() > 0): ?>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-trophy text-warning me-2"></i>
                        Top 20 Clients par Chiffre d'Affaires
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Client</th>
                                    <th>Email</th>
                                    <th>Commandes</th>
                                    <th>CA Total</th>
                                    <th>Panier Moyen</th>
                                    <th>Dernière Commande</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $topCustomers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php if($index < 3): ?>
                                        <i class="bi bi-trophy-fill text-warning fs-5"></i>
                                        <?php else: ?>
                                        <?php echo e($index + 1); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td><strong><?php echo e($customer->name); ?></strong></td>
                                    <td><?php echo e($customer->email); ?></td>
                                    <td>
                                        <span class="badge bg-primary"><?php echo e($customer->orders_count); ?></span>
                                    </td>
                                    <td>
                                        <strong class="text-success"><?php echo e(number_format($customer->total_spent, 2)); ?> DT</strong>
                                    </td>
                                    <td><?php echo e(number_format($customer->average_order, 2)); ?> DT</td>
                                    <td>
                                        <?php if($customer->last_order): ?>
                                        <small><?php echo e(\Carbon\Carbon::parse($customer->last_order)->format('d/m/Y')); ?></small>
                                        <?php else: ?>
                                        <small class="text-muted">-</small>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Customers by Group -->
    <?php if($customersByGroup->count() > 0): ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-diagram-3 me-2"></i>
                        Clients par Groupe
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Groupe</th>
                                    <th>Description</th>
                                    <th>Nombre de Clients</th>
                                    <th>Statut</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $customersByGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><strong><?php echo e($group->name); ?></strong></td>
                                    <td><?php echo e($group->description ?? '-'); ?></td>
                                    <td>
                                        <span class="badge bg-info"><?php echo e($group->users_count); ?> clients</span>
                                    </td>
                                    <td>
                                        <?php if($group->is_active): ?>
                                        <span class="badge bg-success">Actif</span>
                                        <?php else: ?>
                                        <span class="badge bg-secondary">Inactif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.groups.show', $group->id)); ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Voir
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- No Data -->
    <?php if($topCustomers->count() === 0 && $customersByGroup->count() === 0): ?>
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>
        Aucune donnée client disponible pour le moment.
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\reports\customers.blade.php ENDPATH**/ ?>