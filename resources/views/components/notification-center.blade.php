<!-- Notification Center Component -->
<div x-data="notificationCenter()" x-init="init()" class="notification-center">
    <!-- Notification Bell Icon -->
    <div class="position-relative d-inline-block">
        <button @click="toggle()"
                class="btn btn-link position-relative p-2 text-decoration-none"
                :class="{ 'text-primary': open }">
            <i class="bi bi-bell fs-5"
               :class="{ 'animate__animated animate__swing': hasUnread }"></i>

            <!-- Unread Badge -->
            <span x-show="unreadCount > 0"
                  x-transition
                  class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger badge-pulse"
                  x-text="unreadCount > 99 ? '99+' : unreadCount">
            </span>
        </button>

        <!-- Notification Dropdown -->
        <div x-show="open"
             x-transition
             @click.outside="open = false"
             class="notification-dropdown position-absolute end-0 mt-2 bg-white border rounded shadow-lg"
             style="width: 380px; max-height: 500px; z-index: 1050;">

            <!-- Header -->
            <div class="dropdown-header d-flex justify-content-between align-items-center border-bottom p-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-bell me-2"></i>Notifications
                    <span x-show="unreadCount > 0"
                          class="badge bg-danger ms-2"
                          x-text="unreadCount"></span>
                </h6>
                <div class="btn-group btn-group-sm">
                    <button @click="markAllAsRead()"
                            class="btn btn-link text-primary text-decoration-none p-0 me-2"
                            x-show="unreadCount > 0">
                        <small>Tout marquer lu</small>
                    </button>
                    <button @click="clearAll()"
                            class="btn btn-link text-danger text-decoration-none p-0">
                        <small>Tout effacer</small>
                    </button>
                </div>
            </div>

            <!-- Filters -->
            <div class="p-2 border-bottom bg-light">
                <div class="btn-group btn-group-sm w-100" role="group">
                    <button type="button"
                            class="btn"
                            :class="filter === 'all' ? 'btn-primary' : 'btn-outline-secondary'"
                            @click="filter = 'all'">
                        Toutes
                    </button>
                    <button type="button"
                            class="btn"
                            :class="filter === 'unread' ? 'btn-primary' : 'btn-outline-secondary'"
                            @click="filter = 'unread'">
                        Non lues
                    </button>
                    <button type="button"
                            class="btn"
                            :class="filter === 'orders' ? 'btn-primary' : 'btn-outline-secondary'"
                            @click="filter = 'orders'">
                        Commandes
                    </button>
                    <button type="button"
                            class="btn"
                            :class="filter === 'messages' ? 'btn-primary' : 'btn-outline-secondary'"
                            @click="filter = 'messages'">
                        Messages
                    </button>
                </div>
            </div>

            <!-- Notifications List -->
            <div class="notifications-list overflow-auto" style="max-height: 350px;">
                <template x-if="filteredNotifications.length === 0">
                    <div class="text-center py-5">
                        <i class="bi bi-bell-slash display-4 text-muted mb-3"></i>
                        <p class="text-muted">Aucune notification</p>
                    </div>
                </template>

                <template x-for="(notification, index) in filteredNotifications" :key="notification.id">
                    <div @click="handleNotificationClick(notification)"
                         class="notification-item p-3 border-bottom cursor-pointer transition-all"
                         :class="{
                             'bg-light': !notification.read,
                             'notification-hover': true
                         }"
                         style="cursor: pointer;">

                        <div class="d-flex">
                            <!-- Icon -->
                            <div class="me-3 flex-shrink-0">
                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                     :class="getIconClass(notification.type)"
                                     style="width: 40px; height: 40px;">
                                    <i class="bi" :class="getIconName(notification.type)"></i>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <h6 class="mb-0 fw-bold"
                                        :class="{ 'text-primary': !notification.read }"
                                        x-text="notification.title"></h6>
                                    <button @click.stop="removeNotification(notification.id)"
                                            class="btn btn-link btn-sm p-0 text-muted">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                                <p class="mb-1 small text-muted" x-text="notification.message"></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>
                                        <span x-text="formatTime(notification.created_at)"></span>
                                    </small>
                                    <span x-show="!notification.read"
                                          class="badge bg-primary badge-sm">Nouveau</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Footer -->
            <div class="dropdown-footer border-top p-2 text-center bg-light">
                <a href="/notifications" class="btn btn-sm btn-link text-decoration-none">
                    Voir toutes les notifications
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function notificationCenter() {
    return {
        open: false,
        filter: 'all',
        notifications: [],
        pollingInterval: null,

        get unreadCount() {
            return this.notifications.filter(n => !n.read).length;
        },

        get hasUnread() {
            return this.unreadCount > 0;
        },

        get filteredNotifications() {
            let filtered = this.notifications;

            switch(this.filter) {
                case 'unread':
                    filtered = filtered.filter(n => !n.read);
                    break;
                case 'orders':
                    filtered = filtered.filter(n => n.type === 'order');
                    break;
                case 'messages':
                    filtered = filtered.filter(n => n.type === 'message');
                    break;
            }

            return filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        },

        init() {
            this.loadNotifications();
            this.startPolling();

            // Listen for new notifications
            window.addEventListener('new-notification', (event) => {
                this.addNotification(event.detail);
            });
        },

        toggle() {
            this.open = !this.open;
        },

        loadNotifications() {
            // Load from localStorage for demo
            const saved = localStorage.getItem('notifications');
            if (saved) {
                this.notifications = JSON.parse(saved);
            } else {
                // Demo notifications
                this.notifications = this.getDemoNotifications();
                this.saveNotifications();
            }
        },

        saveNotifications() {
            localStorage.setItem('notifications', JSON.stringify(this.notifications));
        },

        addNotification(notification) {
            this.notifications.unshift({
                id: Date.now(),
                read: false,
                created_at: new Date().toISOString(),
                ...notification
            });

            // Keep only last 50 notifications
            if (this.notifications.length > 50) {
                this.notifications = this.notifications.slice(0, 50);
            }

            this.saveNotifications();

            // Show toast
            notyf.success(notification.title);

            // Play sound (optional)
            this.playNotificationSound();
        },

        handleNotificationClick(notification) {
            // Mark as read
            notification.read = true;
            this.saveNotifications();

            // Navigate to relevant page
            if (notification.action_url) {
                window.location.href = notification.action_url;
            }

            this.open = false;
        },

        markAllAsRead() {
            this.notifications.forEach(n => n.read = true);
            this.saveNotifications();
            notyf.success('Toutes les notifications marquées comme lues');
        },

        async clearAll() {
            const result = await Swal.fire({
                title: 'Effacer toutes les notifications?',
                text: 'Cette action est irréversible',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, effacer',
                cancelButtonText: 'Annuler',
                confirmButtonColor: '#dc3545'
            });

            if (result.isConfirmed) {
                this.notifications = [];
                this.saveNotifications();
                notyf.success('Notifications effacées');
                this.open = false;
            }
        },

        removeNotification(id) {
            this.notifications = this.notifications.filter(n => n.id !== id);
            this.saveNotifications();
        },

        startPolling() {
            // Poll for new notifications every 30 seconds
            this.pollingInterval = setInterval(() => {
                this.fetchNewNotifications();
            }, 30000);
        },

        async fetchNewNotifications() {
            // In real app, fetch from API
            // const response = await fetch('/api/notifications/new');
            // const newNotifications = await response.json();
            // newNotifications.forEach(n => this.addNotification(n));
        },

        playNotificationSound() {
            // Optional: play notification sound
            // const audio = new Audio('/sounds/notification.mp3');
            // audio.play().catch(e => console.log('Sound play failed'));
        },

        getIconClass(type) {
            const classes = {
                'order': 'bg-primary text-white',
                'message': 'bg-success text-white',
                'alert': 'bg-danger text-white',
                'info': 'bg-info text-white',
                'promo': 'bg-warning text-dark',
                'system': 'bg-secondary text-white'
            };
            return classes[type] || 'bg-secondary text-white';
        },

        getIconName(type) {
            const icons = {
                'order': 'bi-cart-check',
                'message': 'bi-chat-dots',
                'alert': 'bi-exclamation-triangle',
                'info': 'bi-info-circle',
                'promo': 'bi-gift',
                'system': 'bi-gear'
            };
            return icons[type] || 'bi-bell';
        },

        formatTime(date) {
            const now = new Date();
            const notifDate = new Date(date);
            const diff = now - notifDate;

            const minutes = Math.floor(diff / 60000);
            const hours = Math.floor(diff / 3600000);
            const days = Math.floor(diff / 86400000);

            if (minutes < 1) return 'À l\'instant';
            if (minutes < 60) return `Il y a ${minutes} min`;
            if (hours < 24) return `Il y a ${hours}h`;
            if (days < 7) return `Il y a ${days}j`;

            return notifDate.toLocaleDateString('fr-FR');
        },

        getDemoNotifications() {
            return [
                {
                    id: 1,
                    type: 'order',
                    title: 'Commande confirmée',
                    message: 'Votre commande #ORD-12345 a été confirmée',
                    action_url: '/orders/ORD-12345',
                    read: false,
                    created_at: new Date(Date.now() - 300000).toISOString()
                },
                {
                    id: 2,
                    type: 'message',
                    title: 'Nouveau message',
                    message: 'Vous avez reçu un message du grossiste',
                    action_url: '/messages',
                    read: false,
                    created_at: new Date(Date.now() - 3600000).toISOString()
                },
                {
                    id: 3,
                    type: 'promo',
                    title: 'Promotion spéciale',
                    message: '-20% sur tous les produits électroniques',
                    action_url: '/products?category=electronics',
                    read: true,
                    created_at: new Date(Date.now() - 86400000).toISOString()
                }
            ];
        }
    }
}
</script>

<style>
.notification-center {
    display: inline-block;
}

.notification-dropdown {
    animation: fadeInDown 0.3s ease;
}

.notification-item {
    transition: all 0.2s ease;
}

.notification-hover:hover {
    background-color: #f8f9fa !important;
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
