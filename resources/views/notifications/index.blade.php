@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="bi bi-bell me-2"></i>Notifications
                        @if($unreadCount > 0)
                            <span class="badge bg-danger">{{ $unreadCount }}</span>
                        @endif
                    </h4>
                    <div class="btn-group">
                        @if($unreadCount > 0)
                            <form action="{{ route('notifications.mark-all-read') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="bi bi-check-all"></i> Tout marquer comme lu
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('notifications.delete-read') }}" method="POST" class="d-inline ms-2">
                            @csrf
                            @method('DELETE')
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
                            <a href="{{ route('notifications.index', ['filter' => 'all']) }}"
                               class="btn btn-sm {{ $filter === 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                                Toutes
                            </a>
                            <a href="{{ route('notifications.index', ['filter' => 'unread']) }}"
                               class="btn btn-sm {{ $filter === 'unread' ? 'btn-primary' : 'btn-outline-primary' }}">
                                Non lues ({{ $unreadCount }})
                            </a>
                            <a href="{{ route('notifications.index', ['filter' => 'read']) }}"
                               class="btn btn-sm {{ $filter === 'read' ? 'btn-primary' : 'btn-outline-primary' }}">
                                Lues
                            </a>
                        </div>
                    </div>

                    @if($notifications->count() > 0)
                        <div class="list-group">
                            @foreach($notifications as $notification)
                                <div class="list-group-item {{ !$notification->is_read ? 'bg-light' : '' }}">
                                    <div class="d-flex w-100 justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi {{ $notification->getIconClass() }} fs-4 me-3 text-primary"></i>
                                                <div>
                                                    <h5 class="mb-1">
                                                        {{ $notification->title }}
                                                        @if(!$notification->is_read)
                                                            <span class="badge bg-primary">Nouveau</span>
                                                        @endif
                                                        <span class="badge bg-{{ $notification->getPriorityBadgeClass() }}">
                                                            {{ ucfirst($notification->priority) }}
                                                        </span>
                                                    </h5>
                                                    <p class="mb-1 text-muted">{{ $notification->message }}</p>
                                                    <small class="text-muted">
                                                        <i class="bi bi-clock"></i> {{ $notification->created_at->diffForHumans() }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btn-group ms-3">
                                            @if($notification->link)
                                                <a href="{{ route('notifications.mark-read', $notification->id) }}"
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-box-arrow-up-right"></i> Ouvrir
                                                </a>
                                            @endif
                                            @if(!$notification->is_read)
                                                <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                                        <i class="bi bi-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Supprimer cette notification ?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-bell-slash fs-1 text-muted"></i>
                            <p class="text-muted mt-3">Aucune notification</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
