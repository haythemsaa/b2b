<?php $__env->startSection('title', 'Rapport des Stocks'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="bi bi-box-seam me-2 text-success"></i>
                Rapport des Stocks
            </h1>
            <p class="text-muted">État de votre inventaire et alertes stock</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?php echo e(route('admin.reports.index')); ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Retour
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="text-white-50">Total Produits</h6>
                    <h2 class="mb-0"><?php echo e($totalProducts); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="text-white-50">Produits Actifs</h6>
                    <h2 class="mb-0"><?php echo e($activeProducts); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6 class="text-white-50">Stock Total</h6>
                    <h2 class="mb-0"><?php echo e(number_format($stockValue->total_items)); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="text-white-50">Valeur Stock</h6>
                    <h2 class="mb-0"><?php echo e(number_format($stockValue->total_value, 2)); ?> DT</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Alert -->
    <?php if($lowStockProducts->count() > 0): ?>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-warning">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Produits en Stock Faible (<?php echo e($lowStockProducts->count()); ?>)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>SKU</th>
                                    <th>Stock Actuel</th>
                                    <th>Seuil Min</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $lowStockProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><strong><?php echo e($product->name); ?></strong></td>
                                    <td><code><?php echo e($product->sku); ?></code></td>
                                    <td>
                                        <span class="badge bg-warning"><?php echo e($product->stock_quantity); ?></span>
                                    </td>
                                    <td><?php echo e($product->low_stock_threshold ?? 10); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil"></i> Réapprovisionner
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

    <!-- Out of Stock -->
    <?php if($outOfStockProducts->count() > 0): ?>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-x-circle me-2"></i>
                        Produits en Rupture (<?php echo e($outOfStockProducts->count()); ?>)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>SKU</th>
                                    <th>Catégorie</th>
                                    <th>Prix</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $outOfStockProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><strong><?php echo e($product->name); ?></strong></td>
                                    <td><code><?php echo e($product->sku); ?></code></td>
                                    <td><?php echo e($product->category->name ?? '-'); ?></td>
                                    <td><?php echo e(number_format($product->price, 2)); ?> DT</td>
                                    <td>
                                        <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="btn btn-sm btn-danger">
                                            <i class="bi bi-box-arrow-in-down"></i> Réapprovisionner
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

    <!-- Stock by Category -->
    <?php if($productsByCategory->count() > 0): ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-pie-chart me-2"></i>
                        Répartition par Catégorie
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Catégorie</th>
                                    <th>Nombre de Produits</th>
                                    <th>Stock Total</th>
                                    <th>Valeur Totale</th>
                                    <th>% de la Valeur</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $totalValue = $productsByCategory->sum('total_value'); ?>
                                <?php $__currentLoopData = $productsByCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><strong><?php echo e($cat->category); ?></strong></td>
                                    <td><span class="badge bg-primary"><?php echo e($cat->products_count); ?></span></td>
                                    <td><?php echo e(number_format($cat->total_stock)); ?></td>
                                    <td><strong><?php echo e(number_format($cat->total_value, 2)); ?> DT</strong></td>
                                    <td>
                                        <?php $percentage = $totalValue > 0 ? ($cat->total_value / $totalValue) * 100 : 0; ?>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                 style="width: <?php echo e($percentage); ?>%">
                                                <?php echo e(number_format($percentage, 1)); ?>%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th>TOTAL</th>
                                    <th><span class="badge bg-dark"><?php echo e($productsByCategory->sum('products_count')); ?></span></th>
                                    <th><?php echo e(number_format($productsByCategory->sum('total_stock'))); ?></th>
                                    <th><strong><?php echo e(number_format($totalValue, 2)); ?> DT</strong></th>
                                    <th>100%</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\reports\inventory.blade.php ENDPATH**/ ?>