@extends('layouts.admin')

@section('title', 'Rapport Clients')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="bi bi-people me-2 text-info"></i>
                Rapport Clients
            </h1>
            <p class="text-muted">Analyse de votre clientèle et performance</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.reports.export', 'customers') }}" class="btn btn-success">
                <i class="bi bi-download me-2"></i>Exporter CSV
            </a>
            <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Retour
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="text-white-50">Total Clients</h6>
                    <h2 class="mb-0">{{ $totalCustomers }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="text-white-50">Clients Actifs</h6>
                    <h2 class="mb-0">{{ $activeCustomers }}</h2>
                    <small class="text-white-50">{{ number_format(($activeCustomers / max($totalCustomers, 1)) * 100, 1) }}%</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="text-white-50">Nouveaux Clients (30j)</h6>
                    <h2 class="mb-0">{{ $newCustomers }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Customers -->
    @if($topCustomers->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-trophy text-warning me-2"></i>
                        Top 20 Clients par Chiffre d'Affaires
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Client</th>
                                    <th>Email</th>
                                    <th>Commandes</th>
                                    <th>CA Total</th>
                                    <th>Panier Moyen</th>
                                    <th>Dernière Commande</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topCustomers as $index => $customer)
                                <tr>
                                    <td>
                                        @if($index < 3)
                                        <i class="bi bi-trophy-fill text-warning fs-5"></i>
                                        @else
                                        {{ $index + 1 }}
                                        @endif
                                    </td>
                                    <td><strong>{{ $customer->name }}</strong></td>
                                    <td>{{ $customer->email }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $customer->orders_count }}</span>
                                    </td>
                                    <td>
                                        <strong class="text-success">{{ number_format($customer->total_spent, 2) }} DT</strong>
                                    </td>
                                    <td>{{ number_format($customer->average_order, 2) }} DT</td>
                                    <td>
                                        @if($customer->last_order)
                                        <small>{{ \Carbon\Carbon::parse($customer->last_order)->format('d/m/Y') }}</small>
                                        @else
                                        <small class="text-muted">-</small>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Customers by Group -->
    @if($customersByGroup->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-diagram-3 me-2"></i>
                        Clients par Groupe
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Groupe</th>
                                    <th>Description</th>
                                    <th>Nombre de Clients</th>
                                    <th>Statut</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customersByGroup as $group)
                                <tr>
                                    <td><strong>{{ $group->name }}</strong></td>
                                    <td>{{ $group->description ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $group->users_count }} clients</span>
                                    </td>
                                    <td>
                                        @if($group->is_active)
                                        <span class="badge bg-success">Actif</span>
                                        @else
                                        <span class="badge bg-secondary">Inactif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.groups.show', $group->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Voir
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- No Data -->
    @if($topCustomers->count() === 0 && $customersByGroup->count() === 0)
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>
        Aucune donnée client disponible pour le moment.
    </div>
    @endif
</div>
@endsection
