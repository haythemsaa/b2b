@extends('layouts.admin')

@section('title', 'Tableau de Bord Admin')
@section('page-title', 'Tableau de Bord')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Tableau de Bord Administrateur</h1>
                <div class="text-muted">{{ now()->format('d/m/Y H:i') }}</div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Statistiques rapides -->
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Vendeurs Actifs</h6>
                            <h3>{{ $stats['active_vendors'] ?? 0 }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-people fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Commandes du Mois</h6>
                            <h3>{{ $stats['orders_this_month'] ?? 0 }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-cart3 fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Produits</h6>
                            <h3>{{ $stats['total_products'] ?? 0 }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-box-seam fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">CA du Mois</h6>
                            <h3>{{ number_format($stats['revenue_this_month'] ?? 0) }}€</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-graph-up fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Commandes récentes -->
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Commandes Récentes</h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                </div>
                <div class="card-body">
                    @if(isset($recent_orders) && $recent_orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>N° Commande</th>
                                        <th>Client</th>
                                        <th>Montant</th>
                                        <th>Statut</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_orders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order->order_number) }}" class="text-decoration-none">
                                                {{ $order->order_number }}
                                            </a>
                                        </td>
                                        <td>{{ $order->user->company_name ?? $order->user->name }}</td>
                                        <td>{{ number_format($order->total_amount, 2) }}€</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'confirmed' ? 'success' : 'secondary') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Aucune commande récente.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Actions Rapides</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-outline-primary">
                            <i class="bi bi-person-plus"></i> Nouveau Vendeur
                        </a>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-outline-success">
                            <i class="bi bi-plus-circle"></i> Nouveau Produit
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-warning">
                            <i class="bi bi-list-check"></i> Gérer Commandes
                        </a>
                        <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-info">
                            <i class="bi bi-chat-dots"></i> Messages
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection