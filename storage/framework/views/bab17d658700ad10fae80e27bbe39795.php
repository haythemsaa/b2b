<?php $__env->startSection('title', __('My Orders')); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><?php echo e(__('My Orders')); ?></h1>
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i><?php echo e(__('Place New Order')); ?>

                </a>
            </div>
        </div>
    </div>

    <?php if(isset($orders) && $orders->count() > 0): ?>
    <div class="row">
        <div class="col-12">
            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card mb-3">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <h6 class="mb-0"><?php echo e(__('Order')); ?> #<?php echo e($order->order_number); ?></h6>
                            <small class="text-muted"><?php echo e($order->created_at->format('d/m/Y H:i')); ?></small>
                        </div>
                        <div class="col-md-2">
                            <span class="badge bg-<?php echo e($order->status === 'completed' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning')); ?>">
                                <?php echo e(ucfirst($order->status)); ?>

                            </span>
                        </div>
                        <div class="col-md-2">
                            <strong><?php echo e(number_format($order->total_amount, 2)); ?> DT</strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted">
                                <?php if($order->items_count): ?>
                                <?php echo e($order->items_count); ?> <?php echo e(__('item(s)')); ?>

                                <?php endif; ?>
                            </small>
                        </div>
                        <div class="col-md-2 text-end">
                            <a href="<?php echo e(route('orders.show', $order->order_number)); ?>" class="btn btn-outline-primary btn-sm">
                                <?php echo e(__('View Details')); ?>

                            </a>
                        </div>
                    </div>
                </div>

                <?php if($order->items && $order->items->count() > 0): ?>
                <div class="card-body">
                    <div class="row">
                        <?php $__currentLoopData = $order->items->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4 mb-2">
                            <div class="d-flex align-items-center">
                                <?php if($item->product && $item->product->image_url): ?>
                                <img src="<?php echo e($item->product->image_url); ?>" class="me-2 rounded" style="width: 40px; height: 40px; object-fit: cover;" alt="<?php echo e($item->product_name); ?>">
                                <?php else: ?>
                                <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-image text-muted small"></i>
                                </div>
                                <?php endif; ?>
                                <div>
                                    <small class="fw-medium"><?php echo e($item->product_name); ?></small>
                                    <br>
                                    <small class="text-muted"><?php echo e(__('Qty')); ?>: <?php echo e($item->quantity); ?></small>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($order->items->count() > 3): ?>
                        <div class="col-md-12">
                            <small class="text-muted"><?php echo e(__('and')); ?> <?php echo e($order->items->count() - 3); ?> <?php echo e(__('more items...')); ?></small>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if(method_exists($orders, 'links')): ?>
            <div class="d-flex justify-content-center">
                <?php echo e($orders->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php else: ?>
    <div class="row">
        <div class="col-12 text-center py-5">
            <i class="bi bi-bag-x display-1 text-muted mb-3"></i>
            <h4 class="text-muted mb-3"><?php echo e(__('No orders found')); ?></h4>
            <p class="text-muted mb-4"><?php echo e(__('You haven\'t placed any orders yet. Start shopping to see your orders here.')); ?></p>
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary">
                <i class="bi bi-shop me-2"></i><?php echo e(__('Start Shopping')); ?>

            </a>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\orders\index.blade.php ENDPATH**/ ?>