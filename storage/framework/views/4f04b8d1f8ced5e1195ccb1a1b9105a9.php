<?php $__env->startSection('title', 'Rapport des Ventes'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="bi bi-graph-up me-2 text-primary"></i>
                Rapport des Ventes
            </h1>
            <p class="text-muted">Analyse détaillée de vos performances commerciales</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?php echo e(route('admin.reports.export', 'sales')); ?>" class="btn btn-success">
                <i class="bi bi-download me-2"></i>Exporter CSV
            </a>
            <a href="<?php echo e(route('admin.reports.index')); ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Retour
            </a>
        </div>
    </div>

    <!-- Filter Period -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Date début</label>
                            <input type="date" class="form-control" name="start_date"
                                   value="<?php echo e(request('start_date', $startDate->format('Y-m-d'))); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Date fin</label>
                            <input type="date" class="form-control" name="end_date"
                                   value="<?php echo e(request('end_date', $endDate->format('Y-m-d'))); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary d-block w-100">
                                <i class="bi bi-filter me-2"></i>Filtrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="text-white-50">Chiffre d'Affaires Total</h6>
                    <h2 class="mb-0"><?php echo e(number_format($totalRevenue, 2)); ?> DT</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="text-white-50">Nombre de Commandes</h6>
                    <h2 class="mb-0"><?php echo e($totalOrders); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="text-white-50">Panier Moyen</h6>
                    <h2 class="mb-0"><?php echo e(number_format($averageOrder, 2)); ?> DT</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Chart -->
    <?php if($salesData->count() > 0): ?>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Évolution des Ventes</h5>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Top Sellers -->
    <?php if($topSellers->count() > 0): ?>
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-trophy text-warning me-2"></i>
                        Top 10 Vendeurs
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Vendeur</th>
                                    <th>Commandes</th>
                                    <th class="text-end">CA Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $topSellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $seller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php if($index < 3): ?>
                                        <i class="bi bi-trophy-fill text-warning"></i>
                                        <?php else: ?>
                                        <?php echo e($index + 1); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?php echo e($seller->name); ?></strong><br>
                                        <small class="text-muted"><?php echo e($seller->email); ?></small>
                                    </td>
                                    <td><span class="badge bg-primary"><?php echo e($seller->orders_count); ?></span></td>
                                    <td class="text-end"><strong><?php echo e(number_format($seller->total_sales, 2)); ?> DT</strong></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-star text-success me-2"></i>
                        Top 10 Produits
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Produit</th>
                                    <th>Quantité</th>
                                    <th class="text-end">CA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($index + 1); ?></td>
                                    <td>
                                        <strong><?php echo e($product->name); ?></strong><br>
                                        <small class="text-muted"><?php echo e($product->sku); ?></small>
                                    </td>
                                    <td><span class="badge bg-success"><?php echo e($product->quantity_sold); ?></span></td>
                                    <td class="text-end"><strong><?php echo e(number_format($product->revenue, 2)); ?> DT</strong></td>
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

    <!-- Daily Sales Table -->
    <?php if($salesData->count() > 0): ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Ventes Quotidiennes</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Nombre de Commandes</th>
                                    <th>CA Total</th>
                                    <th>Panier Moyen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $salesData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(\Carbon\Carbon::parse($sale->date)->format('d/m/Y')); ?></td>
                                    <td><span class="badge bg-primary"><?php echo e($sale->orders_count); ?></span></td>
                                    <td><strong><?php echo e(number_format($sale->total_sales, 2)); ?> DT</strong></td>
                                    <td><?php echo e(number_format($sale->average_order, 2)); ?> DT</td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>
        Aucune vente pour la période sélectionnée.
    </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
<?php if($salesData->count() > 0): ?>
const ctx = document.getElementById('salesChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($salesData->pluck('date')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('d/m');
        })); ?>,
        datasets: [{
            label: 'Chiffre d\'Affaires (DT)',
            data: <?php echo json_encode($salesData->pluck('total_sales')); ?>,
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1
        }, {
            label: 'Nombre de Commandes',
            data: <?php echo json_encode($salesData->pluck('orders_count')); ?>,
            borderColor: 'rgb(255, 99, 132)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            tension: 0.1,
            yAxisID: 'y1'
        }]
    },
    options: {
        responsive: true,
        interaction: {
            mode: 'index',
            intersect: false,
        },
        scales: {
            y: {
                type: 'linear',
                display: true,
                position: 'left',
                title: {
                    display: true,
                    text: 'CA (DT)'
                }
            },
            y1: {
                type: 'linear',
                display: true,
                position: 'right',
                title: {
                    display: true,
                    text: 'Commandes'
                },
                grid: {
                    drawOnChartArea: false,
                }
            }
        }
    }
});
<?php endif; ?>
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\reports\sales.blade.php ENDPATH**/ ?>