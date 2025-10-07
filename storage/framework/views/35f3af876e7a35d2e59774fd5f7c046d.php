

<?php $__env->startSection('title', 'Créer un Groupe de Clients'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Créer un Groupe de Clients</h1>
                <a href="<?php echo e(route('admin.groups.index')); ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informations du Groupe</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.groups.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nom du Groupe <span class="text-danger">*</span></label>
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

                            <div class="col-md-6 mb-3">
                                <label for="discount_percentage" class="form-label">Remise par Défaut (%)</label>
                                <input type="number"
                                       class="form-control <?php $__errorArgs = ['discount_percentage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="discount_percentage"
                                       name="discount_percentage"
                                       value="<?php echo e(old('discount_percentage', 0)); ?>"
                                       min="0"
                                       max="100"
                                       step="0.01">
                                <?php $__errorArgs = ['discount_percentage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="form-text text-muted">Remise appliquée automatiquement aux membres de ce groupe</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      id="description"
                                      name="description"
                                      rows="3"
                                      placeholder="Description du groupe de clients..."><?php echo e(old('description')); ?></textarea>
                            <?php $__errorArgs = ['description'];
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

                        <div class="mb-4">
                            <label class="form-label">Attribution des Vendeurs</label>
                            <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                <?php if($users->count() > 0): ?>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   name="users[]"
                                                   value="<?php echo e($user->id); ?>"
                                                   id="user_<?php echo e($user->id); ?>"
                                                   <?php echo e(in_array($user->id, old('users', [])) ? 'checked' : ''); ?>>
                                            <label class="form-check-label" for="user_<?php echo e($user->id); ?>">
                                                <strong><?php echo e($user->name); ?></strong>
                                                <div class="small text-muted">
                                                    <?php echo e($user->email); ?>

                                                    <?php if($user->company_name): ?>
                                                        - <?php echo e($user->company_name); ?>

                                                    <?php endif; ?>
                                                </div>
                                            </label>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <div class="text-muted text-center py-3">
                                        <i class="fas fa-users-slash"></i>
                                        Aucun vendeur disponible
                                    </div>
                                <?php endif; ?>
                            </div>
                            <small class="form-text text-muted">Sélectionnez les vendeurs qui feront partie de ce groupe</small>
                            <?php $__errorArgs = ['users'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?php echo e(route('admin.groups.index')); ?>" class="btn btn-outline-secondary">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Créer le Groupe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Aide</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6><i class="fas fa-info-circle text-info"></i> Groupes de Clients</h6>
                        <p class="small text-muted">
                            Les groupes permettent d'organiser vos vendeurs par catégories et d'appliquer des tarifs spécifiques.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6><i class="fas fa-percentage text-success"></i> Remises</h6>
                        <p class="small text-muted">
                            La remise par défaut s'applique automatiquement aux commandes des membres du groupe, sauf si un tarif personnalisé existe.
                        </p>
                    </div>

                    <div>
                        <h6><i class="fas fa-users text-primary"></i> Attribution</h6>
                        <p class="small text-muted">
                            Un vendeur peut appartenir à plusieurs groupes. Les tarifs les plus avantageux seront appliqués automatiquement.
                        </p>
                    </div>
                </div>
            </div>

            <?php if($users->count() > 0): ?>
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">Actions Rapides</h6>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-outline-primary btn-sm w-100 mb-2" onclick="selectAllUsers()">
                        <i class="fas fa-check-double"></i> Sélectionner Tous
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="deselectAllUsers()">
                        <i class="fas fa-times"></i> Désélectionner Tous
                    </button>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function selectAllUsers() {
    document.querySelectorAll('input[name="users[]"]').forEach(checkbox => {
        checkbox.checked = true;
    });
}

function deselectAllUsers() {
    document.querySelectorAll('input[name="users[]"]').forEach(checkbox => {
        checkbox.checked = false;
    });
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\groups\create.blade.php ENDPATH**/ ?>