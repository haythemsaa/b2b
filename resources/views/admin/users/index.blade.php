@extends('layouts.admin')

@section('title', 'Gestion des Vendeurs')
@section('page-title', 'Gestion des Vendeurs')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">Vendeurs</h2>
                <p class="text-muted">Gérez les comptes vendeurs</p>
            </div>
            <div>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouveau Vendeur
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
                    <h5 class="card-title mb-0">Liste des Vendeurs</h5>
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3 mb-4">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Rechercher..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Actif</option>
                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactif</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-outline-primary w-100">Filtrer</button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                        </div>
                    </form>

                    @if($users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Vendeur</th>
                                        <th>Entreprise</th>
                                        <th>Téléphone</th>
                                        <th>Groupes</th>
                                        <th>Statut</th>
                                        <th>Inscrit le</th>
                                        <th width="150">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong>{{ $user->name }}</strong>
                                                    <div class="small text-muted">{{ $user->email }}</div>
                                                </div>
                                            </td>
                                            <td>{{ $user->company_name ?: '-' }}</td>
                                            <td>{{ $user->phone ?: '-' }}</td>
                                            <td>
                                                @if($user->customerGroups->count() > 0)
                                                    @foreach($user->customerGroups as $group)
                                                        <span class="badge bg-info me-1">{{ $group->name }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">Aucun groupe</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($user->is_active)
                                                    <span class="badge bg-success">Actif</span>
                                                @else
                                                    <span class="badge bg-danger">Inactif</span>
                                                @endif
                                            </td>
                                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.users.edit', $user) }}"
                                                       class="btn btn-sm btn-outline-primary" title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-warning toggle-status"
                                                            data-user-id="{{ $user->id }}"
                                                            title="{{ $user->is_active ? 'Désactiver' : 'Activer' }}">
                                                        <i class="fas {{ $user->is_active ? 'fa-pause' : 'fa-play' }}"></i>
                                                    </button>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-danger delete-user"
                                                            data-user-id="{{ $user->id }}"
                                                            data-user-name="{{ $user->name }}"
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

                        {{ $users->withQueryString()->links() }}
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucun vendeur trouvé</h5>
                            <p class="text-muted">Commencez par créer votre premier vendeur.</p>
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Créer un Vendeur
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
    const deleteButtons = document.querySelectorAll('.delete-user');
    const toggleButtons = document.querySelectorAll('.toggle-status');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.userId;
            const userName = this.dataset.userName;

            if (confirm(`Êtes-vous sûr de vouloir supprimer le vendeur "${userName}" ?`)) {
                fetch(`/admin/users/${userId}`, {
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
            const userId = this.dataset.userId;

            fetch(`/admin/users/${userId}/toggle-status`, {
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