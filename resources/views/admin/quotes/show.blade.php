@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-file-invoice"></i> Devis {{ $quote->quote_number }}
            </h1>
            <p class="text-muted">Détails du devis</p>
        </div>
        <div>
            <a href="{{ route('admin.quotes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
            <a href="{{ route('admin.quotes.pdf', $quote) }}" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf"></i> PDF
            </a>
            @if($quote->status === 'draft')
                <a href="{{ route('admin.quotes.edit', $quote) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Modifier
                </a>
            @endif
        </div>
    </div>

    <div class="row">
        <!-- Informations principales -->
        <div class="col-md-8">
            <!-- Informations du devis -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informations du Devis</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>N° Devis:</strong> {{ $quote->quote_number }}</p>
                            <p><strong>Date création:</strong> {{ $quote->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Validité jusqu'au:</strong>
                                @if($quote->valid_until)
                                    {{ \Carbon\Carbon::parse($quote->valid_until)->format('d/m/Y') }}
                                    @if(\Carbon\Carbon::parse($quote->valid_until)->isPast())
                                        <span class="badge bg-danger">Expiré</span>
                                    @endif
                                @else
                                    <span class="text-muted">Non défini</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Statut:</strong>
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
                                <span class="badge bg-{{ $color }}">{{ ucfirst($quote->status) }}</span>
                            </p>
                            <p><strong>Créé par:</strong> {{ $quote->grossiste->name }}</p>
                            @if($quote->sent_at)
                                <p><strong>Envoyé le:</strong> {{ $quote->sent_at->format('d/m/Y H:i') }}</p>
                            @endif
                        </div>
                    </div>

                    @if($quote->notes)
                        <hr>
                        <p><strong>Notes:</strong></p>
                        <p class="text-muted">{{ $quote->notes }}</p>
                    @endif
                </div>
            </div>

            <!-- Client -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user"></i> Informations Client</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nom:</strong> {{ $quote->user->name }}</p>
                            <p><strong>Email:</strong> {{ $quote->user->email }}</p>
                            <p><strong>Téléphone:</strong> {{ $quote->user->phone ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Société:</strong> {{ $quote->user->company_name }}</p>
                            <p><strong>Adresse:</strong> {{ $quote->user->address ?? 'N/A' }}</p>
                            <p><strong>Ville:</strong> {{ $quote->user->city ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Articles du devis -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-box"></i> Articles du Devis</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>SKU</th>
                                    <th class="text-end">Prix Unitaire</th>
                                    <th class="text-center">Quantité</th>
                                    <th class="text-end">Remise</th>
                                    <th class="text-end">Sous-total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($quote->items as $item)
                                    <tr>
                                        <td>
                                            <strong>{{ $item->product->name }}</strong>
                                            @if($item->notes)
                                                <br><small class="text-muted">{{ $item->notes }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $item->product->sku }}</td>
                                        <td class="text-end">{{ number_format($item->unit_price, 2) }} TND</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end">
                                            @if($item->discount > 0)
                                                {{ number_format($item->discount, 2) }} TND
                                                <br><small class="text-success">({{ number_format(($item->discount / ($item->unit_price * $item->quantity)) * 100, 2) }}%)</small>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <strong>{{ number_format($item->subtotal, 2) }} TND</strong>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end"><strong>Sous-total:</strong></td>
                                    <td class="text-end"><strong>{{ number_format($quote->subtotal, 2) }} TND</strong></td>
                                </tr>
                                @if($quote->discount > 0)
                                    <tr>
                                        <td colspan="5" class="text-end"><strong>Remise globale:</strong></td>
                                        <td class="text-end text-success">
                                            <strong>-{{ number_format($quote->discount, 2) }} TND</strong>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="5" class="text-end"><strong>TVA ({{ $quote->tax_rate ?? 0 }}%):</strong></td>
                                    <td class="text-end"><strong>{{ number_format($quote->tax, 2) }} TND</strong></td>
                                </tr>
                                <tr class="table-primary">
                                    <td colspan="5" class="text-end"><strong>TOTAL:</strong></td>
                                    <td class="text-end"><h4 class="mb-0">{{ number_format($quote->total, 2) }} TND</h4></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Conditions -->
            @if($quote->terms)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-file-contract"></i> Conditions</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">{{ $quote->terms }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Actions et historique -->
        <div class="col-md-4">
            <!-- Actions rapides -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-tasks"></i> Actions</h5>
                </div>
                <div class="card-body">
                    @if(in_array($quote->status, ['draft', 'sent']))
                        <form action="{{ route('admin.quotes.send', $quote) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-info w-100">
                                <i class="fas fa-paper-plane"></i> Envoyer au Client
                            </button>
                        </form>
                    @endif

                    @if($quote->status === 'sent' || $quote->status === 'viewed')
                        <form action="{{ route('admin.quotes.accept', $quote) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-check"></i> Marquer Accepté
                            </button>
                        </form>

                        <form action="{{ route('admin.quotes.reject', $quote) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-times"></i> Marquer Rejeté
                            </button>
                        </form>
                    @endif

                    @if($quote->status === 'accepted' && !$quote->converted_order_id)
                        <form action="{{ route('admin.quotes.convert', $quote) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-exchange-alt"></i> Convertir en Commande
                            </button>
                        </form>
                    @endif

                    @if($quote->converted_order_id && $quote->convertedOrder)
                        <a href="{{ route('admin.orders.show', $quote->convertedOrder->order_number) }}" class="btn btn-outline-primary w-100 mb-2">
                            <i class="fas fa-shopping-cart"></i> Voir la Commande {{ $quote->convertedOrder->order_number }}
                        </a>
                    @endif

                    <a href="{{ route('admin.quotes.duplicate', $quote) }}" class="btn btn-outline-secondary w-100 mb-2">
                        <i class="fas fa-copy"></i> Dupliquer
                    </a>

                    @if($quote->status === 'draft')
                        <form action="{{ route('admin.quotes.destroy', $quote) }}"
                              method="POST"
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce devis ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Timeline/Historique -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-history"></i> Historique</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <p class="mb-0"><strong>Devis créé</strong></p>
                                <small class="text-muted">{{ $quote->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>

                        @if($quote->sent_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <p class="mb-0"><strong>Devis envoyé</strong></p>
                                    <small class="text-muted">{{ $quote->sent_at->format('d/m/Y H:i') }}</small>
                                </div>
                            </div>
                        @endif

                        @if($quote->viewed_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <p class="mb-0"><strong>Devis consulté</strong></p>
                                    <small class="text-muted">{{ $quote->viewed_at->format('d/m/Y H:i') }}</small>
                                </div>
                            </div>
                        @endif

                        @if($quote->accepted_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <p class="mb-0"><strong>Devis accepté</strong></p>
                                    <small class="text-muted">{{ $quote->accepted_at->format('d/m/Y H:i') }}</small>
                                </div>
                            </div>
                        @endif

                        @if($quote->rejected_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-danger"></div>
                                <div class="timeline-content">
                                    <p class="mb-0"><strong>Devis rejeté</strong></p>
                                    <small class="text-muted">{{ $quote->rejected_at->format('d/m/Y H:i') }}</small>
                                </div>
                            </div>
                        @endif

                        @if($quote->converted_order_id)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <p class="mb-0"><strong>Converti en commande</strong></p>
                                    <small class="text-muted">{{ $quote->updated_at->format('d/m/Y H:i') }}</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-item:before {
    content: '';
    position: absolute;
    left: -22px;
    top: 8px;
    bottom: -12px;
    width: 2px;
    background: #dee2e6;
}

.timeline-item:last-child:before {
    display: none;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 0;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-content {
    padding-left: 0;
}
</style>
@endsection
