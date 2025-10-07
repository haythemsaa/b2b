<?php $__env->startSection('title', 'Gestion des Tenants - Super Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Gestion des Tenants</h1>
                <a href="<?php echo e(route('superadmin.tenants.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Nouveau Tenant
                </a>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5>Total Tenants</h5>
                    <h2><?php echo e($stats['total_tenants']); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5>Tenants Actifs</h5>
                    <h2><?php echo e($stats['active_tenants']); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5>Revenus Mensuels</h5>
                    <h2><?php echo e(number_format($stats['monthly_revenue'], 2)); ?>€</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5>Total Utilisateurs</h5>
                    <h2><?php echo e($stats['total_users']); ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search"
                           placeholder="Rechercher..." value="<?php echo e(request('search')); ?>">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="plan">
                        <option value="">Tous les plans</option>
                        <option value="starter" <?php echo e(request('plan') === 'starter' ? 'selected' : ''); ?>>Starter</option>
                        <option value="pro" <?php echo e(request('plan') === 'pro' ? 'selected' : ''); ?>>Pro</option>
                        <option value="enterprise" <?php echo e(request('plan') === 'enterprise' ? 'selected' : ''); ?>>Enterprise</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="">Tous les statuts</option>
                        <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Actif</option>
                        <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactif</option>
                        <option value="deleted" <?php echo e(request('status') === 'deleted' ? 'selected' : ''); ?>>Supprimé</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-search"></i> Filtrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des tenants -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Plan</th>
                            <th>Statut</th>
                            <th>Utilisateurs</th>
                            <th>Produits</th>
                            <th>Revenus</th>
                            <th>Créé le</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $tenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tenant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="<?php echo e($tenant->trashed() ? 'table-secondary' : ''); ?>">
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php if($tenant->logo_url): ?>
                                        <img src="<?php echo e($tenant->logo_url); ?>" alt="Logo"
                                             class="rounded me-2" width="30" height="30">
                                    <?php endif; ?>
                                    <div>
                                        <strong><?php echo e($tenant->name); ?></strong><br>
                                        <small class="text-muted"><?php echo e($tenant->slug); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo e($tenant->email); ?></td>
                            <td>
                                <span class="badge bg-<?php echo e($tenant->plan === 'enterprise' ? 'success' : ($tenant->plan === 'pro' ? 'primary' : 'secondary')); ?>">
                                    <?php echo e(ucfirst($tenant->plan)); ?>

                                </span>
                            </td>
                            <td>
                                <?php if($tenant->trashed()): ?>
                                    <span class="badge bg-danger">Supprimé</span>
                                <?php elseif($tenant->is_active): ?>
                                    <span class="badge bg-success">Actif</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Suspendu</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($tenant->users_count ?? 0); ?>/<?php echo e($tenant->max_users); ?></td>
                            <td><?php echo e($tenant->products_count ?? 0); ?>/<?php echo e($tenant->max_products); ?></td>
                            <td><?php echo e(number_format($tenant->monthly_fee, 2)); ?>€/mois</td>
                            <td><?php echo e($tenant->created_at->format('d/m/Y')); ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="<?php echo e(route('superadmin.tenants.show', $tenant)); ?>"
                                       class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <?php if(!$tenant->trashed()): ?>
                                        <a href="<?php echo e(route('superadmin.tenants.edit', $tenant)); ?>"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <?php if($tenant->is_active): ?>
                                            <button type="button" class="btn btn-sm btn-outline-warning"
                                                    onclick="suspendTenant(<?php echo e($tenant->id); ?>)">
                                                <i class="bi bi-pause"></i>
                                            </button>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-sm btn-outline-success"
                                                    onclick="activateTenant(<?php echo e($tenant->id); ?>)">
                                                <i class="bi bi-play"></i>
                                            </button>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-sm btn-outline-success"
                                                onclick="restoreTenant(<?php echo e($tenant->id); ?>)">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9" class="text-center">Aucun tenant trouvé</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php echo e($tenants->links()); ?>

        </div>
    </div>
</div>

<!-- Formulaires cachés pour les actions -->
<form id="suspendForm" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PATCH'); ?>
</form>

<form id="activateForm" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PATCH'); ?>
</form>

<form id="restoreForm" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PATCH'); ?>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function suspendTenant(tenantId) {
    if (confirm('Êtes-vous sûr de vouloir suspendre ce tenant ?')) {
        const form = document.getElementById('suspendForm');
        form.action = `/superadmin/tenants/${tenantId}/suspend`;
        form.submit();
    }
}

function activateTenant(tenantId) {
    if (confirm('Êtes-vous sûr de vouloir activer ce tenant ?')) {
        const form = document.getElementById('activateForm');
        form.action = `/superadmin/tenants/${tenantId}/activate`;
        form.submit();
    }
}

function restoreTenant(tenantId) {
    if (confirm('Êtes-vous sûr de vouloir restaurer ce tenant ?')) {
        const form = document.getElementById('restoreForm');
        form.action = `/superadmin/tenants/${tenantId}/restore`;
        form.submit();
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\superadmin\tenants\index.blade.php ENDPATH**/ ?>