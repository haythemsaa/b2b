@extends('layouts.app')

@section('title', __('Order Details'))

@section('content')
<div class="container">
    @if(isset($order))
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>{{ __('Order') }} #{{ $order->order_number }}</h1>
                <div>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-arrow-left me-1"></i>{{ __('Back to Orders') }}
                    </a>
                    @if($order->status !== 'cancelled' && in_array($order->status, ['pending', 'processing']))
                    <a href="{{ route('returns.create') }}?order={{ $order->id }}" class="btn btn-outline-warning">
                        <i class="bi bi-arrow-return-left me-1"></i>{{ __('Request Return') }}
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Order Items -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Order Items') }}</h5>
                </div>
                <div class="card-body">
                    @if($order->items && $order->items->count() > 0)
                    @foreach($order->items as $item)
                    <div class="row align-items-center mb-3 pb-3 border-bottom">
                        <div class="col-md-2">
                            @if($item->product && $item->product->image_url)
                            <img src="{{ $item->product->image_url }}" class="img-fluid rounded" alt="{{ $item->product_name }}">
                            @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 80px;">
                                <i class="bi bi-image text-muted"></i>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <h6 class="mb-1">{{ $item->product_name }}</h6>
                            @if($item->product)
                            <small class="text-muted">SKU: {{ $item->product->sku }}</small>
                            @endif
                        </div>
                        <div class="col-md-2">
                            <span class="text-muted">{{ number_format($item->unit_price, 2) }} DT</span>
                        </div>
                        <div class="col-md-2">
                            <span class="badge bg-secondary">x{{ $item->quantity }}</span>
                        </div>
                        <div class="col-md-2 text-end">
                            <strong>{{ number_format($item->total_price, 2) }} DT</strong>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <p class="text-muted">{{ __('No items found for this order.') }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Order Summary -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Order Summary') }}</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ __('Subtotal') }}:</span>
                        <span>{{ number_format($order->total_amount, 2) }} DT</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ __('Tax') }}:</span>
                        <span>{{ __('Included') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ __('Shipping') }}:</span>
                        <span>{{ __('Free') }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>{{ __('Total') }}:</strong>
                        <strong class="text-primary">{{ number_format($order->total_amount, 2) }} DT</strong>
                    </div>
                </div>
            </div>

            <!-- Order Status -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Order Status') }}</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }} fs-6 mb-3">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    <div class="timeline">
                        <div class="timeline-item {{ $order->status !== 'cancelled' ? 'active' : '' }}">
                            <i class="bi bi-check-circle"></i>
                            <span>{{ __('Order Placed') }}</span>
                            <small class="text-muted d-block">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        @if($order->status !== 'cancelled')
                        <div class="timeline-item {{ in_array($order->status, ['processing', 'shipped', 'completed']) ? 'active' : '' }}">
                            <i class="bi bi-gear"></i>
                            <span>{{ __('Processing') }}</span>
                        </div>
                        <div class="timeline-item {{ in_array($order->status, ['shipped', 'completed']) ? 'active' : '' }}">
                            <i class="bi bi-truck"></i>
                            <span>{{ __('Shipped') }}</span>
                        </div>
                        <div class="timeline-item {{ $order->status === 'completed' ? 'active' : '' }}">
                            <i class="bi bi-check-circle"></i>
                            <span>{{ __('Delivered') }}</span>
                        </div>
                        @else
                        <div class="timeline-item active text-danger">
                            <i class="bi bi-x-circle"></i>
                            <span>{{ __('Cancelled') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Details -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Order Details') }}</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>{{ __('Order Number') }}:</strong><br>
                        <span class="text-muted">#{{ $order->order_number }}</span>
                    </p>
                    <p class="mb-2">
                        <strong>{{ __('Order Date') }}:</strong><br>
                        <span class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </p>
                    @if($order->notes)
                    <p class="mb-2">
                        <strong>{{ __('Notes') }}:</strong><br>
                        <span class="text-muted">{{ $order->notes }}</span>
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-12 text-center py-5">
            <i class="bi bi-exclamation-circle display-1 text-muted mb-3"></i>
            <h4 class="text-muted">{{ __('Order not found') }}</h4>
            <p class="text-muted mb-4">{{ __('The order you\'re looking for doesn\'t exist or you don\'t have access to it.') }}</p>
            <a href="{{ route('orders.index') }}" class="btn btn-primary">
                {{ __('Back to Orders') }}
            </a>
        </div>
    </div>
    @endif
</div>

<style>
.timeline {
    position: relative;
    padding: 0;
}

.timeline-item {
    position: relative;
    padding: 15px 0 15px 50px;
    border-left: 2px solid #e9ecef;
}

.timeline-item:last-child {
    border-left: none;
}

.timeline-item.active {
    border-left-color: #28a745;
}

.timeline-item.active i {
    color: #28a745;
}

.timeline-item i {
    position: absolute;
    left: -10px;
    top: 15px;
    background: white;
    padding: 5px;
    border-radius: 50%;
    color: #6c757d;
}
</style>
@endsection