@extends('layouts.app')

@section('title', 'Facture ' . $invoice->invoice_number)

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-outline-secondary mb-2">
                                <i class="bi bi-arrow-left"></i> Retour aux factures
                            </a>
                            <h3 class="mb-1">Facture {{ $invoice->invoice_number }}</h3>
                            <div class="d-flex gap-2 align-items-center">
                                @if($invoice->status == 'pending')
                                    <span class="badge bg-warning text-dark">En attente</span>
                                @elseif($invoice->status == 'paid')
                                    <span class="badge bg-success">Payée</span>
                                @elseif($invoice->status == 'overdue')
                                    <span class="badge bg-danger">En retard</span>
                                @else
                                    <span class="badge bg-secondary">Annulée</span>
                                @endif
                                <small class="text-muted">
                                    @if($invoice->invoice_date)
                                        | Émise le {{ $invoice->invoice_date->format('d/m/Y') }}
                                    @endif
                                </small>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('invoices.download', $invoice->id) }}"
                               class="btn btn-primary">
                                <i class="bi bi-download"></i> Télécharger PDF
                            </a>
                            <button onclick="window.print()" class="btn btn-outline-primary">
                                <i class="bi bi-printer"></i> Imprimer
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Détails de la facture -->
            <div class="row">
                <div class="col-md-8">
                    <!-- Informations commande -->
                    @if($invoice->order)
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="bi bi-box-seam"></i> Commande associée
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong>Numéro de commande:</strong>
                                        <a href="{{ route('orders.show', $invoice->order->order_number) }}">
                                            {{ $invoice->order->order_number }}
                                        </a>
                                    </p>
                                    <p class="mb-2">
                                        <strong>Date de commande:</strong>
                                        {{ $invoice->order->created_at->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong>Statut commande:</strong>
                                        <span class="badge bg-{{ $invoice->order->status == 'completed' ? 'success' : ($invoice->order->status == 'processing' ? 'info' : 'warning') }}">
                                            {{ ucfirst($invoice->order->status) }}
                                        </span>
                                    </p>
                                    <p class="mb-0">
                                        <strong>Nombre d'articles:</strong>
                                        {{ $invoice->order->items->count() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Articles de la facture -->
                    @if($invoice->order && $invoice->order->items)
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="bi bi-list-ul"></i> Articles facturés
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Produit</th>
                                            <th class="text-center">Quantité</th>
                                            <th class="text-end">Prix unitaire</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoice->order->items as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($item->product && $item->product->coverImage)
                                                        <img src="{{ asset('storage/' . $item->product->coverImage->image_path) }}"
                                                             alt="{{ $item->product->name }}"
                                                             class="rounded me-2"
                                                             style="width: 40px; height: 40px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center"
                                                             style="width: 40px; height: 40px;">
                                                            <i class="bi bi-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <div class="fw-bold">{{ $item->product->name ?? 'Produit supprimé' }}</div>
                                                        @if($item->product)
                                                            <small class="text-muted">Réf: {{ $item->product->reference }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">{{ number_format($item->unit_price, 2) }} TND</td>
                                            <td class="text-end fw-bold">{{ number_format($item->total, 2) }} TND</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Notes -->
                    @if($invoice->notes)
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="bi bi-sticky"></i> Notes
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $invoice->notes }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="col-md-4">
                    <!-- Résumé financier -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="bi bi-calculator"></i> Résumé financier
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Sous-total HT:</span>
                                <strong>{{ number_format($invoice->subtotal, 2) }} TND</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>TVA (19%):</span>
                                <strong>{{ number_format($invoice->tax, 2) }} TND</strong>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong class="text-primary">Total TTC:</strong>
                                <h4 class="mb-0 text-primary">{{ number_format($invoice->total, 2) }} TND</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Dates importantes -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="bi bi-calendar3"></i> Dates importantes
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($invoice->invoice_date)
                            <div class="mb-3">
                                <small class="text-muted d-block">Date d'émission</small>
                                <strong>{{ $invoice->invoice_date->format('d/m/Y') }}</strong>
                            </div>
                            @endif

                            @if($invoice->due_date)
                            <div class="mb-3">
                                <small class="text-muted d-block">Date d'échéance</small>
                                <strong class="@if($invoice->due_date->isPast() && $invoice->status == 'pending') text-danger @endif">
                                    {{ $invoice->due_date->format('d/m/Y') }}
                                </strong>
                                @if($invoice->due_date->isPast() && $invoice->status == 'pending')
                                    <br><small class="text-danger">Échue depuis {{ $invoice->due_date->diffForHumans() }}</small>
                                @endif
                            </div>
                            @endif

                            @if($invoice->sent_at)
                            <div class="mb-3">
                                <small class="text-muted d-block">Envoyée le</small>
                                <strong>{{ $invoice->sent_at->format('d/m/Y H:i') }}</strong>
                            </div>
                            @endif

                            @if($invoice->paid_at)
                            <div class="mb-0">
                                <small class="text-muted d-block">Payée le</small>
                                <strong class="text-success">{{ $invoice->paid_at->format('d/m/Y H:i') }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Statut payment -->
                    @if($invoice->status == 'pending')
                    <div class="alert alert-warning shadow-sm">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>Paiement en attente</strong>
                        <p class="mb-0 small">Cette facture n'a pas encore été payée. Veuillez procéder au règlement avant la date d'échéance.</p>
                    </div>
                    @elseif($invoice->status == 'paid')
                    <div class="alert alert-success shadow-sm">
                        <i class="bi bi-check-circle"></i>
                        <strong>Facture payée</strong>
                        <p class="mb-0 small">Cette facture a été réglée. Merci pour votre paiement !</p>
                    </div>
                    @elseif($invoice->status == 'overdue')
                    <div class="alert alert-danger shadow-sm">
                        <i class="bi bi-exclamation-circle"></i>
                        <strong>Facture en retard</strong>
                        <p class="mb-0 small">Cette facture est en retard de paiement. Veuillez régulariser votre situation au plus vite.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    @media print {
        .btn, .card-header, .alert, nav, footer {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
    }
</style>
@endpush
@endsection
