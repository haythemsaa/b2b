

<?php $__env->startSection('title', 'Gestion des Tarifs Personnalisés'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Tarifs Personnalisés</h1>
                <a href="<?php echo e(route('admin.custom-prices.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouveau Tarif
                </a>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Liste des Tarifs Personnalisés</h5>
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3 mb-4">
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control" placeholder="Rechercher produit..." value="<?php echo e(request('search')); ?>">
                        </div>
                        <div class="col-md-2">
                            <select name="product_id" class="form-select">
                                <option value="">Tous les produits</option>
                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($product->id); ?>" <?php echo e(request('product_id') == $product->id ? 'selected' : ''); ?>>
                                        <?php echo e($product->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="customer_group_id" class="form-select">
                                <option value="">Tous les groupes</option>
                                <?php $__currentLoopData = $customerGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($group->id); ?>" <?php echo e(request('customer_group_id') == $group->id ? 'selected' : ''); ?>>
                                        <?php echo e($group->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="1" <?php echo e(request('status') === '1' ? 'selected' : ''); ?>>Actif</option>
                                <option value="0" <?php echo e(request('status') === '0' ? 'selected' : ''); ?>>Inactif</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-outline-primary w-100">Filtrer</button>
                        </div>
                        <div class="col-md-1">
                            <a href="<?php echo e(route('admin.custom-prices.index')); ?>" class="btn btn-outline-secondary w-100">Reset</a>
                        </div>
                    </form>

                    <?php if($customPrices->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Prix Standard</th>
                                        <th>Prix Personnalisé</th>
                                        <th>Économie</th>
                                        <th>Cible</th>
                                        <th>Validité</th>
                                        <th>Statut</th>
                                        <th width="120">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $customPrices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customPrice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong><?php echo e($customPrice->product->name); ?></strong>
                                                    <div class="small text-muted">SKU: <?php echo e($customPrice->product->sku); ?></div>
                                                </div>
                                            </td>
                                            <td><?php echo e(number_format($customPrice->product->base_price, 2)); ?> MAD</td>
                                            <td>
                                                <strong class="text-success"><?php echo e(number_format($customPrice->price, 2)); ?> MAD</strong>
                                                <?php if($customPrice->min_quantity > 1): ?>
                                                    <div class="small text-muted">Min: <?php echo e($customPrice->min_quantity); ?></div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($customPrice->product->price > 0): ?>
                                                    <?php if($customPrice->price < $customPrice->product->price): ?>
                                                        <?php
                                                            $savings = $customPrice->product->price - $customPrice->price;
                                                            $percentage = ($savings / $customPrice->product->price) * 100;
                                                        ?>
                                                        <span class="badge bg-success">
                                                            -<?php echo e(number_format($percentage, 1)); ?>%
                                                        </span>
                                                    <?php elseif($customPrice->price > $customPrice->product->price): ?>
                                                        <?php
                                                            $difference = $customPrice->price - $customPrice->product->price;
                                                            $percentage = ($difference / $customPrice->product->price) * 100;
                                                        ?>
                                                        <span class="badge bg-warning">+<?php echo e(number_format($percentage, 1)); ?>%</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">Identique</span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($customPrice->user): ?>
                                                    <div>
                                                        <i class="fas fa-user text-primary"></i>
                                                        <strong><?php echo e($customPrice->user->name); ?></strong>
                                                        <div class="small text-muted"><?php echo e($customPrice->user->company_name); ?></div>
                                                    </div>
                                                <?php elseif($customPrice->customerGroup): ?>
                                                    <div>
                                                        <i class="fas fa-users text-info"></i>
                                                        <strong><?php echo e($customPrice->customerGroup->name); ?></strong>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($customPrice->valid_from || $customPrice->valid_until): ?>
                                                    <div class="small">
                                                        <?php if($customPrice->valid_from): ?>
                                                            Du <?php echo e($customPrice->valid_from->format('d/m/Y')); ?>

                                                        <?php endif; ?>
                                                        <?php if($customPrice->valid_until): ?>
                                                            <br>Au <?php echo e($customPrice->valid_until->format('d/m/Y')); ?>

                                                        <?php endif; ?>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted">Permanent</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($customPrice->is_active): ?>
                                                    <?php if($customPrice->isValid()): ?>
                                                        <span class="badge bg-success">Actif</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-warning">Expiré</span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Inactif</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo e(route('admin.custom-prices.show', $customPrice)); ?>"
                                                       class="btn btn-sm btn-outline-info" title="Voir">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?php echo e(route('admin.custom-prices.edit', $customPrice)); ?>"
                                                       class="btn btn-sm btn-outline-primary" title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-warning toggle-status"
                                                            data-price-id="<?php echo e($customPrice->id); ?>"
                                                            title="<?php echo e($customPrice->is_active ? 'Désactiver' : 'Activer'); ?>">
                                                        <i class="fas <?php echo e($customPrice->is_active ? 'fa-pause' : 'fa-play'); ?>"></i>
                                                    </button>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-danger delete-price"
                                                            data-price-id="<?php echo e($customPrice->id); ?>"
                                                            data-product-name="<?php echo e($customPrice->product->name); ?>"
                                                            title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <?php echo e($customPrices->withQueryString()->links()); ?>

                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucun tarif personnalisé trouvé</h5>
                            <p class="text-muted">Commencez par créer votre premier tarif personnalisé pour vos clients ou groupes.</p>
                            <a href="<?php echo e(route('admin.custom-prices.create')); ?>" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Créer un Tarif
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-price');
    const toggleButtons = document.querySelectorAll('.toggle-status');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const priceId = this.dataset.priceId;
            const productName = this.dataset.productName;

            if (confirm(`Êtes-vous sûr de vouloir supprimer le tarif personnalisé pour "${productName}" ?`)) {
                fetch(`/admin/custom-prices/${priceId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Une erreur est survenue');
                });
            }
        });
    });

    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const priceId = this.dataset.priceId;

            fetch(`/admin/custom-prices/${priceId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    location.reload();
                } else {
                    alert('Une erreur est survenue');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur est survenue');
            });
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\custom-prices\index.blade.php ENDPATH**/ ?>