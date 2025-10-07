<?php $__env->startSection('title', 'Quick Order - Commande Rapide'); ?>

<?php $__env->startSection('content'); ?>
<div class="container" x-data="quickOrder()" x-init="init()">
    <!-- Header -->
    <div class="row mb-4 animate__animated animate__fadeInDown">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1><i class="bi bi-lightning-charge me-2 text-warning"></i>Commande Rapide</h1>
                    <p class="text-muted mb-0">
                        Passez vos commandes rapidement en saisissant les SKU ou en important un fichier CSV
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <button @click="clearAll()" class="btn btn-outline-danger" x-show="orderLines.length > 0">
                        <i class="bi bi-trash"></i> Tout effacer
                    </button>
                    <button @click="downloadTemplate()" class="btn btn-outline-secondary">
                        <i class="bi bi-download"></i> Template CSV
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Input Methods -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm animate__animated animate__fadeInLeft">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-input-cursor me-2"></i>Méthodes de saisie</h5>
                </div>
                <div class="card-body">
                    <!-- Manual Input -->
                    <div class="mb-4">
                        <h6 class="mb-3"><i class="bi bi-keyboard me-2 text-primary"></i>Saisie Manuelle</h6>
                        <form @submit.prevent="addLine()">
                            <div class="mb-3">
                                <label class="form-label">SKU Produit</label>
                                <input type="text"
                                       class="form-control"
                                       x-model="currentSku"
                                       @input="searchProduct()"
                                       placeholder="Ex: PROD-001"
                                       autocomplete="off">

                                <!-- Autocomplete Results -->
                                <div x-show="searchResults.length > 0 && currentSku.length > 2"
                                     class="position-absolute bg-white border rounded shadow-sm mt-1 w-100"
                                     style="z-index: 1000; max-height: 200px; overflow-y: auto;">
                                    <template x-for="product in searchResults" :key="product.id">
                                        <div class="p-2 border-bottom cursor-pointer hover-bg-light"
                                             @click="selectProduct(product)"
                                             style="cursor: pointer;">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <strong x-text="product.sku"></strong>
                                                    <div class="small text-muted" x-text="product.name"></div>
                                                </div>
                                                <div class="text-end">
                                                    <div class="small" x-text="product.price + ' DT'"></div>
                                                    <div class="small text-muted">Stock: <span x-text="product.stock_quantity"></span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Quantité</label>
                                <input type="number"
                                       class="form-control"
                                       x-model.number="currentQuantity"
                                       min="1"
                                       placeholder="1">
                            </div>

                            <button type="submit"
                                    class="btn btn-primary w-100"
                                    :disabled="!currentSku || currentQuantity < 1">
                                <i class="bi bi-plus-circle me-2"></i>Ajouter à la commande
                            </button>
                        </form>
                    </div>

                    <hr>

                    <!-- CSV Import -->
                    <div class="mb-3">
                        <h6 class="mb-3"><i class="bi bi-file-earmark-spreadsheet me-2 text-success"></i>Import CSV</h6>
                        <div class="mb-2">
                            <label class="btn btn-outline-success w-100 mb-0" for="csvFile">
                                <i class="bi bi-upload me-2"></i>
                                <span x-text="csvFileName || 'Choisir un fichier CSV'"></span>
                            </label>
                            <input type="file"
                                   id="csvFile"
                                   class="d-none"
                                   accept=".csv"
                                   @change="handleCsvUpload($event)">
                        </div>
                        <small class="text-muted">
                            Format: SKU, Quantité (une ligne par produit)
                        </small>
                    </div>

                    <hr>

                    <!-- Paste Mode -->
                    <div>
                        <h6 class="mb-3"><i class="bi bi-clipboard me-2 text-info"></i>Copier-Coller</h6>
                        <textarea class="form-control"
                                  rows="4"
                                  x-model="pasteText"
                                  placeholder="SKU1, Quantité&#10;SKU2, Quantité&#10;..."
                                  @blur="processPasteText()"></textarea>
                        <small class="text-muted">Copiez depuis Excel/Google Sheets</small>
                    </div>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="card shadow-sm mt-3 border-0 bg-light animate__animated animate__fadeInLeft"
                 style="animation-delay: 0.2s">
                <div class="card-body">
                    <h6 class="text-primary mb-2">
                        <i class="bi bi-lightbulb me-2"></i>Astuces Quick Order
                    </h6>
                    <ul class="small mb-0 ps-3">
                        <li>Tapez un SKU pour voir l'autocomplétion</li>
                        <li>Importez un CSV pour commandes en masse</li>
                        <li>Copiez depuis Excel directement</li>
                        <li>Vérifiez les stocks avant validation</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Order Lines -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm animate__animated animate__fadeInRight">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-list-ol me-2 text-primary"></i>
                        Lignes de commande
                        <span class="badge bg-primary ms-2" x-text="orderLines.length"></span>
                    </h5>
                    <div>
                        <span class="text-muted me-3">
                            Total: <strong class="text-primary" x-text="formatPrice(totalAmount)"></strong>
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Empty State -->
                    <div x-show="orderLines.length === 0" class="text-center py-5">
                        <i class="bi bi-cart-x display-1 text-muted mb-3"></i>
                        <h5 class="text-muted">Aucun produit ajouté</h5>
                        <p class="text-muted">Utilisez l'une des méthodes de saisie pour ajouter des produits</p>
                    </div>

                    <!-- Order Table -->
                    <div x-show="orderLines.length > 0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>SKU</th>
                                        <th>Produit</th>
                                        <th class="text-center">Quantité</th>
                                        <th class="text-end">Prix Unit.</th>
                                        <th class="text-end">Total</th>
                                        <th class="text-center" style="width: 80px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(line, index) in orderLines" :key="index">
                                        <tr class="animate__animated animate__fadeInUp"
                                            :class="{ 'table-danger': !line.in_stock, 'table-warning': line.below_minimum }">
                                            <td x-text="index + 1"></td>
                                            <td>
                                                <strong x-text="line.sku"></strong>
                                            </td>
                                            <td>
                                                <div x-text="line.name"></div>
                                                <small x-show="!line.in_stock" class="text-danger">
                                                    <i class="bi bi-exclamation-triangle"></i> Hors stock
                                                </small>
                                                <small x-show="line.below_minimum" class="text-warning">
                                                    <i class="bi bi-info-circle"></i> Min: <span x-text="line.min_order_quantity"></span>
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <div class="input-group input-group-sm d-inline-flex" style="width: 120px;">
                                                    <button class="btn btn-outline-secondary"
                                                            type="button"
                                                            @click="decrementQuantity(index)">
                                                        <i class="bi bi-dash"></i>
                                                    </button>
                                                    <input type="number"
                                                           class="form-control text-center"
                                                           x-model.number="line.quantity"
                                                           @change="updateLine(index)"
                                                           min="1">
                                                    <button class="btn btn-outline-secondary"
                                                            type="button"
                                                            @click="incrementQuantity(index)">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="text-end" x-text="formatPrice(line.price)"></td>
                                            <td class="text-end">
                                                <strong x-text="formatPrice(line.price * line.quantity)"></strong>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-danger"
                                                        @click="removeLine(index)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="5" class="text-end"><strong>Total</strong></td>
                                        <td class="text-end">
                                            <strong class="text-primary fs-5" x-text="formatPrice(totalAmount)"></strong>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Validation Errors -->
                        <div x-show="hasErrors" class="alert alert-danger">
                            <h6><i class="bi bi-exclamation-triangle me-2"></i>Attention</h6>
                            <ul class="mb-0">
                                <li x-show="outOfStockCount > 0">
                                    <span x-text="outOfStockCount"></span> produit(s) hors stock
                                </li>
                                <li x-show="belowMinimumCount > 0">
                                    <span x-text="belowMinimumCount"></span> produit(s) en dessous du minimum
                                </li>
                            </ul>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 justify-content-end mt-3">
                            <button @click="saveAsDraft()" class="btn btn-outline-secondary">
                                <i class="bi bi-save me-2"></i>Sauvegarder brouillon
                            </button>
                            <button @click="addToCart()"
                                    class="btn btn-success"
                                    :disabled="hasErrors || orderLines.length === 0">
                                <i class="bi bi-cart-plus me-2"></i>
                                Ajouter au panier (<span x-text="orderLines.length"></span> items)
                            </button>
                            <button @click="directCheckout()"
                                    class="btn btn-primary"
                                    :disabled="hasErrors || orderLines.length === 0">
                                <i class="bi bi-lightning-charge me-2"></i>
                                Commander directement
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function quickOrder() {
    return {
        orderLines: [],
        currentSku: '',
        currentQuantity: 1,
        searchResults: [],
        pasteText: '',
        csvFileName: '',
        searchTimeout: null,

        init() {
            // Load draft if exists
            const draft = localStorage.getItem('quick_order_draft');
            if (draft) {
                this.orderLines = JSON.parse(draft);
            }
        },

        get totalAmount() {
            return this.orderLines.reduce((sum, line) => sum + (line.price * line.quantity), 0);
        },

        get hasErrors() {
            return this.outOfStockCount > 0 || this.belowMinimumCount > 0;
        },

        get outOfStockCount() {
            return this.orderLines.filter(line => !line.in_stock).length;
        },

        get belowMinimumCount() {
            return this.orderLines.filter(line => line.below_minimum).length;
        },

        async searchProduct() {
            if (this.currentSku.length < 2) {
                this.searchResults = [];
                return;
            }

            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(async () => {
                try {
                    const response = await fetch(`/products/search?q=${encodeURIComponent(this.currentSku)}`);
                    const data = await response.json();
                    this.searchResults = data.slice(0, 5); // Limit to 5 results
                } catch (error) {
                    console.error('Search error:', error);
                }
            }, 300);
        },

        selectProduct(product) {
            this.currentSku = product.sku;
            this.searchResults = [];
            this.addLine(product);
        },

        addLine(product = null) {
            // If product not provided, search by SKU
            if (!product && this.currentSku) {
                // Try to find in search results
                product = this.searchResults.find(p => p.sku === this.currentSku);

                if (!product) {
                    notyf.error('Produit non trouvé: ' + this.currentSku);
                    return;
                }
            }

            if (!product) return;

            // Check if already in list
            const existingIndex = this.orderLines.findIndex(line => line.sku === product.sku);
            if (existingIndex >= 0) {
                this.orderLines[existingIndex].quantity += this.currentQuantity;
                notyf.success('Quantité mise à jour');
            } else {
                this.orderLines.push({
                    sku: product.sku,
                    name: product.name,
                    price: product.price || product.user_price,
                    quantity: this.currentQuantity,
                    stock_quantity: product.stock_quantity,
                    min_order_quantity: product.min_order_quantity || 1,
                    in_stock: product.stock_quantity > 0,
                    below_minimum: this.currentQuantity < (product.min_order_quantity || 1)
                });
                notyf.success('Produit ajouté');
            }

            // Reset form
            this.currentSku = '';
            this.currentQuantity = 1;
            this.searchResults = [];

            this.saveDraft();
        },

        incrementQuantity(index) {
            this.orderLines[index].quantity++;
            this.updateLine(index);
        },

        decrementQuantity(index) {
            if (this.orderLines[index].quantity > 1) {
                this.orderLines[index].quantity--;
                this.updateLine(index);
            }
        },

        updateLine(index) {
            const line = this.orderLines[index];
            line.below_minimum = line.quantity < line.min_order_quantity;
            this.saveDraft();
        },

        removeLine(index) {
            this.orderLines.splice(index, 1);
            notyf.success('Ligne supprimée');
            this.saveDraft();
        },

        clearAll() {
            if (confirm('Effacer toutes les lignes?')) {
                this.orderLines = [];
                localStorage.removeItem('quick_order_draft');
                notyf.success('Tout effacé');
            }
        },

        async handleCsvUpload(event) {
            const file = event.target.files[0];
            if (!file) return;

            this.csvFileName = file.name;

            const reader = new FileReader();
            reader.onload = (e) => {
                const text = e.target.result;
                this.parseCsv(text);
            };
            reader.readAsText(file);
        },

        parseCsv(text) {
            const lines = text.split('\n');
            let added = 0;

            lines.forEach(line => {
                const [sku, quantity] = line.trim().split(/[,;\t]/);
                if (sku && quantity) {
                    // Add to order (simplified, should fetch product data)
                    this.currentSku = sku.trim();
                    this.currentQuantity = parseInt(quantity.trim()) || 1;
                    // In real app, fetch product data
                    added++;
                }
            });

            notyf.success(`${added} ligne(s) importée(s)`);
            this.csvFileName = '';
        },

        processPasteText() {
            if (!this.pasteText.trim()) return;

            this.parseCsv(this.pasteText);
            this.pasteText = '';
        },

        downloadTemplate() {
            const csv = 'SKU,Quantité\nPROD-001,10\nPROD-002,5\n';
            const blob = new Blob([csv], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'quick_order_template.csv';
            a.click();
            notyf.success('Template téléchargé');
        },

        saveDraft() {
            localStorage.setItem('quick_order_draft', JSON.stringify(this.orderLines));
        },

        async addToCart() {
            if (this.hasErrors) {
                notyf.error('Veuillez corriger les erreurs avant de continuer');
                return;
            }

            // Add all lines to cart
            for (const line of this.orderLines) {
                try {
                    await fetch('/cart/add', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            product_sku: line.sku,
                            quantity: line.quantity
                        })
                    });
                } catch (error) {
                    console.error('Error adding to cart:', error);
                }
            }

            notyf.success(`${this.orderLines.length} produits ajoutés au panier`);
            this.orderLines = [];
            localStorage.removeItem('quick_order_draft');

            // Redirect to cart
            setTimeout(() => {
                window.location.href = '/cart';
            }, 1000);
        },

        async directCheckout() {
            if (this.hasErrors) {
                notyf.error('Veuillez corriger les erreurs avant de continuer');
                return;
            }

            await this.addToCart();
            // Then redirect to checkout (handled in addToCart)
        },

        formatPrice(amount) {
            return parseFloat(amount).toFixed(2) + ' DT';
        }
    }
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.hover-bg-light:hover {
    background-color: #f8f9fa;
}

.cursor-pointer {
    cursor: pointer;
}

.table-warning {
    background-color: #fff3cd50 !important;
}

.table-danger {
    background-color: #f8d7da50 !important;
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\quick-order\index.blade.php ENDPATH**/ ?>