@extends('layouts.admin')

@section('title', 'Groupe - ' . $group->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Groupe : {{ $group->name }}</h1>
                <div>
                    <a href="{{ route('admin.groups.edit', $group) }}" class="btn btn-outline-primary">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <a href="{{ route('admin.groups.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Informations du groupe -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Informations Générales</h5>
                    @if($group->is_active)
                        <span class="badge bg-success">Actif</span>
                    @else
                        <span class="badge bg-danger">Inactif</span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Nom du Groupe</label>
                                <div class="fw-bold">{{ $group->name }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Remise par Défaut</label>
                                <div>
                                    @if($group->discount_percentage > 0)
                                        <span class="badge bg-success fs-6">{{ $group->discount_percentage }}%</span>
                                    @else
                                        <span class="text-muted">Aucune remise</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Créé le</label>
                                <div>{{ $group->created_at->format('d/m/Y à H:i') }}</div>
                            </div>

                            @if($group->updated_at != $group->created_at)
                            <div class="mb-3">
                                <label class="form-label text-muted">Dernière modification</label>
                                <div>{{ $group->updated_at->format('d/m/Y à H:i') }}</div>
                            </div>
                            @endif
                        </div>
                    </div>

                    @if($group->description)
                    <div class="mb-0">
                        <label class="form-label text-muted">Description</label>
                        <div class="border rounded p-3 bg-light">{{ $group->description }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Vendeurs du groupe -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Vendeurs du Groupe ({{ $group->users->count() }})</h5>
                </div>
                <div class="card-body">
                    @if($group->users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Email</th>
                                        <th>Entreprise</th>
                                        <th>Statut</th>
                                        <th>Inscrit le</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($group->users as $user)
                                        <tr>
                                            <td>
                                                <strong>{{ $user->name }}</strong>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->company_name ?: '-' }}</td>
                                            <td>
                                                @if($user->is_active)
                                                    <span class="badge bg-success">Actif</span>
                                                @else
                                                    <span class="badge bg-danger">Inactif</span>
                                                @endif
                                            </td>
                                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">Aucun vendeur assigné</h6>
                            <p class="text-muted">Ce groupe ne contient aucun vendeur pour le moment.</p>
                            <a href="{{ route('admin.groups.edit', $group) }}" class="btn btn-outline-primary">
                                <i class="fas fa-user-plus"></i> Ajouter des Vendeurs
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tarifs personnalisés -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Tarifs Personnalisés ({{ $group->customPrices->count() }})</h5>
                </div>
                <div class="card-body">
                    @if($group->customPrices->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Prix Standard</th>
                                        <th>Prix Groupe</th>
                                        <th>Économie</th>
                                        <th>Créé le</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($group->customPrices as $customPrice)
                                        <tr>
                                            <td>
                                                <strong>{{ $customPrice->product->name }}</strong>
                                                <div class="small text-muted">SKU: {{ $customPrice->product->sku }}</div>
                                            </td>
                                            <td>{{ number_format($customPrice->product->price, 2) }} MAD</td>
                                            <td>
                                                <span class="fw-bold text-success">{{ number_format($customPrice->price, 2) }} MAD</span>
                                            </td>
                                            <td>
                                                @php
                                                    $savings = $customPrice->product->price - $customPrice->price;
                                                    $percentage = ($savings / $customPrice->product->price) * 100;
                                                @endphp
                                                <span class="badge bg-success">
                                                    -{{ number_format($percentage, 1) }}%
                                                </span>
                                            </td>
                                            <td>{{ $customPrice->created_at->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">Aucun tarif personnalisé</h6>
                            <p class="text-muted">Ce groupe utilise les tarifs standards avec la remise par défaut de {{ $group->discount_percentage }}%.</p>
                            <button class="btn btn-outline-primary" disabled>
                                <i class="fas fa-plus"></i> Gérer les Tarifs
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Statistiques -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Statistiques</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end pe-3">
                                <h3 class="text-primary mb-0">{{ $group->users->count() }}</h3>
                                <small class="text-muted">Vendeurs</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="ps-3">
                                <h3 class="text-success mb-0">{{ $group->customPrices->count() }}</h3>
                                <small class="text-muted">Tarifs</small>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end pe-3">
                                <h4 class="text-info mb-0">{{ $group->users->where('is_active', true)->count() }}</h4>
                                <small class="text-muted">Actifs</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="ps-3">
                                <h4 class="text-warning mb-0">{{ $group->users->where('is_active', false)->count() }}</h4>
                                <small class="text-muted">Inactifs</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Actions</h6>
                </div>
                <div class="card-body d-grid gap-2">
                    <a href="{{ route('admin.groups.edit', $group) }}" class="btn btn-outline-primary">
                        <i class="fas fa-edit"></i> Modifier le Groupe
                    </a>

                    <button type="button" class="btn btn-outline-warning" onclick="toggleGroupStatus()">
                        <i class="fas {{ $group->is_active ? 'fa-pause' : 'fa-play' }}"></i>
                        {{ $group->is_active ? 'Désactiver' : 'Activer' }}
                    </button>

                    <button type="button" class="btn btn-outline-danger" onclick="deleteGroup()">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>

                    <hr>

                    <button type="button" class="btn btn-outline-info" disabled>
                        <i class="fas fa-chart-line"></i> Voir les Statistiques
                    </button>

                    <button type="button" class="btn btn-outline-secondary" disabled>
                        <i class="fas fa-file-export"></i> Exporter les Données
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleGroupStatus() {
    if (confirm('Êtes-vous sûr de vouloir changer le statut de ce groupe ?')) {
        fetch(`/admin/groups/{{ $group->id }}/toggle-status`, {
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

function deleteGroup() {
    if (confirm(`Êtes-vous sûr de vouloir supprimer le groupe "{{ $group->name }}" ?\n\nCette action est irréversible.`)) {
        fetch(`/admin/groups/{{ $group->id }}`, {
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
                window.location.href = '{{ route("admin.groups.index") }}';
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
