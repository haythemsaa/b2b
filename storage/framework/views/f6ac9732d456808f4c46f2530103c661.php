

<?php $__env->startSection('title', 'Créer un Tarif Personnalisé'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Créer un Tarif Personnalisé</h1>
                <a href="<?php echo e(route('admin.custom-prices.index')); ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informations du Tarif</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.custom-prices.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="product_id" class="form-label">Produit <span class="text-danger">*</span></label>
                                <select class="form-select <?php $__errorArgs = ['product_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="product_id"
                                        name="product_id"
                                        required>
                                    <option value="">Sélectionner un produit</option>
                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($product->id); ?>"
                                                data-price="<?php echo e($product->price); ?>"
                                                <?php echo e(old('product_id') == $product->id ? 'selected' : ''); ?>>
                                            <?php echo e($product->name); ?> (<?php echo e(number_format($product->price, 2)); ?> MAD)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['product_id'];
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
                                <label for="price" class="form-label">Prix Personnalisé <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number"
                                           class="form-control <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="price"
                                           name="price"
                                           value="<?php echo e(old('price')); ?>"
                                           step="0.01"
                                           min="0"
                                           required>
                                    <span class="input-group-text">MAD</span>
                                </div>
                                <small id="price-comparison" class="form-text"></small>
                                <?php $__errorArgs = ['price'];
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

                        <div class="mb-3">
                            <label class="form-label">Type de Tarif <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" id="type_group" value="group" <?php echo e(old('type', 'group') === 'group' ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="type_group">
                                            <i class="fas fa-users text-info"></i>
                                            <strong>Groupe de Clients</strong>
                                            <div class="small text-muted">Appliquer à tout un groupe</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" id="type_user" value="user" <?php echo e(old('type') === 'user' ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="type_user">
                                            <i class="fas fa-user text-primary"></i>
                                            <strong>Vendeur Spécifique</strong>
                                            <div class="small text-muted">Appliquer à un vendeur unique</div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3" id="group-selection">
                                <label for="customer_group_id" class="form-label">Groupe de Clients</label>
                                <select class="form-select <?php $__errorArgs = ['customer_group_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="customer_group_id"
                                        name="customer_group_id">
                                    <option value="">Sélectionner un groupe</option>
                                    <?php $__currentLoopData = $customerGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($group->id); ?>" <?php echo e(old('customer_group_id') == $group->id ? 'selected' : ''); ?>>
                                            <?php echo e($group->name); ?>

                                            <?php if($group->discount_percentage > 0): ?>
                                                (remise <?php echo e($group->discount_percentage); ?>%)
                                            <?php endif; ?>
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['customer_group_id'];
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

                            <div class="col-md-6 mb-3" id="user-selection" style="display: none;">
                                <label for="user_id" class="form-label">Vendeur Spécifique</label>
                                <select class="form-select <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="user_id"
                                        name="user_id">
                                    <option value="">Sélectionner un vendeur</option>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($user->id); ?>" <?php echo e(old('user_id') == $user->id ? 'selected' : ''); ?>>
                                            <?php echo e($user->name); ?> - <?php echo e($user->company_name ?? $user->email); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['user_id'];
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

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="min_quantity" class="form-label">Quantité Minimum</label>
                                <input type="number"
                                       class="form-control <?php $__errorArgs = ['min_quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="min_quantity"
                                       name="min_quantity"
                                       value="<?php echo e(old('min_quantity', 1)); ?>"
                                       min="1">
                                <small class="form-text text-muted">Quantité minimum pour appliquer ce tarif</small>
                                <?php $__errorArgs = ['min_quantity'];
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

                            <div class="col-md-4 mb-3">
                                <label for="valid_from" class="form-label">Valide à partir du</label>
                                <input type="date"
                                       class="form-control <?php $__errorArgs = ['valid_from'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="valid_from"
                                       name="valid_from"
                                       value="<?php echo e(old('valid_from')); ?>">
                                <small class="form-text text-muted">Laissez vide pour immédiat</small>
                                <?php $__errorArgs = ['valid_from'];
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

                            <div class="col-md-4 mb-3">
                                <label for="valid_until" class="form-label">Valide jusqu'au</label>
                                <input type="date"
                                       class="form-control <?php $__errorArgs = ['valid_until'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="valid_until"
                                       name="valid_until"
                                       value="<?php echo e(old('valid_until')); ?>">
                                <small class="form-text text-muted">Laissez vide pour permanent</small>
                                <?php $__errorArgs = ['valid_until'];
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

                        <?php if($errors->has('error')): ?>
                            <div class="alert alert-danger">
                                <?php echo e($errors->first('error')); ?>

                            </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?php echo e(route('admin.custom-prices.index')); ?>" class="btn btn-outline-secondary">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Créer le Tarif
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
                        <h6><i class="fas fa-info-circle text-info"></i> Tarifs Personnalisés</h6>
                        <p class="small text-muted">
                            Créez des prix spéciaux pour vos clients ou groupes de clients selon vos besoins commerciaux.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6><i class="fas fa-users text-primary"></i> Groupes vs Individuel</h6>
                        <p class="small text-muted">
                            <strong>Groupe :</strong> Le tarif s'applique à tous les membres du groupe.<br>
                            <strong>Individuel :</strong> Le tarif ne s'applique qu'au vendeur sélectionné.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6><i class="fas fa-calendar text-warning"></i> Validité</h6>
                        <p class="small text-muted">
                            Définissez une période de validité pour des promotions temporaires ou laissez vide pour un tarif permanent.
                        </p>
                    </div>

                    <div>
                        <h6><i class="fas fa-sort-numeric-up text-success"></i> Quantité Minimum</h6>
                        <p class="small text-muted">
                            Le tarif ne s'applique que si la quantité commandée atteint le minimum spécifié.
                        </p>
                    </div>
                </div>
            </div>

            <div class="card mt-3" id="product-info" style="display: none;">
                <div class="card-header">
                    <h6 class="card-title mb-0">Information Produit</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted">Prix Standard</small>
                        <div id="standard-price" class="fw-bold"></div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Votre Prix</small>
                        <div id="custom-price" class="fw-bold text-success"></div>
                    </div>
                    <div>
                        <small class="text-muted">Différence</small>
                        <div id="price-difference" class="fw-bold"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeRadios = document.querySelectorAll('input[name="type"]');
    const groupSelection = document.getElementById('group-selection');
    const userSelection = document.getElementById('user-selection');
    const productSelect = document.getElementById('product_id');
    const priceInput = document.getElementById('price');
    const priceComparison = document.getElementById('price-comparison');
    const productInfo = document.getElementById('product-info');

    // Toggle entre groupe et utilisateur
    typeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'group') {
                groupSelection.style.display = 'block';
                userSelection.style.display = 'none';
                document.getElementById('customer_group_id').required = true;
                document.getElementById('user_id').required = false;
            } else {
                groupSelection.style.display = 'none';
                userSelection.style.display = 'block';
                document.getElementById('customer_group_id').required = false;
                document.getElementById('user_id').required = true;
            }
        });
    });

    // Déclencher l'événement au chargement
    document.querySelector('input[name="type"]:checked').dispatchEvent(new Event('change'));

    // Comparaison des prix
    function updatePriceComparison() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const customPrice = parseFloat(priceInput.value);

        if (selectedOption && selectedOption.dataset.price && customPrice) {
            const standardPrice = parseFloat(selectedOption.dataset.price);
            const difference = standardPrice - customPrice;
            const percentage = (difference / standardPrice * 100).toFixed(1);

            productInfo.style.display = 'block';
            document.getElementById('standard-price').textContent = standardPrice.toFixed(2) + ' MAD';
            document.getElementById('custom-price').textContent = customPrice.toFixed(2) + ' MAD';

            if (difference > 0) {
                priceComparison.innerHTML = `<span class="text-success">Économie: ${difference.toFixed(2)} MAD (-${percentage}%)</span>`;
                document.getElementById('price-difference').innerHTML = `<span class="text-success">-${difference.toFixed(2)} MAD (-${percentage}%)</span>`;
            } else if (difference < 0) {
                priceComparison.innerHTML = `<span class="text-warning">Supplément: ${Math.abs(difference).toFixed(2)} MAD (+${Math.abs(percentage)}%)</span>`;
                document.getElementById('price-difference').innerHTML = `<span class="text-warning">+${Math.abs(difference).toFixed(2)} MAD (+${Math.abs(percentage)}%)</span>`;
            } else {
                priceComparison.innerHTML = `<span class="text-muted">Prix identique</span>`;
                document.getElementById('price-difference').innerHTML = `<span class="text-muted">Identique</span>`;
            }
        } else {
            priceComparison.textContent = '';
            productInfo.style.display = 'none';
        }
    }

    productSelect.addEventListener('change', updatePriceComparison);
    priceInput.addEventListener('input', updatePriceComparison);
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\custom-prices\create.blade.php ENDPATH**/ ?>