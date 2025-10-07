@extends('layouts.admin')

@section('title', 'Rapport des Stocks')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="bi bi-box-seam me-2 text-success"></i>
                Rapport des Stocks
            </h1>
            <p class="text-muted">État de votre inventaire et alertes stock</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Retour
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="text-white-50">Total Produits</h6>
                    <h2 class="mb-0">{{ $totalProducts }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="text-white-50">Produits Actifs</h6>
                    <h2 class="mb-0">{{ $activeProducts }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6 class="text-white-50">Stock Total</h6>
                    <h2 class="mb-0">{{ number_format($stockValue->total_items) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="text-white-50">Valeur Stock</h6>
                    <h2 class="mb-0">{{ number_format($stockValue->total_value, 2) }} DT</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Alert -->
    @if($lowStockProducts->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-warning">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Produits en Stock Faible ({{ $lowStockProducts->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>SKU</th>
                                    <th>Stock Actuel</th>
                                    <th>Seuil Min</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lowStockProducts as $product)
                                <tr>
                                    <td><strong>{{ $product->name }}</strong></td>
                                    <td><code>{{ $product->sku }}</code></td>
                                    <td>
                                        <span class="badge bg-warning">{{ $product->stock_quantity }}</span>
                                    </td>
                                    <td>{{ $product->low_stock_threshold ?? 10 }}</td>
                                    <td>
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil"></i> Réapprovisionner
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

    <!-- Out of Stock -->
    @if($outOfStockProducts->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-x-circle me-2"></i>
                        Produits en Rupture ({{ $outOfStockProducts->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>SKU</th>
                                    <th>Catégorie</th>
                                    <th>Prix</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($outOfStockProducts as $product)
                                <tr>
                                    <td><strong>{{ $product->name }}</strong></td>
                                    <td><code>{{ $product->sku }}</code></td>
                                    <td>{{ $product->category->name ?? '-' }}</td>
                                    <td>{{ number_format($product->price, 2) }} DT</td>
                                    <td>
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-danger">
                                            <i class="bi bi-box-arrow-in-down"></i> Réapprovisionner
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

    <!-- Stock by Category -->
    @if($productsByCategory->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-pie-chart me-2"></i>
                        Répartition par Catégorie
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Catégorie</th>
                                    <th>Nombre de Produits</th>
                                    <th>Stock Total</th>
                                    <th>Valeur Totale</th>
                                    <th>% de la Valeur</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalValue = $productsByCategory->sum('total_value'); @endphp
                                @foreach($productsByCategory as $cat)
                                <tr>
                                    <td><strong>{{ $cat->category }}</strong></td>
                                    <td><span class="badge bg-primary">{{ $cat->products_count }}</span></td>
                                    <td>{{ number_format($cat->total_stock) }}</td>
                                    <td><strong>{{ number_format($cat->total_value, 2) }} DT</strong></td>
                                    <td>
                                        @php $percentage = $totalValue > 0 ? ($cat->total_value / $totalValue) * 100 : 0; @endphp
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                 style="width: {{ $percentage }}%">
                                                {{ number_format($percentage, 1) }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th>TOTAL</th>
                                    <th><span class="badge bg-dark">{{ $productsByCategory->sum('products_count') }}</span></th>
                                    <th>{{ number_format($productsByCategory->sum('total_stock')) }}</th>
                                    <th><strong>{{ number_format($totalValue, 2) }} DT</strong></th>
                                    <th>100%</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
