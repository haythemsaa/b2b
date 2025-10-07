<?php $__env->startSection('title', 'Analytics SuperAdmin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-chart-line me-2"></i>Analytics & Rapports
                </h1>
                <div class="btn-group">
                    <button class="btn btn-outline-primary" onclick="refreshData()">
                        <i class="fas fa-sync-alt"></i> Actualiser
                    </button>
                    <a href="<?php echo e(route('superadmin.export.analytics', ['format' => 'csv'])); ?>" class="btn btn-success">
                        <i class="fas fa-download"></i> Export CSV
                    </a>
                    <a href="<?php echo e(route('superadmin.export.analytics', ['format' => 'json'])); ?>" class="btn btn-info">
                        <i class="fas fa-download"></i> Export JSON
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Revenus Total (DT)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e(number_format(\App\Models\Order::sum('total_amount'), 2)); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Commandes Totales
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e(\App\Models\Order::count()); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Utilisateurs Actifs
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e(\App\Models\User::where('role', '!=', 'superadmin')->count()); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Produits Stock Bas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e(\App\Models\Product::where('stock_quantity', '<', 10)->count()); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-area me-2"></i>Évolution des Revenus
                    </h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                            <div class="dropdown-header">Période:</div>
                            <a class="dropdown-item" href="#" onclick="updateChart('7days')">7 derniers jours</a>
                            <a class="dropdown-item" href="#" onclick="updateChart('30days')">30 derniers jours</a>
                            <a class="dropdown-item" href="#" onclick="updateChart('6months')">6 derniers mois</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="revenueChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-pie me-2"></i>Répartition par Rôle
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="rolesChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <?php
                            $grossistes = \App\Models\User::where('role', 'grossiste')->count();
                            $vendeurs = \App\Models\User::where('role', 'vendeur')->count();
                            $total = $grossistes + $vendeurs;
                        ?>
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Grossistes: <?php echo e($grossistes); ?>

                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Vendeurs: <?php echo e($vendeurs); ?>

                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="row">
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-star me-2"></i>Top Produits
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Vendus</th>
                                    <th>Revenus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // Simulation des données - À remplacer par de vraies requêtes
                                    $topProducts = \App\Models\Product::take(5)->get();
                                ?>
                                <?php $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($product->name); ?></td>
                                    <td><?php echo e(rand(10, 100)); ?></td>
                                    <td><?php echo e(number_format($product->price * rand(10, 100), 2)); ?> DT</td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-users me-2"></i>Top Vendeurs
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Vendeur</th>
                                    <th>Commandes</th>
                                    <th>CA (DT)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $topVendeurs = \App\Models\User::where('role', 'vendeur')->take(5)->get();
                                ?>
                                <?php $__currentLoopData = $topVendeurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendeur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($vendeur->name); ?></td>
                                    <td><?php echo e($vendeur->orders()->count()); ?></td>
                                    <td><?php echo e(number_format($vendeur->orders()->sum('total_amount'), 2)); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics détaillés -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-bar me-2"></i>Statistiques Détaillées
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="border-left-info p-3">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Panier Moyen
                                </div>
                                <div class="h6 mb-0 font-weight-bold text-gray-800">
                                    <?php
                                        $orderCount = \App\Models\Order::count();
                                        $totalRevenue = \App\Models\Order::sum('total_amount');
                                        $avgOrder = $orderCount > 0 ? $totalRevenue / $orderCount : 0;
                                    ?>
                                    <?php echo e(number_format($avgOrder, 2)); ?> DT
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border-left-success p-3">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Taux de Conversion
                                </div>
                                <div class="h6 mb-0 font-weight-bold text-gray-800">
                                    <?php echo e(rand(15, 35)); ?>%
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border-left-warning p-3">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Retours
                                </div>
                                <div class="h6 mb-0 font-weight-bold text-gray-800">
                                    <?php echo e(\App\Models\ProductReturn::count()); ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border-left-danger p-3">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Taux de Retour
                                </div>
                                <div class="h6 mb-0 font-weight-bold text-gray-800">
                                    <?php
                                        $returnRate = $orderCount > 0 ? (\App\Models\ProductReturn::count() / $orderCount) * 100 : 0;
                                    ?>
                                    <?php echo e(number_format($returnRate, 1)); ?>%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
        datasets: [{
            label: 'Revenus (DT)',
            data: [
                <?php echo e(rand(5000, 15000)); ?>,
                <?php echo e(rand(5000, 15000)); ?>,
                <?php echo e(rand(5000, 15000)); ?>,
                <?php echo e(rand(5000, 15000)); ?>,
                <?php echo e(rand(5000, 15000)); ?>,
                <?php echo e(rand(5000, 15000)); ?>

            ],
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.1)',
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
                        return value.toLocaleString() + ' DT';
                    }
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

// Roles Chart
const rolesCtx = document.getElementById('rolesChart').getContext('2d');
const rolesChart = new Chart(rolesCtx, {
    type: 'doughnut',
    data: {
        labels: ['Grossistes', 'Vendeurs'],
        datasets: [{
            data: [<?php echo e($grossistes); ?>, <?php echo e($vendeurs); ?>],
            backgroundColor: ['#4e73df', '#1cc88a'],
            hoverBackgroundColor: ['#2e59d9', '#17a673'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        cutout: '80%'
    }
});

function updateChart(period) {
    // Ici vous pouvez ajouter la logique pour mettre à jour les graphiques
    console.log('Updating chart for period:', period);
}

function refreshData() {
    location.reload();
}
</script>

<style>
.border-left-primary { border-left: 0.25rem solid #4e73df !important; }
.border-left-success { border-left: 0.25rem solid #1cc88a !important; }
.border-left-info { border-left: 0.25rem solid #36b9cc !important; }
.border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
.border-left-danger { border-left: 0.25rem solid #e74a3b !important; }

.chart-area {
    position: relative;
    height: 320px;
}

.chart-pie {
    position: relative;
    height: 245px;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\superadmin\analytics.blade.php ENDPATH**/ ?>