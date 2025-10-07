@extends('layouts.app')

@section('title', __('My Orders'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>{{ __('My Orders') }}</h1>
                <a href="{{ route('products.index') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>{{ __('Place New Order') }}
                </a>
            </div>
        </div>
    </div>

    @if(isset($orders) && $orders->count() > 0)
    <div class="row">
        <div class="col-12">
            @foreach($orders as $order)
            <div class="card mb-3">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <h6 class="mb-0">{{ __('Order') }} #{{ $order->order_number }}</h6>
                            <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <div class="col-md-2">
                            <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="col-md-2">
                            <strong>{{ number_format($order->total_amount, 2) }} DT</strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted">
                                @if($order->items_count)
                                {{ $order->items_count }} {{ __('item(s)') }}
                                @endif
                            </small>
                        </div>
                        <div class="col-md-2 text-end">
                            <a href="{{ route('orders.show', $order->order_number) }}" class="btn btn-outline-primary btn-sm">
                                {{ __('View Details') }}
                            </a>
                        </div>
                    </div>
                </div>

                @if($order->items && $order->items->count() > 0)
                <div class="card-body">
                    <div class="row">
                        @foreach($order->items->take(3) as $item)
                        <div class="col-md-4 mb-2">
                            <div class="d-flex align-items-center">
                                @if($item->product && $item->product->image_url)
                                <img src="{{ $item->product->image_url }}" class="me-2 rounded" style="width: 40px; height: 40px; object-fit: cover;" alt="{{ $item->product_name }}">
                                @else
                                <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-image text-muted small"></i>
                                </div>
                                @endif
                                <div>
                                    <small class="fw-medium">{{ $item->product_name }}</small>
                                    <br>
                                    <small class="text-muted">{{ __('Qty') }}: {{ $item->quantity }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @if($order->items->count() > 3)
                        <div class="col-md-12">
                            <small class="text-muted">{{ __('and') }} {{ $order->items->count() - 3 }} {{ __('more items...') }}</small>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            @endforeach

            @if(method_exists($orders, 'links'))
            <div class="d-flex justify-content-center">
                {{ $orders->links() }}
            </div>
            @endif
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-12 text-center py-5">
            <i class="bi bi-bag-x display-1 text-muted mb-3"></i>
            <h4 class="text-muted mb-3">{{ __('No orders found') }}</h4>
            <p class="text-muted mb-4">{{ __('You haven\'t placed any orders yet. Start shopping to see your orders here.') }}</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">
                <i class="bi bi-shop me-2"></i>{{ __('Start Shopping') }}
            </a>
        </div>
    </div>
    @endif
</div>
@endsection