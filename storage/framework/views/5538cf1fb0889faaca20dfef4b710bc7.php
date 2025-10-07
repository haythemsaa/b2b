<?php $__env->startSection('title', 'Nouvelle Demande de Retour'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Nouvelle Demande de Retour</h1>
                <a href="<?php echo e(route('returns.index')); ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if($orders->count() === 0): ?>
        <div class="alert alert-info">
            <h5><i class="fas fa-info-circle"></i> Aucune commande éligible</h5>
            <p class="mb-0">
                Vous devez avoir des commandes livrées pour pouvoir faire une demande de retour.
                Les retours ne sont possibles que sur des commandes avec le statut "Livrée".
            </p>
        </div>
    <?php else: ?>
        <form action="<?php echo e(route('returns.store')); ?>" method="POST" enctype="multipart/form-data" id="returnForm">
            <?php echo csrf_field(); ?>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">1. Sélection de la commande et du produit</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Commande <span class="text-danger">*</span></label>
                                    <select name="order_id" id="orderSelect" class="form-select" required>
                                        <option value="">Choisissez une commande...</option>
                                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($order->id); ?>"
                                                    <?php echo e($selectedOrderItem && $selectedOrderItem->order_id == $order->id ? 'selected' : ''); ?>>
                                                <?php echo e($order->order_number); ?> - <?php echo e($order->delivered_at->format('d/m/Y')); ?>

                                                (<?php echo e($order->items->count()); ?> article(s))
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="form-text">Seules les commandes livrées sont éligibles</div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Article à retourner <span class="text-danger">*</span></label>
                                    <select name="order_item_id" id="orderItemSelect" class="form-select" required>
                                        <option value="">Sélectionnez d'abord une commande</option>
                                    </select>
                                    <div class="form-text">Articles disponibles pour retour</div>
                                </div>
                            </div>

                            <!-- Détails du produit sélectionné -->
                            <div id="productDetails" style="display: none;" class="mt-3 p-3 bg-light rounded">
                                <h6>Détails du produit :</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong id="productName"></strong><br>
                                        <small class="text-muted">SKU: <span id="productSku"></span></small>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <div>Commandé: <span id="quantityOrdered" class="badge bg-primary"></span></div>
                                        <div>Déjà retourné: <span id="quantityReturned" class="badge bg-secondary"></span></div>
                                        <div>Disponible: <span id="quantityAvailable" class="badge bg-success"></span></div>
                                        <div class="mt-1">Prix unitaire: <span id="unitPrice"></span> MAD</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">2. Détails du retour</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Quantité à retourner <span class="text-danger">*</span></label>
                                    <input type="number" name="quantity_returned" id="quantityReturnedInput"
                                           class="form-control" min="1" max="1" value="<?php echo e(old('quantity_returned', 1)); ?>" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Raison du retour <span class="text-danger">*</span></label>
                                    <select name="reason" class="form-select" required>
                                        <option value="">Choisissez une raison...</option>
                                        <option value="defective" <?php echo e(old('reason') == 'defective' ? 'selected' : ''); ?>>Produit défectueux</option>
                                        <option value="wrong_item" <?php echo e(old('reason') == 'wrong_item' ? 'selected' : ''); ?>>Mauvais article</option>
                                        <option value="not_as_described" <?php echo e(old('reason') == 'not_as_described' ? 'selected' : ''); ?>>Non conforme à la description</option>
                                        <option value="damaged_shipping" <?php echo e(old('reason') == 'damaged_shipping' ? 'selected' : ''); ?>>Endommagé pendant l'expédition</option>
                                        <option value="expired" <?php echo e(old('reason') == 'expired' ? 'selected' : ''); ?>>Produit périmé</option>
                                        <option value="other" <?php echo e(old('reason') == 'other' ? 'selected' : ''); ?>>Autre raison</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">État du produit <span class="text-danger">*</span></label>
                                    <select name="condition" class="form-select" required>
                                        <option value="">Choisissez l'état...</option>
                                        <option value="unopened" <?php echo e(old('condition') == 'unopened' ? 'selected' : ''); ?>>Non ouvert</option>
                                        <option value="opened" <?php echo e(old('condition') == 'opened' ? 'selected' : ''); ?>>Ouvert</option>
                                        <option value="damaged" <?php echo e(old('condition') == 'damaged' ? 'selected' : ''); ?>>Endommagé</option>
                                        <option value="unusable" <?php echo e(old('condition') == 'unusable' ? 'selected' : ''); ?>>Inutilisable</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Type de retour souhaité <span class="text-danger">*</span></label>
                                    <select name="return_type" class="form-select" required>
                                        <option value="">Choisissez le type...</option>
                                        <option value="refund" <?php echo e(old('return_type') == 'refund' ? 'selected' : ''); ?>>Remboursement</option>
                                        <option value="replacement" <?php echo e(old('return_type') == 'replacement' ? 'selected' : ''); ?>>Remplacement</option>
                                        <option value="credit" <?php echo e(old('return_type') == 'credit' ? 'selected' : ''); ?>>Avoir client</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Photos du produit (optionnel)</label>
                                    <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                                    <div class="form-text">Ajoutez des photos pour justifier votre demande (max 2MB par image)</div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Détails supplémentaires</label>
                                <textarea name="reason_details" class="form-control" rows="4"
                                          placeholder="Décrivez en détail le problème rencontré..."><?php echo e(old('reason_details')); ?></textarea>
                                <div class="form-text">Plus vous donnerez de détails, plus votre demande sera traitée rapidement</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Résumé</h6>
                        </div>
                        <div class="card-body">
                            <div id="returnSummary" style="display: none;">
                                <div class="mb-3">
                                    <label class="text-muted">Produit :</label>
                                    <div id="summaryProduct">-</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted">Quantité :</label>
                                    <div id="summaryQuantity">-</div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted">Valeur estimée :</label>
                                    <div id="summaryValue" class="fw-bold text-success">-</div>
                                </div>
                            </div>
                            <div id="noSelection" class="text-center text-muted py-3">
                                Sélectionnez un produit pour voir le résumé
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Informations importantes</h6>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info mb-3">
                                <h6><i class="fas fa-info-circle"></i> À savoir</h6>
                                <ul class="mb-0 small">
                                    <li>Délai de traitement : 48-72h</li>
                                    <li>Seuls les produits livrés peuvent être retournés</li>
                                    <li>Les photos accélèrent le traitement</li>
                                    <li>Vous recevrez une notification par email</li>
                                </ul>
                            </div>

                            <div class="alert alert-warning mb-0">
                                <h6><i class="fas fa-exclamation-triangle"></i> Attention</h6>
                                <p class="mb-0 small">
                                    Une fois soumise, votre demande ne peut plus être modifiée.
                                    Assurez-vous que toutes les informations sont correctes.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-paper-plane"></i> Soumettre la demande
                            </button>
                            <a href="<?php echo e(route('returns.index')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const orderSelect = document.getElementById('orderSelect');
    const orderItemSelect = document.getElementById('orderItemSelect');
    const productDetails = document.getElementById('productDetails');
    const quantityInput = document.getElementById('quantityReturnedInput');
    const returnSummary = document.getElementById('returnSummary');
    const noSelection = document.getElementById('noSelection');

    let currentOrderItems = [];
    let selectedItem = null;

    <?php if($selectedOrderItem): ?>
        // Si un item est pré-sélectionné, charger ses détails
        loadOrderItems(<?php echo e($selectedOrderItem->order_id); ?>, <?php echo e($selectedOrderItem->id); ?>);
    <?php endif; ?>

    orderSelect.addEventListener('change', function() {
        const orderId = this.value;

        if (orderId) {
            loadOrderItems(orderId);
        } else {
            resetItemSelection();
        }
    });

    orderItemSelect.addEventListener('change', function() {
        const itemId = this.value;

        if (itemId) {
            selectedItem = currentOrderItems.find(item => item.id == itemId);
            if (selectedItem) {
                showProductDetails(selectedItem);
                updateSummary();
            }
        } else {
            hideProductDetails();
        }
    });

    quantityInput.addEventListener('input', function() {
        updateSummary();
    });

    function loadOrderItems(orderId, preselectedItemId = null) {
        fetch(`/returns/order/${orderId}/items`)
            .then(response => response.json())
            .then(data => {
                currentOrderItems = data;
                updateOrderItemSelect(preselectedItemId);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors du chargement des articles');
            });
    }

    function updateOrderItemSelect(preselectedItemId = null) {
        orderItemSelect.innerHTML = '<option value="">Choisissez un article...</option>';

        currentOrderItems.forEach(item => {
            if (item.can_return) {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = `${item.product_name} (${item.quantity_available} disponible)`;
                if (preselectedItemId && item.id == preselectedItemId) {
                    option.selected = true;
                }
                orderItemSelect.appendChild(option);
            }
        });

        // Si un item est présélectionné, déclencher l'événement de changement
        if (preselectedItemId) {
            orderItemSelect.dispatchEvent(new Event('change'));
        }
    }

    function showProductDetails(item) {
        document.getElementById('productName').textContent = item.product_name;
        document.getElementById('productSku').textContent = item.product_sku;
        document.getElementById('quantityOrdered').textContent = item.quantity_ordered;
        document.getElementById('quantityReturned').textContent = item.quantity_returned;
        document.getElementById('quantityAvailable').textContent = item.quantity_available;
        document.getElementById('unitPrice').textContent = parseFloat(item.unit_price).toFixed(2);

        quantityInput.max = item.quantity_available;
        quantityInput.value = Math.min(quantityInput.value || 1, item.quantity_available);

        productDetails.style.display = 'block';
    }

    function hideProductDetails() {
        productDetails.style.display = 'none';
        resetSummary();
    }

    function updateSummary() {
        if (selectedItem && quantityInput.value) {
            const quantity = parseInt(quantityInput.value);
            const totalValue = quantity * parseFloat(selectedItem.unit_price);

            document.getElementById('summaryProduct').textContent = selectedItem.product_name;
            document.getElementById('summaryQuantity').textContent = quantity + ' unité(s)';
            document.getElementById('summaryValue').textContent = totalValue.toFixed(2) + ' MAD';

            returnSummary.style.display = 'block';
            noSelection.style.display = 'none';
        } else {
            resetSummary();
        }
    }

    function resetSummary() {
        returnSummary.style.display = 'none';
        noSelection.style.display = 'block';
    }

    function resetItemSelection() {
        orderItemSelect.innerHTML = '<option value="">Sélectionnez d\'abord une commande</option>';
        hideProductDetails();
        currentOrderItems = [];
        selectedItem = null;
    }

    // Validation du formulaire
    document.getElementById('returnForm').addEventListener('submit', function(e) {
        if (!selectedItem) {
            e.preventDefault();
            alert('Veuillez sélectionner un article à retourner');
            return false;
        }

        const quantity = parseInt(quantityInput.value);
        if (quantity > selectedItem.quantity_available) {
            e.preventDefault();
            alert(`Quantité maximum disponible: ${selectedItem.quantity_available}`);
            return false;
        }

        return true;
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\returns\create.blade.php ENDPATH**/ ?>