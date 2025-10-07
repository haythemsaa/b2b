<?php $__env->startSection('title', 'Modifier Tenant - ' . $tenant->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Modifier le Tenant : <?php echo e($tenant->name); ?></h1>
                <div class="btn-group">
                    <a href="<?php echo e(route('superadmin.tenants.show', $tenant)); ?>" class="btn btn-outline-info">
                        <i class="bi bi-eye"></i> Voir
                    </a>
                    <a href="<?php echo e(route('superadmin.tenants.index')); ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="<?php echo e(route('superadmin.tenants.update', $tenant)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="row">
            <!-- Informations de base -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informations de Base</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom du Tenant <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="name" name="name" value="<?php echo e(old('name', $tenant->name)); ?>" required>
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
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="email" name="email" value="<?php echo e(old('email', $tenant->email)); ?>" required>
                            <?php $__errorArgs = ['email'];
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
                            <label for="domain" class="form-label">Domaine Personnalisé</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['domain'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="domain" name="domain" value="<?php echo e(old('domain', $tenant->domain)); ?>"
                                   placeholder="mondomaine.com">
                            <?php $__errorArgs = ['domain'];
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

                        <div class="row">
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Téléphone</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="phone" name="phone" value="<?php echo e(old('phone', $tenant->phone)); ?>">
                                <?php $__errorArgs = ['phone'];
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
                            <div class="col-md-6">
                                <label for="country" class="form-label">Pays <span class="text-danger">*</span></label>
                                <select class="form-select <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="country" name="country" required>
                                    <option value="TN" <?php echo e(old('country', $tenant->country) === 'TN' ? 'selected' : ''); ?>>Tunisie</option>
                                    <option value="MA" <?php echo e(old('country', $tenant->country) === 'MA' ? 'selected' : ''); ?>>Maroc</option>
                                    <option value="DZ" <?php echo e(old('country', $tenant->country) === 'DZ' ? 'selected' : ''); ?>>Algérie</option>
                                    <option value="FR" <?php echo e(old('country', $tenant->country) === 'FR' ? 'selected' : ''); ?>>France</option>
                                </select>
                                <?php $__errorArgs = ['country'];
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
                        </div>

                        <div class="mt-3">
                            <label for="address" class="form-label">Adresse</label>
                            <textarea class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      id="address" name="address" rows="2"><?php echo e(old('address', $tenant->address)); ?></textarea>
                            <?php $__errorArgs = ['address'];
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

                        <div class="mt-3">
                            <label for="city" class="form-label">Ville</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="city" name="city" value="<?php echo e(old('city', $tenant->city)); ?>">
                            <?php $__errorArgs = ['city'];
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
                    </div>
                </div>
            </div>

            <!-- Configuration & Quotas -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Configuration & Quotas</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="plan" class="form-label">Plan d'Abonnement <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['plan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="plan" name="plan" required>
                                <option value="starter" <?php echo e(old('plan', $tenant->plan) === 'starter' ? 'selected' : ''); ?>>Starter</option>
                                <option value="pro" <?php echo e(old('plan', $tenant->plan) === 'pro' ? 'selected' : ''); ?>>Pro</option>
                                <option value="enterprise" <?php echo e(old('plan', $tenant->plan) === 'enterprise' ? 'selected' : ''); ?>>Enterprise</option>
                            </select>
                            <?php $__errorArgs = ['plan'];
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

                        <div class="row">
                            <div class="col-md-6">
                                <label for="max_users" class="form-label">Max Utilisateurs <span class="text-danger">*</span></label>
                                <input type="number" class="form-control <?php $__errorArgs = ['max_users'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="max_users" name="max_users" value="<?php echo e(old('max_users', $tenant->max_users)); ?>" min="1" required>
                                <?php $__errorArgs = ['max_users'];
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
                            <div class="col-md-6">
                                <label for="max_products" class="form-label">Max Produits <span class="text-danger">*</span></label>
                                <input type="number" class="form-control <?php $__errorArgs = ['max_products'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="max_products" name="max_products" value="<?php echo e(old('max_products', $tenant->max_products)); ?>" min="1" required>
                                <?php $__errorArgs = ['max_products'];
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
                        </div>

                        <div class="mt-3">
                            <label for="monthly_fee" class="form-label">Tarif Mensuel (€) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control <?php $__errorArgs = ['monthly_fee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="monthly_fee" name="monthly_fee" value="<?php echo e(old('monthly_fee', $tenant->monthly_fee)); ?>" min="0" required>
                            <?php $__errorArgs = ['monthly_fee'];
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

                        <div class="mt-3">
                            <label for="trial_ends_at" class="form-label">Fin de la Période d'Essai</label>
                            <input type="date" class="form-control <?php $__errorArgs = ['trial_ends_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="trial_ends_at" name="trial_ends_at"
                                   value="<?php echo e(old('trial_ends_at', $tenant->trial_ends_at?->format('Y-m-d'))); ?>">
                            <?php $__errorArgs = ['trial_ends_at'];
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

                        <div class="mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                       id="is_active" <?php echo e(old('is_active', $tenant->is_active) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="is_active">
                                    Tenant Actif
                                </label>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="form-label">Modules Activés</label>
                            <?php
                                $enabledModules = old('enabled_modules', $tenant->enabled_modules ?? []);
                            ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="enabled_modules[]" value="chat"
                                       id="module_chat" <?php echo e(in_array('chat', $enabledModules) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="module_chat">
                                    Chat en temps réel
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="enabled_modules[]" value="analytics"
                                       id="module_analytics" <?php echo e(in_array('analytics', $enabledModules) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="module_analytics">
                                    Analytics avancés
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="enabled_modules[]" value="api"
                                       id="module_api" <?php echo e(in_array('api', $enabledModules) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="module_api">
                                    Accès API
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="enabled_modules[]" value="custom_reports"
                                       id="module_reports" <?php echo e(in_array('custom_reports', $enabledModules) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="module_reports">
                                    Rapports personnalisés
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations système -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informations Système</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Slug:</strong><br>
                                <span class="text-muted"><?php echo e($tenant->slug); ?></span>
                            </div>
                            <div class="col-md-3">
                                <strong>Créé le:</strong><br>
                                <span class="text-muted"><?php echo e($tenant->created_at->format('d/m/Y H:i')); ?></span>
                            </div>
                            <div class="col-md-3">
                                <strong>Modifié le:</strong><br>
                                <span class="text-muted"><?php echo e($tenant->updated_at->format('d/m/Y H:i')); ?></span>
                            </div>
                            <div class="col-md-3">
                                <strong>Statut:</strong><br>
                                <?php if($tenant->is_active): ?>
                                    <span class="badge bg-success">Actif</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Suspendu</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="d-flex justify-content-end">
                    <a href="<?php echo e(route('superadmin.tenants.show', $tenant)); ?>" class="btn btn-outline-secondary me-2">Annuler</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Mettre à Jour
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\superadmin\tenants\edit.blade.php ENDPATH**/ ?>