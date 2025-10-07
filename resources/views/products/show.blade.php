@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('Products') }}</a></li>
            @if($product->category)
            <li class="breadcrumb-item"><a href="{{ route('products.category', $product->category->slug) }}">{{ $product->category->name }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-6 mb-4">
            @if($product->image_url)
            <img src="{{ $product->image_url }}" class="img-fluid rounded" alt="{{ $product->name }}">
            @else
            <div class="d-flex align-items-center justify-content-center bg-light rounded" style="height: 400px;">
                <i class="bi bi-image text-muted" style="font-size: 5rem;"></i>
            </div>
            @endif
        </div>

        <div class="col-md-6">
            <h1 class="mb-3">{{ $product->name }}</h1>

            @if($product->category)
            <p class="text-muted mb-2">
                <i class="bi bi-tag me-1"></i>{{ $product->category->name }}
            </p>
            @endif

            <p class="text-muted mb-3">
                <i class="bi bi-upc me-1"></i><strong>{{ __('SKU') }}:</strong> {{ $product->sku }}
            </p>

            <div class="mb-4">
                @if(isset($product->user_price) && $product->user_price != $product->price)
                <div class="mb-2">
                    <span class="text-muted text-decoration-line-through h5">{{ number_format($product->price, 2) }} DT</span>
                    <span class="badge bg-success ms-2">{{ __('Special Price') }}</span>
                </div>
                <h3 class="text-primary">{{ number_format($product->user_price, 2) }} DT</h3>
                @else
                <h3 class="text-primary">{{ number_format($product->price, 2) }} DT</h3>
                @endif
            </div>

            <div class="mb-4">
                @if($product->stock_quantity > 0)
                <p class="text-success mb-2">
                    <i class="bi bi-check-circle me-1"></i>{{ __('In Stock') }} ({{ $product->stock_quantity }} {{ __('available') }})
                </p>
                @else
                <p class="text-danger mb-2">
                    <i class="bi bi-x-circle me-1"></i>{{ __('Out of Stock') }}
                </p>
                @endif
            </div>

            @if($product->stock_quantity > 0)
            <form action="{{ route('cart.add') }}" method="POST" class="mb-4" id="addToCartForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div class="row align-items-end">
                    <div class="col-md-4 mb-2">
                        <label for="quantity" class="form-label">{{ __('Quantity') }}</label>
                        <input type="number" class="form-control" id="quantity" name="quantity"
                               value="{{ $product->min_order_quantity ?? 1 }}"
                               min="{{ $product->min_order_quantity ?? 1 }}"
                               @if($product->order_multiple)
                               step="{{ $product->order_multiple }}"
                               @endif
                               max="{{ $product->stock_quantity }}">
                        @if($product->min_order_quantity)
                        <small class="text-muted">Min: {{ $product->min_order_quantity }}</small>
                        @endif
                        @if($product->order_multiple)
                        <small class="text-muted">Par multiples de: {{ $product->order_multiple }}</small>
                        @endif
                    </div>
                    <div class="col-md-8 mb-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-cart-plus me-2"></i>{{ __('Add to Cart') }}
                        </button>
                    </div>
                </div>
            </form>
            @endif

            @if($product->description)
            <div class="mb-4">
                <h5>{{ __('Description') }}</h5>
                <p class="text-muted">{{ $product->description }}</p>
            </div>
            @endif

            @if($product->specifications)
            <div class="mb-4">
                <h5>{{ __('Specifications') }}</h5>
                <p class="text-muted">{{ $product->specifications }}</p>
            </div>
            @endif

            <!-- Product Actions -->
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>{{ __('Back to Products') }}
                </a>

                @if($product->category)
                <a href="{{ route('products.category', $product->category->slug) }}" class="btn btn-outline-primary">
                    <i class="bi bi-collection me-1"></i>{{ __('More in') }} {{ $product->category->name }}
                </a>
                @endif
            </div>
        </div>
    </div>

    @if($product->category && $product->category->products->where('id', '!=', $product->id)->count() > 0)
    <hr class="my-5">

    <h4 class="mb-4">{{ __('Related Products') }}</h4>
    <div class="row">
        @foreach($product->category->products->where('id', '!=', $product->id)->take(4) as $relatedProduct)
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                @if($relatedProduct->image_url)
                <img src="{{ $relatedProduct->image_url }}" class="card-img-top" alt="{{ $relatedProduct->name }}" style="height: 150px; object-fit: cover;">
                @else
                <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 150px;">
                    <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                </div>
                @endif

                <div class="card-body">
                    <h6 class="card-title">{{ Str::limit($relatedProduct->name, 50) }}</h6>
                    <p class="text-primary fw-bold">{{ number_format($relatedProduct->price, 2) }} DT</p>
                    <a href="{{ route('products.show', $relatedProduct->sku) }}" class="btn btn-outline-primary btn-sm">
                        {{ __('View Details') }}
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('addToCartForm');
    const quantityInput = document.getElementById('quantity');

    if (form && quantityInput) {
        const minQty = parseInt(quantityInput.getAttribute('min')) || 1;
        const maxQty = parseInt(quantityInput.getAttribute('max'));
        const multiple = parseInt(quantityInput.getAttribute('step')) || 1;

        // Validate quantity on change
        quantityInput.addEventListener('change', function() {
            let qty = parseInt(this.value);

            if (qty < minQty) {
                this.value = minQty;
                alert(`La quantité minimale est de ${minQty}`);
            } else if (maxQty && qty > maxQty) {
                this.value = maxQty;
                alert(`Stock disponible: ${maxQty} unités`);
            } else if (multiple > 1 && qty % multiple !== 0) {
                // Round to nearest multiple
                const rounded = Math.round(qty / multiple) * multiple;
                this.value = Math.max(minQty, rounded);
                alert(`Ce produit doit être commandé par multiples de ${multiple}`);
            }
        });

        // Validate on form submit
        form.addEventListener('submit', function(e) {
            const qty = parseInt(quantityInput.value);

            if (qty < minQty) {
                e.preventDefault();
                alert(`La quantité minimale est de ${minQty}`);
                quantityInput.value = minQty;
                return false;
            }

            if (multiple > 1 && qty % multiple !== 0) {
                e.preventDefault();
                alert(`Ce produit doit être commandé par multiples de ${multiple}`);
                return false;
            }
        });
    }
});
</script>
@endpush
@endsection