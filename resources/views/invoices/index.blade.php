@extends('layouts.app')

@section('title', 'Mes Factures')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">
                                <i class="bi bi-receipt text-primary"></i>
                                Mes Factures
                            </h4>
                            <small class="text-muted">Consultez l'historique de vos factures</small>
                        </div>
                        <div>
                            <a href="{{ route('invoices.export') }}" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-file-earmark-spreadsheet"></i> Export CSV
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filtres -->
                    <form method="GET" action="{{ route('invoices.index') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label small">Recherche</label>
                                <input type="text"
                                       name="search"
                                       class="form-control"
                                       placeholder="N° facture ou commande"
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small">Statut</label>
                                <select name="status" class="form-select">
                                    <option value="">Tous</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Payé</option>
                                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>En retard</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Date début</label>
                                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Date fin</label>
                                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label small d-block">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Liste des factures -->
                    @if($invoices->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>N° Facture</th>
                                    <th>N° Commande</th>
                                    <th>Date</th>
                                    <th>Échéance</th>
                                    <th>Montant TTC</th>
                                    <th>Statut</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $invoice)
                                <tr>
                                    <td>
                                        <strong class="text-primary">{{ $invoice->invoice_number }}</strong>
                                    </td>
                                    <td>
                                        @if($invoice->order)
                                            <a href="{{ route('orders.show', $invoice->order->order_number) }}" class="text-decoration-none">
                                                {{ $invoice->order->order_number }}
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($invoice->invoice_date)
                                            {{ $invoice->invoice_date->format('d/m/Y') }}
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($invoice->due_date)
                                            <span class="@if($invoice->due_date->isPast() && $invoice->status == 'pending') text-danger @endif">
                                                {{ $invoice->due_date->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ number_format($invoice->total, 2) }} TND</strong>
                                    </td>
                                    <td>
                                        @if($invoice->status == 'pending')
                                            <span class="badge bg-warning text-dark">En attente</span>
                                        @elseif($invoice->status == 'paid')
                                            <span class="badge bg-success">Payé</span>
                                        @elseif($invoice->status == 'overdue')
                                            <span class="badge bg-danger">En retard</span>
                                        @else
                                            <span class="badge bg-secondary">Annulé</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('invoices.show', $invoice->id) }}"
                                               class="btn btn-outline-primary"
                                               title="Voir">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('invoices.download', $invoice->id) }}"
                                               class="btn btn-outline-success"
                                               title="Télécharger PDF">
                                                <i class="bi bi-file-pdf"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted small">
                            Affichage de {{ $invoices->firstItem() }} à {{ $invoices->lastItem() }} sur {{ $invoices->total() }} factures
                        </div>
                        <div>
                            {{ $invoices->links() }}
                        </div>
                    </div>
                    @else
                    <!-- Aucune facture -->
                    <div class="text-center py-5">
                        <i class="bi bi-receipt text-muted" style="font-size: 4rem;"></i>
                        <h5 class="text-muted mt-3">Aucune facture trouvée</h5>
                        <p class="text-muted">
                            @if(request()->hasAny(['search', 'status', 'from_date', 'to_date']))
                                Aucune facture ne correspond à vos critères de recherche.
                                <br>
                                <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-outline-primary mt-2">
                                    Réinitialiser les filtres
                                </a>
                            @else
                                Vos factures apparaîtront ici une fois vos commandes traitées.
                            @endif
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm border-start border-4 border-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">En attente</h6>
                            <h3 class="mb-0">{{ \App\Models\Invoice::where('tenant_id', Auth::user()->tenant_id)->where('status', 'pending')->count() }}</h3>
                        </div>
                        <i class="bi bi-clock-history text-warning" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-start border-4 border-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Payées</h6>
                            <h3 class="mb-0">{{ \App\Models\Invoice::where('tenant_id', Auth::user()->tenant_id)->where('status', 'paid')->count() }}</h3>
                        </div>
                        <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-start border-4 border-danger">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">En retard</h6>
                            <h3 class="mb-0">{{ \App\Models\Invoice::where('tenant_id', Auth::user()->tenant_id)->where('status', 'overdue')->count() }}</h3>
                        </div>
                        <i class="bi bi-exclamation-circle text-danger" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-start border-4 border-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total</h6>
                            <h3 class="mb-0">{{ \App\Models\Invoice::where('tenant_id', Auth::user()->tenant_id)->count() }}</h3>
                        </div>
                        <i class="bi bi-receipt text-primary" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
