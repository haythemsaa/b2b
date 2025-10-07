<?php $__env->startSection('title', 'Tableau de bord'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid" x-data="dashboard()" x-init="init()">
    <!-- Header -->
    <div class="row mb-4 animate__animated animate__fadeInDown">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1><i class="bi bi-speedometer2 me-2 text-primary"></i>Tableau de bord</h1>
                    <p class="text-muted mb-0">
                        Bienvenue, <strong><?php echo e(auth()->user()->name); ?></strong> 👋
                        <span class="ms-3 small">
                            <i class="bi bi-calendar me-1"></i>
                            <span x-text="currentDate"></span>
                        </span>
                    </p>
                </div>
                <button @click="refreshData()" class="btn btn-outline-primary" :disabled="loading">
                    <i class="bi bi-arrow-clockwise" :class="{ 'rotate-animation': loading }"></i>
                    Actualiser
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <!-- Total Orders -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-gradient-primary text-white shadow-sm card-hover animate__animated animate__fadeInUp"
                 style="animation-delay: 0.1s">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small mb-1">Total commandes</div>
                            <h2 class="mb-0 counter" x-text="stats.total_orders"><?php echo e($orderStats['total']); ?></h2>
                        </div>
                        <div class="text-white-50">
                            <i class="bi bi-cart fs-1"></i>
                        </div>
                    </div>
                    <div class="mt-3 small">
                        <i class="bi bi-arrow-up me-1"></i>
                        <span x-text="stats.orders_growth + '%'">12%</span> ce mois
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-gradient-warning text-white shadow-sm card-hover animate__animated animate__fadeInUp"
                 style="animation-delay: 0.2s">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small mb-1">En attente</div>
                            <h2 class="mb-0 counter" x-text="stats.pending_orders"><?php echo e($orderStats['pending']); ?></h2>
                        </div>
                        <div class="text-white-50">
                            <i class="bi bi-clock fs-1 pulse"></i>
                        </div>
                    </div>
                    <div class="mt-3 small">
                        <a href="<?php echo e(route('orders.index')); ?>" class="text-white text-decoration-none">
                            Voir les commandes <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delivered Orders -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-gradient-success text-white shadow-sm card-hover animate__animated animate__fadeInUp"
                 style="animation-delay: 0.3s">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small mb-1">Livrées</div>
                            <h2 class="mb-0 counter" x-text="stats.delivered_orders"><?php echo e($orderStats['delivered']); ?></h2>
                        </div>
                        <div class="text-white-50">
                            <i class="bi bi-check-circle fs-1"></i>
                        </div>
                    </div>
                    <div class="mt-3 small">
                        <i class="bi bi-check2 me-1"></i>
                        <span x-text="stats.delivery_rate + '%'">95%</span> taux de livraison
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-gradient-info text-white shadow-sm card-hover animate__animated animate__fadeInUp"
                 style="animation-delay: 0.4s">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small mb-1">Messages non lus</div>
                            <h2 class="mb-0 counter" x-text="stats.unread_messages"><?php echo e($unreadMessages); ?></h2>
                        </div>
                        <div class="text-white-50">
                            <i class="bi bi-envelope fs-1" :class="{ 'pulse': stats.unread_messages > 0 }"></i>
                        </div>
                    </div>
                    <div class="mt-3 small">
                        <a href="<?php echo e(route('messages.index')); ?>" class="text-white text-decoration-none">
                            Lire les messages <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Orders -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm animate__animated animate__fadeInLeft">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-list-check me-2 text-primary"></i>
                        Commandes récentes
                    </h5>
                    <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-sm btn-outline-primary">
                        Voir tout <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body">
                    <?php if($recentOrders->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>N° Commande</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th class="text-end">Total</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="animate__animated animate__fadeInUp"
                                    style="animation-delay: <?php echo e($index * 0.05); ?>s">
                                    <td>
                                        <strong class="text-primary"><?php echo e($order->order_number); ?></strong>
                                    </td>
                                    <td>
                                        <small><?php echo e($order->created_at->format('d/m/Y H:i')); ?></small>
                                    </td>
                                    <td>
                                        <?php
                                            $statusConfig = [
                                                'pending' => ['class' => 'warning', 'icon' => 'clock', 'text' => 'En attente'],
                                                'confirmed' => ['class' => 'info', 'icon' => 'check-circle', 'text' => 'Confirmée'],
                                                'preparing' => ['class' => 'primary', 'icon' => 'box-seam', 'text' => 'En préparation'],
                                                'shipped' => ['class' => 'secondary', 'icon' => 'truck', 'text' => 'Expédiée'],
                                                'delivered' => ['class' => 'success', 'icon' => 'check-circle-fill', 'text' => 'Livrée'],
                                                'cancelled' => ['class' => 'danger', 'icon' => 'x-circle', 'text' => 'Annulée'],
                                            ];
                                            $status = $statusConfig[$order->status] ?? ['class' => 'secondary', 'icon' => 'question', 'text' => $order->status];
                                        ?>
                                        <span class="badge bg-<?php echo e($status['class']); ?>">
                                            <i class="bi bi-<?php echo e($status['icon']); ?> me-1"></i>
                                            <?php echo e($status['text']); ?>

                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <strong><?php echo e(number_format($order->total_amount, 2)); ?> DT</strong>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?php echo e(route('orders.show', $order->order_number)); ?>"
                                           class="btn btn-sm btn-outline-primary transition-all">
                                            <i class="bi bi-eye"></i> Voir
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-5">
                        <i class="bi bi-cart-x display-1 text-muted mb-3"></i>
                        <h5 class="text-muted">Aucune commande récente</h5>
                        <p class="text-muted mb-4">Commencez à passer des commandes pour les voir apparaître ici</p>
                        <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary">
                            <i class="bi bi-shop me-2"></i>Parcourir les produits
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Notifications -->
        <div class="col-lg-4 mb-4">
            <!-- Quick Actions -->
            <div class="card shadow-sm mb-4 animate__animated animate__fadeInRight">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-lightning-charge me-2 text-warning"></i>
                        Actions rapides
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?php echo e(route('products.index')); ?>"
                           class="btn btn-primary transition-all shadow-hover">
                            <i class="bi bi-box-seam me-2"></i>Parcourir les produits
                        </a>
                        <a href="<?php echo e(route('cart.index')); ?>"
                           class="btn btn-outline-primary transition-all" x-data="cart">
                            <i class="bi bi-cart3 me-2"></i>Voir le panier
                            <span x-show="count > 0" class="badge bg-primary ms-2" x-text="count"></span>
                        </a>
                        <a href="<?php echo e(route('messages.index')); ?>"
                           class="btn btn-outline-success transition-all">
                            <i class="bi bi-chat-dots me-2"></i>Contacter le grossiste
                        </a>
                        <a href="<?php echo e(route('orders.index')); ?>"
                           class="btn btn-outline-info transition-all">
                            <i class="bi bi-list-ul me-2"></i>Historique des commandes
                        </a>
                    </div>
                </div>
            </div>

            <!-- Notifications -->
            <?php if($unreadMessages > 0): ?>
            <div class="alert alert-info shadow-sm animate__animated animate__bounceIn">
                <h6 class="alert-heading">
                    <i class="bi bi-envelope-fill me-2"></i>Nouveaux messages
                </h6>
                <p class="mb-2">
                    Vous avez <strong><?php echo e($unreadMessages); ?></strong> nouveau(x) message(s).
                </p>
                <hr>
                <a href="<?php echo e(route('messages.index')); ?>" class="btn btn-sm btn-info">
                    Lire maintenant
                </a>
            </div>
            <?php endif; ?>

            <!-- Tips Card -->
            <div class="card shadow-sm border-0 bg-light animate__animated animate__fadeInRight"
                 style="animation-delay: 0.2s">
                <div class="card-body">
                    <h6 class="text-primary mb-3">
                        <i class="bi bi-lightbulb me-2"></i>Astuce du jour
                    </h6>
                    <p class="small text-muted mb-0">
                        💡 Utilisez les filtres de recherche pour trouver rapidement vos produits préférés.
                        Vous pouvez trier par prix, nom ou date d'ajout !
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Products -->
    <?php if($featuredProducts->count() > 0): ?>
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm animate__animated animate__fadeInUp">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-star me-2 text-warning"></i>
                        Produits recommandés
                    </h5>
                    <a href="<?php echo e(route('products.index')); ?>" class="btn btn-sm btn-outline-primary">
                        Voir tout <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
                            <div class="card h-100 product-card border-0 shadow-sm animate__animated animate__zoomIn"
                                 style="animation-delay: <?php echo e($index * 0.1); ?>s">
                                <div class="position-relative overflow-hidden" style="height: 180px;">
                                    <?php if($product->first_image): ?>
                                    <img src="<?php echo e($product->first_image); ?>"
                                         class="card-img-top w-100 h-100"
                                         style="object-fit: cover;"
                                         alt="<?php echo e($product->name); ?>">
                                    <?php else: ?>
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center h-100">
                                        <i class="bi bi-image fs-1 text-muted"></i>
                                    </div>
                                    <?php endif; ?>

                                    <!-- Badge Stock -->
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <?php if($product->isInStock()): ?>
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> En stock
                                        </span>
                                        <?php else: ?>
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle"></i> Rupture
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title text-truncate" title="<?php echo e($product->name); ?>">
                                        <?php echo e($product->name); ?>

                                    </h6>
                                    <p class="card-text text-muted small mb-2">
                                        <i class="bi bi-tag me-1"></i><?php echo e($product->sku); ?>

                                    </p>

                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <strong class="text-primary fs-5">
                                                <?php echo e(number_format($product->user_price, 2)); ?> DT
                                            </strong>
                                        </div>

                                        <div class="d-grid gap-2">
                                            <a href="<?php echo e(route('products.show', $product->sku)); ?>"
                                               class="btn btn-sm btn-outline-primary transition-all">
                                                <i class="bi bi-eye me-1"></i>Voir détails
                                            </a>
                                            <?php if($product->isInStock()): ?>
                                            <button type="button"
                                                    class="btn btn-sm btn-primary transition-all"
                                                    x-data="cart"
                                                    @click="addItem(<?php echo e($product->id); ?>)">
                                                <i class="bi bi-cart-plus me-1"></i>Ajouter au panier
                                            </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('styles'); ?>
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.counter {
    font-weight: 700;
    font-size: 2.5rem;
}

.rotate-animation {
    animation: rotate 1s linear infinite;
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-5px);
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function dashboard() {
    return {
        loading: false,
        currentDate: new Date().toLocaleDateString('fr-FR', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        }),
        stats: {
            total_orders: <?php echo e($orderStats['total']); ?>,
            pending_orders: <?php echo e($orderStats['pending']); ?>,
            delivered_orders: <?php echo e($orderStats['delivered']); ?>,
            unread_messages: <?php echo e($unreadMessages); ?>,
            orders_growth: 12,
            delivery_rate: 95
        },

        init() {
            // Animate counters on load
            this.animateCounters();
        },

        animateCounters() {
            // Simple counter animation would go here
            // For now, using CSS animations
        },

        async refreshData() {
            this.loading = true;

            try {
                // Simulate API call
                await new Promise(resolve => setTimeout(resolve, 1000));

                notyf.success('Données actualisées !');

                // In real app, fetch new data from API
                // const response = await fetch('/api/dashboard/stats');
                // this.stats = await response.json();

            } catch (error) {
                notyf.error('Erreur lors de l\'actualisation');
                console.error(error);
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\dashboard\index.blade.php ENDPATH**/ ?>