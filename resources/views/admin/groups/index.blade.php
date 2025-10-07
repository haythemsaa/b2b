@extends('layouts.admin')

@section('title', 'Gestion des Groupes de Clients')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Groupes de Clients</h1>
                <a href="{{ route('admin.groups.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouveau Groupe
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
                    <h5 class="card-title mb-0">Liste des Groupes</h5>
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
                            <a href="{{ route('admin.groups.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                        </div>
                    </form>

                    @if($groups->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Description</th>
                                        <th>Remise %</th>
                                        <th>Vendeurs</th>
                                        <th>Statut</th>
                                        <th>Créé le</th>
                                        <th width="150">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($groups as $group)
                                        <tr>
                                            <td>
                                                <strong>{{ $group->name }}</strong>
                                            </td>
                                            <td>{{ Str::limit($group->description, 50) }}</td>
                                            <td>
                                                @if($group->discount_percentage > 0)
                                                    <span class="badge bg-success">{{ $group->discount_percentage }}%</span>
                                                @else
                                                    <span class="text-muted">0%</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $group->users_count }}</span>
                                            </td>
                                            <td>
                                                @if($group->is_active)
                                                    <span class="badge bg-success">Actif</span>
                                                @else
                                                    <span class="badge bg-danger">Inactif</span>
                                                @endif
                                            </td>
                                            <td>{{ $group->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.groups.show', $group) }}"
                                                       class="btn btn-sm btn-outline-info" title="Voir">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.groups.edit', $group) }}"
                                                       class="btn btn-sm btn-outline-primary" title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-warning toggle-status"
                                                            data-group-id="{{ $group->id }}"
                                                            title="{{ $group->is_active ? 'Désactiver' : 'Activer' }}">
                                                        <i class="fas {{ $group->is_active ? 'fa-pause' : 'fa-play' }}"></i>
                                                    </button>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-danger delete-group"
                                                            data-group-id="{{ $group->id }}"
                                                            data-group-name="{{ $group->name }}"
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

                        {{ $groups->withQueryString()->links() }}
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucun groupe trouvé</h5>
                            <p class="text-muted">Commencez par créer votre premier groupe de clients.</p>
                            <a href="{{ route('admin.groups.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Créer un Groupe
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
    const deleteButtons = document.querySelectorAll('.delete-group');
    const toggleButtons = document.querySelectorAll('.toggle-status');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const groupId = this.dataset.groupId;
            const groupName = this.dataset.groupName;

            if (confirm(`Êtes-vous sûr de vouloir supprimer le groupe "${groupName}" ?`)) {
                fetch(`/admin/groups/${groupId}`, {
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
            const groupId = this.dataset.groupId;

            fetch(`/admin/groups/${groupId}/toggle-status`, {
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
