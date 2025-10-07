

<?php $__env->startSection('title', 'Messagerie - Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="bi bi-chat-dots"></i> Messagerie
        </h1>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Conversations avec les vendeurs</h6>
                </div>
                <div class="card-body">
                    <?php if(count($conversations) === 0): ?>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Aucune conversation pour le moment.
                        </div>
                    <?php else: ?>
                        <div class="list-group">
                            <?php $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conversation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('admin.messages.conversation', $conversation['user']->id)); ?>"
                                   class="list-group-item list-group-item-action <?php echo e($conversation['unread_count'] > 0 ? 'list-group-item-primary' : ''); ?>">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                                 style="width: 50px; height: 50px; font-size: 1.5rem;">
                                                <?php echo e(substr($conversation['user']->name, 0, 1)); ?>

                                            </div>
                                            <div>
                                                <h5 class="mb-1"><?php echo e($conversation['user']->name); ?></h5>
                                                <p class="mb-1 text-muted small"><?php echo e($conversation['user']->email); ?></p>
                                                <?php if($conversation['last_message']): ?>
                                                    <p class="mb-0 text-muted small">
                                                        <i class="bi bi-chat-text"></i>
                                                        <?php echo e(Str::limit($conversation['last_message']->message, 50)); ?>

                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <?php if($conversation['last_message']): ?>
                                                <small class="text-muted">
                                                    <?php echo e($conversation['last_message']->created_at->diffForHumans()); ?>

                                                </small>
                                            <?php endif; ?>
                                            <?php if($conversation['unread_count'] > 0): ?>
                                                <br>
                                                <span class="badge bg-danger">
                                                    <?php echo e($conversation['unread_count']); ?> nouveau<?php echo e($conversation['unread_count'] > 1 ? 'x' : ''); ?>

                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
.list-group-item-action:hover {
    background-color: #f8f9fa;
}
.list-group-item-primary {
    background-color: #e3f2fd !important;
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\messages\index.blade.php ENDPATH**/ ?>