<?php $__env->startSection('title', 'Créer un Attribut'); ?>
<?php $__env->startSection('page-title', 'Créer un Attribut'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-plus-circle me-2"></i>Nouvel Attribut
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('admin.attributes.store')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nom de l'attribut <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="name"
                               name="name"
                               value="<?php echo e(old('name')); ?>"
                               placeholder="Ex: Couleur, Taille, Matière..."
                               required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Type d'attribut <span class="text-danger">*</span></label>
                        <select class="form-select <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="type"
                                name="type"
                                required>
                            <option value="">Sélectionnez un type</option>
                            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>" <?php echo e(old('type') == $key ? 'selected' : ''); ?>>
                                    <?php echo e($label); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="text-muted">Le type détermine comment l'attribut sera affiché et utilisé</small>
                    </div>

                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Ordre d'affichage</label>
                        <input type="number"
                               class="form-control <?php $__errorArgs = ['sort_order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="sort_order"
                               name="sort_order"
                               value="<?php echo e(old('sort_order', 0)); ?>"
                               min="0">
                        <?php $__errorArgs = ['sort_order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="text-muted">Les attributs sont triés par ordre croissant</small>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="is_required"
                                   name="is_required"
                                   <?php echo e(old('is_required') ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="is_required">
                                <strong>Attribut requis</strong>
                            </label>
                        </div>
                        <small class="text-muted">Les attributs requis doivent être renseignés pour chaque produit</small>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="is_filterable"
                                   name="is_filterable"
                                   <?php echo e(old('is_filterable', true) ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="is_filterable">
                                <strong>Filtrable</strong>
                            </label>
                        </div>
                        <small class="text-muted">Les attributs filtrables peuvent être utilisés pour filtrer les produits</small>
                    </div>

                    <hr>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Note :</strong> Après avoir créé l'attribut, vous pourrez ajouter des valeurs si nécessaire (pour les types : liste déroulante, sélection multiple, couleur).
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('admin.attributes.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                        <button type="submit" class="btn btn-admin-primary">
                            <i class="fas fa-save me-2"></i>Créer l'attribut
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Type Descriptions -->
        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-question-circle me-2"></i>Types d'attributs
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h6><span class="badge bg-secondary">Texte</span></h6>
                        <p class="small text-muted mb-0">Champ texte libre. Utilisé pour des descriptions ou valeurs uniques.</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6><span class="badge bg-primary">Liste déroulante</span></h6>
                        <p class="small text-muted mb-0">Sélection unique parmi plusieurs valeurs prédéfinies.</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6><span class="badge bg-info">Sélection multiple</span></h6>
                        <p class="small text-muted mb-0">Possibilité de sélectionner plusieurs valeurs.</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6><span class="badge bg-warning">Nombre</span></h6>
                        <p class="small text-muted mb-0">Valeur numérique (poids, dimensions, etc.).</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6><span class="badge bg-success">Oui/Non</span></h6>
                        <p class="small text-muted mb-0">Attribut booléen simple (oui/non, vrai/faux).</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6><span class="badge bg-danger">Couleur</span></h6>
                        <p class="small text-muted mb-0">Sélecteur de couleur avec valeurs prédéfinies.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\attributes\create.blade.php ENDPATH**/ ?>