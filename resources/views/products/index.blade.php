@extends('layouts.app')

@section('title', __('Products'))

@section('content')
<div class="container-fluid" x-data="productCatalog()" x-init="init()">
    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-md-3 mb-4">
            <div class="card animate__animated animate__fadeInLeft">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>{{ __('Filters') }}</h5>
                </div>
                <div class="card-body">
                    <!-- Search Box -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Search') }}</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text"
                                   class="form-control"
                                   placeholder="{{ __('Search products...') }}"
                                   x-model="search"
                                   @input.debounce.300ms="filterProducts()">
                        </div>
                    </div>

                    <!-- Sort By -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Sort By') }}</label>
                        <select class="form-select" x-model="sortBy" @change="sortProducts()">
                            <option value="name">{{ __('Name') }} (A-Z)</option>
                            <option value="price_asc">{{ __('Price') }} ({{ __('Low to High') }})</option>
                            <option value="price_desc">{{ __('Price') }} ({{ __('High to Low') }})</option>
                            <option value="newest">{{ __('Newest First') }}</option>
                        </select>
                    </div>

                    <!-- View Mode -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('View') }}</label>
                        <div class="btn-group w-100" role="group">
                            <button type="button"
                                    class="btn btn-outline-secondary"
                                    :class="{ 'active': viewMode === 'grid' }"
                                    @click="viewMode = 'grid'">
                                <i class="bi bi-grid-3x3-gap"></i> Grid
                            </button>
                            <button type="button"
                                    class="btn btn-outline-secondary"
                                    :class="{ 'active': viewMode === 'list' }"
                                    @click="viewMode = 'list'">
                                <i class="bi bi-list-ul"></i> List
                            </button>
                        </div>
                    </div>

                    <!-- Price Range Filter -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Price Range') }}</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="number"
                                       class="form-control form-control-sm"
                                       placeholder="{{ __('Min') }}"
                                       x-model.number="priceMin"
                                       @input.debounce.300ms="filterProducts()">
                            </div>
                            <div class="col-6">
                                <input type="number"
                                       class="form-control form-control-sm"
                                       placeholder="{{ __('Max') }}"
                                       x-model.number="priceMax"
                                       @input.debounce.300ms="filterProducts()">
                            </div>
                        </div>
                    </div>

                    <!-- Stock Filter -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Availability') }}</label>
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="inStockOnly"
                                   x-model="inStockOnly"
                                   @change="filterProducts()">
                            <label class="form-check-label" for="inStockOnly">
                                {{ __('In Stock Only') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="lowStock"
                                   x-model="lowStock"
                                   @change="filterProducts()">
                            <label class="form-check-label" for="lowStock">
                                {{ __('Low Stock') }} (&lt; 10)
                            </label>
                        </div>
                    </div>

                    <!-- Clear Filters -->
                    <div class="d-grid">
                        <button class="btn btn-outline-danger btn-sm"
                                @click="clearFilters()"
                                :disabled="!hasActiveFilters()">
                            <i class="bi bi-x-circle me-1"></i>{{ __('Clear Filters') }}
                        </button>
                    </div>
                </div>

                <!-- Categories -->
                <div class="list-group list-group-flush">
                    <a href="#"
                       class="list-group-item list-group-item-action transition-all"
                       :class="{ 'active': !category }"
                       @click.prevent="category = ''; filterProducts()">
                        <i class="bi bi-grid-3x3-gap me-2"></i>{{ __('All Products') }}
                        <span class="badge bg-secondary float-end" x-text="products.length"></span>
                    </a>
                    @foreach($categories as $cat)
                    <a href="#"
                       class="list-group-item list-group-item-action transition-all"
                       :class="{ 'active': category == '{{ $cat->id }}' }"
                       @click.prevent="category = '{{ $cat->id }}'; filterProducts()">
                        <i class="bi bi-tag me-2"></i>{{ $cat->name }}
                        <span class="badge bg-secondary float-end">{{ $cat->products_count ?? 0 }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeInDown">
                <div>
                    <h2><i class="bi bi-box-seam me-2 text-primary"></i>{{ __('Products') }}</h2>
                    <p class="text-muted mb-0">
                        <span x-text="filteredProducts.length"></span> {{ __('products found') }}
                    </p>
                </div>

                <!-- Quick Actions -->
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" @click="location.reload()" title="{{ __('Refresh') }}">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>
                </div>
            </div>

            <!-- Loading State -->
            <div x-show="loading" class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-muted mt-3">{{ __('Loading products...') }}</p>
            </div>

            <!-- Grid View -->
            <div x-show="!loading && viewMode === 'grid'" class="row" x-transition>
                <template x-for="product in filteredProducts" :key="product.id">
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 product-card shadow-sm animate__animated animate__fadeInUp">
                            <!-- Product Image -->
                            <div class="position-relative overflow-hidden" style="height: 200px;">
                                <img :src="product.image_url || '/images/placeholder.png'"
                                     class="card-img-top h-100 w-100"
                                     style="object-fit: cover;"
                                     :alt="product.name">

                                <!-- Stock Badge -->
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge"
                                          :class="product.stock_quantity > 0 ? 'bg-success' : 'bg-danger'">
                                        <i class="bi" :class="product.stock_quantity > 0 ? 'bi-check-circle' : 'bi-x-circle'"></i>
                                        <span x-text="product.stock_quantity > 0 ? '{{ __('In Stock') }}' : '{{ __('Out of Stock') }}'"></span>
                                    </span>
                                </div>

                                <!-- Quick View Overlay -->
                                <div class="overlay">
                                    <a :href="`/products/${product.sku}`"
                                       class="btn btn-light btn-sm">
                                        <i class="bi bi-eye"></i> {{ __('Quick View') }}
                                    </a>
                                </div>
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title" x-text="product.name"></h5>
                                <p class="card-text flex-grow-1 text-muted small" x-text="truncate(product.description, 80)"></p>

                                <div class="mt-auto">
                                    <!-- Price -->
                                    <div class="mb-3">
                                        <template x-if="product.user_price && product.user_price != product.price">
                                            <div>
                                                <span class="text-muted text-decoration-line-through small" x-text="product.price + ' DT'"></span>
                                                <strong class="text-primary fs-5 ms-2" x-text="product.user_price + ' DT'"></strong>
                                                <span class="badge bg-danger ms-1">{{ __('Promo!') }}</span>
                                            </div>
                                        </template>
                                        <template x-if="!product.user_price || product.user_price == product.price">
                                            <strong class="text-primary fs-5" x-text="product.price + ' DT'"></strong>
                                        </template>
                                    </div>

                                    <!-- Actions -->
                                    <div class="d-grid gap-2">
                                        <a :href="`/products/${product.sku}`"
                                           class="btn btn-outline-primary btn-sm transition-all scale-hover">
                                            <i class="bi bi-eye me-1"></i>{{ __('View Details') }}
                                        </a>

                                        <button type="button"
                                                class="btn btn-primary btn-sm transition-all"
                                                :disabled="product.stock_quantity <= 0"
                                                @click="addToCart(product.id)"
                                                :class="{ 'btn-loading': addingToCart === product.id }">
                                            <i class="bi bi-cart-plus me-1"></i>
                                            <span x-text="product.stock_quantity > 0 ? '{{ __('Add to Cart') }}' : '{{ __('Out of Stock') }}'"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- List View -->
            <div x-show="!loading && viewMode === 'list'" x-transition>
                <template x-for="product in filteredProducts" :key="product.id">
                    <div class="card mb-3 product-card shadow-sm animate__animated animate__fadeInRight">
                        <div class="row g-0">
                            <div class="col-md-3">
                                <img :src="product.image_url || '/images/placeholder.png'"
                                     class="img-fluid h-100"
                                     style="object-fit: cover;"
                                     :alt="product.name">
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-title" x-text="product.name"></h5>
                                        <div>
                                            <template x-if="product.user_price && product.user_price != product.price">
                                                <div>
                                                    <span class="text-muted text-decoration-line-through" x-text="product.price + ' DT'"></span>
                                                    <strong class="text-primary fs-4 ms-2" x-text="product.user_price + ' DT'"></strong>
                                                </div>
                                            </template>
                                            <template x-if="!product.user_price || product.user_price == product.price">
                                                <strong class="text-primary fs-4" x-text="product.price + ' DT'"></strong>
                                            </template>
                                        </div>
                                    </div>
                                    <p class="card-text" x-text="product.description"></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge"
                                                  :class="product.stock_quantity > 0 ? 'bg-success' : 'bg-danger'">
                                                <span x-text="product.stock_quantity > 0 ? '{{ __('In Stock') }} (' + product.stock_quantity + ')' : '{{ __('Out of Stock') }}'"></span>
                                            </span>
                                        </div>
                                        <div class="btn-group">
                                            <a :href="`/products/${product.sku}`" class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-eye"></i> {{ __('Details') }}
                                            </a>
                                            <button type="button"
                                                    class="btn btn-primary btn-sm"
                                                    :disabled="product.stock_quantity <= 0"
                                                    @click="addToCart(product.id)">
                                                <i class="bi bi-cart-plus"></i> {{ __('Add to Cart') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- No Results -->
            <div x-show="!loading && filteredProducts.length === 0"
                 class="text-center py-5 animate__animated animate__fadeIn">
                <i class="bi bi-search display-1 text-muted mb-3"></i>
                <h4 class="text-muted">{{ __('No products found') }}</h4>
                <p class="text-muted">{{ __('Try adjusting your search criteria') }}</p>
                <button @click="search = ''; category = ''; filterProducts()" class="btn btn-primary">
                    <i class="bi bi-arrow-counterclockwise me-2"></i>{{ __('Reset Filters') }}
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function productCatalog() {
    return {
        products: @json($products->items()),
        filteredProducts: [],
        search: '',
        category: '',
        sortBy: 'name',
        viewMode: 'grid',
        loading: false,
        addingToCart: null,
        priceMin: null,
        priceMax: null,
        inStockOnly: false,
        lowStock: false,

        init() {
            this.filteredProducts = [...this.products];
            this.sortProducts();
        },

        filterProducts() {
            let filtered = [...this.products];

            // Filter by search
            if (this.search) {
                const searchLower = this.search.toLowerCase();
                filtered = filtered.filter(p =>
                    p.name.toLowerCase().includes(searchLower) ||
                    (p.description && p.description.toLowerCase().includes(searchLower))
                );
            }

            // Filter by category
            if (this.category) {
                filtered = filtered.filter(p => p.category_id == this.category);
            }

            // Filter by price range
            if (this.priceMin !== null && this.priceMin !== '') {
                filtered = filtered.filter(p => {
                    const price = p.user_price || p.price;
                    return price >= this.priceMin;
                });
            }
            if (this.priceMax !== null && this.priceMax !== '') {
                filtered = filtered.filter(p => {
                    const price = p.user_price || p.price;
                    return price <= this.priceMax;
                });
            }

            // Filter by stock
            if (this.inStockOnly) {
                filtered = filtered.filter(p => p.stock_quantity > 0);
            }
            if (this.lowStock) {
                filtered = filtered.filter(p => p.stock_quantity > 0 && p.stock_quantity < 10);
            }

            this.filteredProducts = filtered;
            this.sortProducts();
        },

        clearFilters() {
            this.search = '';
            this.category = '';
            this.priceMin = null;
            this.priceMax = null;
            this.inStockOnly = false;
            this.lowStock = false;
            this.filterProducts();
        },

        hasActiveFilters() {
            return this.search !== '' ||
                   this.category !== '' ||
                   this.priceMin !== null ||
                   this.priceMax !== null ||
                   this.inStockOnly ||
                   this.lowStock;
        },

        sortProducts() {
            const sorted = [...this.filteredProducts];

            switch(this.sortBy) {
                case 'name':
                    sorted.sort((a, b) => a.name.localeCompare(b.name));
                    break;
                case 'price_asc':
                    sorted.sort((a, b) => (a.user_price || a.price) - (b.user_price || b.price));
                    break;
                case 'price_desc':
                    sorted.sort((a, b) => (b.user_price || b.price) - (a.user_price || a.price));
                    break;
                case 'newest':
                    sorted.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                    break;
            }

            this.filteredProducts = sorted;
        },

        async addToCart(productId) {
            this.addingToCart = productId;
            try {
                const response = await fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1
                    })
                });

                const data = await response.json();

                if (data.success) {
                    notyf.success('{{ __('Product added to cart!') }}');
                    // Update cart count in sidebar
                    window.dispatchEvent(new CustomEvent('cart-updated'));
                } else {
                    notyf.error(data.message || '{{ __('Error adding to cart') }}');
                }
            } catch (error) {
                notyf.error('{{ __('Error adding to cart') }}');
                console.error(error);
            } finally {
                this.addingToCart = null;
            }
        },

        truncate(text, length) {
            if (!text) return '';
            return text.length > length ? text.substring(0, length) + '...' : text;
        }
    }
}
</script>
@endpush
@endsection
