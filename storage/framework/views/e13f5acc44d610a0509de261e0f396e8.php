<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0"><i class="fas fa-plug"></i> Intégrations ERP/Comptabilité</h1>
            <p class="text-muted">Gérez vos connexions avec les systèmes externes</p>
        </div>
        <a href="<?php echo e(route('admin.integrations.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouvelle Intégration
        </a>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Intégrations</p>
                            <h3 class="mb-0"><?php echo e($stats['total_integrations']); ?></h3>
                        </div>
                        <div class="text-primary">
                            <i class="fas fa-plug fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Intégrations Actives</p>
                            <h3 class="mb-0 text-success"><?php echo e($stats['active_integrations']); ?></h3>
                        </div>
                        <div class="text-success">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Synchronisations</p>
                            <h3 class="mb-0"><?php echo e(number_format($stats['total_syncs'])); ?></h3>
                        </div>
                        <div class="text-info">
                            <i class="fas fa-sync fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Taux de Succès</p>
                            <h3 class="mb-0"><?php echo e($stats['success_rate']); ?>%</h3>
                        </div>
                        <div class="text-warning">
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des intégrations -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-list"></i> Liste des Intégrations</h5>
        </div>
        <div class="card-body">
            <?php if($integrations->isEmpty()): ?>
                <div class="text-center py-5">
                    <i class="fas fa-plug fa-4x text-muted mb-3"></i>
                    <p class="text-muted">Aucune intégration configurée</p>
                    <a href="<?php echo e(route('admin.integrations.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Créer la première intégration
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Type</th>
                                <th>Statut</th>
                                <th>Direction</th>
                                <th>Fréquence</th>
                                <th>Dernière Sync</th>
                                <th>Taux Succès</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $integrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $integration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <strong><?php echo e($integration->name); ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            <?php echo e($integration->getTypeName()); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo e($integration->getStatusBadge()); ?>">
                                            <?php echo e(ucfirst($integration->status)); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <i class="fas fa-arrow-<?php echo e($integration->sync_direction === 'export' ? 'up' : ($integration->sync_direction === 'import' ? 'down' : 'left-right')); ?>"></i>
                                        <?php echo e(ucfirst($integration->sync_direction)); ?>

                                    </td>
                                    <td>
                                        <i class="fas fa-clock"></i>
                                        <?php echo e(ucfirst($integration->sync_frequency)); ?>

                                    </td>
                                    <td>
                                        <?php if($integration->last_sync_at): ?>
                                            <small><?php echo e($integration->last_sync_at->diffForHumans()); ?></small>
                                        <?php else: ?>
                                            <small class="text-muted">Jamais</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                            $successRate = $integration->getSuccessRate();
                                            $badgeClass = $successRate >= 80 ? 'success' : ($successRate >= 50 ? 'warning' : 'danger');
                                        ?>
                                        <span class="badge bg-<?php echo e($badgeClass); ?>">
                                            <?php echo e($successRate); ?>%
                                        </span>
                                        <small class="text-muted d-block">
                                            <?php echo e($integration->successful_syncs); ?>/<?php echo e($integration->total_syncs); ?>

                                        </small>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('admin.integrations.show', $integration)); ?>"
                                               class="btn btn-sm btn-outline-primary" title="Détails">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <?php if($integration->canSync()): ?>
                                                <form action="<?php echo e(route('admin.integrations.sync', $integration)); ?>"
                                                      method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-success"
                                                            title="Synchroniser maintenant">
                                                        <i class="fas fa-sync"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>

                                            <form action="<?php echo e(route('admin.integrations.test', $integration)); ?>"
                                                  method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-info"
                                                        title="Tester connexion">
                                                    <i class="fas fa-vial"></i>
                                                </button>
                                            </form>

                                            <a href="<?php echo e(route('admin.integrations.edit', $integration)); ?>"
                                               class="btn btn-sm btn-outline-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="<?php echo e(route('admin.integrations.destroy', $integration)); ?>"
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette intégration ?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <?php if($integration->last_error): ?>
                                    <tr>
                                        <td colspan="8" class="bg-danger bg-opacity-10">
                                            <small class="text-danger">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                <strong>Dernière erreur:</strong> <?php echo e($integration->last_error); ?>

                                            </small>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Logs récents -->
    <?php if(!$integrations->isEmpty()): ?>
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-history"></i> Activité Récente</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Intégration</th>
                                <th>Action</th>
                                <th>Statut</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $integrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $integration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $integration->logs->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <small><strong><?php echo e($integration->name); ?></strong></small>
                                        </td>
                                        <td>
                                            <small>
                                                <i class="fas fa-<?php echo e($log->direction === 'export' ? 'arrow-up' : 'arrow-down'); ?>"></i>
                                                <?php echo e(ucfirst($log->action)); ?> <?php echo e($log->entity_type); ?>

                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php echo e($log->getStatusBadge()); ?>">
                                                <?php echo e(ucfirst($log->status)); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <small><?php echo e($log->created_at->diffForHumans()); ?></small>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\integrations\index.blade.php ENDPATH**/ ?>