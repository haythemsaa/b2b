<?php $__env->startSection('title', 'Modifier un Attribut'); ?>
<?php $__env->startSection('page-title', 'Modifier un Attribut'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit me-2"></i>Modifier l'attribut : <?php echo e($attribute->name); ?>

            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('admin.attributes.update', $attribute)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

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
                               value="<?php echo e(old('name', $attribute->name)); ?>"
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
                            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>"
                                    <?php echo e(old('type', $attribute->type) == $key ? 'selected' : ''); ?>>
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
                               value="<?php echo e(old('sort_order', $attribute->sort_order)); ?>"
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
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="is_required"
                                   name="is_required"
                                   <?php echo e(old('is_required', $attribute->is_required) ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="is_required">
                                <strong>Attribut requis</strong>
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="is_filterable"
                                   name="is_filterable"
                                   <?php echo e(old('is_filterable', $attribute->is_filterable) ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="is_filterable">
                                <strong>Filtrable</strong>
                            </label>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('admin.attributes.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                        <button type="submit" class="btn btn-admin-primary">
                            <i class="fas fa-save me-2"></i>Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Gestion des valeurs pour les types select/multiselect/color -->
        <?php if(in_array($attribute->type, ['select', 'multiselect', 'color'])): ?>
        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-list me-2"></i>Valeurs de l'attribut
            </div>
            <div class="card-body">
                <?php if($attribute->values->count() > 0): ?>
                    <div class="table-responsive mb-3">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Valeur</th>
                                    <th class="text-center">Ordre</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $attribute->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php if($attribute->type === 'color'): ?>
                                            <span class="badge" style="background-color: <?php echo e($value->value); ?>">
                                                <?php echo e($value->value); ?>

                                            </span>
                                        <?php else: ?>
                                            <?php echo e($value->value); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center"><?php echo e($value->sort_order ?? 0); ?></td>
                                    <td class="text-center">
                                        <form method="POST"
                                              action="<?php echo e(route('admin.attributes.values.delete', [$attribute, $value])); ?>"
                                              class="d-inline"
                                              onsubmit="return confirm('Supprimer cette valeur ?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center">Aucune valeur définie pour cet attribut.</p>
                <?php endif; ?>

                <hr>

                <!-- Formulaire d'ajout de valeur -->
                <h6>Ajouter une valeur</h6>
                <form method="POST" action="<?php echo e(route('admin.attributes.values.add', $attribute)); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <input type="text"
                                   class="form-control"
                                   name="value"
                                   placeholder="Nouvelle valeur"
                                   required>
                        </div>
                        <div class="col-md-3">
                            <input type="number"
                                   class="form-control"
                                   name="sort_order"
                                   placeholder="Ordre"
                                   value="0"
                                   min="0">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-plus me-2"></i>Ajouter
                            </button>
                        </div>
                    </div>
                </form>

                <?php if($attribute->type === 'color'): ?>
                <div class="alert alert-info mt-3 mb-0">
                    <small>
                        <i class="fas fa-info-circle me-2"></i>
                        Pour les couleurs, utilisez le format hexadécimal (ex: #FF5733) ou les noms CSS (ex: red, blue).
                    </small>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\attributes\edit.blade.php ENDPATH**/ ?>