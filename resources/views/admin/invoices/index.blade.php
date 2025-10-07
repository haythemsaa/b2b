@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0"><i class="fas fa-file-invoice me-2"></i>Gestion des Factures</h1>
            <p class="text-muted mb-0">Gérez toutes les factures de votre plateforme</p>
        </div>
        <div>
            <a href="{{ route('admin.invoices.export') }}" class="btn btn-success">
                <i class="fas fa-file-excel me-1"></i> Exporter CSV
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Factures</p>
                            <h3 class="mb-0">{{ $stats['total'] }}</h3>
                        </div>
                        <div class="text-primary">
                            <i class="fas fa-file-invoice fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">En Attente</p>
                            <h3 class="mb-0">{{ $stats['pending'] }}</h3>
                            <small class="text-warning">{{ number_format($stats['pending_amount'], 2) }} TND</small>
                        </div>
                        <div class="text-warning">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Payées</p>
                            <h3 class="mb-0">{{ $stats['paid'] }}</h3>
                        </div>
                        <div class="text-success">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Revenu Total</p>
                            <h3 class="mb-0">{{ number_format($stats['total_revenue'], 2) }}</h3>
                            <small class="text-muted">TND</small>
                        </div>
                        <div class="text-info">
                            <i class="fas fa-dollar-sign fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtres</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.invoices.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Recherche</label>
                        <input type="text" name="search" class="form-control" placeholder="N° facture, client..." value="{{ request('search') }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Statut</label>
                        <select name="status" class="form-select">
                            <option value="">Tous</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Payée</option>
                            <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>En retard</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Date début</label>
                        <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Date fin</label>
                        <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search me-1"></i> Rechercher
                        </button>
                        <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary">
                            <i class="fas fa-redo me-1"></i> Réinitialiser
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Invoices Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>N° Facture</th>
                            <th>Commande</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Échéance</th>
                            <th class="text-end">Montant</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                        <tr>
                            <td>
                                <strong>{{ $invoice->invoice_number }}</strong>
                            </td>
                            <td>
                                @if($invoice->order)
                                    <a href="{{ route('admin.orders.show', $invoice->order->id) }}">
                                        {{ $invoice->order->order_number }}
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($invoice->order && $invoice->order->user)
                                    <div>{{ $invoice->order->user->name }}</div>
                                    <small class="text-muted">{{ $invoice->order->user->email }}</small>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                {{ $invoice->invoice_date ? $invoice->invoice_date->format('d/m/Y') : ($invoice->issue_date ? $invoice->issue_date->format('d/m/Y') : 'N/A') }}
                            </td>
                            <td>
                                @if($invoice->due_date)
                                    {{ $invoice->due_date->format('d/m/Y') }}
                                    @if($invoice->due_date->isPast() && $invoice->status != 'paid')
                                        <span class="badge bg-danger ms-1">Retard</span>
                                    @endif
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="text-end">
                                <strong>{{ number_format($invoice->total, 2) }} TND</strong>
                            </td>
                            <td>
                                @if($invoice->status == 'pending')
                                    <span class="badge bg-warning">En attente</span>
                                @elseif($invoice->status == 'paid')
                                    <span class="badge bg-success">Payée</span>
                                @elseif($invoice->status == 'overdue')
                                    <span class="badge bg-danger">En retard</span>
                                @elseif($invoice->status == 'cancelled')
                                    <span class="badge bg-secondary">Annulée</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.invoices.show', $invoice->id) }}" class="btn btn-outline-primary" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($invoice->status == 'pending')
                                    <form action="{{ route('admin.invoices.mark-paid', $invoice->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success" title="Marquer comme payée">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted">Aucune facture trouvée</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($invoices->hasPages())
            <div class="mt-3">
                {{ $invoices->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
