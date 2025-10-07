<?php $__env->startSection('title', 'Gestion des Devises'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">
                <i class="fas fa-money-bill-wave text-primary"></i> Gestion des Devises
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Devises</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="<?php echo e(route('admin.exchange-rates.index')); ?>" class="btn btn-info me-2">
                <i class="fas fa-exchange-alt"></i> Taux de Change
            </a>
            <a href="<?php echo e(route('admin.currencies.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nouvelle Devise
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Devises</h6>
                            <h2 class="mb-0"><?php echo e($stats['total']); ?></h2>
                        </div>
                        <i class="fas fa-coins fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Devises Actives</h6>
                            <h2 class="mb-0"><?php echo e($stats['active']); ?></h2>
                        </div>
                        <i class="fas fa-check-circle fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Devise par Défaut</h6>
                            <h2 class="mb-0"><?php echo e($stats['default'] ? $stats['default']->code : 'N/A'); ?></h2>
                        </div>
                        <i class="fas fa-star fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des devises -->
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">
                <i class="fas fa-list"></i> Liste des Devises (<?php echo e($currencies->count()); ?>)
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Nom</th>
                            <th>Symbole</th>
                            <th>Décimales</th>
                            <th>Format</th>
                            <th>Position</th>
                            <th>Statut</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($currency->id); ?></td>
                                <td>
                                    <strong><?php echo e($currency->code); ?></strong>
                                    <?php if($currency->is_default): ?>
                                        <span class="badge bg-warning text-dark ms-1">
                                            <i class="fas fa-star"></i> Défaut
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($currency->name); ?></td>
                                <td><span class="badge bg-info"><?php echo e($currency->symbol); ?></span></td>
                                <td><?php echo e($currency->decimal_places); ?></td>
                                <td><code><?php echo e($currency->format); ?></code></td>
                                <td><?php echo e($currency->position); ?></td>
                                <td>
                                    <form action="<?php echo e(route('admin.currencies.toggle-active', $currency)); ?>"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Confirmer le changement de statut ?')">
                                        <?php echo csrf_field(); ?>
                                        <?php if($currency->is_active): ?>
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-check"></i> Actif
                                            </button>
                                        <?php else: ?>
                                            <button type="submit" class="btn btn-sm btn-secondary">
                                                <i class="fas fa-times"></i> Inactif
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo e(route('admin.currencies.show', $currency)); ?>"
                                           class="btn btn-sm btn-info"
                                           title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.currencies.edit', $currency)); ?>"
                                           class="btn btn-sm btn-warning"
                                           title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if (! ($currency->is_default)): ?>
                                            <form action="<?php echo e(route('admin.currencies.set-default', $currency)); ?>"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Définir <?php echo e($currency->code); ?> comme devise par défaut ?')">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-primary" title="Définir par défaut">
                                                    <i class="fas fa-star"></i>
                                                </button>
                                            </form>
                                            <form action="<?php echo e(route('admin.currencies.destroy', $currency)); ?>"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Supprimer cette devise ?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Aucune devise trouvée.</p>
                                    <a href="<?php echo e(route('admin.currencies.create')); ?>" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Ajouter une devise
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\currencies\index.blade.php ENDPATH**/ ?>