@extends('layouts.app')

@section('title', 'Mes Adresses')

@section('content')
<div class="container" x-data="addressManager()" x-init="init()">
    <!-- Header -->
    <div class="row mb-4 animate__animated animate__fadeInDown">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1><i class="bi bi-geo-alt-fill me-2 text-primary"></i>Mes Adresses</h1>
                    <p class="text-muted mb-0">Gérez vos adresses de livraison</p>
                </div>
                <a href="{{ route('addresses.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Nouvelle Adresse
                </a>
            </div>
        </div>
    </div>

    <!-- Empty State -->
    @if($addresses->isEmpty())
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 animate__animated animate__fadeIn">
                <div class="card-body text-center py-5">
                    <i class="bi bi-geo-alt display-1 text-muted mb-4"></i>
                    <h3 class="text-muted mb-3">Aucune adresse enregistrée</h3>
                    <p class="text-muted mb-4">
                        Ajoutez une adresse de livraison pour faciliter vos commandes
                    </p>
                    <a href="{{ route('addresses.create') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>Ajouter une adresse
                    </a>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Addresses Grid -->
    <div class="row">
        @foreach($addresses as $index => $address)
        <div class="col-lg-6 mb-4">
            <div class="card h-100 shadow-sm border-0 animate__animated animate__fadeInUp"
                 style="animation-delay: {{ $index * 0.1 }}s;">
                <div class="card-body">
                    <!-- Address Header -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            @if($address->label)
                            <h5 class="card-title mb-1">
                                <i class="bi bi-tag-fill me-2 text-primary"></i>{{ $address->label }}
                            </h5>
                            @else
                            <h5 class="card-title mb-1">
                                <i class="bi bi-geo-alt-fill me-2 text-primary"></i>Adresse {{ $index + 1 }}
                            </h5>
                            @endif

                            @if($address->is_default)
                            <span class="badge bg-success">
                                <i class="bi bi-star-fill"></i> Par défaut
                            </span>
                            @endif
                        </div>

                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('addresses.edit', $address) }}">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </a>
                                </li>
                                @if(!$address->is_default)
                                <li>
                                    <button class="dropdown-item" @click="setDefault({{ $address->id }})">
                                        <i class="bi bi-star"></i> Définir par défaut
                                    </button>
                                </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <button class="dropdown-item text-danger" @click="deleteAddress({{ $address->id }})">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Address Details -->
                    <div class="mb-3">
                        <p class="mb-1"><strong>{{ $address->full_name }}</strong></p>
                        @if($address->company_name)
                        <p class="mb-1 text-muted">{{ $address->company_name }}</p>
                        @endif
                        <p class="mb-1">{{ $address->address_line1 }}</p>
                        @if($address->address_line2)
                        <p class="mb-1">{{ $address->address_line2 }}</p>
                        @endif
                        <p class="mb-1">{{ $address->postal_code }} {{ $address->city }}</p>
                        @if($address->state)
                        <p class="mb-1">{{ $address->state }}</p>
                        @endif
                        <p class="mb-1">{{ $address->country }}</p>
                    </div>

                    <!-- Contact Info -->
                    <div class="border-top pt-3">
                        <p class="mb-2">
                            <i class="bi bi-telephone me-2"></i>
                            <a href="tel:{{ $address->phone }}">{{ $address->phone }}</a>
                        </p>
                        @if($address->notes)
                        <p class="mb-0 text-muted small">
                            <i class="bi bi-info-circle me-2"></i>{{ $address->notes }}
                        </p>
                        @endif
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-3 d-grid gap-2 d-md-flex">
                        <a href="{{ route('addresses.edit', $address) }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i> Modifier
                        </a>
                        @if(!$address->is_default)
                        <button class="btn btn-sm btn-outline-success"
                                @click="setDefault({{ $address->id }})">
                            <i class="bi bi-star"></i> Par défaut
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

@push('scripts')
<script>
function addressManager() {
    return {
        init() {
            console.log('Address manager initialized');
        },

        async setDefault(addressId) {
            try {
                const response = await fetch(`/addresses/${addressId}/set-default`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                if (data.success) {
                    notyf.success('Adresse définie comme par défaut');
                    // Reload page to update UI
                    setTimeout(() => window.location.reload(), 500);
                } else {
                    notyf.error(data.message || 'Erreur');
                }
            } catch (error) {
                notyf.error('Erreur lors de la mise à jour');
                console.error(error);
            }
        },

        async deleteAddress(addressId) {
            const result = await Swal.fire({
                title: 'Supprimer cette adresse?',
                text: 'Cette action est irréversible',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler',
                confirmButtonColor: '#dc3545'
            });

            if (!result.isConfirmed) return;

            try {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/addresses/${addressId}`;

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';

                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            } catch (error) {
                notyf.error('Erreur lors de la suppression');
                console.error(error);
            }
        }
    }
}
</script>
@endpush
@endsection
