

<?php $__env->startSection('title', 'Conversation - Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="<?php echo e(route('admin.messages.index')); ?>" class="btn btn-outline-secondary mb-2">
                <i class="bi bi-arrow-left"></i> Retour aux conversations
            </a>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-chat-dots"></i> Conversation avec <?php echo e($user->name); ?>

            </h1>
            <small class="text-muted"><?php echo e($user->email); ?></small>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="chat-container mb-3" id="chatContainer">
                        <?php if(count($messages) === 0): ?>
                            <div class="text-center text-muted">
                                <i class="bi bi-chat-text fs-1"></i>
                                <p>Aucun message pour le moment. Démarrez la conversation!</p>
                            </div>
                        <?php else: ?>
                            <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="message <?php echo e($message->from_user_id === auth()->id() ? 'mine' : 'theirs'); ?>">
                                    <div>
                                        <span class="badge <?php echo e($message->from_user_id === auth()->id() ? 'bg-primary' : 'bg-secondary'); ?>">
                                            <?php echo e($message->fromUser->name); ?>

                                        </span>
                                        <small class="text-muted ms-2"><?php echo e($message->created_at->format('d/m/Y H:i')); ?></small>
                                    </div>
                                    <div class="mt-1">
                                        <?php echo e($message->message); ?>

                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>

                    <form id="messageForm" onsubmit="sendMessage(event)">
                        <?php echo csrf_field(); ?>
                        <div class="input-group">
                            <input type="hidden" name="to_user_id" value="<?php echo e($user->id); ?>">
                            <input type="text"
                                   class="form-control"
                                   id="messageInput"
                                   name="message"
                                   placeholder="Tapez votre message..."
                                   required
                                   maxlength="1000">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-send"></i> Envoyer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function sendMessage(event) {
    event.preventDefault();

    const form = event.target;
    const messageInput = document.getElementById('messageInput');
    const message = messageInput.value.trim();

    if (!message) {
        return;
    }

    const formData = new FormData(form);

    axios.post('<?php echo e(route("admin.messages.send")); ?>', formData)
        .then(response => {
            const data = response.data.data;

            const chatContainer = document.getElementById('chatContainer');

            // Remove "no messages" message if exists
            const noMessages = chatContainer.querySelector('.text-center.text-muted');
            if (noMessages) {
                noMessages.remove();
            }

            const messageHtml = `
                <div class="message mine">
                    <div>
                        <span class="badge bg-primary">${data.from_user}</span>
                        <small class="text-muted ms-2">${data.created_at}</small>
                    </div>
                    <div class="mt-1">
                        ${data.message}
                    </div>
                </div>
            `;

            chatContainer.insertAdjacentHTML('beforeend', messageHtml);

            messageInput.value = '';

            chatContainer.scrollTop = chatContainer.scrollHeight;
        })
        .catch(error => {
            console.error('Error sending message:', error);
            alert('Erreur lors de l\'envoi du message. Veuillez réessayer.');
        });
}

// Scroll to bottom on page load
document.addEventListener('DOMContentLoaded', function() {
    const chatContainer = document.getElementById('chatContainer');
    chatContainer.scrollTop = chatContainer.scrollHeight;
});
</script>

<?php $__env->startPush('styles'); ?>
<style>
.chat-container {
    height: 400px;
    overflow-y: auto;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 15px;
    background-color: #f8f9fa;
}
.message {
    margin-bottom: 15px;
    padding: 10px;
    border-radius: 8px;
    background-color: white;
}
.message.mine {
    text-align: right;
    margin-left: 20%;
}
.message.theirs {
    text-align: left;
    margin-right: 20%;
}
.message.mine .badge {
    background-color: #0d6efd !important;
}
.message.theirs .badge {
    background-color: #6c757d !important;
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\admin\messages\conversation.blade.php ENDPATH**/ ?>