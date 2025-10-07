<?php $__env->startSection('title', 'Gestion des Catégories'); ?>
<?php $__env->startSection('page-title', 'Gestion des Catégories'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">Catégories de Produits</h2>
                <p class="text-muted">Gérez l'arborescence des catégories</p>
            </div>
            <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-admin-primary">
                <i class="fas fa-plus-circle me-2"></i>Nouvelle Catégorie
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-sitemap me-2"></i>Arborescence des Catégories
            </div>
            <div class="card-body">
                <?php if(count($tree) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Slug</th>
                                    <th>Parent</th>
                                    <th class="text-center">Produits</th>
                                    <th class="text-center">Ordre</th>
                                    <th class="text-center">Statut</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $tree; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if($category->level > 0): ?>
                                                <span class="text-muted me-2" style="padding-left: <?php echo e($category->level * 20); ?>px;">
                                                    <i class="fas fa-level-up-alt fa-rotate-90"></i>
                                                </span>
                                            <?php endif; ?>
                                            <div>
                                                <strong><?php echo e($category->name); ?></strong>
                                                <?php if($category->description): ?>
                                                    <br><small class="text-muted"><?php echo e(Str::limit($category->description, 50)); ?></small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td><code><?php echo e($category->slug); ?></code></td>
                                    <td>
                                        <?php if($category->parent): ?>
                                            <span class="badge bg-secondary"><?php echo e($category->parent->name); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-primary">Racine</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info"><?php echo e($category->products->count()); ?></span>
                                    </td>
                                    <td class="text-center"><?php echo e($category->sort_order ?? 0); ?></td>
                                    <td class="text-center">
                                        <?php if($category->is_active): ?>
                                            <span class="badge bg-success">
                                                <i class="fas fa-check"></i> Actif
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-times"></i> Inactif
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('admin.categories.edit', $category)); ?>"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST"
                                                  action="<?php echo e(route('admin.categories.destroy', $category)); ?>"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-sitemap fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Aucune catégorie trouvée.</p>
                        <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Créer la première catégorie
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Info Box -->
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-0">Total Catégories</h6>
                        <h3 class="mb-0"><?php echo e($categories->count()); ?></h3>
                    </div>
                    <i class="fas fa-sitemap fa-2x text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-0">Catégories Racines</h6>
                        <h3 class="mb-0"><?php echo e($categories->whereNull('parent_id')->count()); ?></h3>
                    </div>
                    <i class="fas fa-folder fa-2x text-success"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-0">Catégories Actives</h6>
                        <h3 class="mb-0"><?php echo e($categories->where('is_active', true)->count()); ?></h3>
                    </div>
                    <i class="fas fa-check-circle fa-2x text-info"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\categories\index.blade.php ENDPATH**/ ?>