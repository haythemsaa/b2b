<!-- Notifications Dropdown -->
<div class="dropdown">
    <a class="nav-link dropdown-toggle position-relative" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-bell fs-5"></i>
        <?php if(isset($notificationCount) && $notificationCount > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?php echo e($notificationCount > 99 ? '99+' : $notificationCount); ?>

                <span class="visually-hidden">notifications non lues</span>
            </span>
        <?php endif; ?>
    </a>
    <ul class="dropdown-menu dropdown-menu-end notification-dropdown" aria-labelledby="notificationsDropdown" style="width: 350px; max-height: 500px; overflow-y: auto;">
        <li class="dropdown-header d-flex justify-content-between align-items-center">
            <strong>Notifications</strong>
            <?php if(isset($notificationCount) && $notificationCount > 0): ?>
                <span class="badge bg-primary"><?php echo e($notificationCount); ?></span>
            <?php endif; ?>
        </li>
        <li><hr class="dropdown-divider"></li>

        <?php if(isset($unreadNotifications) && $unreadNotifications->count() > 0): ?>
            <?php $__currentLoopData = $unreadNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <a class="dropdown-item <?php echo e(!$notification->is_read ? 'bg-light' : ''); ?>"
                       href="<?php echo e($notification->link ? route('notifications.mark-read', $notification->id) : '#'); ?>">
                        <div class="d-flex align-items-start">
                            <i class="bi <?php echo e($notification->getIconClass()); ?> fs-4 me-2 text-primary"></i>
                            <div class="flex-grow-1">
                                <strong class="d-block"><?php echo e(Str::limit($notification->title, 30)); ?></strong>
                                <small class="text-muted d-block"><?php echo e(Str::limit($notification->message, 50)); ?></small>
                                <small class="text-muted">
                                    <i class="bi bi-clock"></i> <?php echo e($notification->created_at->diffForHumans()); ?>

                                </small>
                            </div>
                            <?php if($notification->priority === 'urgent' || $notification->priority === 'high'): ?>
                                <span class="badge bg-<?php echo e($notification->getPriorityBadgeClass()); ?> ms-2">!</span>
                            <?php endif; ?>
                        </div>
                    </a>
                </li>
                <?php if(!$loop->last): ?>
                    <li><hr class="dropdown-divider"></li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item text-center text-primary" href="<?php echo e(route('notifications.index')); ?>">
                    <i class="bi bi-eye"></i> Voir toutes les notifications
                </a>
            </li>
        <?php else: ?>
            <li>
                <div class="dropdown-item text-center text-muted py-3">
                    <i class="bi bi-bell-slash fs-3"></i>
                    <p class="mb-0 mt-2">Aucune notification</p>
                </div>
            </li>
        <?php endif; ?>
    </ul>
</div>

<style>
.notification-dropdown .dropdown-item {
    white-space: normal;
    padding: 0.75rem 1rem;
}
.notification-dropdown .dropdown-item:hover {
    background-color: #f8f9fa;
}
.notification-dropdown .bg-light {
    background-color: #e7f3ff !important;
}
</style>
<?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\partials\notifications-dropdown.blade.php ENDPATH**/ ?>