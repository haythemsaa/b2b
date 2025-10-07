<?php $__env->startSection('title', 'Tenant - ' . $tenant->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><?php echo e($tenant->name); ?>

                    <?php if($tenant->trashed()): ?>
                        <span class="badge bg-danger ms-2">Supprimé</span>
                    <?php elseif($tenant->is_active): ?>
                        <span class="badge bg-success ms-2">Actif</span>
                    <?php else: ?>
                        <span class="badge bg-warning ms-2">Suspendu</span>
                    <?php endif; ?>
                </h1>
                <div class="btn-group">
                    <?php if(!$tenant->trashed()): ?>
                        <a href="<?php echo e(route('superadmin.tenants.edit', $tenant)); ?>" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> Modifier
                        </a>
                        <?php if($tenant->is_active): ?>
                            <button type="button" class="btn btn-warning"
                                    onclick="suspendTenant(<?php echo e($tenant->id); ?>)">
                                <i class="bi bi-pause"></i> Suspendre
                            </button>
                        <?php else: ?>
                            <button type="button" class="btn btn-success"
                                    onclick="activateTenant(<?php echo e($tenant->id); ?>)">
                                <i class="bi bi-play"></i> Activer
                            </button>
                        <?php endif; ?>
                    <?php else: ?>
                        <button type="button" class="btn btn-success"
                                onclick="restoreTenant(<?php echo e($tenant->id); ?>)">
                            <i class="bi bi-arrow-clockwise"></i> Restaurer
                        </button>
                    <?php endif; ?>
                    <a href="<?php echo e(route('superadmin.tenants.index')); ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>Utilisateurs</h5>
                            <h2><?php echo e($stats['users_count']); ?>/<?php echo e($tenant->max_users); ?></h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-people fs-1"></i>
                        </div>
                    </div>
                    <div class="progress mt-2" style="height: 5px;">
                        <div class="progress-bar bg-light" role="progressbar"
                             style="width: <?php echo e($stats['quota_users_used']); ?>%"
                             aria-valuenow="<?php echo e($stats['quota_users_used']); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small><?php echo e($stats['quota_users_used']); ?>% utilisé</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>Produits</h5>
                            <h2><?php echo e($stats['products_count']); ?>/<?php echo e($tenant->max_products); ?></h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-box fs-1"></i>
                        </div>
                    </div>
                    <div class="progress mt-2" style="height: 5px;">
                        <div class="progress-bar bg-light" role="progressbar"
                             style="width: <?php echo e($stats['quota_products_used']); ?>%"
                             aria-valuenow="<?php echo e($stats['quota_products_used']); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small><?php echo e($stats['quota_products_used']); ?>% utilisé</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>Commandes</h5>
                            <h2><?php echo e($stats['orders_count'] ?? 0); ?></h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-cart fs-1"></i>
                        </div>
                    </div>
                    <small>Total des commandes</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>Revenus</h5>
                            <h2><?php echo e(number_format($tenant->monthly_fee, 2)); ?>€</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-currency-euro fs-1"></i>
                        </div>
                    </div>
                    <small>Par mois</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Informations générales -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informations Générales</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <th>Nom:</th>
                                <td><?php echo e($tenant->name); ?></td>
                            </tr>
                            <tr>
                                <th>Slug:</th>
                                <td><code><?php echo e($tenant->slug); ?></code></td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>
                                    <a href="mailto:<?php echo e($tenant->email); ?>"><?php echo e($tenant->email); ?></a>
                                </td>
                            </tr>
                            <tr>
                                <th>Téléphone:</th>
                                <td><?php echo e($tenant->phone ?: 'Non renseigné'); ?></td>
                            </tr>
                            <tr>
                                <th>Domaine:</th>
                                <td>
                                    <?php if($tenant->domain): ?>
                                        <a href="https://<?php echo e($tenant->domain); ?>" target="_blank"><?php echo e($tenant->domain); ?></a>
                                    <?php else: ?>
                                        Non configuré
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Adresse:</th>
                                <td><?php echo e($tenant->address ?: 'Non renseignée'); ?></td>
                            </tr>
                            <tr>
                                <th>Ville:</th>
                                <td><?php echo e($tenant->city ?: 'Non renseignée'); ?></td>
                            </tr>
                            <tr>
                                <th>Pays:</th>
                                <td><?php echo e($tenant->country); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modules activés -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Modules Activés</h5>
                </div>
                <div class="card-body">
                    <?php
                        $modules = [
                            'chat' => 'Chat en temps réel',
                            'analytics' => 'Analytics avancés',
                            'api' => 'Accès API',
                            'custom_reports' => 'Rapports personnalisés'
                        ];
                        $enabledModules = $tenant->enabled_modules ?? [];
                    ?>

                    <?php if(empty($enabledModules)): ?>
                        <p class="text-muted">Aucun module activé</p>
                    <?php else: ?>
                        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(in_array($key, $enabledModules)): ?>
                                <span class="badge bg-success me-1 mb-1"><?php echo e($name); ?></span>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Configuration & Plan -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Configuration & Plan</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <th>Plan:</th>
                                <td>
                                    <span class="badge bg-<?php echo e($tenant->plan === 'enterprise' ? 'success' : ($tenant->plan === 'pro' ? 'primary' : 'secondary')); ?>">
                                        <?php echo e(ucfirst($tenant->plan)); ?>

                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Max Utilisateurs:</th>
                                <td><?php echo e($tenant->max_users); ?></td>
                            </tr>
                            <tr>
                                <th>Max Produits:</th>
                                <td><?php echo e($tenant->max_products); ?></td>
                            </tr>
                            <tr>
                                <th>Tarif Mensuel:</th>
                                <td><strong><?php echo e(number_format($tenant->monthly_fee, 2)); ?>€</strong></td>
                            </tr>
                            <tr>
                                <th>Période d'essai:</th>
                                <td>
                                    <?php if($tenant->trial_ends_at): ?>
                                        <?php echo e($tenant->trial_ends_at->format('d/m/Y')); ?>

                                        <?php if($tenant->trial_ends_at->isFuture()): ?>
                                            <span class="badge bg-info">En cours</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Terminée</span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        Pas de période d'essai
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Créé le:</th>
                                <td><?php echo e($tenant->created_at->format('d/m/Y H:i')); ?></td>
                            </tr>
                            <tr>
                                <th>Dernière connexion:</th>
                                <td>
                                    <?php if($stats['last_login']): ?>
                                        <?php echo e($stats['last_login']->diffForHumans()); ?>

                                    <?php else: ?>
                                        Jamais
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Actions Rapides</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <?php if($tenant->domain): ?>
                            <a href="https://<?php echo e($tenant->domain); ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-box-arrow-up-right"></i> Visiter le site
                            </a>
                        <?php endif; ?>
                        <a href="/t/<?php echo e($tenant->slug); ?>" target="_blank" class="btn btn-outline-info btn-sm">
                            <i class="bi bi-box-arrow-up-right"></i> Interface Tenant
                        </a>
                        <button class="btn btn-outline-danger btn-sm" onclick="deleteTenant(<?php echo e($tenant->id); ?>)">
                            <i class="bi bi-trash"></i> Supprimer le tenant
                        </button>
                    </div>
                </div>
            </div>
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

<form id="deleteForm" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function suspendTenant(tenantId) {
    if (confirm('Êtes-vous sûr de vouloir suspendre ce tenant ? Ses utilisateurs ne pourront plus accéder à la plateforme.')) {
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

function deleteTenant(tenantId) {
    if (confirm('⚠️ ATTENTION : Cette action supprimera définitivement le tenant et toutes ses données.\n\nTapez "SUPPRIMER" pour confirmer :')) {
        const confirmation = prompt('Tapez "SUPPRIMER" pour confirmer la suppression :');
        if (confirmation === 'SUPPRIMER') {
            const form = document.getElementById('deleteForm');
            form.action = `/superadmin/tenants/${tenantId}`;
            form.submit();
        }
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\superadmin\tenants\show.blade.php ENDPATH**/ ?>