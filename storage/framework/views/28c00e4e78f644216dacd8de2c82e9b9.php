<?php $__env->startSection('title', 'Tableau de Bord Super-Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header avec actions rapides -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Tableau de Bord Super-Admin</h1>
                <div class="btn-group">
                    <a href="<?php echo e(route('superadmin.tenants.create')); ?>" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Nouveau Tenant
                    </a>
                    <a href="<?php echo e(route('superadmin.tenants.index')); ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-building"></i> Gérer Tenants
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertes système -->
    <?php if(!empty($alerts)): ?>
    <div class="row mb-4">
        <div class="col-12">
            <?php $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="alert alert-<?php echo e($alert['type'] === 'warning' ? 'warning' : 'info'); ?> alert-dismissible fade show" role="alert">
                <i class="bi bi-<?php echo e($alert['type'] === 'warning' ? 'exclamation-triangle' : 'info-circle'); ?>"></i>
                <?php echo e($alert['message']); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Métriques principales -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <i class="bi bi-building fs-1 mb-2"></i>
                    <h3><?php echo e($totalTenants); ?></h3>
                    <p class="mb-0">Total Tenants</p>
                    <?php if($tenantGrowth > 0): ?>
                        <small class="badge bg-success">+<?php echo e($tenantGrowth); ?> ce mois</small>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <i class="bi bi-check-circle fs-1 mb-2"></i>
                    <h3><?php echo e($activeTenants); ?></h3>
                    <p class="mb-0">Tenants Actifs</p>
                    <small><?php echo e(round(($activeTenants / max($totalTenants, 1)) * 100, 1)); ?>% actifs</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <i class="bi bi-people fs-1 mb-2"></i>
                    <h3><?php echo e($totalUsers); ?></h3>
                    <p class="mb-0">Total Utilisateurs</p>
                    <small><?php echo e(round($totalUsers / max($totalTenants, 1), 1)); ?> par tenant</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <i class="bi bi-box fs-1 mb-2"></i>
                    <h3><?php echo e(number_format($totalProducts)); ?></h3>
                    <p class="mb-0">Total Produits</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-secondary text-white">
                <div class="card-body text-center">
                    <i class="bi bi-cart fs-1 mb-2"></i>
                    <h3><?php echo e(number_format($totalOrders)); ?></h3>
                    <p class="mb-0">Total Commandes</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <i class="bi bi-currency-euro fs-1 mb-2"></i>
                    <h3><?php echo e(number_format($monthlyRevenue, 0)); ?>€</h3>
                    <p class="mb-0">Revenus/Mois</p>
                    <small><?php echo e(number_format($monthlyRevenue * 12, 0)); ?>€ annuel</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Graphique des revenus -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Évolution des Revenus (12 derniers mois)</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <!-- Répartition par plan -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Répartition par Plan</h5>
                </div>
                <div class="card-body">
                    <?php $__currentLoopData = $planStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="mb-0"><?php echo e(ucfirst($plan->plan)); ?></h6>
                            <small class="text-muted"><?php echo e($plan->count); ?> tenant(s)</small>
                        </div>
                        <div class="text-end">
                            <strong><?php echo e(number_format($plan->revenue, 0)); ?>€</strong>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Top tenants -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Top 5 Tenants (Revenus)</h5>
                </div>
                <div class="card-body">
                    <?php $__empty_1 = true; $__currentLoopData = $topTenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tenant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div>
                            <h6 class="mb-1"><?php echo e($tenant->name); ?></h6>
                            <small class="text-muted">
                                <?php echo e($tenant->users_count); ?> utilisateurs • <?php echo e($tenant->products_count); ?> produits
                            </small>
                        </div>
                        <div class="text-end">
                            <strong><?php echo e(number_format($tenant->monthly_fee, 0)); ?>€/mois</strong>
                            <br>
                            <span class="badge bg-<?php echo e($tenant->plan === 'enterprise' ? 'success' : ($tenant->plan === 'pro' ? 'primary' : 'secondary')); ?>">
                                <?php echo e(ucfirst($tenant->plan)); ?>

                            </span>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-muted">Aucun tenant trouvé</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Utilisation des quotas -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Utilisation Moyenne des Quotas</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Utilisateurs</span>
                            <span><?php echo e(number_format($quotaStats['users_avg'] ?? 0, 1)); ?>%</span>
                        </div>
                        <div class="progress mb-2">
                            <div class="progress-bar bg-primary" role="progressbar"
                                 style="width: <?php echo e($quotaStats['users_avg'] ?? 0); ?>%"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Produits</span>
                            <span><?php echo e(number_format($quotaStats['products_avg'] ?? 0, 1)); ?>%</span>
                        </div>
                        <div class="progress mb-2">
                            <div class="progress-bar bg-warning" role="progressbar"
                                 style="width: <?php echo e($quotaStats['products_avg'] ?? 0); ?>%"></div>
                        </div>
                    </div>

                    <div class="row text-center">
                        <div class="col-6">
                            <h5 class="text-primary"><?php echo e($activeTenants); ?></h5>
                            <small class="text-muted">Tenants Actifs</small>
                        </div>
                        <div class="col-6">
                            <h5 class="text-success"><?php echo e(number_format(($activeTenants / max($totalTenants, 1)) * 100, 1)); ?>%</h5>
                            <small class="text-muted">Taux d'Activité</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tenants récents -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Tenants Récents</h5>
                    <a href="<?php echo e(route('superadmin.tenants.index')); ?>" class="btn btn-sm btn-outline-primary">Voir tout</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Plan</th>
                                    <th>Utilisateurs</th>
                                    <th>Revenus</th>
                                    <th>Créé le</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $recentTenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tenant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <strong><?php echo e($tenant->name); ?></strong><br>
                                        <small class="text-muted"><?php echo e($tenant->email); ?></small>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo e($tenant->plan === 'enterprise' ? 'success' : ($tenant->plan === 'pro' ? 'primary' : 'secondary')); ?>">
                                            <?php echo e(ucfirst($tenant->plan)); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($tenant->users->count()); ?>/<?php echo e($tenant->max_users); ?></td>
                                    <td><?php echo e(number_format($tenant->monthly_fee, 0)); ?>€/mois</td>
                                    <td><?php echo e($tenant->created_at->diffForHumans()); ?></td>
                                    <td>
                                        <?php if($tenant->is_active): ?>
                                            <span class="badge bg-success">Actif</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Suspendu</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('superadmin.tenants.show', $tenant)); ?>"
                                           class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center">Aucun tenant trouvé</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Graphique des revenus
const ctx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode(collect($revenueChart)->pluck('month')); ?>,
        datasets: [{
            label: 'Revenus Mensuels (€)',
            data: <?php echo json_encode(collect($revenueChart)->pluck('revenue')); ?>,
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return value + '€';
                    }
                }
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        }
    }
});

// Auto-refresh des données toutes les 5 minutes
setInterval(function() {
    location.reload();
}, 300000);
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\superadmin\dashboard.blade.php ENDPATH**/ ?>