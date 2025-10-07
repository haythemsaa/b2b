@extends('layouts.admin')

@section('title', 'Rapports & Statistiques')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">
                <i class="bi bi-file-earmark-bar-graph me-2 text-primary"></i>
                Rapports & Statistiques
            </h1>
            <p class="text-muted">Analysez vos performances business</p>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <i class="bi bi-graph-up text-primary" style="font-size: 3rem;"></i>
                    <h3 class="mt-3">Ventes</h3>
                    <p class="text-muted">Analyse des ventes</p>
                    <a href="{{ route('admin.reports.sales') }}" class="btn btn-primary">
                        Voir le rapport
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="bi bi-box-seam text-success" style="font-size: 3rem;"></i>
                    <h3 class="mt-3">Stock</h3>
                    <p class="text-muted">Gestion inventaire</p>
                    <a href="{{ route('admin.reports.inventory') }}" class="btn btn-success">
                        Voir le rapport
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <i class="bi bi-people text-info" style="font-size: 3rem;"></i>
                    <h3 class="mt-3">Clients</h3>
                    <p class="text-muted">Analyse clientèle</p>
                    <a href="{{ route('admin.reports.customers') }}" class="btn btn-info">
                        Voir le rapport
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <i class="bi bi-download text-warning" style="font-size: 3rem;"></i>
                    <h3 class="mt-3">Exports</h3>
                    <p class="text-muted">Télécharger données</p>
                    <div class="dropdown">
                        <button class="btn btn-warning dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Exporter
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.reports.export', 'sales') }}">Ventes CSV</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.reports.export', 'products') }}">Produits CSV</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.reports.export', 'customers') }}">Clients CSV</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Available Reports -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Rapports Disponibles</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Rapport</th>
                                    <th>Description</th>
                                    <th>Données</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><i class="bi bi-graph-up text-primary me-2"></i>Rapport Ventes</td>
                                    <td>Analyse détaillée des ventes par période, top vendeurs et produits</td>
                                    <td><span class="badge bg-primary">Ventes, CA, Vendeurs</span></td>
                                    <td>
                                        <a href="{{ route('admin.reports.sales') }}" class="btn btn-sm btn-primary">Voir</a>
                                        <a href="{{ route('admin.reports.export', 'sales') }}" class="btn btn-sm btn-outline-primary">Export</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-box-seam text-success me-2"></i>Rapport Stock</td>
                                    <td>État des stocks, produits en rupture, valeur inventaire</td>
                                    <td><span class="badge bg-success">Stock, Valeur, Catégories</span></td>
                                    <td>
                                        <a href="{{ route('admin.reports.inventory') }}" class="btn btn-sm btn-success">Voir</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-people text-info me-2"></i>Rapport Clients</td>
                                    <td>Top clients, nouveaux clients, analyse par groupe</td>
                                    <td><span class="badge bg-info">Clients, Groupes, CA</span></td>
                                    <td>
                                        <a href="{{ route('admin.reports.customers') }}" class="btn btn-sm btn-info">Voir</a>
                                        <a href="{{ route('admin.reports.export', 'customers') }}" class="btn btn-sm btn-outline-info">Export</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
