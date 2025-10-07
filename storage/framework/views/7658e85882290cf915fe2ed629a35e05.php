

<?php $__env->startSection('title', 'Tarif Personnalisé - ' . $customPrice->product->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Tarif Personnalisé</h1>
                <div>
                    <a href="<?php echo e(route('admin.custom-prices.edit', $customPrice)); ?>" class="btn btn-outline-primary">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <a href="<?php echo e(route('admin.custom-prices.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
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
        <div class="col-lg-8">
            <!-- Informations du produit -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Informations Produit</h5>
                    <?php if($customPrice->is_active): ?>
                        <?php if($customPrice->isValid()): ?>
                            <span class="badge bg-success fs-6">Actif</span>
                        <?php else: ?>
                            <span class="badge bg-warning fs-6">Expiré</span>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="badge bg-danger fs-6">Inactif</span>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Nom du Produit</label>
                                <div class="fw-bold fs-5"><?php echo e($customPrice->product->name); ?></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">SKU</label>
                                <div><?php echo e($customPrice->product->sku); ?></div>
                            </div>

                            <?php if($customPrice->product->description): ?>
                            <div class="mb-3">
                                <label class="form-label text-muted">Description</label>
                                <div><?php echo e(Str::limit($customPrice->product->description, 200)); ?></div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Prix Standard</label>
                                <div class="fw-bold fs-4"><?php echo e(number_format($customPrice->product->price, 2)); ?> MAD</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Prix Personnalisé</label>
                                <div class="fw-bold fs-3 text-success"><?php echo e(number_format($customPrice->price, 2)); ?> MAD</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Économie/Supplément</label>
                                <div>
                                    <?php if($customPrice->product->price > 0): ?>
                                        <?php if($customPrice->price < $customPrice->product->price): ?>
                                            <?php
                                                $savings = $customPrice->product->price - $customPrice->price;
                                                $percentage = ($savings / $customPrice->product->price) * 100;
                                            ?>
                                            <span class="badge bg-success fs-6">
                                                Économie de <?php echo e(number_format($savings, 2)); ?> MAD (-<?php echo e(number_format($percentage, 1)); ?>%)
                                            </span>
                                        <?php elseif($customPrice->price > $customPrice->product->price): ?>
                                            <?php
                                                $difference = $customPrice->price - $customPrice->product->price;
                                                $percentage = ($difference / $customPrice->product->price) * 100;
                                            ?>
                                            <span class="badge bg-warning fs-6">
                                                Supplément de <?php echo e(number_format($difference, 2)); ?> MAD (+<?php echo e(number_format($percentage, 1)); ?>%)
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary fs-6">Prix identique</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations du tarif -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Conditions du Tarif</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Cible</label>
                                <div>
                                    <?php if($customPrice->user): ?>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user text-primary fa-2x me-3"></i>
                                            <div>
                                                <div class="fw-bold"><?php echo e($customPrice->user->name); ?></div>
                                                <div class="text-muted"><?php echo e($customPrice->user->company_name ?? $customPrice->user->email); ?></div>
                                                <div class="small text-muted">
                                                    <i class="fas fa-envelope"></i> <?php echo e($customPrice->user->email); ?>

                                                    <?php if($customPrice->user->phone): ?>
                                                        | <i class="fas fa-phone"></i> <?php echo e($customPrice->user->phone); ?>

                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php elseif($customPrice->customerGroup): ?>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-users text-info fa-2x me-3"></i>
                                            <div>
                                                <div class="fw-bold"><?php echo e($customPrice->customerGroup->name); ?></div>
                                                <?php if($customPrice->customerGroup->description): ?>
                                                    <div class="text-muted"><?php echo e($customPrice->customerGroup->description); ?></div>
                                                <?php endif; ?>
                                                <div class="small text-success">
                                                    <i class="fas fa-users"></i> <?php echo e($customPrice->customerGroup->users->count()); ?> vendeurs dans ce groupe
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Quantité Minimum</label>
                                <div>
                                    <?php if($customPrice->min_quantity > 1): ?>
                                        <span class="badge bg-info"><?php echo e($customPrice->min_quantity); ?> unités minimum</span>
                                    <?php else: ?>
                                        <span class="text-muted">Aucune quantité minimum</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Période de Validité</label>
                                <div>
                                    <?php if($customPrice->valid_from || $customPrice->valid_until): ?>
                                        <div class="border rounded p-3 bg-light">
                                            <?php if($customPrice->valid_from): ?>
                                                <div><i class="fas fa-calendar-plus text-success"></i> <strong>Du :</strong> <?php echo e($customPrice->valid_from->format('d/m/Y')); ?></div>
                                            <?php endif; ?>
                                            <?php if($customPrice->valid_until): ?>
                                                <div><i class="fas fa-calendar-minus text-danger"></i> <strong>Au :</strong> <?php echo e($customPrice->valid_until->format('d/m/Y')); ?></div>
                                            <?php endif; ?>
                                            <div class="mt-2">
                                                <?php if($customPrice->isValid()): ?>
                                                    <span class="badge bg-success">En cours de validité</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning">Période expirée</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center p-3 bg-light rounded">
                                            <i class="fas fa-infinity text-primary fa-2x mb-2"></i>
                                            <div class="fw-bold">Tarif Permanent</div>
                                            <div class="small text-muted">Aucune limite de validité</div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Membres du groupe (si applicable) -->
            <?php if($customPrice->customerGroup): ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Vendeurs Concernés (<?php echo e($customPrice->customerGroup->users->count()); ?>)</h5>
                </div>
                <div class="card-body">
                    <?php if($customPrice->customerGroup->users->count() > 0): ?>
                        <div class="row">
                            <?php $__currentLoopData = $customPrice->customerGroup->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-6 mb-3">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user-tie text-primary me-2"></i>
                                            <div>
                                                <div class="fw-bold"><?php echo e($user->name); ?></div>
                                                <div class="small text-muted"><?php echo e($user->company_name ?? $user->email); ?></div>
                                                <div class="small">
                                                    <?php if($user->is_active): ?>
                                                        <span class="badge bg-success">Actif</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Inactif</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-3 text-muted">
                            <i class="fas fa-users-slash fa-2x mb-2"></i>
                            <div>Aucun vendeur dans ce groupe</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-4">
            <!-- Résumé -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Résumé</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end pe-3">
                                <h4 class="text-primary mb-0"><?php echo e(number_format($customPrice->product->price, 2)); ?></h4>
                                <small class="text-muted">Prix Standard</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="ps-3">
                                <h4 class="text-success mb-0"><?php echo e(number_format($customPrice->price, 2)); ?></h4>
                                <small class="text-muted">Prix Personnalisé</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations système -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Informations</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Créé le</small>
                        <div><?php echo e($customPrice->created_at->format('d/m/Y à H:i')); ?></div>
                    </div>

                    <?php if($customPrice->updated_at != $customPrice->created_at): ?>
                    <div class="mb-3">
                        <small class="text-muted">Dernière modification</small>
                        <div><?php echo e($customPrice->updated_at->format('d/m/Y à H:i')); ?></div>
                    </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <small class="text-muted">Statut</small>
                        <div>
                            <?php if($customPrice->is_active): ?>
                                <?php if($customPrice->isValid()): ?>
                                    <span class="badge bg-success">Actif et valide</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Actif mais expiré</span>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="badge bg-danger">Inactif</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-0">
                        <small class="text-muted">Type de cible</small>
                        <div>
                            <?php if($customPrice->user): ?>
                                <i class="fas fa-user text-primary"></i> Vendeur individuel
                            <?php elseif($customPrice->customerGroup): ?>
                                <i class="fas fa-users text-info"></i> Groupe de clients
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Actions</h6>
                </div>
                <div class="card-body d-grid gap-2">
                    <a href="<?php echo e(route('admin.custom-prices.edit', $customPrice)); ?>" class="btn btn-outline-primary">
                        <i class="fas fa-edit"></i> Modifier le Tarif
                    </a>

                    <button type="button" class="btn btn-outline-warning" onclick="togglePriceStatus()">
                        <i class="fas <?php echo e($customPrice->is_active ? 'fa-pause' : 'fa-play'); ?>"></i>
                        <?php echo e($customPrice->is_active ? 'Désactiver' : 'Activer'); ?>

                    </button>

                    <button type="button" class="btn btn-outline-danger" onclick="deletePrice()">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>

                    <hr>

                    <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                        <i class="fas fa-print"></i> Imprimer
                    </button>

                    <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-outline-info">
                        <i class="fas fa-box"></i> Voir Tous les Produits
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function togglePriceStatus() {
    if (confirm('Êtes-vous sûr de vouloir changer le statut de ce tarif ?')) {
        fetch(`/admin/custom-prices/<?php echo e($customPrice->id); ?>/toggle-status`, {
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
    }
}

function deletePrice() {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce tarif personnalisé ?\n\nCette action est irréversible.')) {
        fetch(`/admin/custom-prices/<?php echo e($customPrice->id); ?>`, {
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
                window.location.href = '<?php echo e(route("admin.custom-prices.index")); ?>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue');
        });
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\custom-prices\show.blade.php ENDPATH**/ ?>