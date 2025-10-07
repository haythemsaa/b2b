@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0"><i class="fas fa-file-invoice"></i> Gestion des Devis</h1>
            <p class="text-muted">Gérez les demandes de devis de vos clients</p>
        </div>
        <a href="{{ route('admin.quotes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouveau Devis
        </a>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Devis</p>
                            <h3 class="mb-0">{{ $stats['total'] }}</h3>
                        </div>
                        <div class="text-primary">
                            <i class="fas fa-file-invoice fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Brouillons</p>
                            <h3 class="mb-0 text-secondary">{{ $stats['draft'] }}</h3>
                        </div>
                        <div class="text-secondary">
                            <i class="fas fa-edit fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Envoyés</p>
                            <h3 class="mb-0 text-info">{{ $stats['sent'] }}</h3>
                        </div>
                        <div class="text-info">
                            <i class="fas fa-paper-plane fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Acceptés</p>
                            <h3 class="mb-0 text-success">{{ $stats['accepted'] }}</h3>
                        </div>
                        <div class="text-success">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Convertis</p>
                            <h3 class="mb-0 text-primary">{{ $stats['converted'] }}</h3>
                        </div>
                        <div class="text-primary">
                            <i class="fas fa-exchange-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Montant Total</p>
                            <h4 class="mb-0">{{ number_format($stats['total_amount'], 2) }} TND</h4>
                        </div>
                        <div class="text-warning">
                            <i class="fas fa-coins fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.quotes.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Vendeur</label>
                    <select name="user_id" class="form-select">
                        <option value="">Tous les vendeurs</option>
                        @foreach($vendeurs as $vendeur)
                            <option value="{{ $vendeur->id }}" {{ request('user_id') == $vendeur->id ? 'selected' : '' }}>
                                {{ $vendeur->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Statut</label>
                    <select name="status" class="form-select">
                        <option value="">Tous les statuts</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Date début</label>
                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Date fin</label>
                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filtrer
                    </button>
                    <a href="{{ route('admin.quotes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des devis -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-list"></i> Liste des Devis</h5>
        </div>
        <div class="card-body">
            @if($quotes->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-file-invoice fa-4x text-muted mb-3"></i>
                    <p class="text-muted">Aucun devis trouvé</p>
                    <a href="{{ route('admin.quotes.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Créer le premier devis
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>N° Devis</th>
                                <th>Client</th>
                                <th>Date</th>
                                <th>Validité</th>
                                <th>Montant Total</th>
                                <th>Statut</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quotes as $quote)
                                <tr>
                                    <td>
                                        <strong>{{ $quote->quote_number }}</strong>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $quote->user->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $quote->user->company_name }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <small>{{ $quote->created_at->format('d/m/Y') }}</small>
                                    </td>
                                    <td>
                                        @if($quote->valid_until)
                                            <small>{{ \Carbon\Carbon::parse($quote->valid_until)->format('d/m/Y') }}</small>
                                            <br>
                                            @if(\Carbon\Carbon::parse($quote->valid_until)->isPast())
                                                <span class="badge bg-danger">Expiré</span>
                                            @else
                                                <small class="text-success">
                                                    {{ \Carbon\Carbon::parse($quote->valid_until)->diffForHumans() }}
                                                </small>
                                            @endif
                                        @else
                                            <small class="text-muted">Non défini</small>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ number_format($quote->total, 2) }} TND</strong>
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'draft' => 'secondary',
                                                'sent' => 'info',
                                                'viewed' => 'primary',
                                                'accepted' => 'success',
                                                'rejected' => 'danger',
                                                'expired' => 'warning',
                                                'converted' => 'success'
                                            ];
                                            $color = $statusColors[$quote->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $color }}">
                                            {{ ucfirst($quote->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.quotes.show', $quote) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if($quote->status === 'draft')
                                                <a href="{{ route('admin.quotes.edit', $quote) }}"
                                                   class="btn btn-sm btn-outline-warning"
                                                   title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif

                                            @if(in_array($quote->status, ['draft', 'sent']))
                                                <form action="{{ route('admin.quotes.send', $quote) }}"
                                                      method="POST"
                                                      class="d-inline">
                                                    @csrf
                                                    <button type="submit"
                                                            class="btn btn-sm btn-outline-info"
                                                            title="Envoyer au client">
                                                        <i class="fas fa-paper-plane"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            @if($quote->status === 'accepted' && !$quote->converted_order_id)
                                                <form action="{{ route('admin.quotes.convert', $quote) }}"
                                                      method="POST"
                                                      class="d-inline">
                                                    @csrf
                                                    <button type="submit"
                                                            class="btn btn-sm btn-outline-success"
                                                            title="Convertir en commande">
                                                        <i class="fas fa-exchange-alt"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <a href="{{ route('admin.quotes.pdf', $quote) }}"
                                               class="btn btn-sm btn-outline-danger"
                                               title="Télécharger PDF"
                                               target="_blank">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>

                                            @if($quote->status === 'draft')
                                                <form action="{{ route('admin.quotes.destroy', $quote) }}"
                                                      method="POST"
                                                      class="d-inline"
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce devis ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-sm btn-outline-danger"
                                                            title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $quotes->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
