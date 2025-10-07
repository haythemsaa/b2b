<?php $__env->startSection('title', __('Messages')); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><?php echo e(__('Messages')); ?></h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newMessageModal">
                    <i class="bi bi-plus-circle me-2"></i><?php echo e(__('New Message')); ?>

                </button>
            </div>
        </div>
    </div>

    <?php if(isset($messages) && $messages->count() > 0): ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="message-item p-3 border-bottom <?php echo e(!$message->is_read ? 'unread' : ''); ?>">
                        <div class="row align-items-center">
                            <div class="col-md-1">
                                <div class="message-avatar">
                                    <i class="bi bi-person-circle fs-2 text-<?php echo e($message->sender_id === auth()->id() ? 'primary' : 'secondary'); ?>"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="d-flex align-items-center mb-1">
                                    <h6 class="mb-0 me-2">
                                        <?php echo e($message->sender_id === auth()->id() ? __('You') : ($message->sender->name ?? __('System'))); ?>

                                    </h6>
                                    <?php if(!$message->is_read && $message->receiver_id === auth()->id()): ?>
                                    <span class="badge bg-primary"><?php echo e(__('New')); ?></span>
                                    <?php endif; ?>
                                </div>
                                <p class="text-muted mb-1"><?php echo e($message->subject); ?></p>
                                <small class="text-muted"><?php echo e(Str::limit($message->content, 100)); ?></small>
                            </div>
                            <div class="col-md-2 text-muted small">
                                <?php echo e($message->created_at->diffForHumans()); ?>

                            </div>
                            <div class="col-md-1 text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <button class="dropdown-item" onclick="viewMessage(<?php echo e($message->id); ?>)">
                                                <i class="bi bi-eye me-2"></i><?php echo e(__('View')); ?>

                                            </button>
                                        </li>
                                        <?php if(!$message->is_read && $message->receiver_id === auth()->id()): ?>
                                        <li>
                                            <form action="<?php echo e(route('messages.mark-read', $message)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="dropdown-item">
                                                    <i class="bi bi-check me-2"></i><?php echo e(__('Mark as Read')); ?>

                                                </button>
                                            </form>
                                        </li>
                                        <?php endif; ?>
                                        <li>
                                            <button class="dropdown-item" onclick="replyToMessage(<?php echo e($message->id); ?>)">
                                                <i class="bi bi-reply me-2"></i><?php echo e(__('Reply')); ?>

                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <?php if(method_exists($messages, 'links')): ?>
            <div class="d-flex justify-content-center mt-4">
                <?php echo e($messages->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php else: ?>
    <div class="row">
        <div class="col-12 text-center py-5">
            <i class="bi bi-envelope display-1 text-muted mb-3"></i>
            <h4 class="text-muted mb-3"><?php echo e(__('No messages')); ?></h4>
            <p class="text-muted mb-4"><?php echo e(__('You don\'t have any messages yet. Start a conversation with the administrator.')); ?></p>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newMessageModal">
                <i class="bi bi-plus-circle me-2"></i><?php echo e(__('Send New Message')); ?>

            </button>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- New Message Modal -->
<div class="modal fade" id="newMessageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo e(__('New Message')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('messages.send')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="subject" class="form-label"><?php echo e(__('Subject')); ?> *</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label"><?php echo e(__('Message')); ?> *</label>
                        <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send me-2"></i><?php echo e(__('Send Message')); ?>

                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Message View Modal -->
<div class="modal fade" id="messageViewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageViewSubject"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <strong><?php echo e(__('From')); ?>:</strong>
                    <span id="messageViewSender"></span>
                </div>
                <div class="mb-3">
                    <strong><?php echo e(__('Date')); ?>:</strong>
                    <span id="messageViewDate"></span>
                </div>
                <hr>
                <div id="messageViewContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
                <button type="button" class="btn btn-primary" onclick="replyToCurrentMessage()">
                    <i class="bi bi-reply me-2"></i><?php echo e(__('Reply')); ?>

                </button>
            </div>
        </div>
    </div>
</div>

<style>
.message-item.unread {
    background-color: #f8f9fa;
    border-left: 4px solid #007bff;
}

.message-item:hover {
    background-color: #f8f9fa;
}

.message-avatar {
    text-align: center;
}
</style>

<script>
function viewMessage(messageId) {
    // Implement AJAX call to load message details
    // This is a placeholder - you'll need to implement the actual AJAX call
    console.log('View message:', messageId);
}

function replyToMessage(messageId) {
    // Implement reply functionality
    // This is a placeholder - you'll need to implement the actual reply functionality
    console.log('Reply to message:', messageId);
}

function replyToCurrentMessage() {
    // Implement reply to current viewed message
    console.log('Reply to current message');
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\messages\index.blade.php ENDPATH**/ ?>