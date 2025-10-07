@extends('layouts.admin')

@section('title', 'Modifier le Tarif Personnalisé')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Modifier le Tarif Personnalisé</h1>
                <div>
                    <a href="{{ route('admin.custom-prices.show', $customPrice) }}" class="btn btn-outline-info">
                        <i class="fas fa-eye"></i> Voir
                    </a>
                    <a href="{{ route('admin.custom-prices.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Informations du Tarif</h5>
                    <div>
                        @if($customPrice->is_active)
                            @if($customPrice->isValid())
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-warning">Expiré</span>
                            @endif
                        @else
                            <span class="badge bg-danger">Inactif</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.custom-prices.update', $customPrice) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="product_id" class="form-label">Produit <span class="text-danger">*</span></label>
                                <select class="form-select @error('product_id') is-invalid @enderror"
                                        id="product_id"
                                        name="product_id"
                                        required>
                                    <option value="">Sélectionner un produit</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}"
                                                data-price="{{ $product->price }}"
                                                {{ old('product_id', $customPrice->product_id) == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }} ({{ number_format($product->price, 2) }} MAD)
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Prix Personnalisé <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number"
                                           class="form-control @error('price') is-invalid @enderror"
                                           id="price"
                                           name="price"
                                           value="{{ old('price', $customPrice->price) }}"
                                           step="0.01"
                                           min="0"
                                           required>
                                    <span class="input-group-text">MAD</span>
                                </div>
                                <small id="price-comparison" class="form-text"></small>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Type de Tarif <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        @php
                                            $currentType = old('type', $customPrice->customer_group_id ? 'group' : 'user');
                                        @endphp
                                        <input class="form-check-input" type="radio" name="type" id="type_group" value="group" {{ $currentType === 'group' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="type_group">
                                            <i class="fas fa-users text-info"></i>
                                            <strong>Groupe de Clients</strong>
                                            <div class="small text-muted">Appliquer à tout un groupe</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" id="type_user" value="user" {{ $currentType === 'user' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="type_user">
                                            <i class="fas fa-user text-primary"></i>
                                            <strong>Vendeur Spécifique</strong>
                                            <div class="small text-muted">Appliquer à un vendeur unique</div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3" id="group-selection">
                                <label for="customer_group_id" class="form-label">Groupe de Clients</label>
                                <select class="form-select @error('customer_group_id') is-invalid @enderror"
                                        id="customer_group_id"
                                        name="customer_group_id">
                                    <option value="">Sélectionner un groupe</option>
                                    @foreach($customerGroups as $group)
                                        <option value="{{ $group->id }}" {{ old('customer_group_id', $customPrice->customer_group_id) == $group->id ? 'selected' : '' }}>
                                            {{ $group->name }}
                                            @if($group->discount_percentage > 0)
                                                (remise {{ $group->discount_percentage }}%)
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_group_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3" id="user-selection">
                                <label for="user_id" class="form-label">Vendeur Spécifique</label>
                                <select class="form-select @error('user_id') is-invalid @enderror"
                                        id="user_id"
                                        name="user_id">
                                    <option value="">Sélectionner un vendeur</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $customPrice->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} - {{ $user->company_name ?? $user->email }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="min_quantity" class="form-label">Quantité Minimum</label>
                                <input type="number"
                                       class="form-control @error('min_quantity') is-invalid @enderror"
                                       id="min_quantity"
                                       name="min_quantity"
                                       value="{{ old('min_quantity', $customPrice->min_quantity) }}"
                                       min="1">
                                <small class="form-text text-muted">Quantité minimum pour appliquer ce tarif</small>
                                @error('min_quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="valid_from" class="form-label">Valide à partir du</label>
                                <input type="date"
                                       class="form-control @error('valid_from') is-invalid @enderror"
                                       id="valid_from"
                                       name="valid_from"
                                       value="{{ old('valid_from', $customPrice->valid_from?->format('Y-m-d')) }}">
                                <small class="form-text text-muted">Laissez vide pour immédiat</small>
                                @error('valid_from')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="valid_until" class="form-label">Valide jusqu'au</label>
                                <input type="date"
                                       class="form-control @error('valid_until') is-invalid @enderror"
                                       id="valid_until"
                                       name="valid_until"
                                       value="{{ old('valid_until', $customPrice->valid_until?->format('Y-m-d')) }}">
                                <small class="form-text text-muted">Laissez vide pour permanent</small>
                                @error('valid_until')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        @if($errors->has('error'))
                            <div class="alert alert-danger">
                                {{ $errors->first('error') }}
                            </div>
                        @endif

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.custom-prices.index') }}" class="btn btn-outline-secondary">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Mettre à Jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Informations Actuelles</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Produit Actuel</small>
                        <div class="fw-bold">{{ $customPrice->product->name }}</div>
                        <div class="text-muted">SKU: {{ $customPrice->product->sku }}</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Prix Standard</small>
                        <div>{{ number_format($customPrice->product->price, 2) }} MAD</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Prix Personnalisé Actuel</small>
                        <div class="fw-bold text-success">{{ number_format($customPrice->price, 2) }} MAD</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Cible Actuelle</small>
                        <div>
                            @if($customPrice->user)
                                <i class="fas fa-user text-primary"></i>
                                {{ $customPrice->user->name }}
                                <div class="small text-muted">{{ $customPrice->user->company_name }}</div>
                            @elseif($customPrice->customerGroup)
                                <i class="fas fa-users text-info"></i>
                                {{ $customPrice->customerGroup->name }}
                            @endif
                        </div>
                    </div>

                    @if($customPrice->valid_from || $customPrice->valid_until)
                    <div class="mb-3">
                        <small class="text-muted">Période Actuelle</small>
                        <div>
                            @if($customPrice->valid_from)
                                Du {{ $customPrice->valid_from->format('d/m/Y') }}
                            @endif
                            @if($customPrice->valid_until)
                                <br>Au {{ $customPrice->valid_until->format('d/m/Y') }}
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="mb-3">
                        <small class="text-muted">Créé le</small>
                        <div>{{ $customPrice->created_at->format('d/m/Y à H:i') }}</div>
                    </div>

                    @if($customPrice->updated_at != $customPrice->created_at)
                    <div class="mb-3">
                        <small class="text-muted">Modifié le</small>
                        <div>{{ $customPrice->updated_at->format('d/m/Y à H:i') }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card mt-3" id="product-info" style="display: none;">
                <div class="card-header">
                    <h6 class="card-title mb-0">Nouveau Calcul</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted">Prix Standard</small>
                        <div id="standard-price" class="fw-bold"></div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Nouveau Prix</small>
                        <div id="custom-price" class="fw-bold text-success"></div>
                    </div>
                    <div>
                        <small class="text-muted">Différence</small>
                        <div id="price-difference" class="fw-bold"></div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">Actions</h6>
                </div>
                <div class="card-body d-grid gap-2">
                    <button type="button" class="btn btn-outline-warning" onclick="togglePriceStatus()">
                        <i class="fas {{ $customPrice->is_active ? 'fa-pause' : 'fa-play' }}"></i>
                        {{ $customPrice->is_active ? 'Désactiver' : 'Activer' }}
                    </button>

                    <button type="button" class="btn btn-outline-danger" onclick="deletePrice()">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeRadios = document.querySelectorAll('input[name="type"]');
    const groupSelection = document.getElementById('group-selection');
    const userSelection = document.getElementById('user-selection');
    const productSelect = document.getElementById('product_id');
    const priceInput = document.getElementById('price');
    const priceComparison = document.getElementById('price-comparison');
    const productInfo = document.getElementById('product-info');

    // Toggle entre groupe et utilisateur
    function updateTypeSelection() {
        const selectedType = document.querySelector('input[name="type"]:checked').value;

        if (selectedType === 'group') {
            groupSelection.style.display = 'block';
            userSelection.style.display = 'none';
            document.getElementById('customer_group_id').required = true;
            document.getElementById('user_id').required = false;
        } else {
            groupSelection.style.display = 'none';
            userSelection.style.display = 'block';
            document.getElementById('customer_group_id').required = false;
            document.getElementById('user_id').required = true;
        }
    }

    typeRadios.forEach(radio => {
        radio.addEventListener('change', updateTypeSelection);
    });

    // Initialiser au chargement
    updateTypeSelection();

    // Comparaison des prix
    function updatePriceComparison() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const customPrice = parseFloat(priceInput.value);

        if (selectedOption && selectedOption.dataset.price && customPrice) {
            const standardPrice = parseFloat(selectedOption.dataset.price);
            const difference = standardPrice - customPrice;
            const percentage = (difference / standardPrice * 100).toFixed(1);

            productInfo.style.display = 'block';
            document.getElementById('standard-price').textContent = standardPrice.toFixed(2) + ' MAD';
            document.getElementById('custom-price').textContent = customPrice.toFixed(2) + ' MAD';

            if (difference > 0) {
                priceComparison.innerHTML = `<span class="text-success">Économie: ${difference.toFixed(2)} MAD (-${percentage}%)</span>`;
                document.getElementById('price-difference').innerHTML = `<span class="text-success">-${difference.toFixed(2)} MAD (-${percentage}%)</span>`;
            } else if (difference < 0) {
                priceComparison.innerHTML = `<span class="text-warning">Supplément: ${Math.abs(difference).toFixed(2)} MAD (+${Math.abs(percentage)}%)</span>`;
                document.getElementById('price-difference').innerHTML = `<span class="text-warning">+${Math.abs(difference).toFixed(2)} MAD (+${Math.abs(percentage)}%)</span>`;
            } else {
                priceComparison.innerHTML = `<span class="text-muted">Prix identique</span>`;
                document.getElementById('price-difference').innerHTML = `<span class="text-muted">Identique</span>`;
            }
        } else {
            priceComparison.textContent = '';
            productInfo.style.display = 'none';
        }
    }

    productSelect.addEventListener('change', updatePriceComparison);
    priceInput.addEventListener('input', updatePriceComparison);

    // Initialiser la comparaison
    updatePriceComparison();
});

function togglePriceStatus() {
    if (confirm('Êtes-vous sûr de vouloir changer le statut de ce tarif ?')) {
        fetch(`/admin/custom-prices/{{ $customPrice->id }}/toggle-status`, {
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
    }
}

function deletePrice() {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce tarif personnalisé ?\n\nCette action est irréversible.')) {
        fetch(`/admin/custom-prices/{{ $customPrice->id }}`, {
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
                window.location.href = '{{ route("admin.custom-prices.index") }}';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue');
        });
    }
}
</script>
@endpush
@endsection
