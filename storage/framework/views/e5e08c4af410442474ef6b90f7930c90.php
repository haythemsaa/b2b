<?php $__env->startSection('title', 'Notifications'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="bi bi-bell me-2"></i>Notifications
                        <?php if($unreadCount > 0): ?>
                            <span class="badge bg-danger"><?php echo e($unreadCount); ?></span>
                        <?php endif; ?>
                    </h4>
                    <div class="btn-group">
                        <?php if($unreadCount > 0): ?>
                            <form action="<?php echo e(route('notifications.mark-all-read')); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="bi bi-check-all"></i> Tout marquer comme lu
                                </button>
                            </form>
                        <?php endif; ?>
                        <form action="<?php echo e(route('notifications.delete-read')); ?>" method="POST" class="d-inline ms-2">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Supprimer toutes les notifications lues ?')">
                                <i class="bi bi-trash"></i> Supprimer les lues
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filtres -->
                    <div class="mb-3">
                        <div class="btn-group" role="group">
                            <a href="<?php echo e(route('notifications.index', ['filter' => 'all'])); ?>"
                               class="btn btn-sm <?php echo e($filter === 'all' ? 'btn-primary' : 'btn-outline-primary'); ?>">
                                Toutes
                            </a>
                            <a href="<?php echo e(route('notifications.index', ['filter' => 'unread'])); ?>"
                               class="btn btn-sm <?php echo e($filter === 'unread' ? 'btn-primary' : 'btn-outline-primary'); ?>">
                                Non lues (<?php echo e($unreadCount); ?>)
                            </a>
                            <a href="<?php echo e(route('notifications.index', ['filter' => 'read'])); ?>"
                               class="btn btn-sm <?php echo e($filter === 'read' ? 'btn-primary' : 'btn-outline-primary'); ?>">
                                Lues
                            </a>
                        </div>
                    </div>

                    <?php if($notifications->count() > 0): ?>
                        <div class="list-group">
                            <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="list-group-item <?php echo e(!$notification->is_read ? 'bg-light' : ''); ?>">
                                    <div class="d-flex w-100 justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi <?php echo e($notification->getIconClass()); ?> fs-4 me-3 text-primary"></i>
                                                <div>
                                                    <h5 class="mb-1">
                                                        <?php echo e($notification->title); ?>

                                                        <?php if(!$notification->is_read): ?>
                                                            <span class="badge bg-primary">Nouveau</span>
                                                        <?php endif; ?>
                                                        <span class="badge bg-<?php echo e($notification->getPriorityBadgeClass()); ?>">
                                                            <?php echo e(ucfirst($notification->priority)); ?>

                                                        </span>
                                                    </h5>
                                                    <p class="mb-1 text-muted"><?php echo e($notification->message); ?></p>
                                                    <small class="text-muted">
                                                        <i class="bi bi-clock"></i> <?php echo e($notification->created_at->diffForHumans()); ?>

                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btn-group ms-3">
                                            <?php if($notification->link): ?>
                                                <a href="<?php echo e(route('notifications.mark-read', $notification->id)); ?>"
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-box-arrow-up-right"></i> Ouvrir
                                                </a>
                                            <?php endif; ?>
                                            <?php if(!$notification->is_read): ?>
                                                <form action="<?php echo e(route('notifications.mark-read', $notification->id)); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                                        <i class="bi bi-check"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <form action="<?php echo e(route('notifications.destroy', $notification->id)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Supprimer cette notification ?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            <?php echo e($notifications->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bi bi-bell-slash fs-1 text-muted"></i>
                            <p class="text-muted mt-3">Aucune notification</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\notifications\index.blade.php ENDPATH**/ ?>