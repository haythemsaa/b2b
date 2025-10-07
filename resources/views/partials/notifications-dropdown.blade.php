<!-- Notifications Dropdown -->
<div class="dropdown">
    <a class="nav-link dropdown-toggle position-relative" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-bell fs-5"></i>
        @if(isset($notificationCount) && $notificationCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $notificationCount > 99 ? '99+' : $notificationCount }}
                <span class="visually-hidden">notifications non lues</span>
            </span>
        @endif
    </a>
    <ul class="dropdown-menu dropdown-menu-end notification-dropdown" aria-labelledby="notificationsDropdown" style="width: 350px; max-height: 500px; overflow-y: auto;">
        <li class="dropdown-header d-flex justify-content-between align-items-center">
            <strong>Notifications</strong>
            @if(isset($notificationCount) && $notificationCount > 0)
                <span class="badge bg-primary">{{ $notificationCount }}</span>
            @endif
        </li>
        <li><hr class="dropdown-divider"></li>

        @if(isset($unreadNotifications) && $unreadNotifications->count() > 0)
            @foreach($unreadNotifications as $notification)
                <li>
                    <a class="dropdown-item {{ !$notification->is_read ? 'bg-light' : '' }}"
                       href="{{ $notification->link ? route('notifications.mark-read', $notification->id) : '#' }}">
                        <div class="d-flex align-items-start">
                            <i class="bi {{ $notification->getIconClass() }} fs-4 me-2 text-primary"></i>
                            <div class="flex-grow-1">
                                <strong class="d-block">{{ Str::limit($notification->title, 30) }}</strong>
                                <small class="text-muted d-block">{{ Str::limit($notification->message, 50) }}</small>
                                <small class="text-muted">
                                    <i class="bi bi-clock"></i> {{ $notification->created_at->diffForHumans() }}
                                </small>
                            </div>
                            @if($notification->priority === 'urgent' || $notification->priority === 'high')
                                <span class="badge bg-{{ $notification->getPriorityBadgeClass() }} ms-2">!</span>
                            @endif
                        </div>
                    </a>
                </li>
                @if(!$loop->last)
                    <li><hr class="dropdown-divider"></li>
                @endif
            @endforeach
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item text-center text-primary" href="{{ route('notifications.index') }}">
                    <i class="bi bi-eye"></i> Voir toutes les notifications
                </a>
            </li>
        @else
            <li>
                <div class="dropdown-item text-center text-muted py-3">
                    <i class="bi bi-bell-slash fs-3"></i>
                    <p class="mb-0 mt-2">Aucune notification</p>
                </div>
            </li>
        @endif
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
