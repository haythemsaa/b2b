@extends('layouts.admin')

@section('title', 'Messagerie - Admin')

@section('content')
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
                    @if(count($conversations) === 0)
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Aucune conversation pour le moment.
                        </div>
                    @else
                        <div class="list-group">
                            @foreach($conversations as $conversation)
                                <a href="{{ route('admin.messages.conversation', $conversation['user']->id) }}"
                                   class="list-group-item list-group-item-action {{ $conversation['unread_count'] > 0 ? 'list-group-item-primary' : '' }}">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                                 style="width: 50px; height: 50px; font-size: 1.5rem;">
                                                {{ substr($conversation['user']->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <h5 class="mb-1">{{ $conversation['user']->name }}</h5>
                                                <p class="mb-1 text-muted small">{{ $conversation['user']->email }}</p>
                                                @if($conversation['last_message'])
                                                    <p class="mb-0 text-muted small">
                                                        <i class="bi bi-chat-text"></i>
                                                        {{ Str::limit($conversation['last_message']->message, 50) }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            @if($conversation['last_message'])
                                                <small class="text-muted">
                                                    {{ $conversation['last_message']->created_at->diffForHumans() }}
                                                </small>
                                            @endif
                                            @if($conversation['unread_count'] > 0)
                                                <br>
                                                <span class="badge bg-danger">
                                                    {{ $conversation['unread_count'] }} nouveau{{ $conversation['unread_count'] > 1 ? 'x' : '' }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.list-group-item-action:hover {
    background-color: #f8f9fa;
}
.list-group-item-primary {
    background-color: #e3f2fd !important;
}
</style>
@endpush
@endsection
