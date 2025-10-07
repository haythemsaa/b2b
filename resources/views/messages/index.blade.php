@extends('layouts.app')

@section('title', __('Messages'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>{{ __('Messages') }}</h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newMessageModal">
                    <i class="bi bi-plus-circle me-2"></i>{{ __('New Message') }}
                </button>
            </div>
        </div>
    </div>

    @if(isset($messages) && $messages->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    @foreach($messages as $message)
                    <div class="message-item p-3 border-bottom {{ !$message->is_read ? 'unread' : '' }}">
                        <div class="row align-items-center">
                            <div class="col-md-1">
                                <div class="message-avatar">
                                    <i class="bi bi-person-circle fs-2 text-{{ $message->sender_id === auth()->id() ? 'primary' : 'secondary' }}"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="d-flex align-items-center mb-1">
                                    <h6 class="mb-0 me-2">
                                        {{ $message->sender_id === auth()->id() ? __('You') : ($message->sender->name ?? __('System')) }}
                                    </h6>
                                    @if(!$message->is_read && $message->receiver_id === auth()->id())
                                    <span class="badge bg-primary">{{ __('New') }}</span>
                                    @endif
                                </div>
                                <p class="text-muted mb-1">{{ $message->subject }}</p>
                                <small class="text-muted">{{ Str::limit($message->content, 100) }}</small>
                            </div>
                            <div class="col-md-2 text-muted small">
                                {{ $message->created_at->diffForHumans() }}
                            </div>
                            <div class="col-md-1 text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <button class="dropdown-item" onclick="viewMessage({{ $message->id }})">
                                                <i class="bi bi-eye me-2"></i>{{ __('View') }}
                                            </button>
                                        </li>
                                        @if(!$message->is_read && $message->receiver_id === auth()->id())
                                        <li>
                                            <form action="{{ route('messages.mark-read', $message) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="dropdown-item">
                                                    <i class="bi bi-check me-2"></i>{{ __('Mark as Read') }}
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                        <li>
                                            <button class="dropdown-item" onclick="replyToMessage({{ $message->id }})">
                                                <i class="bi bi-reply me-2"></i>{{ __('Reply') }}
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            @if(method_exists($messages, 'links'))
            <div class="d-flex justify-content-center mt-4">
                {{ $messages->links() }}
            </div>
            @endif
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-12 text-center py-5">
            <i class="bi bi-envelope display-1 text-muted mb-3"></i>
            <h4 class="text-muted mb-3">{{ __('No messages') }}</h4>
            <p class="text-muted mb-4">{{ __('You don\'t have any messages yet. Start a conversation with the administrator.') }}</p>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newMessageModal">
                <i class="bi bi-plus-circle me-2"></i>{{ __('Send New Message') }}
            </button>
        </div>
    </div>
    @endif
</div>

<!-- New Message Modal -->
<div class="modal fade" id="newMessageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('New Message') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('messages.send') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="subject" class="form-label">{{ __('Subject') }} *</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">{{ __('Message') }} *</label>
                        <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send me-2"></i>{{ __('Send Message') }}
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
                    <strong>{{ __('From') }}:</strong>
                    <span id="messageViewSender"></span>
                </div>
                <div class="mb-3">
                    <strong>{{ __('Date') }}:</strong>
                    <span id="messageViewDate"></span>
                </div>
                <hr>
                <div id="messageViewContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button type="button" class="btn btn-primary" onclick="replyToCurrentMessage()">
                    <i class="bi bi-reply me-2"></i>{{ __('Reply') }}
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
@endsection