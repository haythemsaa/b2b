@extends('layouts.admin')

@section('title', 'Gestion des Catégories')
@section('page-title', 'Gestion des Catégories')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">Catégories de Produits</h2>
                <p class="text-muted">Gérez l'arborescence des catégories</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-admin-primary">
                <i class="fas fa-plus-circle me-2"></i>Nouvelle Catégorie
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-sitemap me-2"></i>Arborescence des Catégories
            </div>
            <div class="card-body">
                @if(count($tree) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Slug</th>
                                    <th>Parent</th>
                                    <th class="text-center">Produits</th>
                                    <th class="text-center">Ordre</th>
                                    <th class="text-center">Statut</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tree as $category)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($category->level > 0)
                                                <span class="text-muted me-2" style="padding-left: {{ $category->level * 20 }}px;">
                                                    <i class="fas fa-level-up-alt fa-rotate-90"></i>
                                                </span>
                                            @endif
                                            <div>
                                                <strong>{{ $category->name }}</strong>
                                                @if($category->description)
                                                    <br><small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td><code>{{ $category->slug }}</code></td>
                                    <td>
                                        @if($category->parent)
                                            <span class="badge bg-secondary">{{ $category->parent->name }}</span>
                                        @else
                                            <span class="badge bg-primary">Racine</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info">{{ $category->products->count() }}</span>
                                    </td>
                                    <td class="text-center">{{ $category->sort_order ?? 0 }}</td>
                                    <td class="text-center">
                                        @if($category->is_active)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check"></i> Actif
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-times"></i> Inactif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.categories.edit', $category) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST"
                                                  action="{{ route('admin.categories.destroy', $category) }}"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-sitemap fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Aucune catégorie trouvée.</p>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Créer la première catégorie
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Info Box -->
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-0">Total Catégories</h6>
                        <h3 class="mb-0">{{ $categories->count() }}</h3>
                    </div>
                    <i class="fas fa-sitemap fa-2x text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-0">Catégories Racines</h6>
                        <h3 class="mb-0">{{ $categories->whereNull('parent_id')->count() }}</h3>
                    </div>
                    <i class="fas fa-folder fa-2x text-success"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-0">Catégories Actives</h6>
                        <h3 class="mb-0">{{ $categories->where('is_active', true)->count() }}</h3>
                    </div>
                    <i class="fas fa-check-circle fa-2x text-info"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
