<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', 'Admin'); ?> - <?php echo e(config('app.name', 'B2B Platform')); ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Admin Custom CSS -->
    <style>
        :root {
            --admin-primary: #2c3e50;
            --admin-secondary: #34495e;
            --admin-accent: #3498db;
            --admin-success: #27ae60;
            --admin-warning: #f39c12;
            --admin-danger: #e74c3c;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .admin-sidebar {
            background: linear-gradient(180deg, var(--admin-primary), var(--admin-secondary));
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            z-index: 1000;
            transition: all 0.3s;
        }

        .admin-content {
            margin-left: 250px;
            transition: all 0.3s;
        }

        .sidebar-brand {
            padding: 1.5rem 1rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-brand h4 {
            color: white;
            margin: 0;
            font-weight: 600;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            padding: 0.75rem 1.5rem;
            border-radius: 0;
            transition: all 0.3s;
            display: flex;
            align-items: center;
        }

        .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: white !important;
            transform: translateX(5px);
        }

        .nav-link.active {
            background-color: var(--admin-accent);
            color: white !important;
        }

        .nav-link i {
            width: 20px;
            margin-right: 10px;
        }

        .admin-header {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .admin-title {
            color: var(--admin-primary);
            margin: 0;
            font-weight: 600;
        }

        .breadcrumb-item a {
            color: var(--admin-accent);
            text-decoration: none;
        }

        .card {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .card-header {
            background: var(--admin-primary);
            color: white;
            border-bottom: none;
            font-weight: 600;
        }

        .btn-admin-primary {
            background-color: var(--admin-primary);
            border-color: var(--admin-primary);
            color: white;
        }

        .btn-admin-primary:hover {
            background-color: var(--admin-secondary);
            border-color: var(--admin-secondary);
            color: white;
        }

        .table th {
            background-color: var(--admin-primary);
            color: white;
            border: none;
        }

        .user-info {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: auto;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--admin-accent);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .stats-card {
            background: linear-gradient(135deg, var(--admin-accent), #5dade2);
            color: white;
            border-radius: 10px;
        }

        .stats-card .card-body {
            padding: 1.5rem;
        }

        .stats-icon {
            font-size: 2.5rem;
            opacity: 0.3;
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                margin-left: -250px;
            }
            .admin-content {
                margin-left: 0;
            }
            .sidebar-toggled .admin-sidebar {
                margin-left: 0;
            }
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--admin-danger);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav class="admin-sidebar d-flex flex-column">
            <div class="sidebar-brand">
                <h4>
                    <i class="fas fa-cog"></i>
                    Admin Panel
                </h4>
                <small class="text-light"><?php echo e(config('app.name')); ?></small>
            </div>

            <ul class="nav flex-column sidebar-nav flex-grow-1">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard')); ?>">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.users.index')); ?>">
                        <i class="fas fa-users"></i>
                        Utilisateurs
                        <?php if(\App\Models\User::where('tenant_id', auth()->user()->tenant_id)->count() > 0): ?>
                            <span class="notification-badge"><?php echo e(\App\Models\User::where('tenant_id', auth()->user()->tenant_id)->count()); ?></span>
                        <?php endif; ?>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.products.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.products.index')); ?>">
                        <i class="fas fa-box"></i>
                        Produits
                        <span class="notification-badge"><?php echo e(\App\Models\Product::count()); ?></span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.categories.index')); ?>">
                        <i class="fas fa-sitemap"></i>
                        Catégories
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.attributes.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.attributes.index')); ?>">
                        <i class="fas fa-sliders-h"></i>
                        Attributs Produits
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.groups.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.groups.index')); ?>">
                        <i class="fas fa-layer-group"></i>
                        Groupes Clients
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.custom-prices.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.custom-prices.index')); ?>">
                        <i class="fas fa-tags"></i>
                        Prix Personnalisés
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.orders.index')); ?>">
                        <i class="fas fa-shopping-cart"></i>
                        Commandes
                        <?php if(\App\Models\Order::where('status', 'pending')->count() > 0): ?>
                            <span class="notification-badge"><?php echo e(\App\Models\Order::where('status', 'pending')->count()); ?></span>
                        <?php endif; ?>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.returns.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.returns.index')); ?>">
                        <i class="fas fa-undo"></i>
                        Retours & SAV
                        <?php if(\App\Models\ProductReturn::where('status', 'pending')->count() > 0): ?>
                            <span class="notification-badge"><?php echo e(\App\Models\ProductReturn::where('status', 'pending')->count()); ?></span>
                        <?php endif; ?>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.reports.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.reports.index')); ?>">
                        <i class="fas fa-chart-bar"></i>
                        Rapports
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.quotes.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.quotes.index')); ?>">
                        <i class="fas fa-file-invoice"></i>
                        Devis
                        <?php if(\App\Models\Quote::whereIn('status', ['sent', 'viewed'])->count() > 0): ?>
                            <span class="notification-badge"><?php echo e(\App\Models\Quote::whereIn('status', ['sent', 'viewed'])->count()); ?></span>
                        <?php endif; ?>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.currencies.*', 'admin.exchange-rates.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.currencies.index')); ?>">
                        <i class="fas fa-money-bill-wave"></i>
                        Devises & Taux
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.integrations.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.integrations.index')); ?>">
                        <i class="fas fa-plug"></i>
                        Intégrations ERP
                    </a>
                </li>

                <hr class="sidebar-divider" style="border-color: rgba(255,255,255,0.2);">

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('dashboard')); ?>">
                        <i class="fas fa-eye"></i>
                        Voir le site
                    </a>
                </li>

                <?php if(auth()->user()->role === 'superadmin'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('superadmin.dashboard')); ?>">
                        <i class="fas fa-crown"></i>
                        SuperAdmin
                    </a>
                </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        Déconnexion
                    </a>
                </li>
            </ul>

            <div class="user-info">
                <div class="d-flex align-items-center">
                    <div class="user-avatar">
                        <?php echo e(strtoupper(substr(auth()->user()->name, 0, 2))); ?>

                    </div>
                    <div class="ms-2 flex-grow-1">
                        <div class="text-white font-weight-bold"><?php echo e(auth()->user()->name); ?></div>
                        <small class="text-light"><?php echo e(ucfirst(auth()->user()->role)); ?></small>
                    </div>
                </div>
                <!-- Language Selector -->
                <div class="mt-3">
                    <select class="form-select form-select-sm" onchange="window.location.href=this.value" style="background-color: rgba(255,255,255,0.1); color: white; border-color: rgba(255,255,255,0.2);">
                        <option value="<?php echo e(route('set-locale', 'fr')); ?>" <?php echo e(app()->getLocale() == 'fr' ? 'selected' : ''); ?>>🇫🇷 Français</option>
                        <option value="<?php echo e(route('set-locale', 'en')); ?>" <?php echo e(app()->getLocale() == 'en' ? 'selected' : ''); ?>>🇬🇧 English</option>
                        <option value="<?php echo e(route('set-locale', 'ar')); ?>" <?php echo e(app()->getLocale() == 'ar' ? 'selected' : ''); ?>>🇸🇦 العربية</option>
                    </select>
                </div>
            </div>
        </nav>

        <!-- Content -->
        <main class="admin-content">
            <header class="admin-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="admin-title"><?php echo $__env->yieldContent('page-title', 'Administration'); ?></h1>
                        <?php if(isset($breadcrumbs)): ?>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($loop->last): ?>
                                            <li class="breadcrumb-item active"><?php echo e($breadcrumb['text']); ?></li>
                                        <?php else: ?>
                                            <li class="breadcrumb-item">
                                                <a href="<?php echo e($breadcrumb['url']); ?>"><?php echo e($breadcrumb['text']); ?></a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ol>
                            </nav>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-outline-secondary me-3 d-md-none" id="sidebar-toggle">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i>
                                <?php echo e(auth()->user()->name); ?>

                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user-cog me-2"></i>Profil</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Paramètres</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>

            <div class="container-fluid px-4">
                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?php echo e(session('error')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h6><i class="fas fa-exclamation-triangle me-2"></i>Erreurs détectées :</h6>
                        <ul class="mb-0">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
        <?php echo csrf_field(); ?>
    </form>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Admin Custom JS -->
    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebar-toggle')?.addEventListener('click', function() {
            document.body.classList.toggle('sidebar-toggled');
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Confirmation dialogs for delete actions
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-confirm') || e.target.closest('.delete-confirm')) {
                if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ? Cette action est irréversible.')) {
                    e.preventDefault();
                    return false;
                }
            }
        });

        // Table row highlighting
        document.querySelectorAll('table tbody tr').forEach(function(row) {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8f9fa';
            });
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\layouts\admin.blade.php ENDPATH**/ ?>