@extends('layouts.app')

@section('title', 'Détails du Devis')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><i class="fas fa-file-invoice me-2 text-primary"></i>Devis {{ $quote->quote_number }}</h1>
                <div>
                    <a href="{{ route('quotes.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Retour
                    </a>
                    <a href="{{ route('quotes.pdf', $quote) }}" class="btn btn-outline-primary me-2" target="_blank">
                        <i class="fas fa-file-pdf me-2"></i>Télécharger PDF
                    </a>
                    @if($quote->status === 'draft')
                    <form action="{{ route('quotes.send', $quote) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success" onclick="return confirm('Envoyer ce devis au client?')">
                            <i class="fas fa-paper-plane me-2"></i>Envoyer
                        </button>
                    </form>
                    @endif
                    @if($quote->canBeConverted() && Auth::id() === $quote->user_id)
                    <form action="{{ route('quotes.convert', $quote) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Convertir ce devis en commande?')">
                            <i class="fas fa-exchange-alt me-2"></i>Convertir en Commande
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <!-- Informations Générales -->
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Statut:</label>
                        <br>
                        @php
                            $statusColors = [
                                'draft' => 'secondary',
                                'sent' => 'info',
                                'viewed' => 'primary',
                                'accepted' => 'success',
                                'rejected' => 'danger',
                                'expired' => 'warning',
                                'converted' => 'dark'
                            ];
                            $statusLabels = [
                                'draft' => 'Brouillon',
                                'sent' => 'Envoyé',
                                'viewed' => 'Vu',
                                'accepted' => 'Accepté',
                                'rejected' => 'Rejeté',
                                'expired' => 'Expiré',
                                'converted' => 'Converti'
                            ];
                        @endphp
                        <span class="badge bg-{{ $statusColors[$quote->status] ?? 'secondary' }} fs-6">
                            {{ $statusLabels[$quote->status] ?? ucfirst($quote->status) }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Date de création:</label>
                        <br>
                        <strong>{{ $quote->created_at->format('d/m/Y à H:i') }}</strong>
                    </div>

                    @if($quote->valid_until)
                    <div class="mb-3">
                        <label class="text-muted small">Valide jusqu'au:</label>
                        <br>
                        <strong>{{ $quote->valid_until->format('d/m/Y') }}</strong>
                        @if($quote->isExpired())
                        <span class="badge bg-warning ms-2">Expiré</span>
                        @endif
                    </div>
                    @endif

                    @if($quote->accepted_at)
                    <div class="mb-3">
                        <label class="text-muted small">Accepté le:</label>
                        <br>
                        <strong>{{ $quote->accepted_at->format('d/m/Y') }}</strong>
                    </div>
                    @endif

                    @if($quote->rejected_at)
                    <div class="mb-3">
                        <label class="text-muted small">Rejeté le:</label>
                        <br>
                        <strong>{{ $quote->rejected_at->format('d/m/Y') }}</strong>
                    </div>
                    @endif

                    @if($quote->converted_order_id)
                    <div class="mb-3">
                        <label class="text-muted small">Commande liée:</label>
                        <br>
                        <a href="{{ route('orders.show', $quote->convertedOrder->order_number) }}" class="btn btn-sm btn-outline-primary">
                            Voir Commande #{{ $quote->convertedOrder->order_number }}
                        </a>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="text-muted small">Vendeur:</label>
                        <br>
                        <strong>{{ $quote->user->name }}</strong>
                        <br>
                        <small class="text-muted">{{ $quote->user->email }}</small>
                    </div>

                    <div class="mb-0">
                        <label class="text-muted small">Grossiste:</label>
                        <br>
                        <strong>{{ $quote->grossiste->name }}</strong>
                        <br>
                        <small class="text-muted">{{ $quote->grossiste->email }}</small>
                    </div>
                </div>
            </div>

            <!-- Actions Grossiste -->
            @if(Auth::id() === $quote->grossiste_id && in_array($quote->status, ['sent', 'viewed']))
            <div class="card mb-4 shadow-sm border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Actions</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('quotes.accept', $quote) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-success w-100" onclick="return confirm('Accepter ce devis?')">
                            <i class="fas fa-check-circle me-2"></i>Accepter le Devis
                        </button>
                    </form>
                    <form action="{{ route('quotes.reject', $quote) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Rejeter ce devis?')">
                            <i class="fas fa-times-circle me-2"></i>Rejeter le Devis
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <!-- Client et Articles -->
        <div class="col-md-8">
            <!-- Informations Client -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Client</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small">Nom:</label>
                                <br>
                                <strong>{{ $quote->customer_name }}</strong>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small">Email:</label>
                                <br>
                                <a href="mailto:{{ $quote->customer_email }}">{{ $quote->customer_email }}</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if($quote->customer_phone)
                            <div class="mb-3">
                                <label class="text-muted small">Téléphone:</label>
                                <br>
                                <a href="tel:{{ $quote->customer_phone }}">{{ $quote->customer_phone }}</a>
                            </div>
                            @endif
                            @if($quote->customer_address)
                            <div class="mb-0">
                                <label class="text-muted small">Adresse:</label>
                                <br>
                                {{ $quote->customer_address }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Articles -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Articles ({{ $quote->items->count() }})</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Produit</th>
                                    <th class="text-center">Quantité</th>
                                    <th class="text-end">Prix Unit.</th>
                                    <th class="text-center">Remise</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($quote->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product && $item->product->coverImage)
                                            <img src="/storage/{{ $item->product->coverImage->image_path }}"
                                                 class="me-3 rounded" style="width: 50px; height: 50px; object-fit: cover;"
                                                 alt="{{ $item->product_name }}">
                                            @endif
                                            <div>
                                                <strong>{{ $item->product_name }}</strong>
                                                <br>
                                                <small class="text-muted">SKU: {{ $item->product_sku }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge bg-secondary">{{ $item->quantity }}</span>
                                    </td>
                                    <td class="text-end align-middle">
                                        {{ number_format($item->unit_price, 3) }} {{ $quote->currency }}
                                    </td>
                                    <td class="text-center align-middle">
                                        @if($item->discount_percent > 0)
                                        <span class="badge bg-warning text-dark">-{{ $item->discount_percent }}%</span>
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td class="text-end align-middle">
                                        <strong>{{ number_format($item->total, 3) }} {{ $quote->currency }}</strong>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Sous-total HT:</strong></td>
                                    <td class="text-end"><strong>{{ number_format($quote->subtotal, 3) }} {{ $quote->currency }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>TVA ({{ $quote->tax_rate }}%):</strong></td>
                                    <td class="text-end"><strong>{{ number_format($quote->tax_amount, 3) }} {{ $quote->currency }}</strong></td>
                                </tr>
                                @if($quote->discount_amount > 0)
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Remise:</strong></td>
                                    <td class="text-end"><strong class="text-danger">-{{ number_format($quote->discount_amount, 3) }} {{ $quote->currency }}</strong></td>
                                </tr>
                                @endif
                                <tr class="table-success">
                                    <td colspan="4" class="text-end"><strong class="fs-5">TOTAL TTC:</strong></td>
                                    <td class="text-end"><strong class="fs-5 text-success">{{ number_format($quote->total, 3) }} {{ $quote->currency }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if($quote->notes || $quote->terms_conditions)
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Notes & Conditions</h5>
                </div>
                <div class="card-body">
                    @if($quote->notes)
                    <div class="mb-3">
                        <label class="text-muted small fw-bold">Notes:</label>
                        <p class="mb-0">{{ $quote->notes }}</p>
                    </div>
                    @endif

                    @if($quote->terms_conditions)
                    <div class="mb-0">
                        <label class="text-muted small fw-bold">Conditions Générales:</label>
                        <p class="mb-0">{{ $quote->terms_conditions }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
