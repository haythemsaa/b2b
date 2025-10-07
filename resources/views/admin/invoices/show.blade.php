@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-file-invoice me-2"></i>Facture {{ $invoice->invoice_number }}
            </h1>
            <p class="text-muted mb-0">Détails de la facture</p>
        </div>
        <div>
            <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Retour
            </a>
            <a href="{{ route('admin.invoices.pdf', $invoice->id) }}" target="_blank" class="btn btn-info">
                <i class="fas fa-file-pdf me-1"></i> Voir PDF
            </a>
            <a href="{{ route('admin.invoices.download', $invoice->id) }}" class="btn btn-success">
                <i class="fas fa-download me-1"></i> Télécharger PDF
            </a>
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print me-1"></i> Imprimer
            </button>
        </div>
    </div>

    <!-- Invoice Card -->
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <!-- Invoice Header -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h2 class="mb-3">{{ config('app.name', 'B2B Platform') }}</h2>
                    <p class="mb-1"><strong>Adresse:</strong> [Votre Adresse]</p>
                    <p class="mb-1"><strong>Téléphone:</strong> [Votre Téléphone]</p>
                    <p class="mb-1"><strong>Email:</strong> [Votre Email]</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h3 class="text-primary mb-3">FACTURE</h3>
                    <p class="mb-1"><strong>N° Facture:</strong> {{ $invoice->invoice_number }}</p>
                    <p class="mb-1"><strong>Date:</strong> {{ $invoice->invoice_date ? $invoice->invoice_date->format('d/m/Y') : ($invoice->issue_date ? $invoice->issue_date->format('d/m/Y') : 'N/A') }}</p>
                    <p class="mb-1"><strong>Date d'échéance:</strong> {{ $invoice->due_date->format('d/m/Y') }}</p>
                    <p class="mb-0">
                        <span class="badge {{ $invoice->status == 'paid' ? 'bg-success' : ($invoice->status == 'overdue' ? 'bg-danger' : 'bg-warning') }} fs-6">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </p>
                </div>
            </div>

            <hr>

            <!-- Client Info -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="mb-3">Facturé à:</h5>
                    @if($invoice->order && $invoice->order->user)
                        <p class="mb-1"><strong>{{ $invoice->order->user->name }}</strong></p>
                        <p class="mb-1">{{ $invoice->order->user->email }}</p>
                        @if($invoice->order->user->phone)
                            <p class="mb-1">{{ $invoice->order->user->phone }}</p>
                        @endif
                    @else
                        <p class="text-muted">Informations client non disponibles</p>
                    @endif
                </div>
                <div class="col-md-6">
                    <h5 class="mb-3">Détails Commande:</h5>
                    @if($invoice->order)
                        <p class="mb-1"><strong>N° Commande:</strong>
                            <a href="{{ route('admin.orders.show', $invoice->order->id) }}">{{ $invoice->order->order_number }}</a>
                        </p>
                        <p class="mb-1"><strong>Date Commande:</strong> {{ $invoice->order->created_at->format('d/m/Y H:i') }}</p>
                        <p class="mb-1"><strong>Statut Commande:</strong>
                            <span class="badge bg-info">{{ ucfirst($invoice->order->status) }}</span>
                        </p>
                    @else
                        <p class="text-muted">Commande non associée</p>
                    @endif
                </div>
            </div>

            <!-- Items Table -->
            @if($invoice->order && $invoice->order->items->count() > 0)
            <div class="table-responsive mb-4">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Produit</th>
                            <th class="text-center">Quantité</th>
                            <th class="text-end">Prix Unitaire</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->order->items as $item)
                        <tr>
                            <td>
                                <strong>{{ $item->product->name ?? 'Produit supprimé' }}</strong><br>
                                <small class="text-muted">SKU: {{ $item->product->sku ?? 'N/A' }}</small>
                            </td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">{{ number_format($item->price, 2) }} TND</td>
                            <td class="text-end"><strong>{{ number_format($item->total, 2) }} TND</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <!-- Totals -->
            <div class="row">
                <div class="col-md-6 offset-md-6">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Sous-total:</strong></td>
                            <td class="text-end">{{ number_format($invoice->subtotal, 2) }} TND</td>
                        </tr>
                        <tr>
                            <td><strong>TVA (19%):</strong></td>
                            <td class="text-end">{{ number_format($invoice->tax, 2) }} TND</td>
                        </tr>
                        <tr class="table-primary">
                            <td><strong>TOTAL:</strong></td>
                            <td class="text-end"><h4 class="mb-0">{{ number_format($invoice->total, 2) }} TND</h4></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Notes -->
            @if($invoice->notes)
            <div class="mt-4">
                <h6>Notes:</h6>
                <p class="text-muted">{{ $invoice->notes }}</p>
            </div>
            @endif

            <!-- Payment Info -->
            <div class="mt-4">
                <h6>Informations de paiement:</h6>
                @if($invoice->status == 'paid')
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        Cette facture a été payée le {{ $invoice->paid_at ? $invoice->paid_at->format('d/m/Y à H:i') : 'N/A' }}
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Cette facture est en attente de paiement. Date d'échéance: {{ $invoice->due_date->format('d/m/Y') }}
                    </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="mt-4 d-flex gap-2">
                @if($invoice->status == 'pending')
                <form action="{{ route('admin.invoices.mark-paid', $invoice->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success" onclick="return confirm('Marquer cette facture comme payée?')">
                        <i class="fas fa-check me-1"></i> Marquer comme payée
                    </button>
                </form>
                @endif

                @if(!$invoice->sent_at)
                <form action="{{ route('admin.invoices.mark-sent', $invoice->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-paper-plane me-1"></i> Marquer comme envoyée
                    </button>
                </form>
                @else
                <span class="badge bg-info">
                    <i class="fas fa-check me-1"></i> Envoyée le {{ $invoice->sent_at->format('d/m/Y à H:i') }}
                </span>
                @endif

                <form action="{{ route('admin.invoices.update-status', $invoice->id) }}" method="POST" class="d-inline ms-auto">
                    @csrf
                    <select name="status" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                        <option value="">Changer le statut...</option>
                        <option value="pending" {{ $invoice->status == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>Payée</option>
                        <option value="overdue" {{ $invoice->status == 'overdue' ? 'selected' : '' }}>En retard</option>
                        <option value="cancelled" {{ $invoice->status == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                    </select>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .alert, form, .sidebar, .navbar {
        display: none !important;
    }
}
</style>
@endsection
