@extends('layouts.admin')

@section('title', 'Gestion des Produits')
@section('page-title', 'Gestion des Produits')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">Produits</h2>
                <p class="text-muted">Gérez votre catalogue de produits</p>
            </div>
            <a href="{{ route('admin.products.create') }}" class="btn btn-admin-primary">
                <i class="fas fa-plus-circle me-2"></i>Nouveau Produit
            </a>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-filter me-2"></i>Filtres de Recherche
            </div>
            <div class="card-body">
                    <form method="GET" action="{{ route('admin.products.index') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control"
                                       placeholder="Rechercher par nom ou SKU..."
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="category_id" class="form-select">
                                    <option value="">Toutes les catégories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-admin-primary w-100">
                                    <i class="fas fa-search me-2"></i>Filtrer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-box me-2"></i>Liste des Produits ({{ $products->total() }})
            </div>
            <div class="card-body">
                    @if($products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Nom</th>
                                        <th>SKU</th>
                                        <th>Catégorie</th>
                                        <th>Prix</th>
                                        <th>Stock</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                 style="width: 50px; height: 50px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        </td>
                                        <td>
                                            <strong>{{ $product->name }}</strong>
                                            @if($product->description)
                                                <br><small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td><code>{{ $product->sku }}</code></td>
                                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                                        <td>{{ number_format($product->base_price, 2) }}€</td>
                                        <td>
                                            <span class="badge bg-{{ $product->stock_quantity > 10 ? 'success' : ($product->stock_quantity > 0 ? 'warning' : 'danger') }}">
                                                {{ $product->stock_quantity }}
                                            </span>
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.products.toggle-status', $product) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-{{ $product->is_active ? 'success' : 'secondary' }}">
                                                    {{ $product->is_active ? 'Actif' : 'Inactif' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.products.edit', $product) }}"
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                                      class="d-inline" onsubmit="return confirm('Êtes-vous sûr ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $products->links() }}
                    @else
                        <p class="text-muted text-center py-4">Aucun produit trouvé.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection