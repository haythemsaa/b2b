<?php $__env->startSection('title', 'Gestion des Produits'); ?>
<?php $__env->startSection('page-title', 'Gestion des Produits'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">Produits</h2>
                <p class="text-muted">Gérez votre catalogue de produits</p>
            </div>
            <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-admin-primary">
                <i class="fas fa-plus-circle me-2"></i>Nouveau Produit
            </a>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-filter me-2"></i>Filtres de Recherche
            </div>
            <div class="card-body">
                    <form method="GET" action="<?php echo e(route('admin.products.index')); ?>">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control"
                                       placeholder="Rechercher par nom ou SKU..."
                                       value="<?php echo e(request('search')); ?>">
                            </div>
                            <div class="col-md-3">
                                <select name="category_id" class="form-select">
                                    <option value="">Toutes les catégories</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>"
                                                <?php echo e(request('category_id') == $category->id ? 'selected' : ''); ?>>
                                            <?php echo e($category->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-admin-primary w-100">
                                    <i class="fas fa-search me-2"></i>Filtrer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-box me-2"></i>Liste des Produits (<?php echo e($products->total()); ?>)
            </div>
            <div class="card-body">
                    <?php if($products->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Nom</th>
                                        <th>SKU</th>
                                        <th>Catégorie</th>
                                        <th>Prix</th>
                                        <th>Stock</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                 style="width: 50px; height: 50px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        </td>
                                        <td>
                                            <strong><?php echo e($product->name); ?></strong>
                                            <?php if($product->description): ?>
                                                <br><small class="text-muted"><?php echo e(Str::limit($product->description, 50)); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td><code><?php echo e($product->sku); ?></code></td>
                                        <td><?php echo e($product->category->name ?? 'N/A'); ?></td>
                                        <td><?php echo e(number_format($product->base_price, 2)); ?>€</td>
                                        <td>
                                            <span class="badge bg-<?php echo e($product->stock_quantity > 10 ? 'success' : ($product->stock_quantity > 0 ? 'warning' : 'danger')); ?>">
                                                <?php echo e($product->stock_quantity); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <form method="POST" action="<?php echo e(route('admin.products.toggle-status', $product)); ?>" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-<?php echo e($product->is_active ? 'success' : 'secondary'); ?>">
                                                    <?php echo e($product->is_active ? 'Actif' : 'Inactif'); ?>

                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo e(route('admin.products.edit', $product)); ?>"
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form method="POST" action="<?php echo e(route('admin.products.destroy', $product)); ?>"
                                                      class="d-inline" onsubmit="return confirm('Êtes-vous sûr ?')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <?php echo e($products->links()); ?>

                    <?php else: ?>
                        <p class="text-muted text-center py-4">Aucun produit trouvé.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\products\index.blade.php ENDPATH**/ ?>