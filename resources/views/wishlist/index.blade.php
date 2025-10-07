@extends('layouts.app')

@section('title', 'Ma Liste de Favoris')

@section('content')
<div class="container" x-data="wishlistManager()" x-init="init()">
    <!-- Header -->
    <div class="row mb-4 animate__animated animate__fadeInDown">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1><i class="bi bi-heart-fill me-2 text-danger"></i>Ma Liste de Favoris</h1>
                    <p class="text-muted mb-0">
                        <span x-text="items.length"></span> produit(s) dans vos favoris
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <button @click="addAllToCart()"
                            class="btn btn-success"
                            x-show="items.length > 0"
                            :disabled="adding All">
                        <i class="bi bi-cart-plus me-2"></i>
                        Tout ajouter au panier
                    </button>
                    <button @click="clearAll()"
                            class="btn btn-outline-danger"
                            x-show="items.length > 0">
                        <i class="bi bi-trash"></i>
                        Vider la liste
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Empty State -->
    <div x-show="items.length === 0" class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 animate__animated animate__fadeIn">
                <div class="card-body text-center py-5">
                    <i class="bi bi-heart display-1 text-muted mb-4"></i>
                    <h3 class="text-muted mb-3">Votre liste de favoris est vide</h3>
                    <p class="text-muted mb-4">
                        Ajoutez vos produits préférés pour les retrouver facilement plus tard
                    </p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-shop me-2"></i>Découvrir les produits
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Wishlist Items -->
    <div x-show="items.length > 0" class="row">
        <div class="col-12">
            <div class="card shadow-sm animate__animated animate__fadeInUp">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0"><i class="bi bi-heart me-2 text-danger"></i>Mes Produits Favoris</h5>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button"
                                class="btn btn-sm"
                                :class="viewMode === 'grid' ? 'btn-primary' : 'btn-outline-secondary'"
                                @click="viewMode = 'grid'">
                            <i class="bi bi-grid-3x3-gap"></i>
                        </button>
                        <button type="button"
                                class="btn btn-sm"
                                :class="viewMode === 'list' ? 'btn-primary' : 'btn-outline-secondary'"
                                @click="viewMode = 'list'">
                            <i class="bi bi-list-ul"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Grid View -->
                    <div x-show="viewMode === 'grid'" class="row">
                        <template x-for="(item, index) in items" :key="item.id">
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="card h-100 product-card shadow-sm border-0 animate__animated animate__zoomIn"
                                     :style="'animation-delay: ' + (index * 0.1) + 's'">
                                    <!-- Image -->
                                    <div class="position-relative overflow-hidden" style="height: 200px;">
                                        <img :src="item.image_url || '/images/placeholder.png'"
                                             class="card-img-top w-100 h-100"
                                             style="object-fit: cover;"
                                             :alt="item.name">

                                        <!-- Wishlist Badge -->
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <button @click="removeItem(item.id)"
                                                    class="btn btn-danger btn-sm rounded-circle"
                                                    title="Retirer des favoris">
                                                <i class="bi bi-heart-fill"></i>
                                            </button>
                                        </div>

                                        <!-- Stock Badge -->
                                        <div class="position-absolute top-0 start-0 m-2">
                                            <span class="badge"
                                                  :class="item.stock_quantity > 0 ? 'bg-success' : 'bg-danger'">
                                                <i class="bi"
                                                   :class="item.stock_quantity > 0 ? 'bi-check-circle' : 'bi-x-circle'"></i>
                                                <span x-text="item.stock_quantity > 0 ? 'En stock' : 'Rupture'"></span>
                                            </span>
                                        </div>

                                        <!-- Added Date -->
                                        <div class="position-absolute bottom-0 start-0 m-2">
                                            <small class="badge bg-dark bg-opacity-75">
                                                <i class="bi bi-calendar-plus me-1"></i>
                                                <span x-text="formatDate(item.added_at)"></span>
                                            </small>
                                        </div>
                                    </div>

                                    <!-- Card Body -->
                                    <div class="card-body d-flex flex-column">
                                        <h6 class="card-title text-truncate" :title="item.name" x-text="item.name"></h6>
                                        <p class="card-text text-muted small mb-2">
                                            <i class="bi bi-tag me-1"></i><span x-text="item.sku"></span>
                                        </p>

                                        <!-- Price -->
                                        <div class="mb-3">
                                            <template x-if="item.user_price && item.user_price != item.price">
                                                <div>
                                                    <small class="text-muted text-decoration-line-through d-block"
                                                           x-text="formatPrice(item.price)"></small>
                                                    <strong class="text-primary fs-5" x-text="formatPrice(item.user_price)"></strong>
                                                    <span class="badge bg-danger ms-1">Promo!</span>
                                                </div>
                                            </template>
                                            <template x-if="!item.user_price || item.user_price == item.price">
                                                <strong class="text-primary fs-5" x-text="formatPrice(item.price)"></strong>
                                            </template>
                                        </div>

                                        <!-- Actions -->
                                        <div class="mt-auto d-grid gap-2">
                                            <a :href="`/products/${item.sku}`"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye me-1"></i>Voir détails
                                            </a>
                                            <button type="button"
                                                    class="btn btn-sm btn-success"
                                                    :disabled="item.stock_quantity <= 0 || item.adding"
                                                    @click="addToCart(item.id)"
                                                    :class="{ 'btn-loading': item.adding }">
                                                <i class="bi bi-cart-plus me-1"></i>
                                                <span x-text="item.stock_quantity > 0 ? 'Ajouter au panier' : 'Rupture de stock'"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- List View -->
                    <div x-show="viewMode === 'list'">
                        <template x-for="(item, index) in items" :key="item.id">
                            <div class="card mb-3 shadow-sm border-0 animate__animated animate__fadeInRight"
                                 :style="'animation-delay: ' + (index * 0.05) + 's'">
                                <div class="row g-0">
                                    <div class="col-md-2">
                                        <img :src="item.image_url || '/images/placeholder.png'"
                                             class="img-fluid h-100"
                                             style="object-fit: cover;"
                                             :alt="item.name">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <!-- Product Info -->
                                                <div class="col-md-6">
                                                    <h5 class="card-title mb-1" x-text="item.name"></h5>
                                                    <p class="card-text text-muted small mb-2">
                                                        <i class="bi bi-tag me-1"></i><span x-text="item.sku"></span>
                                                    </p>
                                                    <div>
                                                        <span class="badge"
                                                              :class="item.stock_quantity > 0 ? 'bg-success' : 'bg-danger'">
                                                            <span x-text="item.stock_quantity > 0 ? 'En stock (' + item.stock_quantity + ')' : 'Rupture'"></span>
                                                        </span>
                                                        <small class="text-muted ms-2">
                                                            Ajouté le <span x-text="formatDate(item.added_at)"></span>
                                                        </small>
                                                    </div>
                                                </div>

                                                <!-- Price -->
                                                <div class="col-md-3 text-center">
                                                    <template x-if="item.user_price && item.user_price != item.price">
                                                        <div>
                                                            <small class="text-muted text-decoration-line-through d-block"
                                                                   x-text="formatPrice(item.price)"></small>
                                                            <strong class="text-primary fs-4" x-text="formatPrice(item.user_price)"></strong>
                                                        </div>
                                                    </template>
                                                    <template x-if="!item.user_price || item.user_price == item.price">
                                                        <strong class="text-primary fs-4" x-text="formatPrice(item.price)"></strong>
                                                    </template>
                                                </div>

                                                <!-- Actions -->
                                                <div class="col-md-3">
                                                    <div class="d-grid gap-2">
                                                        <a :href="`/products/${item.sku}`"
                                                           class="btn btn-sm btn-outline-primary">
                                                            <i class="bi bi-eye"></i> Détails
                                                        </a>
                                                        <button type="button"
                                                                class="btn btn-sm btn-success"
                                                                :disabled="item.stock_quantity <= 0 || item.adding"
                                                                @click="addToCart(item.id)">
                                                            <i class="bi bi-cart-plus"></i> Panier
                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-sm btn-outline-danger"
                                                                @click="removeItem(item.id)">
                                                            <i class="bi bi-heart-fill"></i> Retirer
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function wishlistManager() {
    return {
        items: [],
        viewMode: 'grid',
        addingAll: false,

        init() {
            this.loadWishlist();
        },

        loadWishlist() {
            // Load from localStorage for demo
            const saved = localStorage.getItem('wishlist');
            if (saved) {
                this.items = JSON.parse(saved);
            }

            // In real app, fetch from API
            // fetch('/api/wishlist')
            //     .then(r => r.json())
            //     .then(data => this.items = data);
        },

        saveWishlist() {
            localStorage.setItem('wishlist', JSON.stringify(this.items));
        },

        async addToCart(itemId) {
            const item = this.items.find(i => i.id == itemId);
            if (!item) return;

            item.adding = true;

            try {
                const response = await fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        product_id: item.id,
                        quantity: 1
                    })
                });

                const data = await response.json();

                if (data.success) {
                    notyf.success('Ajouté au panier !');
                    // Update cart badge
                    window.dispatchEvent(new CustomEvent('cart-updated'));
                } else {
                    notyf.error(data.message || 'Erreur');
                }
            } catch (error) {
                notyf.error('Erreur lors de l\'ajout');
                console.error(error);
            } finally {
                item.adding = false;
            }
        },

        async addAllToCart() {
            const result = await Swal.fire({
                title: 'Ajouter tout au panier?',
                text: `Ajouter ${this.items.length} produits au panier?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Oui, tout ajouter',
                cancelButtonText: 'Annuler'
            });

            if (!result.isConfirmed) return;

            this.addingAll = true;
            let added = 0;

            for (const item of this.items) {
                if (item.stock_quantity > 0) {
                    try {
                        await this.addToCart(item.id);
                        added++;
                    } catch (error) {
                        console.error(error);
                    }
                }
            }

            this.addingAll = false;
            notyf.success(`${added} produit(s) ajoutés au panier`);
        },

        async removeItem(itemId) {
            const result = await Swal.fire({
                title: 'Retirer des favoris?',
                text: 'Voulez-vous retirer ce produit de vos favoris?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, retirer',
                cancelButtonText: 'Annuler',
                confirmButtonColor: '#dc3545'
            });

            if (!result.isConfirmed) return;

            this.items = this.items.filter(i => i.id != itemId);
            this.saveWishlist();
            notyf.success('Retiré des favoris');

            // In real app, call API
            // await fetch(`/api/wishlist/${itemId}`, { method: 'DELETE' });
        },

        async clearAll() {
            const result = await Swal.fire({
                title: 'Vider la liste?',
                text: 'Voulez-vous vraiment vider votre liste de favoris?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, tout supprimer',
                cancelButtonText: 'Annuler',
                confirmButtonColor: '#dc3545'
            });

            if (!result.isConfirmed) return;

            this.items = [];
            localStorage.removeItem('wishlist');
            notyf.success('Liste vidée');
        },

        formatPrice(amount) {
            return parseFloat(amount).toFixed(2) + ' DT';
        },

        formatDate(date) {
            if (!date) return new Date().toLocaleDateString('fr-FR');
            return new Date(date).toLocaleDateString('fr-FR');
        }
    }
}

// Global function to add to wishlist from product pages
window.addToWishlist = function(product) {
    let wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');

    // Check if already in wishlist
    if (wishlist.find(item => item.id == product.id)) {
        notyf.error('Déjà dans vos favoris');
        return;
    }

    wishlist.push({
        ...product,
        added_at: new Date().toISOString(),
        adding: false
    });

    localStorage.setItem('wishlist', JSON.stringify(wishlist));
    notyf.success('Ajouté aux favoris !');

    // Update wishlist badge if exists
    const badge = document.getElementById('wishlist-count');
    if (badge) {
        badge.textContent = wishlist.length;
        badge.style.display = 'inline';
    }
};
</script>
@endpush
@endsection
