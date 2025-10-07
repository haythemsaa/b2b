@extends('layouts.admin')

@section('title', 'Gestion des Tarifs Personnalisés')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Tarifs Personnalisés</h1>
                <a href="{{ route('admin.custom-prices.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouveau Tarif
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Liste des Tarifs Personnalisés</h5>
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3 mb-4">
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control" placeholder="Rechercher produit..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="product_id" class="form-select">
                                <option value="">Tous les produits</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="customer_group_id" class="form-select">
                                <option value="">Tous les groupes</option>
                                @foreach($customerGroups as $group)
                                    <option value="{{ $group->id }}" {{ request('customer_group_id') == $group->id ? 'selected' : '' }}>
                                        {{ $group->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Actif</option>
                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactif</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-outline-primary w-100">Filtrer</button>
                        </div>
                        <div class="col-md-1">
                            <a href="{{ route('admin.custom-prices.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                        </div>
                    </form>

                    @if($customPrices->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Prix Standard</th>
                                        <th>Prix Personnalisé</th>
                                        <th>Économie</th>
                                        <th>Cible</th>
                                        <th>Validité</th>
                                        <th>Statut</th>
                                        <th width="120">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customPrices as $customPrice)
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong>{{ $customPrice->product->name }}</strong>
                                                    <div class="small text-muted">SKU: {{ $customPrice->product->sku }}</div>
                                                </div>
                                            </td>
                                            <td>{{ number_format($customPrice->product->base_price, 2) }} MAD</td>
                                            <td>
                                                <strong class="text-success">{{ number_format($customPrice->price, 2) }} MAD</strong>
                                                @if($customPrice->min_quantity > 1)
                                                    <div class="small text-muted">Min: {{ $customPrice->min_quantity }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if($customPrice->product->price > 0)
                                                    @if($customPrice->price < $customPrice->product->price)
                                                        @php
                                                            $savings = $customPrice->product->price - $customPrice->price;
                                                            $percentage = ($savings / $customPrice->product->price) * 100;
                                                        @endphp
                                                        <span class="badge bg-success">
                                                            -{{ number_format($percentage, 1) }}%
                                                        </span>
                                                    @elseif($customPrice->price > $customPrice->product->price)
                                                        @php
                                                            $difference = $customPrice->price - $customPrice->product->price;
                                                            $percentage = ($difference / $customPrice->product->price) * 100;
                                                        @endphp
                                                        <span class="badge bg-warning">+{{ number_format($percentage, 1) }}%</span>
                                                    @else
                                                        <span class="badge bg-secondary">Identique</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($customPrice->user)
                                                    <div>
                                                        <i class="fas fa-user text-primary"></i>
                                                        <strong>{{ $customPrice->user->name }}</strong>
                                                        <div class="small text-muted">{{ $customPrice->user->company_name }}</div>
                                                    </div>
                                                @elseif($customPrice->customerGroup)
                                                    <div>
                                                        <i class="fas fa-users text-info"></i>
                                                        <strong>{{ $customPrice->customerGroup->name }}</strong>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if($customPrice->valid_from || $customPrice->valid_until)
                                                    <div class="small">
                                                        @if($customPrice->valid_from)
                                                            Du {{ $customPrice->valid_from->format('d/m/Y') }}
                                                        @endif
                                                        @if($customPrice->valid_until)
                                                            <br>Au {{ $customPrice->valid_until->format('d/m/Y') }}
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-muted">Permanent</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($customPrice->is_active)
                                                    @if($customPrice->isValid())
                                                        <span class="badge bg-success">Actif</span>
                                                    @else
                                                        <span class="badge bg-warning">Expiré</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-danger">Inactif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.custom-prices.show', $customPrice) }}"
                                                       class="btn btn-sm btn-outline-info" title="Voir">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.custom-prices.edit', $customPrice) }}"
                                                       class="btn btn-sm btn-outline-primary" title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-warning toggle-status"
                                                            data-price-id="{{ $customPrice->id }}"
                                                            title="{{ $customPrice->is_active ? 'Désactiver' : 'Activer' }}">
                                                        <i class="fas {{ $customPrice->is_active ? 'fa-pause' : 'fa-play' }}"></i>
                                                    </button>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-danger delete-price"
                                                            data-price-id="{{ $customPrice->id }}"
                                                            data-product-name="{{ $customPrice->product->name }}"
                                                            title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $customPrices->withQueryString()->links() }}
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucun tarif personnalisé trouvé</h5>
                            <p class="text-muted">Commencez par créer votre premier tarif personnalisé pour vos clients ou groupes.</p>
                            <a href="{{ route('admin.custom-prices.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Créer un Tarif
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-price');
    const toggleButtons = document.querySelectorAll('.toggle-status');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const priceId = this.dataset.priceId;
            const productName = this.dataset.productName;

            if (confirm(`Êtes-vous sûr de vouloir supprimer le tarif personnalisé pour "${productName}" ?`)) {
                fetch(`/admin/custom-prices/${priceId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Une erreur est survenue');
                });
            }
        });
    });

    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const priceId = this.dataset.priceId;

            fetch(`/admin/custom-prices/${priceId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    location.reload();
                } else {
                    alert('Une erreur est survenue');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur est survenue');
            });
        });
    });
});
</script>
@endpush
@endsection
