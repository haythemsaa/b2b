<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" x-data="{ darkMode: $persist(false) }" :class="{ 'dark-mode': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'B2B Platform')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Notyf CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    @if(app()->getLocale() === 'ar')
    <!-- RTL Support -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @endif

    @vite(['resources/css/app.css'])

    <style>
        /* Root CSS Variables - Light Mode */
        :root {
            --bg-primary: #ffffff;
            --bg-secondary: #f8f9fa;
            --bg-tertiary: #e9ecef;
            --text-primary: #212529;
            --text-secondary: #6c757d;
            --text-muted: #adb5bd;
            --border-color: #dee2e6;
            --shadow: rgba(0, 0, 0, 0.1);
            --card-bg: #ffffff;
            --sidebar-bg: #f8f9fa;
            --primary-color: #2c5f2d;
            --primary-hover: #1a3f1a;
        }

        /* Dark Mode Variables */
        .dark-mode {
            --bg-primary: #1a1a1a;
            --bg-secondary: #2d2d2d;
            --bg-tertiary: #3d3d3d;
            --text-primary: #e9ecef;
            --text-secondary: #adb5bd;
            --text-muted: #6c757d;
            --border-color: #495057;
            --shadow: rgba(0, 0, 0, 0.3);
            --card-bg: #2d2d2d;
            --sidebar-bg: #242424;
            --primary-color: #4a9d4e;
            --primary-hover: #3a7d3e;
        }

        /* Base Styles */
        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .navbar-brand {
            font-weight: bold;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        /* Cards */
        .card {
            background-color: var(--card-bg);
            color: var(--text-primary);
            border-color: var(--border-color);
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        /* Sidebar */
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            z-index: 1000;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .sidebar .nav-link {
            color: var(--text-primary);
            transition: color 0.2s ease;
        }

        .sidebar .nav-link:hover {
            background-color: var(--bg-tertiary);
        }

        .sidebar .nav-link.active {
            background-color: var(--primary-color);
            color: white;
        }

        .dark-mode .sidebar .nav-link.active {
            background-color: var(--primary-color);
        }

        /* Text colors */
        .text-muted {
            color: var(--text-muted) !important;
        }

        /* Alerts */
        .dark-mode .alert {
            background-color: var(--bg-secondary);
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        /* Forms */
        .dark-mode .form-control,
        .dark-mode .form-select {
            background-color: var(--bg-secondary);
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        .dark-mode .form-control:focus,
        .dark-mode .form-select:focus {
            background-color: var(--bg-tertiary);
            border-color: var(--primary-color);
            color: var(--text-primary);
        }

        /* Tables */
        .dark-mode table {
            color: var(--text-primary);
        }

        .dark-mode .table {
            --bs-table-bg: var(--bg-secondary);
            --bs-table-border-color: var(--border-color);
        }

        .dark-mode .table-hover tbody tr:hover {
            background-color: var(--bg-tertiary);
        }

        /* Dropdowns */
        .dark-mode .dropdown-menu {
            background-color: var(--bg-secondary);
            border-color: var(--border-color);
        }

        .dark-mode .dropdown-item {
            color: var(--text-primary);
        }

        .dark-mode .dropdown-item:hover {
            background-color: var(--bg-tertiary);
        }

        /* Modals */
        .dark-mode .modal-content {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
        }

        .dark-mode .modal-header,
        .dark-mode .modal-footer {
            border-color: var(--border-color);
        }

        /* Dark Mode Toggle Button */
        .dark-mode-toggle {
            position: relative;
            width: 60px;
            height: 30px;
            background-color: var(--bg-tertiary);
            border-radius: 30px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .dark-mode .dark-mode-toggle {
            background-color: var(--primary-color);
        }

        .dark-mode-toggle-circle {
            position: absolute;
            top: 3px;
            left: 3px;
            width: 24px;
            height: 24px;
            background-color: white;
            border-radius: 50%;
            transition: transform 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dark-mode .dark-mode-toggle-circle {
            transform: translateX(30px);
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .content {
                margin-left: 0;
            }
        }
        .chat-container {
            height: 400px;
            overflow-y: auto;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            padding: 15px;
            background-color: var(--card-bg);
        }
        .message {
            margin-bottom: 10px;
        }
        .message.mine {
            text-align: right;
        }
        .message.mine .badge {
            background-color: #0d6efd;
        }
        .message.theirs .badge {
            background-color: #6c757d;
        }

        /* Badges */
        .dark-mode .badge {
            background-color: var(--bg-tertiary);
            color: var(--text-primary);
        }

        .dark-mode .badge.bg-primary {
            background-color: var(--primary-color) !important;
        }

        /* Buttons */
        .dark-mode .btn-outline-secondary {
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        .dark-mode .btn-outline-secondary:hover {
            background-color: var(--bg-tertiary);
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        /* SweetAlert2 Dark Mode */
        .dark-mode .swal2-popup {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
        }

        .dark-mode .swal2-title,
        .dark-mode .swal2-html-container {
            color: var(--text-primary);
        }
    </style>

    @stack('styles')
</head>
<body x-data="{ sidebarOpen: false, cart: $persist({ count: 0 }) }">
    <div id="app">
        @auth
        <!-- Sidebar -->
        <nav class="sidebar col-md-3 col-lg-2 d-md-block bg-light sidebar animate__animated animate__fadeInLeft"
             id="sidebar"
             :class="{ 'show': sidebarOpen }"
             @click.outside="sidebarOpen = false">
            <div class="position-sticky pt-3">
                <div class="text-center mb-4">
                    <h5 class="text-primary">
                        @if(auth()->user()->role === 'superadmin')
                            SuperAdmin
                        @elseif(auth()->user()->isGrossiste())
                            Espace Grossiste
                        @else
                            Espace Vendeur
                        @endif
                    </h5>
                    <small class="text-muted d-block">{{ auth()->user()->name }}</small>
                    <small class="badge bg-{{ auth()->user()->role === 'superadmin' ? 'danger' : (auth()->user()->isGrossiste() ? 'primary' : 'success') }}">
                        {{ ucfirst(auth()->user()->role) }}
                    </small>
                </div>

                <ul class="nav flex-column">
                    @if(auth()->user()->role === 'superadmin')
                    {{-- Menu SuperAdmin --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}" href="{{ route('superadmin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('superadmin.tenants.*') ? 'active' : '' }}" href="{{ route('superadmin.tenants.index') }}">
                            <i class="bi bi-building"></i> Tenants
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('superadmin.analytics') ? 'active' : '' }}" href="{{ route('superadmin.analytics') }}">
                            <i class="bi bi-graph-up"></i> Analytics
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#exportMenu">
                            <i class="bi bi-download"></i> Exports <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul class="collapse nav flex-column ms-3" id="exportMenu">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('superadmin.export.tenants') }}?format=csv">
                                    <i class="bi bi-file-earmark-spreadsheet"></i> Tenants (CSV)
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('superadmin.export.analytics') }}?format=csv">
                                    <i class="bi bi-file-earmark-bar-graph"></i> Analytics (CSV)
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('superadmin.export.financial') }}?format=csv">
                                    <i class="bi bi-currency-dollar"></i> Financial (CSV)
                                </a>
                            </li>
                        </ul>
                    </li>

                    @elseif(auth()->user()->isGrossiste())
                    {{-- Menu Grossiste (Admin) --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-house-door"></i> Accueil
                        </a>
                    </li>

                    <li class="nav-item mt-3">
                        <small class="text-muted ps-3">GESTION VENDEURS</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                            <i class="bi bi-people"></i> Vendeurs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.groups.*') ? 'active' : '' }}" href="{{ route('admin.groups.index') }}">
                            <i class="bi bi-people-fill"></i> Groupes Clients
                        </a>
                    </li>

                    <li class="nav-item mt-3">
                        <small class="text-muted ps-3">CATALOGUE</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                            <i class="bi bi-box-seam"></i> Produits
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.custom-prices.*') ? 'active' : '' }}" href="{{ route('admin.custom-prices.index') }}">
                            <i class="bi bi-tag"></i> Prix Personnalisés
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-percent"></i> Promotions
                        </a>
                    </li>

                    <li class="nav-item mt-3">
                        <small class="text-muted ps-3">COMMANDES & STOCK</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                            <i class="bi bi-cart-check"></i> Commandes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.quotes.*') ? 'active' : '' }}" href="{{ route('admin.quotes.index') }}">
                            <i class="bi bi-file-text"></i> Devis
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.returns.*') ? 'active' : '' }}" href="{{ route('admin.returns.index') }}">
                            <i class="bi bi-arrow-return-left"></i> Retours RMA
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-box"></i> Stock
                        </a>
                    </li>

                    <li class="nav-item mt-3">
                        <small class="text-muted ps-3">COMMUNICATION</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}" href="{{ route('admin.messages.index') }}">
                            <i class="bi bi-chat-dots"></i> Messagerie
                        </a>
                    </li>

                    <li class="nav-item mt-3">
                        <small class="text-muted ps-3">RAPPORTS</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-graph-up"></i> Analytics
                        </a>
                    </li>

                    @else
                    {{-- Menu Vendeur --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-house-door"></i> Accueil
                        </a>
                    </li>

                    <li class="nav-item mt-3">
                        <small class="text-muted ps-3">CATALOGUE</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            <i class="bi bi-box-seam"></i> Produits
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-heart"></i> Favoris
                        </a>
                    </li>

                    <li class="nav-item mt-3">
                        <small class="text-muted ps-3">COMMANDES</small>
                    </li>
                    <li class="nav-item" x-data="cart" x-init="updateCount()">
                        <a class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart3 cart-icon"></i> Panier
                            <span class="badge bg-primary ms-1 badge-animated"
                                  x-show="count > 0"
                                  x-text="count"
                                  x-transition></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-lightning"></i> Quick Order
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                            <i class="bi bi-list-check"></i> Mes Commandes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('quotes.*') ? 'active' : '' }}" href="{{ route('quotes.index') }}">
                            <i class="bi bi-file-text"></i> Devis
                        </a>
                    </li>

                    <li class="nav-item mt-3">
                        <small class="text-muted ps-3">SERVICE</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('returns.*') ? 'active' : '' }}" href="{{ route('returns.index') }}">
                            <i class="bi bi-arrow-return-left"></i> Retours
                        </a>
                    </li>
                    <li class="nav-item" x-data="messages">
                        <a class="nav-link {{ request()->routeIs('messages.*') ? 'active' : '' }}" href="{{ route('messages.index') }}">
                            <i class="bi bi-chat-dots"></i> Messages
                            <span class="badge bg-danger ms-1 badge-animated badge-pulse"
                                  x-show="unreadCount > 0"
                                  x-text="unreadCount"
                                  x-transition></span>
                        </a>
                    </li>

                    <li class="nav-item mt-3">
                        <small class="text-muted ps-3">COMPTE</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('addresses.*') ? 'active' : '' }}" href="{{ route('addresses.index') }}">
                            <i class="bi bi-geo-alt"></i> Mes Adresses
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-file-text"></i> Documents
                        </a>
                    </li>
                    @endif
                </ul>

                <hr>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile') }}">
                            <i class="bi bi-person"></i> Profil
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-globe"></i> {{ app()->getLocale() === 'fr' ? 'Français' : 'العربية' }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('set-locale', 'fr') }}">Français</a></li>
                            <li><a class="dropdown-item" href="{{ route('set-locale', 'ar') }}">العربية</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <div class="nav-link d-flex align-items-center justify-content-between" style="cursor: default;">
                            <span><i class="bi" :class="darkMode ? 'bi-moon-stars-fill' : 'bi-sun-fill'"></i> Thème</span>
                            <div class="dark-mode-toggle" @click="darkMode = !darkMode">
                                <div class="dark-mode-toggle-circle">
                                    <i class="bi" :class="darkMode ? 'bi-moon-stars-fill text-warning' : 'bi-sun-fill text-warning'" style="font-size: 12px;"></i>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-start">
                                <i class="bi bi-box-arrow-right"></i> Déconnexion
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
        @endauth

        <!-- Main content -->
        <main class="@auth content @endauth">
            @auth
            <!-- Top bar for mobile -->
            <div class="d-md-none mb-3">
                <button class="btn btn-outline-secondary" type="button" @click="sidebarOpen = !sidebarOpen">
                    <i class="bi bi-list"></i>
                </button>
            </div>
            @endauth

            <!-- Flash messages with animations -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show animate__animated animate__shakeX" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Notyf JS -->
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/js/app.js'])

    <script>
        // Initialize Notyf
        const notyf = new Notyf({
            duration: 3000,
            position: { x: 'right', y: 'top' },
            dismissible: true,
            ripple: true,
        });

        // Alpine.js global components
        document.addEventListener('alpine:init', () => {
            // Sidebar component
            Alpine.data('sidebar', () => ({
                open: false,
                toggle() {
                    this.open = !this.open;
                    const sidebar = document.getElementById('sidebar');
                    if (sidebar) {
                        sidebar.classList.toggle('show');
                    }
                }
            }));

            // Cart manager
            Alpine.data('cart', () => ({
                count: 0,
                init() {
                    this.updateCount();
                },
                updateCount() {
                    const cart = JSON.parse(localStorage.getItem('cart') || '{}');
                    this.count = Object.values(cart).reduce((sum, qty) => sum + parseInt(qty), 0);
                },
                async addItem(productId, quantity = 1) {
                    try {
                        const response = await fetch('/cart/add', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ product_id: productId, quantity })
                        });
                        const data = await response.json();
                        if (data.success) {
                            this.updateCount();
                            notyf.success('Produit ajouté au panier !');
                        }
                    } catch (error) {
                        notyf.error('Erreur lors de l\'ajout au panier');
                        console.error(error);
                    }
                }
            }));

            // Messages manager
            @auth
            Alpine.data('messages', () => ({
                unreadCount: 0,
                init() {
                    this.updateUnreadCount();
                    setInterval(() => this.updateUnreadCount(), 30000);
                },
                async updateUnreadCount() {
                    try {
                        const response = await fetch('{{ route("messages.unread-count") }}');
                        const data = await response.json();
                        this.unreadCount = data.count;
                    } catch (error) {
                        console.error('Error updating message count:', error);
                    }
                }
            }));
            @endauth
        });
    </script>

    @stack('scripts')
</body>
</html>