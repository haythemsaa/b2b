@extends('layouts.app')

@section('title', 'Mes Devis')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><i class="fas fa-file-invoice me-2 text-primary"></i>Mes Devis</h1>
                <a href="{{ route('quotes.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Créer un Devis
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(isset($quotes) && $quotes->count() > 0)
    <div class="row">
        <div class="col-12">
            @foreach($quotes as $quote)
            <div class="card mb-3 shadow-sm">
                <div class="card-header bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <h6 class="mb-0"><i class="fas fa-file-alt me-2"></i>{{ $quote->quote_number }}</h6>
                            <small class="text-muted">{{ $quote->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <div class="col-md-3">
                            <strong>{{ $quote->customer_name }}</strong>
                            <br>
                            <small class="text-muted">{{ $quote->customer_email }}</small>
                        </div>
                        <div class="col-md-2">
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
                            <span class="badge bg-{{ $statusColors[$quote->status] ?? 'secondary' }}">
                                {{ $statusLabels[$quote->status] ?? ucfirst($quote->status) }}
                            </span>
                        </div>
                        <div class="col-md-2">
                            <strong class="text-success">{{ number_format($quote->total, 3) }} {{ $quote->currency }}</strong>
                            <br>
                            <small class="text-muted">{{ $quote->items->count() }} article(s)</small>
                        </div>
                        <div class="col-md-2 text-end">
                            <a href="{{ route('quotes.show', $quote) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>Voir Détails
                            </a>
                        </div>
                    </div>
                </div>

                @if($quote->items && $quote->items->count() > 0)
                <div class="card-body">
                    <div class="row">
                        @foreach($quote->items->take(3) as $item)
                        <div class="col-md-4 mb-2">
                            <div class="d-flex align-items-center">
                                @if($item->product && $item->product->coverImage)
                                <img src="/storage/{{ $item->product->coverImage->image_path }}" class="me-2 rounded" style="width: 40px; height: 40px; object-fit: cover;" alt="{{ $item->product_name }}">
                                @else
                                <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fas fa-image text-muted small"></i>
                                </div>
                                @endif
                                <div>
                                    <small class="fw-medium">{{ $item->product_name }}</small>
                                    <br>
                                    <small class="text-muted">Qté: {{ $item->quantity }} × {{ number_format($item->unit_price, 3) }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @if($quote->items->count() > 3)
                        <div class="col-md-12">
                            <small class="text-muted">et {{ $quote->items->count() - 3 }} autre(s) article(s)...</small>
                        </div>
                        @endif
                    </div>

                    @if($quote->valid_until)
                    <div class="mt-2">
                        <small class="text-muted">
                            <i class="fas fa-calendar-alt me-1"></i>
                            Valide jusqu'au: <strong>{{ $quote->valid_until->format('d/m/Y') }}</strong>
                            @if($quote->isExpired())
                                <span class="badge bg-warning ms-2">Expiré</span>
                            @endif
                        </small>
                    </div>
                    @endif
                </div>
                @endif
            </div>
            @endforeach

            @if(method_exists($quotes, 'links'))
            <div class="d-flex justify-content-center">
                {{ $quotes->links() }}
            </div>
            @endif
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-12 text-center py-5">
            <i class="fas fa-file-invoice display-1 text-muted mb-3"></i>
            <h4 class="text-muted mb-3">Aucun devis trouvé</h4>
            <p class="text-muted mb-4">Vous n'avez pas encore créé de devis. Commencez par créer votre premier devis.</p>
            <a href="{{ route('quotes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Créer mon Premier Devis
            </a>
        </div>
    </div>
    @endif
</div>
@endsection
