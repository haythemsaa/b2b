<?php $__env->startSection('title', __('Shopping Cart')); ?>

<?php $__env->startSection('content'); ?>
<div class="container" x-data="cartManager()" x-init="init()">
    <div class="row mb-4 animate__animated animate__fadeInDown">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="bi bi-cart3 me-2 text-primary"></i><?php echo e(__('Shopping Cart')); ?></h1>
                <p class="text-muted mb-0">
                    <span x-show="items.length > 0">
                        <span x-text="items.length"></span> <?php echo e(__('item(s)')); ?> -
                        <span x-text="totalItems"></span> <?php echo e(__('product(s)')); ?>

                    </span>
                </p>
            </div>
            <div x-show="items.length > 0">
                <button @click="clearCart()" class="btn btn-outline-danger">
                    <i class="bi bi-trash me-2"></i><?php echo e(__('Clear Cart')); ?>

                </button>
            </div>
        </div>
    </div>

    <!-- Empty State -->
    <div x-show="items.length === 0" class="row">
        <div class="col-12 text-center py-5 animate__animated animate__fadeIn">
            <i class="bi bi-cart-x display-1 text-muted mb-3"></i>
            <h4 class="text-muted mb-3"><?php echo e(__('Your cart is empty')); ?></h4>
            <p class="text-muted mb-4"><?php echo e(__('Add some products to your cart to continue shopping')); ?></p>
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary btn-lg">
                <i class="bi bi-shop me-2"></i><?php echo e(__('Start Shopping')); ?>

            </a>
        </div>
    </div>

    <!-- Cart Items -->
    <div x-show="items.length > 0" class="row">
        <!-- Cart Items List -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm animate__animated animate__fadeInLeft">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-bag me-2"></i><?php echo e(__('Cart Items')); ?></h5>
                </div>
                <div class="card-body">
                    <template x-for="(item, index) in items" :key="item.id">
                        <div class="row align-items-center mb-3 pb-3 border-bottom position-relative animate__animated animate__fadeInUp"
                             :style="'animation-delay: ' + (index * 0.1) + 's'">

                            <!-- Loading Overlay -->
                            <div x-show="item.updating"
                                 class="position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-75 d-flex align-items-center justify-content-center"
                                 style="z-index: 10;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>

                            <!-- Image -->
                            <div class="col-md-2 col-3">
                                <div class="position-relative">
                                    <img :src="item.image_url || '/images/placeholder.png'"
                                         class="img-fluid rounded shadow-sm"
                                         :alt="item.name">
                                    <span class="position-absolute top-0 start-0 badge bg-primary m-1"
                                          x-show="item.discount > 0">
                                        -<span x-text="item.discount"></span>%
                                    </span>
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="col-md-4 col-9">
                                <h6 class="mb-1 fw-bold" x-text="item.name"></h6>
                                <small class="text-muted d-block">SKU: <span x-text="item.sku"></span></small>
                                <template x-if="item.min_order_quantity > 1">
                                    <small class="badge bg-warning text-dark mt-1">
                                        Min: <span x-text="item.min_order_quantity"></span>
                                    </small>
                                </template>
                            </div>

                            <!-- Price -->
                            <div class="col-md-2 col-6 mt-2 mt-md-0">
                                <template x-if="item.original_price && item.original_price != item.price">
                                    <div>
                                        <small class="text-muted text-decoration-line-through d-block"
                                               x-text="formatPrice(item.original_price)"></small>
                                        <strong class="text-primary" x-text="formatPrice(item.price)"></strong>
                                    </div>
                                </template>
                                <template x-if="!item.original_price || item.original_price == item.price">
                                    <strong x-text="formatPrice(item.price)"></strong>
                                </template>
                            </div>

                            <!-- Quantity Controls -->
                            <div class="col-md-2 col-6 mt-2 mt-md-0">
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-outline-secondary"
                                            type="button"
                                            @click="decrementQuantity(item.id)"
                                            :disabled="item.quantity <= (item.min_order_quantity || 1)">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input type="number"
                                           class="form-control text-center"
                                           :value="item.quantity"
                                           @change="updateQuantity(item.id, $event.target.value)"
                                           :min="item.min_order_quantity || 1"
                                           :max="item.stock_quantity"
                                           style="max-width: 60px;">
                                    <button class="btn btn-outline-secondary"
                                            type="button"
                                            @click="incrementQuantity(item.id)"
                                            :disabled="item.quantity >= item.stock_quantity">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                                <small class="text-muted d-block mt-1">
                                    Stock: <span x-text="item.stock_quantity"></span>
                                </small>
                            </div>

                            <!-- Subtotal & Remove -->
                            <div class="col-md-2 col-12 mt-2 mt-md-0 text-md-end">
                                <div class="mb-2">
                                    <strong class="text-primary fs-5" x-text="formatPrice(item.price * item.quantity)"></strong>
                                </div>
                                <button @click="removeItem(item.id)"
                                        class="btn btn-sm btn-outline-danger transition-all">
                                    <i class="bi bi-trash"></i> <?php echo e(__('Remove')); ?>

                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Continue Shopping -->
            <div class="mt-3">
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i><?php echo e(__('Continue Shopping')); ?>

                </a>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card shadow-sm position-sticky animate__animated animate__fadeInRight" style="top: 20px;">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-receipt me-2"></i><?php echo e(__('Order Summary')); ?></h5>
                </div>
                <div class="card-body">
                    <!-- Subtotal -->
                    <div class="d-flex justify-content-between mb-2 pb-2">
                        <span><?php echo e(__('Subtotal')); ?>:</span>
                        <strong x-text="formatPrice(subtotal)"></strong>
                    </div>

                    <!-- Discount -->
                    <div x-show="totalDiscount > 0" class="d-flex justify-content-between mb-2 pb-2 text-success">
                        <span><?php echo e(__('Discount')); ?>:</span>
                        <strong>-<span x-text="formatPrice(totalDiscount)"></span></strong>
                    </div>

                    <!-- Tax -->
                    <div class="d-flex justify-content-between mb-2 pb-2">
                        <span><?php echo e(__('Tax')); ?> (<span x-text="taxRate + '%'"></span>):</span>
                        <span x-text="formatPrice(taxAmount)"></span>
                    </div>

                    <!-- Shipping -->
                    <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                        <span><?php echo e(__('Shipping')); ?>:</span>
                        <span class="text-success" x-text="shippingCost > 0 ? formatPrice(shippingCost) : 'FREE'"></span>
                    </div>

                    <!-- Total -->
                    <div class="d-flex justify-content-between mb-4">
                        <h5 class="mb-0"><?php echo e(__('Total')); ?>:</h5>
                        <h5 class="mb-0 text-primary">
                            <span x-text="formatPrice(total)"></span>
                        </h5>
                    </div>

                    <!-- You Save -->
                    <div x-show="totalDiscount > 0" class="alert alert-success mb-3">
                        <i class="bi bi-piggy-bank me-2"></i>
                        <?php echo e(__('You save')); ?>: <strong x-text="formatPrice(totalDiscount)"></strong>
                    </div>

                    <!-- Checkout Button -->
                    <div class="d-grid gap-2">
                        <button @click="checkout()"
                                class="btn btn-primary btn-lg"
                                :disabled="checkingOut"
                                :class="{ 'btn-loading': checkingOut }">
                            <i class="bi bi-credit-card me-2"></i><?php echo e(__('Proceed to Checkout')); ?>

                        </button>

                        <!-- Apply Coupon -->
                        <div class="mt-3">
                            <div class="input-group">
                                <input type="text"
                                       class="form-control"
                                       placeholder="<?php echo e(__('Coupon Code')); ?>"
                                       x-model="couponCode">
                                <button class="btn btn-outline-secondary"
                                        type="button"
                                        @click="applyCoupon()"
                                        :disabled="applyingCoupon">
                                    <?php echo e(__('Apply')); ?>

                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Trust Badges -->
                    <div class="mt-4 pt-3 border-top">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-shield-check text-success me-2"></i>
                            <small class="text-muted"><?php echo e(__('Secure Payment')); ?></small>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-truck text-success me-2"></i>
                            <small class="text-muted"><?php echo e(__('Fast Delivery')); ?></small>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-arrow-return-left text-success me-2"></i>
                            <small class="text-muted"><?php echo e(__('Easy Returns')); ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function cartManager() {
    return {
        items: <?php echo json_encode(session('cart', []), 512) ?>,
        taxRate: 19, // TVA 19%
        shippingCost: 0, // Free shipping
        couponCode: '',
        couponDiscount: 0,
        checkingOut: false,
        applyingCoupon: false,

        init() {
            // Convert object to array if needed
            if (typeof this.items === 'object' && !Array.isArray(this.items)) {
                this.items = Object.keys(this.items).map(id => ({
                    id: id,
                    ...this.items[id],
                    updating: false
                }));
            }

            // Ensure all items have required properties
            this.items = this.items.map(item => ({
                ...item,
                updating: false,
                min_order_quantity: item.min_order_quantity || 1,
                stock_quantity: item.stock_quantity || 999,
                discount: item.discount || 0
            }));
        },

        get totalItems() {
            return this.items.reduce((sum, item) => sum + parseInt(item.quantity), 0);
        },

        get subtotal() {
            return this.items.reduce((sum, item) => {
                const price = parseFloat(item.price);
                const quantity = parseInt(item.quantity);
                return sum + (price * quantity);
            }, 0);
        },

        get totalDiscount() {
            return this.items.reduce((sum, item) => {
                if (item.original_price && item.original_price > item.price) {
                    const discount = (item.original_price - item.price) * item.quantity;
                    return sum + discount;
                }
                return sum;
            }, 0) + this.couponDiscount;
        },

        get taxAmount() {
            return (this.subtotal - this.totalDiscount) * (this.taxRate / 100);
        },

        get total() {
            return this.subtotal - this.totalDiscount + this.taxAmount + this.shippingCost;
        },

        async updateQuantity(productId, quantity) {
            quantity = parseInt(quantity);
            const item = this.items.find(i => i.id == productId);

            if (!item) return;

            // Validate quantity
            if (quantity < (item.min_order_quantity || 1)) {
                notyf.error(`Minimum quantity is ${item.min_order_quantity || 1}`);
                return;
            }

            if (quantity > item.stock_quantity) {
                notyf.error(`Maximum available stock is ${item.stock_quantity}`);
                return;
            }

            item.updating = true;

            try {
                const response = await fetch('<?php echo e(route("cart.update")); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                });

                const data = await response.json();

                if (data.success) {
                    item.quantity = quantity;
                    notyf.success('Cart updated!');
                    this.updateCartBadge();
                } else {
                    notyf.error(data.message || 'Error updating cart');
                }
            } catch (error) {
                notyf.error('Error updating cart');
                console.error(error);
            } finally {
                item.updating = false;
            }
        },

        incrementQuantity(productId) {
            const item = this.items.find(i => i.id == productId);
            if (item && item.quantity < item.stock_quantity) {
                this.updateQuantity(productId, item.quantity + 1);
            }
        },

        decrementQuantity(productId) {
            const item = this.items.find(i => i.id == productId);
            if (item && item.quantity > (item.min_order_quantity || 1)) {
                this.updateQuantity(productId, item.quantity - 1);
            }
        },

        async removeItem(productId) {
            const result = await Swal.fire({
                title: '<?php echo e(__("Remove item?")); ?>',
                text: '<?php echo e(__("Are you sure you want to remove this item from cart?")); ?>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<?php echo e(__("Yes, remove")); ?>',
                cancelButtonText: '<?php echo e(__("Cancel")); ?>',
                confirmButtonColor: '#dc3545',
            });

            if (!result.isConfirmed) return;

            try {
                const response = await fetch('<?php echo e(route("cart.remove")); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ product_id: productId })
                });

                const data = await response.json();

                if (data.success) {
                    this.items = this.items.filter(i => i.id != productId);
                    notyf.success('Item removed from cart');
                    this.updateCartBadge();
                }
            } catch (error) {
                notyf.error('Error removing item');
                console.error(error);
            }
        },

        async clearCart() {
            const result = await Swal.fire({
                title: '<?php echo e(__("Clear cart?")); ?>',
                text: '<?php echo e(__("This will remove all items from your cart")); ?>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<?php echo e(__("Yes, clear")); ?>',
                cancelButtonText: '<?php echo e(__("Cancel")); ?>',
                confirmButtonColor: '#dc3545',
            });

            if (!result.isConfirmed) return;

            try {
                const response = await fetch('<?php echo e(route("cart.clear")); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                if (data.success) {
                    this.items = [];
                    notyf.success('Cart cleared');
                    this.updateCartBadge();
                }
            } catch (error) {
                notyf.error('Error clearing cart');
                console.error(error);
            }
        },

        async applyCoupon() {
            if (!this.couponCode.trim()) {
                notyf.error('Please enter a coupon code');
                return;
            }

            this.applyingCoupon = true;

            // Simulate API call
            setTimeout(() => {
                // Demo: SAVE10 = 10% discount
                if (this.couponCode.toUpperCase() === 'SAVE10') {
                    this.couponDiscount = this.subtotal * 0.10;
                    notyf.success('Coupon applied! 10% discount');
                } else {
                    notyf.error('Invalid coupon code');
                }
                this.applyingCoupon = false;
            }, 1000);
        },

        async checkout() {
            if (this.items.length === 0) {
                notyf.error('Your cart is empty');
                return;
            }

            this.checkingOut = true;

            try {
                const response = await fetch('<?php echo e(route("orders.checkout")); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        items: this.items,
                        coupon_code: this.couponCode
                    })
                });

                const data = await response.json();

                if (data.success) {
                    Swal.fire({
                        title: '<?php echo e(__("Order Placed!")); ?>',
                        text: '<?php echo e(__("Your order has been placed successfully")); ?>',
                        icon: 'success',
                        confirmButtonText: '<?php echo e(__("View Orders")); ?>'
                    }).then(() => {
                        window.location.href = '<?php echo e(route("orders.index")); ?>';
                    });
                } else {
                    notyf.error(data.message || 'Error processing checkout');
                }
            } catch (error) {
                notyf.error('Error processing checkout');
                console.error(error);
            } finally {
                this.checkingOut = false;
            }
        },

        updateCartBadge() {
            window.dispatchEvent(new CustomEvent('cart-updated'));
        },

        formatPrice(amount) {
            return parseFloat(amount).toFixed(2) + ' DT';
        }
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\cart\index.blade.php ENDPATH**/ ?>