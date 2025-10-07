

<?php $__env->startSection('title', 'Modifier le Groupe - ' . $group->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Modifier le Groupe : <?php echo e($group->name); ?></h1>
                <div>
                    <a href="<?php echo e(route('admin.groups.show', $group)); ?>" class="btn btn-outline-info">
                        <i class="fas fa-eye"></i> Voir
                    </a>
                    <a href="<?php echo e(route('admin.groups.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Informations du Groupe</h5>
                    <div>
                        <?php if($group->is_active): ?>
                            <span class="badge bg-success">Actif</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Inactif</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.groups.update', $group)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

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
                                       value="<?php echo e(old('name', $group->name)); ?>"
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
                                       value="<?php echo e(old('discount_percentage', $group->discount_percentage)); ?>"
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
                                      placeholder="Description du groupe de clients..."><?php echo e(old('description', $group->description)); ?></textarea>
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
                                                   <?php echo e(in_array($user->id, old('users', $groupUsers)) ? 'checked' : ''); ?>>
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
                                <i class="fas fa-save"></i> Mettre à Jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Statistiques du Groupe</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary mb-0"><?php echo e($group->users->count()); ?></h4>
                                <small class="text-muted">Vendeurs</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success mb-0"><?php echo e($group->customPrices->count()); ?></h4>
                            <small class="text-muted">Tarifs Personnalisés</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">Informations</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Créé le</small>
                        <div><?php echo e($group->created_at->format('d/m/Y à H:i')); ?></div>
                    </div>

                    <?php if($group->updated_at != $group->created_at): ?>
                    <div class="mb-3">
                        <small class="text-muted">Dernière modification</small>
                        <div><?php echo e($group->updated_at->format('d/m/Y à H:i')); ?></div>
                    </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <small class="text-muted">Statut</small>
                        <div>
                            <?php if($group->is_active): ?>
                                <span class="badge bg-success">Actif</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Inactif</span>
                            <?php endif; ?>
                        </div>
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
                    <button type="button" class="btn btn-outline-secondary btn-sm w-100 mb-2" onclick="deselectAllUsers()">
                        <i class="fas fa-times"></i> Désélectionner Tous
                    </button>
                    <button type="button" class="btn btn-outline-warning btn-sm w-100" onclick="toggleGroupStatus()">
                        <i class="fas <?php echo e($group->is_active ? 'fa-pause' : 'fa-play'); ?>"></i>
                        <?php echo e($group->is_active ? 'Désactiver' : 'Activer'); ?> le Groupe
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

function toggleGroupStatus() {
    if (confirm('Êtes-vous sûr de vouloir changer le statut de ce groupe ?')) {
        fetch(`/admin/groups/<?php echo e($group->id); ?>/toggle-status`, {
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
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\groups\edit.blade.php ENDPATH**/ ?>