<?php $__env->startSection('title', $product->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('products.index')); ?>"><?php echo e(__('Products')); ?></a></li>
            <?php if($product->category): ?>
            <li class="breadcrumb-item"><a href="<?php echo e(route('products.category', $product->category->slug)); ?>"><?php echo e($product->category->name); ?></a></li>
            <?php endif; ?>
            <li class="breadcrumb-item active" aria-current="page"><?php echo e($product->name); ?></li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-6 mb-4">
            <?php if($product->image_url): ?>
            <img src="<?php echo e($product->image_url); ?>" class="img-fluid rounded" alt="<?php echo e($product->name); ?>">
            <?php else: ?>
            <div class="d-flex align-items-center justify-content-center bg-light rounded" style="height: 400px;">
                <i class="bi bi-image text-muted" style="font-size: 5rem;"></i>
            </div>
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <h1 class="mb-3"><?php echo e($product->name); ?></h1>

            <?php if($product->category): ?>
            <p class="text-muted mb-2">
                <i class="bi bi-tag me-1"></i><?php echo e($product->category->name); ?>

            </p>
            <?php endif; ?>

            <p class="text-muted mb-3">
                <i class="bi bi-upc me-1"></i><strong><?php echo e(__('SKU')); ?>:</strong> <?php echo e($product->sku); ?>

            </p>

            <div class="mb-4">
                <?php if(isset($product->user_price) && $product->user_price != $product->price): ?>
                <div class="mb-2">
                    <span class="text-muted text-decoration-line-through h5"><?php echo e(number_format($product->price, 2)); ?> DT</span>
                    <span class="badge bg-success ms-2"><?php echo e(__('Special Price')); ?></span>
                </div>
                <h3 class="text-primary"><?php echo e(number_format($product->user_price, 2)); ?> DT</h3>
                <?php else: ?>
                <h3 class="text-primary"><?php echo e(number_format($product->price, 2)); ?> DT</h3>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <?php if($product->stock_quantity > 0): ?>
                <p class="text-success mb-2">
                    <i class="bi bi-check-circle me-1"></i><?php echo e(__('In Stock')); ?> (<?php echo e($product->stock_quantity); ?> <?php echo e(__('available')); ?>)
                </p>
                <?php else: ?>
                <p class="text-danger mb-2">
                    <i class="bi bi-x-circle me-1"></i><?php echo e(__('Out of Stock')); ?>

                </p>
                <?php endif; ?>
            </div>

            <?php if($product->stock_quantity > 0): ?>
            <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="mb-4" id="addToCartForm">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">

                <div class="row align-items-end">
                    <div class="col-md-4 mb-2">
                        <label for="quantity" class="form-label"><?php echo e(__('Quantity')); ?></label>
                        <input type="number" class="form-control" id="quantity" name="quantity"
                               value="<?php echo e($product->min_order_quantity ?? 1); ?>"
                               min="<?php echo e($product->min_order_quantity ?? 1); ?>"
                               <?php if($product->order_multiple): ?>
                               step="<?php echo e($product->order_multiple); ?>"
                               <?php endif; ?>
                               max="<?php echo e($product->stock_quantity); ?>">
                        <?php if($product->min_order_quantity): ?>
                        <small class="text-muted">Min: <?php echo e($product->min_order_quantity); ?></small>
                        <?php endif; ?>
                        <?php if($product->order_multiple): ?>
                        <small class="text-muted">Par multiples de: <?php echo e($product->order_multiple); ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-8 mb-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-cart-plus me-2"></i><?php echo e(__('Add to Cart')); ?>

                        </button>
                    </div>
                </div>
            </form>
            <?php endif; ?>

            <?php if($product->description): ?>
            <div class="mb-4">
                <h5><?php echo e(__('Description')); ?></h5>
                <p class="text-muted"><?php echo e($product->description); ?></p>
            </div>
            <?php endif; ?>

            <?php if($product->specifications): ?>
            <div class="mb-4">
                <h5><?php echo e(__('Specifications')); ?></h5>
                <p class="text-muted"><?php echo e($product->specifications); ?></p>
            </div>
            <?php endif; ?>

            <!-- Product Actions -->
            <div class="d-flex gap-2 flex-wrap">
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i><?php echo e(__('Back to Products')); ?>

                </a>

                <?php if($product->category): ?>
                <a href="<?php echo e(route('products.category', $product->category->slug)); ?>" class="btn btn-outline-primary">
                    <i class="bi bi-collection me-1"></i><?php echo e(__('More in')); ?> <?php echo e($product->category->name); ?>

                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if($product->category && $product->category->products->where('id', '!=', $product->id)->count() > 0): ?>
    <hr class="my-5">

    <h4 class="mb-4"><?php echo e(__('Related Products')); ?></h4>
    <div class="row">
        <?php $__currentLoopData = $product->category->products->where('id', '!=', $product->id)->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <?php if($relatedProduct->image_url): ?>
                <img src="<?php echo e($relatedProduct->image_url); ?>" class="card-img-top" alt="<?php echo e($relatedProduct->name); ?>" style="height: 150px; object-fit: cover;">
                <?php else: ?>
                <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 150px;">
                    <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                </div>
                <?php endif; ?>

                <div class="card-body">
                    <h6 class="card-title"><?php echo e(Str::limit($relatedProduct->name, 50)); ?></h6>
                    <p class="text-primary fw-bold"><?php echo e(number_format($relatedProduct->price, 2)); ?> DT</p>
                    <a href="<?php echo e(route('products.show', $relatedProduct->sku)); ?>" class="btn btn-outline-primary btn-sm">
                        <?php echo e(__('View Details')); ?>

                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('addToCartForm');
    const quantityInput = document.getElementById('quantity');

    if (form && quantityInput) {
        const minQty = parseInt(quantityInput.getAttribute('min')) || 1;
        const maxQty = parseInt(quantityInput.getAttribute('max'));
        const multiple = parseInt(quantityInput.getAttribute('step')) || 1;

        // Validate quantity on change
        quantityInput.addEventListener('change', function() {
            let qty = parseInt(this.value);

            if (qty < minQty) {
                this.value = minQty;
                alert(`La quantité minimale est de ${minQty}`);
            } else if (maxQty && qty > maxQty) {
                this.value = maxQty;
                alert(`Stock disponible: ${maxQty} unités`);
            } else if (multiple > 1 && qty % multiple !== 0) {
                // Round to nearest multiple
                const rounded = Math.round(qty / multiple) * multiple;
                this.value = Math.max(minQty, rounded);
                alert(`Ce produit doit être commandé par multiples de ${multiple}`);
            }
        });

        // Validate on form submit
        form.addEventListener('submit', function(e) {
            const qty = parseInt(quantityInput.value);

            if (qty < minQty) {
                e.preventDefault();
                alert(`La quantité minimale est de ${minQty}`);
                quantityInput.value = minQty;
                return false;
            }

            if (multiple > 1 && qty % multiple !== 0) {
                e.preventDefault();
                alert(`Ce produit doit être commandé par multiples de ${multiple}`);
                return false;
            }
        });
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\products\show.blade.php ENDPATH**/ ?>