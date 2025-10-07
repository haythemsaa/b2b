@extends('layouts.admin')

@section('title', 'Tarif Personnalisé - ' . $customPrice->product->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Tarif Personnalisé</h1>
                <div>
                    <a href="{{ route('admin.custom-prices.edit', $customPrice) }}" class="btn btn-outline-primary">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <a href="{{ route('admin.custom-prices.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
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
        <div class="col-lg-8">
            <!-- Informations du produit -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Informations Produit</h5>
                    @if($customPrice->is_active)
                        @if($customPrice->isValid())
                            <span class="badge bg-success fs-6">Actif</span>
                        @else
                            <span class="badge bg-warning fs-6">Expiré</span>
                        @endif
                    @else
                        <span class="badge bg-danger fs-6">Inactif</span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Nom du Produit</label>
                                <div class="fw-bold fs-5">{{ $customPrice->product->name }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">SKU</label>
                                <div>{{ $customPrice->product->sku }}</div>
                            </div>

                            @if($customPrice->product->description)
                            <div class="mb-3">
                                <label class="form-label text-muted">Description</label>
                                <div>{{ Str::limit($customPrice->product->description, 200) }}</div>
                            </div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Prix Standard</label>
                                <div class="fw-bold fs-4">{{ number_format($customPrice->product->price, 2) }} MAD</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Prix Personnalisé</label>
                                <div class="fw-bold fs-3 text-success">{{ number_format($customPrice->price, 2) }} MAD</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Économie/Supplément</label>
                                <div>
                                    @if($customPrice->product->price > 0)
                                        @if($customPrice->price < $customPrice->product->price)
                                            @php
                                                $savings = $customPrice->product->price - $customPrice->price;
                                                $percentage = ($savings / $customPrice->product->price) * 100;
                                            @endphp
                                            <span class="badge bg-success fs-6">
                                                Économie de {{ number_format($savings, 2) }} MAD (-{{ number_format($percentage, 1) }}%)
                                            </span>
                                        @elseif($customPrice->price > $customPrice->product->price)
                                            @php
                                                $difference = $customPrice->price - $customPrice->product->price;
                                                $percentage = ($difference / $customPrice->product->price) * 100;
                                            @endphp
                                            <span class="badge bg-warning fs-6">
                                                Supplément de {{ number_format($difference, 2) }} MAD (+{{ number_format($percentage, 1) }}%)
                                            </span>
                                        @else
                                            <span class="badge bg-secondary fs-6">Prix identique</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations du tarif -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Conditions du Tarif</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Cible</label>
                                <div>
                                    @if($customPrice->user)
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user text-primary fa-2x me-3"></i>
                                            <div>
                                                <div class="fw-bold">{{ $customPrice->user->name }}</div>
                                                <div class="text-muted">{{ $customPrice->user->company_name ?? $customPrice->user->email }}</div>
                                                <div class="small text-muted">
                                                    <i class="fas fa-envelope"></i> {{ $customPrice->user->email }}
                                                    @if($customPrice->user->phone)
                                                        | <i class="fas fa-phone"></i> {{ $customPrice->user->phone }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($customPrice->customerGroup)
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-users text-info fa-2x me-3"></i>
                                            <div>
                                                <div class="fw-bold">{{ $customPrice->customerGroup->name }}</div>
                                                @if($customPrice->customerGroup->description)
                                                    <div class="text-muted">{{ $customPrice->customerGroup->description }}</div>
                                                @endif
                                                <div class="small text-success">
                                                    <i class="fas fa-users"></i> {{ $customPrice->customerGroup->users->count() }} vendeurs dans ce groupe
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Quantité Minimum</label>
                                <div>
                                    @if($customPrice->min_quantity > 1)
                                        <span class="badge bg-info">{{ $customPrice->min_quantity }} unités minimum</span>
                                    @else
                                        <span class="text-muted">Aucune quantité minimum</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Période de Validité</label>
                                <div>
                                    @if($customPrice->valid_from || $customPrice->valid_until)
                                        <div class="border rounded p-3 bg-light">
                                            @if($customPrice->valid_from)
                                                <div><i class="fas fa-calendar-plus text-success"></i> <strong>Du :</strong> {{ $customPrice->valid_from->format('d/m/Y') }}</div>
                                            @endif
                                            @if($customPrice->valid_until)
                                                <div><i class="fas fa-calendar-minus text-danger"></i> <strong>Au :</strong> {{ $customPrice->valid_until->format('d/m/Y') }}</div>
                                            @endif
                                            <div class="mt-2">
                                                @if($customPrice->isValid())
                                                    <span class="badge bg-success">En cours de validité</span>
                                                @else
                                                    <span class="badge bg-warning">Période expirée</span>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-center p-3 bg-light rounded">
                                            <i class="fas fa-infinity text-primary fa-2x mb-2"></i>
                                            <div class="fw-bold">Tarif Permanent</div>
                                            <div class="small text-muted">Aucune limite de validité</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Membres du groupe (si applicable) -->
            @if($customPrice->customerGroup)
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Vendeurs Concernés ({{ $customPrice->customerGroup->users->count() }})</h5>
                </div>
                <div class="card-body">
                    @if($customPrice->customerGroup->users->count() > 0)
                        <div class="row">
                            @foreach($customPrice->customerGroup->users as $user)
                                <div class="col-md-6 mb-3">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user-tie text-primary me-2"></i>
                                            <div>
                                                <div class="fw-bold">{{ $user->name }}</div>
                                                <div class="small text-muted">{{ $user->company_name ?? $user->email }}</div>
                                                <div class="small">
                                                    @if($user->is_active)
                                                        <span class="badge bg-success">Actif</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactif</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3 text-muted">
                            <i class="fas fa-users-slash fa-2x mb-2"></i>
                            <div>Aucun vendeur dans ce groupe</div>
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- Résumé -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Résumé</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end pe-3">
                                <h4 class="text-primary mb-0">{{ number_format($customPrice->product->price, 2) }}</h4>
                                <small class="text-muted">Prix Standard</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="ps-3">
                                <h4 class="text-success mb-0">{{ number_format($customPrice->price, 2) }}</h4>
                                <small class="text-muted">Prix Personnalisé</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations système -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Informations</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Créé le</small>
                        <div>{{ $customPrice->created_at->format('d/m/Y à H:i') }}</div>
                    </div>

                    @if($customPrice->updated_at != $customPrice->created_at)
                    <div class="mb-3">
                        <small class="text-muted">Dernière modification</small>
                        <div>{{ $customPrice->updated_at->format('d/m/Y à H:i') }}</div>
                    </div>
                    @endif

                    <div class="mb-3">
                        <small class="text-muted">Statut</small>
                        <div>
                            @if($customPrice->is_active)
                                @if($customPrice->isValid())
                                    <span class="badge bg-success">Actif et valide</span>
                                @else
                                    <span class="badge bg-warning">Actif mais expiré</span>
                                @endif
                            @else
                                <span class="badge bg-danger">Inactif</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-0">
                        <small class="text-muted">Type de cible</small>
                        <div>
                            @if($customPrice->user)
                                <i class="fas fa-user text-primary"></i> Vendeur individuel
                            @elseif($customPrice->customerGroup)
                                <i class="fas fa-users text-info"></i> Groupe de clients
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Actions</h6>
                </div>
                <div class="card-body d-grid gap-2">
                    <a href="{{ route('admin.custom-prices.edit', $customPrice) }}" class="btn btn-outline-primary">
                        <i class="fas fa-edit"></i> Modifier le Tarif
                    </a>

                    <button type="button" class="btn btn-outline-warning" onclick="togglePriceStatus()">
                        <i class="fas {{ $customPrice->is_active ? 'fa-pause' : 'fa-play' }}"></i>
                        {{ $customPrice->is_active ? 'Désactiver' : 'Activer' }}
                    </button>

                    <button type="button" class="btn btn-outline-danger" onclick="deletePrice()">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>

                    <hr>

                    <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                        <i class="fas fa-print"></i> Imprimer
                    </button>

                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-info">
                        <i class="fas fa-box"></i> Voir Tous les Produits
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
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
