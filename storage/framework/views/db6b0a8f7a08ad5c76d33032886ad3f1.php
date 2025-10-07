<?php $__env->startSection('title', 'Gestion des Attributs'); ?>
<?php $__env->startSection('page-title', 'Gestion des Attributs'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">Attributs de Produits</h2>
                <p class="text-muted">Gérez les caractéristiques des produits (couleur, taille, matière...)</p>
            </div>
            <a href="<?php echo e(route('admin.attributes.create')); ?>" class="btn btn-admin-primary">
                <i class="fas fa-plus-circle me-2"></i>Nouvel Attribut
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-sliders-h me-2"></i>Liste des Attributs
            </div>
            <div class="card-body">
                <?php if($attributes->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Slug</th>
                                    <th>Type</th>
                                    <th class="text-center">Valeurs</th>
                                    <th class="text-center">Requis</th>
                                    <th class="text-center">Filtrable</th>
                                    <th class="text-center">Ordre</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <strong><?php echo e($attribute->name); ?></strong>
                                    </td>
                                    <td><code><?php echo e($attribute->slug); ?></code></td>
                                    <td>
                                        <?php
                                            $typeColors = [
                                                'text' => 'secondary',
                                                'select' => 'primary',
                                                'multiselect' => 'info',
                                                'number' => 'warning',
                                                'boolean' => 'success',
                                                'color' => 'danger'
                                            ];
                                            $color = $typeColors[$attribute->type] ?? 'secondary';
                                        ?>
                                        <span class="badge bg-<?php echo e($color); ?>">
                                            <?php echo e(App\Models\Attribute::types()[$attribute->type] ?? $attribute->type); ?>

                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if(in_array($attribute->type, ['select', 'multiselect', 'color'])): ?>
                                            <span class="badge bg-info"><?php echo e($attribute->values_count); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($attribute->is_required): ?>
                                            <span class="badge bg-danger">
                                                <i class="fas fa-check"></i> Oui
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Non</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($attribute->is_filterable): ?>
                                            <span class="badge bg-success">
                                                <i class="fas fa-check"></i> Oui
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Non</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center"><?php echo e($attribute->sort_order ?? 0); ?></td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('admin.attributes.edit', $attribute)); ?>"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST"
                                                  action="<?php echo e(route('admin.attributes.destroy', $attribute)); ?>"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet attribut et toutes ses valeurs ?');">
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
                        <i class="fas fa-sliders-h fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Aucun attribut trouvé.</p>
                        <a href="<?php echo e(route('admin.attributes.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Créer le premier attribut
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Info Box -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card bg-light">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-0">Total Attributs</h6>
                        <h3 class="mb-0"><?php echo e($attributes->count()); ?></h3>
                    </div>
                    <i class="fas fa-sliders-h fa-2x text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-light">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-0">Requis</h6>
                        <h3 class="mb-0"><?php echo e($attributes->where('is_required', true)->count()); ?></h3>
                    </div>
                    <i class="fas fa-asterisk fa-2x text-danger"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-light">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-0">Filtrables</h6>
                        <h3 class="mb-0"><?php echo e($attributes->where('is_filterable', true)->count()); ?></h3>
                    </div>
                    <i class="fas fa-filter fa-2x text-success"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-light">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-0">Total Valeurs</h6>
                        <h3 class="mb-0"><?php echo e($attributes->sum('values_count')); ?></h3>
                    </div>
                    <i class="fas fa-list fa-2x text-info"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Help Section -->
<div class="row mt-4">
    <div class="col-12">
        <div class="alert alert-info">
            <h5><i class="fas fa-info-circle me-2"></i>À propos des attributs</h5>
            <ul class="mb-0">
                <li><strong>Texte :</strong> Champ texte libre pour les caractéristiques personnalisées</li>
                <li><strong>Liste déroulante :</strong> Sélection unique parmi plusieurs valeurs (ex: Taille : S, M, L, XL)</li>
                <li><strong>Sélection multiple :</strong> Possibilité de sélectionner plusieurs valeurs</li>
                <li><strong>Nombre :</strong> Valeur numérique (ex: Poids, Hauteur)</li>
                <li><strong>Oui/Non :</strong> Attribut booléen simple</li>
                <li><strong>Couleur :</strong> Sélecteur de couleur avec valeurs prédéfinies</li>
            </ul>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\attributes\index.blade.php ENDPATH**/ ?>