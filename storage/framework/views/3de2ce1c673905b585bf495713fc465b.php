<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-file-invoice"></i> Nouveau Devis
            </h1>
            <p class="text-muted">Créer un nouveau devis pour un client</p>
        </div>
        <div>
            <a href="<?php echo e(route('admin.quotes.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <form action="<?php echo e(route('admin.quotes.store')); ?>" method="POST" id="quote-form">
        <?php echo csrf_field(); ?>

        <div class="row">
            <div class="col-lg-8">
                <!-- Informations Client -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-user"></i> Informations Client</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="user_id" class="form-label">Vendeur <span class="text-danger">*</span></label>
                                <select class="form-select <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="user_id"
                                        name="user_id"
                                        required
                                        onchange="loadUserInfo()">
                                    <option value="">-- Sélectionner un vendeur --</option>
                                    <?php $__currentLoopData = $vendeurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendeur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($vendeur->id); ?>" <?php echo e(old('user_id') == $vendeur->id ? 'selected' : ''); ?>>
                                            <?php echo e($vendeur->name); ?> (<?php echo e($vendeur->email); ?>)
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

                            <div class="col-md-6 mb-3">
                                <label for="valid_until" class="form-label">Valide jusqu'au <span class="text-danger">*</span></label>
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
                                       value="<?php echo e(old('valid_until', now()->addDays(30)->format('Y-m-d'))); ?>"
                                       required
                                       min="<?php echo e(now()->addDay()->format('Y-m-d')); ?>">
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

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="customer_name" class="form-label">Nom du client <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control <?php $__errorArgs = ['customer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="customer_name"
                                       name="customer_name"
                                       value="<?php echo e(old('customer_name')); ?>"
                                       required>
                                <?php $__errorArgs = ['customer_name'];
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
                                <label for="customer_email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email"
                                       class="form-control <?php $__errorArgs = ['customer_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="customer_email"
                                       name="customer_email"
                                       value="<?php echo e(old('customer_email')); ?>"
                                       required>
                                <?php $__errorArgs = ['customer_email'];
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
                                <label for="customer_phone" class="form-label">Téléphone</label>
                                <input type="text"
                                       class="form-control <?php $__errorArgs = ['customer_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="customer_phone"
                                       name="customer_phone"
                                       value="<?php echo e(old('customer_phone')); ?>">
                                <?php $__errorArgs = ['customer_phone'];
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

                <!-- Articles -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-box"></i> Articles</h5>
                        <button type="button" class="btn btn-sm btn-primary" onclick="addItem()">
                            <i class="fas fa-plus"></i> Ajouter un article
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="items-container">
                            <!-- Les articles seront ajoutés ici -->
                        </div>

                        <div class="alert alert-info mt-3" id="empty-items-alert">
                            <i class="fas fa-info-circle"></i> Cliquez sur "Ajouter un article" pour commencer
                        </div>
                    </div>
                </div>

                <!-- Notes et Conditions -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-sticky-note"></i> Notes et Conditions</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes internes</label>
                            <textarea class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      id="notes"
                                      name="notes"
                                      rows="3"><?php echo e(old('notes')); ?></textarea>
                            <?php $__errorArgs = ['notes'];
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
                            <label for="terms" class="form-label">Conditions générales</label>
                            <textarea class="form-control <?php $__errorArgs = ['terms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      id="terms"
                                      name="terms"
                                      rows="4"><?php echo e(old('terms', 'Paiement sous 30 jours. Marchandise non reprise.')); ?></textarea>
                            <?php $__errorArgs = ['terms'];
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

            <!-- Sidebar Résumé -->
            <div class="col-lg-4">
                <div class="card mb-4 sticky-top" style="top: 20px;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-calculator"></i> Résumé</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="discount" class="form-label">Remise globale (TND)</label>
                            <input type="number"
                                   class="form-control"
                                   id="discount"
                                   name="discount"
                                   value="<?php echo e(old('discount', 0)); ?>"
                                   min="0"
                                   step="0.01"
                                   onchange="calculateTotals()">
                        </div>

                        <div class="mb-3">
                            <label for="tax_rate" class="form-label">Taux TVA (%) <span class="text-danger">*</span></label>
                            <input type="number"
                                   class="form-control <?php $__errorArgs = ['tax_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="tax_rate"
                                   name="tax_rate"
                                   value="<?php echo e(old('tax_rate', 19)); ?>"
                                   min="0"
                                   max="100"
                                   step="0.01"
                                   required
                                   onchange="calculateTotals()">
                            <?php $__errorArgs = ['tax_rate'];
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

                        <hr>

                        <table class="table table-sm">
                            <tr>
                                <td><strong>Sous-total HT:</strong></td>
                                <td class="text-end"><span id="subtotal-display">0.00</span> TND</td>
                            </tr>
                            <tr>
                                <td><strong>Remise:</strong></td>
                                <td class="text-end text-success">-<span id="discount-display">0.00</span> TND</td>
                            </tr>
                            <tr>
                                <td><strong>TVA (<span id="tax-rate-display">19</span>%):</strong></td>
                                <td class="text-end"><span id="tax-display">0.00</span> TND</td>
                            </tr>
                            <tr class="table-primary">
                                <td><strong>TOTAL TTC:</strong></td>
                                <td class="text-end"><h5 class="mb-0"><span id="total-display">0.00</span> TND</h5></td>
                            </tr>
                        </table>

                        <hr>

                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-save"></i> Créer le devis
                        </button>
                        <a href="<?php echo e(route('admin.quotes.index')); ?>" class="btn btn-secondary w-100">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Template pour un article -->
<template id="item-template">
    <div class="card mb-3 item-card" data-index="">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Article <span class="item-number"></span></h6>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeItem(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Produit <span class="text-danger">*</span></label>
                    <select class="form-select item-product" name="items[INDEX][product_id]" required onchange="updatePrice(this)">
                        <option value="">-- Sélectionner --</option>
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($product->id); ?>" data-price="<?php echo e($product->price); ?>">
                                <?php echo e($product->name); ?> (<?php echo e(number_format($product->price, 2)); ?> TND)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Quantité <span class="text-danger">*</span></label>
                    <input type="number"
                           class="form-control item-quantity"
                           name="items[INDEX][quantity]"
                           value="1"
                           min="1"
                           required
                           onchange="calculateItemTotal(this)">
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Prix unitaire <span class="text-danger">*</span></label>
                    <input type="number"
                           class="form-control item-price"
                           name="items[INDEX][unit_price]"
                           value="0"
                           min="0"
                           step="0.01"
                           required
                           onchange="calculateItemTotal(this)">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Remise (TND)</label>
                    <input type="number"
                           class="form-control item-discount"
                           name="items[INDEX][discount]"
                           value="0"
                           min="0"
                           step="0.01"
                           onchange="calculateItemTotal(this)">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Sous-total</label>
                    <div class="input-group">
                        <span class="form-control item-subtotal">0.00</span>
                        <span class="input-group-text">TND</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
let itemIndex = 0;

function addItem() {
    const template = document.getElementById('item-template');
    const clone = template.content.cloneNode(true);

    // Remplacer INDEX par l'index actuel
    clone.querySelectorAll('[name*="INDEX"]').forEach(el => {
        el.name = el.name.replace('INDEX', itemIndex);
    });

    const card = clone.querySelector('.item-card');
    card.dataset.index = itemIndex;
    clone.querySelector('.item-number').textContent = itemIndex + 1;

    document.getElementById('items-container').appendChild(clone);
    document.getElementById('empty-items-alert').style.display = 'none';

    itemIndex++;
}

function removeItem(button) {
    button.closest('.item-card').remove();
    updateItemNumbers();
    calculateTotals();

    if (document.querySelectorAll('.item-card').length === 0) {
        document.getElementById('empty-items-alert').style.display = 'block';
    }
}

function updateItemNumbers() {
    document.querySelectorAll('.item-card').forEach((card, index) => {
        card.querySelector('.item-number').textContent = index + 1;
    });
}

function updatePrice(select) {
    const option = select.options[select.selectedIndex];
    const price = option.dataset.price || 0;
    const card = select.closest('.item-card');
    card.querySelector('.item-price').value = price;
    calculateItemTotal(select);
}

function calculateItemTotal(element) {
    const card = element.closest('.item-card');
    const quantity = parseFloat(card.querySelector('.item-quantity').value) || 0;
    const price = parseFloat(card.querySelector('.item-price').value) || 0;
    const discount = parseFloat(card.querySelector('.item-discount').value) || 0;

    const subtotal = (quantity * price) - discount;
    card.querySelector('.item-subtotal').textContent = subtotal.toFixed(2);

    calculateTotals();
}

function calculateTotals() {
    let subtotal = 0;

    document.querySelectorAll('.item-card').forEach(card => {
        const itemSubtotal = parseFloat(card.querySelector('.item-subtotal').textContent) || 0;
        subtotal += itemSubtotal;
    });

    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const taxRate = parseFloat(document.getElementById('tax_rate').value) || 0;

    const subtotalAfterDiscount = subtotal - discount;
    const tax = subtotalAfterDiscount * (taxRate / 100);
    const total = subtotalAfterDiscount + tax;

    document.getElementById('subtotal-display').textContent = subtotal.toFixed(2);
    document.getElementById('discount-display').textContent = discount.toFixed(2);
    document.getElementById('tax-rate-display').textContent = taxRate.toFixed(2);
    document.getElementById('tax-display').textContent = tax.toFixed(2);
    document.getElementById('total-display').textContent = total.toFixed(2);
}

function loadUserInfo() {
    // TODO: Charger automatiquement les infos du vendeur si nécessaire
}

// Ajouter un article par défaut au chargement
document.addEventListener('DOMContentLoaded', function() {
    addItem();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views/admin/quotes/create.blade.php ENDPATH**/ ?>