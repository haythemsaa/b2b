@extends('layouts.admin')

@section('title', 'Gestion des Devises')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">
                <i class="fas fa-money-bill-wave text-primary"></i> Gestion des Devises
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Devises</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.exchange-rates.index') }}" class="btn btn-info me-2">
                <i class="fas fa-exchange-alt"></i> Taux de Change
            </a>
            <a href="{{ route('admin.currencies.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nouvelle Devise
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Devises</h6>
                            <h2 class="mb-0">{{ $stats['total'] }}</h2>
                        </div>
                        <i class="fas fa-coins fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Devises Actives</h6>
                            <h2 class="mb-0">{{ $stats['active'] }}</h2>
                        </div>
                        <i class="fas fa-check-circle fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Devise par Défaut</h6>
                            <h2 class="mb-0">{{ $stats['default'] ? $stats['default']->code : 'N/A' }}</h2>
                        </div>
                        <i class="fas fa-star fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des devises -->
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">
                <i class="fas fa-list"></i> Liste des Devises ({{ $currencies->count() }})
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Nom</th>
                            <th>Symbole</th>
                            <th>Décimales</th>
                            <th>Format</th>
                            <th>Position</th>
                            <th>Statut</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($currencies as $currency)
                            <tr>
                                <td>{{ $currency->id }}</td>
                                <td>
                                    <strong>{{ $currency->code }}</strong>
                                    @if($currency->is_default)
                                        <span class="badge bg-warning text-dark ms-1">
                                            <i class="fas fa-star"></i> Défaut
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $currency->name }}</td>
                                <td><span class="badge bg-info">{{ $currency->symbol }}</span></td>
                                <td>{{ $currency->decimal_places }}</td>
                                <td><code>{{ $currency->format }}</code></td>
                                <td>{{ $currency->position }}</td>
                                <td>
                                    <form action="{{ route('admin.currencies.toggle-active', $currency) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Confirmer le changement de statut ?')">
                                        @csrf
                                        @if($currency->is_active)
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-check"></i> Actif
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-sm btn-secondary">
                                                <i class="fas fa-times"></i> Inactif
                                            </button>
                                        @endif
                                    </form>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.currencies.show', $currency) }}"
                                           class="btn btn-sm btn-info"
                                           title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.currencies.edit', $currency) }}"
                                           class="btn btn-sm btn-warning"
                                           title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @unless($currency->is_default)
                                            <form action="{{ route('admin.currencies.set-default', $currency) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Définir {{ $currency->code }} comme devise par défaut ?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary" title="Définir par défaut">
                                                    <i class="fas fa-star"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.currencies.destroy', $currency) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Supprimer cette devise ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endunless
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Aucune devise trouvée.</p>
                                    <a href="{{ route('admin.currencies.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Ajouter une devise
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
