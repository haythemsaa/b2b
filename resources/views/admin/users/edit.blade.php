@extends('layouts.admin')

@section('title', 'Modifier le Vendeur - ' . $user->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Modifier le Vendeur : {{ $user->name }}</h1>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Informations du Vendeur</h5>
                    <div>
                        @if($user->is_active)
                            <span class="badge bg-success">Actif</span>
                        @else
                            <span class="badge bg-danger">Inactif</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nom Complet <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', $user->name) }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email', $user->email) }}"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Nouveau Mot de Passe</label>
                                <input type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="password"
                                       name="password">
                                <small class="form-text text-muted">Laissez vide pour conserver le mot de passe actuel</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirmer le Mot de Passe</label>
                                <input type="password"
                                       class="form-control"
                                       id="password_confirmation"
                                       name="password_confirmation">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="company_name" class="form-label">Nom de l'Entreprise</label>
                                <input type="text"
                                       class="form-control @error('company_name') is-invalid @enderror"
                                       id="company_name"
                                       name="company_name"
                                       value="{{ old('company_name', $user->company_name) }}">
                                @error('company_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Téléphone</label>
                                <input type="text"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       id="phone"
                                       name="phone"
                                       value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Adresse</label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                      id="address"
                                      name="address"
                                      rows="2">{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">Ville</label>
                                <input type="text"
                                       class="form-control @error('city') is-invalid @enderror"
                                       id="city"
                                       name="city"
                                       value="{{ old('city', $user->city) }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="postal_code" class="form-label">Code Postal</label>
                                <input type="text"
                                       class="form-control @error('postal_code') is-invalid @enderror"
                                       id="postal_code"
                                       name="postal_code"
                                       value="{{ old('postal_code', $user->postal_code) }}">
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="preferred_language" class="form-label">Langue Préférée <span class="text-danger">*</span></label>
                            <select class="form-select @error('preferred_language') is-invalid @enderror"
                                    id="preferred_language"
                                    name="preferred_language"
                                    required>
                                <option value="">Sélectionner une langue</option>
                                <option value="fr" {{ old('preferred_language', $user->preferred_language) === 'fr' ? 'selected' : '' }}>Français</option>
                                <option value="ar" {{ old('preferred_language', $user->preferred_language) === 'ar' ? 'selected' : '' }}>العربية</option>
                            </select>
                            @error('preferred_language')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Attribution aux Groupes de Clients</label>
                            <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                @if($customerGroups->count() > 0)
                                    @foreach($customerGroups as $group)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   name="customer_groups[]"
                                                   value="{{ $group->id }}"
                                                   id="group_{{ $group->id }}"
                                                   {{ in_array($group->id, old('customer_groups', $userGroups)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="group_{{ $group->id }}">
                                                <strong>{{ $group->name }}</strong>
                                                @if($group->discount_percentage > 0)
                                                    <span class="badge bg-success ms-1">-{{ $group->discount_percentage }}%</span>
                                                @endif
                                                <div class="small text-muted">{{ $group->description }}</div>
                                            </label>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-muted text-center py-3">
                                        <i class="fas fa-users-slash"></i>
                                        Aucun groupe de clients disponible
                                        <div class="mt-2">
                                            <a href="{{ route('admin.groups.create') }}" class="btn btn-outline-primary btn-sm">
                                                Créer un groupe
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <small class="form-text text-muted">Le vendeur peut appartenir à plusieurs groupes</small>
                            @error('customer_groups')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
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
                    <h6 class="card-title mb-0">Informations</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Inscrit le</small>
                        <div>{{ $user->created_at->format('d/m/Y à H:i') }}</div>
                    </div>

                    @if($user->updated_at != $user->created_at)
                    <div class="mb-3">
                        <small class="text-muted">Dernière modification</small>
                        <div>{{ $user->updated_at->format('d/m/Y à H:i') }}</div>
                    </div>
                    @endif

                    <div class="mb-3">
                        <small class="text-muted">Statut</small>
                        <div>
                            @if($user->is_active)
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-danger">Inactif</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Groupes Actuels</small>
                        <div>
                            @if($user->customerGroups->count() > 0)
                                @foreach($user->customerGroups as $group)
                                    <span class="badge bg-info me-1 mb-1">{{ $group->name }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">Aucun groupe</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">Actions</h6>
                </div>
                <div class="card-body d-grid gap-2">
                    <button type="button" class="btn btn-outline-warning" onclick="toggleUserStatus()">
                        <i class="fas {{ $user->is_active ? 'fa-pause' : 'fa-play' }}"></i>
                        {{ $user->is_active ? 'Désactiver' : 'Activer' }}
                    </button>

                    <button type="button" class="btn btn-outline-danger" onclick="deleteUser()">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleUserStatus() {
    if (confirm('Êtes-vous sûr de vouloir changer le statut de ce vendeur ?')) {
        fetch(`/admin/users/{{ $user->id }}/toggle-status`, {
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

function deleteUser() {
    if (confirm(`Êtes-vous sûr de vouloir supprimer le vendeur "{{ $user->name }}" ?\n\nCette action est irréversible.`)) {
        fetch(`/admin/users/{{ $user->id }}`, {
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
                window.location.href = '{{ route("admin.users.index") }}';
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
