@extends('layouts.admin')

@section('title', 'Conversation - Admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary mb-2">
                <i class="bi bi-arrow-left"></i> Retour aux conversations
            </a>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-chat-dots"></i> Conversation avec {{ $user->name }}
            </h1>
            <small class="text-muted">{{ $user->email }}</small>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="chat-container mb-3" id="chatContainer">
                        @if(count($messages) === 0)
                            <div class="text-center text-muted">
                                <i class="bi bi-chat-text fs-1"></i>
                                <p>Aucun message pour le moment. Démarrez la conversation!</p>
                            </div>
                        @else
                            @foreach($messages as $message)
                                <div class="message {{ $message->from_user_id === auth()->id() ? 'mine' : 'theirs' }}">
                                    <div>
                                        <span class="badge {{ $message->from_user_id === auth()->id() ? 'bg-primary' : 'bg-secondary' }}">
                                            {{ $message->fromUser->name }}
                                        </span>
                                        <small class="text-muted ms-2">{{ $message->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <div class="mt-1">
                                        {{ $message->message }}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <form id="messageForm" onsubmit="sendMessage(event)">
                        @csrf
                        <div class="input-group">
                            <input type="hidden" name="to_user_id" value="{{ $user->id }}">
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

    axios.post('{{ route("admin.messages.send") }}', formData)
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

@push('styles')
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
@endpush
@endsection
