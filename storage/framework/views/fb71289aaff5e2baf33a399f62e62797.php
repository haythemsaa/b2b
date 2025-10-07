<?php $__env->startSection('title', __('Order Details')); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <?php if(isset($order)): ?>
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><?php echo e(__('Order')); ?> #<?php echo e($order->order_number); ?></h1>
                <div>
                    <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-arrow-left me-1"></i><?php echo e(__('Back to Orders')); ?>

                    </a>
                    <?php if($order->status !== 'cancelled' && in_array($order->status, ['pending', 'processing'])): ?>
                    <a href="<?php echo e(route('returns.create')); ?>?order=<?php echo e($order->id); ?>" class="btn btn-outline-warning">
                        <i class="bi bi-arrow-return-left me-1"></i><?php echo e(__('Request Return')); ?>

                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Order Items -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo e(__('Order Items')); ?></h5>
                </div>
                <div class="card-body">
                    <?php if($order->items && $order->items->count() > 0): ?>
                    <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="row align-items-center mb-3 pb-3 border-bottom">
                        <div class="col-md-2">
                            <?php if($item->product && $item->product->image_url): ?>
                            <img src="<?php echo e($item->product->image_url); ?>" class="img-fluid rounded" alt="<?php echo e($item->product_name); ?>">
                            <?php else: ?>
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 80px;">
                                <i class="bi bi-image text-muted"></i>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4">
                            <h6 class="mb-1"><?php echo e($item->product_name); ?></h6>
                            <?php if($item->product): ?>
                            <small class="text-muted">SKU: <?php echo e($item->product->sku); ?></small>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-2">
                            <span class="text-muted"><?php echo e(number_format($item->unit_price, 2)); ?> DT</span>
                        </div>
                        <div class="col-md-2">
                            <span class="badge bg-secondary">x<?php echo e($item->quantity); ?></span>
                        </div>
                        <div class="col-md-2 text-end">
                            <strong><?php echo e(number_format($item->total_price, 2)); ?> DT</strong>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                    <p class="text-muted"><?php echo e(__('No items found for this order.')); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Order Summary -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo e(__('Order Summary')); ?></h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span><?php echo e(__('Subtotal')); ?>:</span>
                        <span><?php echo e(number_format($order->total_amount, 2)); ?> DT</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span><?php echo e(__('Tax')); ?>:</span>
                        <span><?php echo e(__('Included')); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span><?php echo e(__('Shipping')); ?>:</span>
                        <span><?php echo e(__('Free')); ?></span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong><?php echo e(__('Total')); ?>:</strong>
                        <strong class="text-primary"><?php echo e(number_format($order->total_amount, 2)); ?> DT</strong>
                    </div>
                </div>
            </div>

            <!-- Order Status -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo e(__('Order Status')); ?></h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <span class="badge bg-<?php echo e($order->status === 'completed' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning')); ?> fs-6 mb-3">
                            <?php echo e(ucfirst($order->status)); ?>

                        </span>
                    </div>

                    <div class="timeline">
                        <div class="timeline-item <?php echo e($order->status !== 'cancelled' ? 'active' : ''); ?>">
                            <i class="bi bi-check-circle"></i>
                            <span><?php echo e(__('Order Placed')); ?></span>
                            <small class="text-muted d-block"><?php echo e($order->created_at->format('d/m/Y H:i')); ?></small>
                        </div>
                        <?php if($order->status !== 'cancelled'): ?>
                        <div class="timeline-item <?php echo e(in_array($order->status, ['processing', 'shipped', 'completed']) ? 'active' : ''); ?>">
                            <i class="bi bi-gear"></i>
                            <span><?php echo e(__('Processing')); ?></span>
                        </div>
                        <div class="timeline-item <?php echo e(in_array($order->status, ['shipped', 'completed']) ? 'active' : ''); ?>">
                            <i class="bi bi-truck"></i>
                            <span><?php echo e(__('Shipped')); ?></span>
                        </div>
                        <div class="timeline-item <?php echo e($order->status === 'completed' ? 'active' : ''); ?>">
                            <i class="bi bi-check-circle"></i>
                            <span><?php echo e(__('Delivered')); ?></span>
                        </div>
                        <?php else: ?>
                        <div class="timeline-item active text-danger">
                            <i class="bi bi-x-circle"></i>
                            <span><?php echo e(__('Cancelled')); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Order Details -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo e(__('Order Details')); ?></h5>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong><?php echo e(__('Order Number')); ?>:</strong><br>
                        <span class="text-muted">#<?php echo e($order->order_number); ?></span>
                    </p>
                    <p class="mb-2">
                        <strong><?php echo e(__('Order Date')); ?>:</strong><br>
                        <span class="text-muted"><?php echo e($order->created_at->format('d/m/Y H:i')); ?></span>
                    </p>
                    <?php if($order->notes): ?>
                    <p class="mb-2">
                        <strong><?php echo e(__('Notes')); ?>:</strong><br>
                        <span class="text-muted"><?php echo e($order->notes); ?></span>
                    </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="row">
        <div class="col-12 text-center py-5">
            <i class="bi bi-exclamation-circle display-1 text-muted mb-3"></i>
            <h4 class="text-muted"><?php echo e(__('Order not found')); ?></h4>
            <p class="text-muted mb-4"><?php echo e(__('The order you\'re looking for doesn\'t exist or you don\'t have access to it.')); ?></p>
            <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-primary">
                <?php echo e(__('Back to Orders')); ?>

            </a>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
.timeline {
    position: relative;
    padding: 0;
}

.timeline-item {
    position: relative;
    padding: 15px 0 15px 50px;
    border-left: 2px solid #e9ecef;
}

.timeline-item:last-child {
    border-left: none;
}

.timeline-item.active {
    border-left-color: #28a745;
}

.timeline-item.active i {
    color: #28a745;
}

.timeline-item i {
    position: absolute;
    left: -10px;
    top: 15px;
    background: white;
    padding: 5px;
    border-radius: 50%;
    color: #6c757d;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\orders\show.blade.php ENDPATH**/ ?>