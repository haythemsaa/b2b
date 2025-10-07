<?php $__env->startSection('title', 'Analytics & Rapports'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid" x-data="analytics()" x-init="init()">
    <!-- Header -->
    <div class="row mb-4 animate__animated animate__fadeInDown">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1><i class="bi bi-graph-up me-2 text-primary"></i>Analytics & Rapports</h1>
                    <p class="text-muted mb-0">Analyse détaillée de vos performances</p>
                </div>
                <div class="d-flex gap-2">
                    <!-- Period Selector -->
                    <select class="form-select" x-model="period" @change="refreshData()">
                        <option value="today">Aujourd'hui</option>
                        <option value="week">Cette semaine</option>
                        <option value="month" selected>Ce mois</option>
                        <option value="quarter">Ce trimestre</option>
                        <option value="year">Cette année</option>
                    </select>
                    <button @click="refreshData()" class="btn btn-outline-primary" :disabled="loading">
                        <i class="bi bi-arrow-clockwise" :class="{ 'rotate-animation': loading }"></i>
                        Actualiser
                    </button>
                    <button @click="exportReport()" class="btn btn-success">
                        <i class="bi bi-download me-2"></i>Exporter PDF
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="row mb-4">
        <!-- Revenue -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm card-hover animate__animated animate__fadeInUp">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-muted mb-0">Chiffre d'Affaires</h6>
                        <div class="icon-shape bg-primary bg-opacity-10 rounded">
                            <i class="bi bi-currency-dollar text-primary fs-4"></i>
                        </div>
                    </div>
                    <h3 class="mb-0" x-text="formatCurrency(kpis.revenue)">0</h3>
                    <div class="mt-2">
                        <span class="badge"
                              :class="kpis.revenue_growth >= 0 ? 'bg-success' : 'bg-danger'">
                            <i class="bi" :class="kpis.revenue_growth >= 0 ? 'bi-arrow-up' : 'bi-arrow-down'"></i>
                            <span x-text="Math.abs(kpis.revenue_growth) + '%'"></span>
                        </span>
                        <small class="text-muted ms-2">vs période précédente</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm card-hover animate__animated animate__fadeInUp"
                 style="animation-delay: 0.1s">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-muted mb-0">Commandes</h6>
                        <div class="icon-shape bg-success bg-opacity-10 rounded">
                            <i class="bi bi-cart-check text-success fs-4"></i>
                        </div>
                    </div>
                    <h3 class="mb-0" x-text="kpis.orders">0</h3>
                    <div class="mt-2">
                        <span class="badge"
                              :class="kpis.orders_growth >= 0 ? 'bg-success' : 'bg-danger'">
                            <i class="bi" :class="kpis.orders_growth >= 0 ? 'bi-arrow-up' : 'bi-arrow-down'"></i>
                            <span x-text="Math.abs(kpis.orders_growth) + '%'"></span>
                        </span>
                        <small class="text-muted ms-2">vs période précédente</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Average Order Value -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm card-hover animate__animated animate__fadeInUp"
                 style="animation-delay: 0.2s">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-muted mb-0">Panier Moyen</h6>
                        <div class="icon-shape bg-warning bg-opacity-10 rounded">
                            <i class="bi bi-wallet2 text-warning fs-4"></i>
                        </div>
                    </div>
                    <h3 class="mb-0" x-text="formatCurrency(kpis.avg_order_value)">0</h3>
                    <div class="mt-2">
                        <span class="badge"
                              :class="kpis.aov_growth >= 0 ? 'bg-success' : 'bg-danger'">
                            <i class="bi" :class="kpis.aov_growth >= 0 ? 'bi-arrow-up' : 'bi-arrow-down'"></i>
                            <span x-text="Math.abs(kpis.aov_growth) + '%'"></span>
                        </span>
                        <small class="text-muted ms-2">vs période précédente</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conversion Rate -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm card-hover animate__animated animate__fadeInUp"
                 style="animation-delay: 0.3s">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-muted mb-0">Taux de Conversion</h6>
                        <div class="icon-shape bg-info bg-opacity-10 rounded">
                            <i class="bi bi-percent text-info fs-4"></i>
                        </div>
                    </div>
                    <h3 class="mb-0"><span x-text="kpis.conversion_rate"></span>%</h3>
                    <div class="mt-2">
                        <span class="badge"
                              :class="kpis.conversion_growth >= 0 ? 'bg-success' : 'bg-danger'">
                            <i class="bi" :class="kpis.conversion_growth >= 0 ? 'bi-arrow-up' : 'bi-arrow-down'"></i>
                            <span x-text="Math.abs(kpis.conversion_growth) + '%'"></span>
                        </span>
                        <small class="text-muted ms-2">vs période précédente</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 1 -->
    <div class="row mb-4">
        <!-- Revenue Chart -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm animate__animated animate__fadeInLeft">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="bi bi-graph-up me-2 text-primary"></i>
                        Évolution du Chiffre d'Affaires
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="80"></canvas>
                </div>
            </div>
        </div>

        <!-- Orders by Status -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm animate__animated animate__fadeInRight">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="bi bi-pie-chart me-2 text-success"></i>
                        Commandes par Statut
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" height="180"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="row mb-4">
        <!-- Top Products -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
                <div class="card-header bg-white border-0 d-flex justify-content-between">
                    <h5 class="mb-0">
                        <i class="bi bi-trophy me-2 text-warning"></i>
                        Top 10 Produits
                    </h5>
                    <div class="btn-group btn-group-sm">
                        <button class="btn" :class="topProductsBy === 'revenue' ? 'btn-primary' : 'btn-outline-secondary'"
                                @click="topProductsBy = 'revenue'; updateTopProducts()">
                            Revenus
                        </button>
                        <button class="btn" :class="topProductsBy === 'quantity' ? 'btn-primary' : 'btn-outline-secondary'"
                                @click="topProductsBy = 'quantity'; updateTopProducts()">
                            Quantité
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="topProductsChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Sales by Category -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm animate__animated animate__fadeInUp"
                 style="animation-delay: 0.1s">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="bi bi-diagram-3 me-2 text-info"></i>
                        Ventes par Catégorie
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="row">
        <!-- Recent Transactions -->
        <div class="col-lg-12 mb-4">
            <div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="bi bi-clock-history me-2 text-secondary"></i>
                        Transactions Récentes
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID Transaction</th>
                                    <th>Client</th>
                                    <th>Produits</th>
                                    <th>Date</th>
                                    <th class="text-end">Montant</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(tx, index) in recentTransactions" :key="tx.id">
                                    <tr class="animate__animated animate__fadeIn"
                                        :style="'animation-delay: ' + (index * 0.05) + 's'">
                                        <td><strong x-text="tx.id"></strong></td>
                                        <td x-text="tx.customer"></td>
                                        <td><span x-text="tx.items_count"></span> article(s)</td>
                                        <td x-text="formatDate(tx.date)"></td>
                                        <td class="text-end"><strong x-text="formatCurrency(tx.amount)"></strong></td>
                                        <td>
                                            <span class="badge"
                                                  :class="getStatusClass(tx.status)"
                                                  x-text="tx.status_label"></span>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
function analytics() {
    return {
        period: 'month',
        loading: false,
        topProductsBy: 'revenue',

        kpis: {
            revenue: 125430,
            revenue_growth: 12.5,
            orders: 248,
            orders_growth: 8.3,
            avg_order_value: 505.77,
            aov_growth: 3.8,
            conversion_rate: 3.2,
            conversion_growth: -0.5
        },

        recentTransactions: [],
        charts: {},

        init() {
            this.loadData();
            this.initCharts();
        },

        loadData() {
            // Demo data
            this.recentTransactions = [
                {
                    id: 'TRX-12345',
                    customer: 'Ahmed Ben Ali',
                    items_count: 5,
                    date: new Date(Date.now() - 3600000),
                    amount: 1250.00,
                    status: 'completed',
                    status_label: 'Complété'
                },
                {
                    id: 'TRX-12344',
                    customer: 'Fatma Hamdi',
                    items_count: 3,
                    date: new Date(Date.now() - 7200000),
                    amount: 850.50,
                    status: 'pending',
                    status_label: 'En attente'
                },
                // Add more demo data...
            ];
        },

        initCharts() {
            this.initRevenueChart();
            this.initStatusChart();
            this.initTopProductsChart();
            this.initCategoryChart();
        },

        initRevenueChart() {
            const ctx = document.getElementById('revenueChart');
            this.charts.revenue = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
                    datasets: [{
                        label: 'Chiffre d\'Affaires',
                        data: [12000, 19000, 15000, 25000, 22000, 30000, 28000, 35000, 32000, 38000, 42000, 45000],
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        },

        initStatusChart() {
            const ctx = document.getElementById('statusChart');
            this.charts.status = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['En attente', 'Confirmée', 'Expédiée', 'Livrée', 'Annulée'],
                    datasets: [{
                        data: [45, 85, 120, 180, 15],
                        backgroundColor: [
                            '#ffc107',
                            '#17a2b8',
                            '#6c757d',
                            '#28a745',
                            '#dc3545'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true
                }
            });
        },

        initTopProductsChart() {
            const ctx = document.getElementById('topProductsChart');
            this.charts.topProducts = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Produit 1', 'Produit 2', 'Produit 3', 'Produit 4', 'Produit 5', 'Produit 6', 'Produit 7', 'Produit 8', 'Produit 9', 'Produit 10'],
                    datasets: [{
                        label: 'Revenus (DT)',
                        data: [12500, 10200, 9800, 8500, 7200, 6800, 6200, 5500, 4800, 4200],
                        backgroundColor: 'rgba(54, 162, 235, 0.8)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    indexAxis: 'y'
                }
            });
        },

        initCategoryChart() {
            const ctx = document.getElementById('categoryChart');
            this.charts.category = new Chart(ctx, {
                type: 'polarArea',
                data: {
                    labels: ['Électronique', 'Alimentation', 'Vêtements', 'Maison', 'Sport'],
                    datasets: [{
                        data: [35000, 28000, 22000, 18000, 12000],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(153, 102, 255, 0.7)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true
                }
            });
        },

        async refreshData() {
            this.loading = true;

            try {
                // Simulate API call
                await new Promise(resolve => setTimeout(resolve, 1000));

                // Update charts with new data
                this.updateChartsData();

                notyf.success('Données actualisées');
            } catch (error) {
                notyf.error('Erreur lors de l\'actualisation');
            } finally {
                this.loading = false;
            }
        },

        updateChartsData() {
            // Update chart data based on selected period
            // This would fetch from API in real app
        },

        updateTopProducts() {
            // Update top products chart based on selection
        },

        exportReport() {
            notyf.success('Export du rapport en cours...');
            // In real app, generate PDF
            setTimeout(() => {
                notyf.success('Rapport exporté avec succès!');
            }, 2000);
        },

        formatCurrency(amount) {
            return new Intl.NumberFormat('fr-TN', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(amount) + ' DT';
        },

        formatDate(date) {
            return new Date(date).toLocaleDateString('fr-FR', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
        },

        getStatusClass(status) {
            const classes = {
                'completed': 'bg-success',
                'pending': 'bg-warning',
                'cancelled': 'bg-danger',
                'processing': 'bg-info'
            };
            return classes[status] || 'bg-secondary';
        }
    }
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.icon-shape {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.rotate-animation {
    animation: rotate 1s linear infinite;
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2025\htdocs\b2bn\resources\views\analytics\index.blade.php ENDPATH**/ ?>