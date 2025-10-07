/**
 * B2B Platform - Main JavaScript
 * Framework: Alpine.js 3.x
 * Features: Reactive UI, Animations, Real-time updates
 */

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import collapse from '@alpinejs/collapse';
import axios from 'axios';
import Swal from 'sweetalert2';
import { Notyf } from 'notyf';
import 'notyf/notyf.min.css';

// Initialize Alpine plugins
Alpine.plugin(focus);
Alpine.plugin(collapse);

// Make Alpine and libraries available globally
window.Alpine = Alpine;
window.axios = axios;
window.Swal = Swal;

// Initialize Notyf for toast notifications
window.notyf = new Notyf({
    duration: 3000,
    position: { x: 'right', y: 'top' },
    dismissible: true,
    ripple: true,
});

// Configure Axios defaults
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

// ======================
// Alpine.js Components
// ======================

// Shopping Cart Component
Alpine.data('cartManager', () => ({
    items: [],
    count: 0,
    total: 0,
    loading: false,

    init() {
        this.loadCart();
        this.$watch('items', () => this.updateCount());
    },

    loadCart() {
        const cart = JSON.parse(localStorage.getItem('cart') || '{}');
        this.items = Object.entries(cart).map(([id, qty]) => ({ id, qty }));
    },

    updateCount() {
        this.count = this.items.reduce((sum, item) => sum + item.qty, 0);
        this.updateBadge();
    },

    updateBadge() {
        const badge = document.getElementById('cart-count');
        if (badge) {
            badge.textContent = this.count;
            badge.style.display = this.count > 0 ? 'inline' : 'none';
        }
    },

    async addItem(productId, quantity = 1) {
        this.loading = true;
        try {
            const response = await axios.post('/cart/add', {
                product_id: productId,
                quantity: quantity
            });

            if (response.data.success) {
                this.loadCart();
                window.notyf.success('Produit ajouté au panier !');
                this.animateCartIcon();
            }
        } catch (error) {
            window.notyf.error('Erreur lors de l\'ajout au panier');
            console.error(error);
        } finally {
            this.loading = false;
        }
    },

    async removeItem(productId) {
        const result = await Swal.fire({
            title: 'Confirmer la suppression ?',
            text: 'Voulez-vous retirer cet article du panier ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler',
            confirmButtonColor: '#dc3545',
        });

        if (result.isConfirmed) {
            try {
                await axios.post('/cart/remove', { product_id: productId });
                this.loadCart();
                window.notyf.success('Produit retiré du panier');
            } catch (error) {
                window.notyf.error('Erreur lors de la suppression');
            }
        }
    },

    async updateQuantity(productId, quantity) {
        if (quantity < 1) {
            this.removeItem(productId);
            return;
        }

        try {
            await axios.post('/cart/update', {
                product_id: productId,
                quantity: quantity
            });
            this.loadCart();
        } catch (error) {
            window.notyf.error('Erreur lors de la mise à jour');
        }
    },

    animateCartIcon() {
        const cartIcon = document.querySelector('.cart-icon');
        if (cartIcon) {
            cartIcon.classList.add('animate__animated', 'animate__bounce');
            setTimeout(() => {
                cartIcon.classList.remove('animate__animated', 'animate__bounce');
            }, 1000);
        }
    }
}));

// Product Catalog Component
Alpine.data('productCatalog', () => ({
    products: [],
    filteredProducts: [],
    search: '',
    category: '',
    sortBy: 'name',
    loading: true,
    viewMode: 'grid', // grid or list

    init() {
        this.loadProducts();
        this.$watch('search', () => this.filterProducts());
        this.$watch('category', () => this.filterProducts());
        this.$watch('sortBy', () => this.sortProducts());
    },

    async loadProducts() {
        try {
            const response = await axios.get('/api/products');
            this.products = response.data;
            this.filteredProducts = [...this.products];
            this.loading = false;
        } catch (error) {
            console.error('Error loading products:', error);
            this.loading = false;
        }
    },

    filterProducts() {
        let filtered = [...this.products];

        // Filter by search
        if (this.search) {
            const searchLower = this.search.toLowerCase();
            filtered = filtered.filter(p =>
                p.name.toLowerCase().includes(searchLower) ||
                p.description?.toLowerCase().includes(searchLower)
            );
        }

        // Filter by category
        if (this.category) {
            filtered = filtered.filter(p => p.category_id == this.category);
        }

        this.filteredProducts = filtered;
        this.sortProducts();
    },

    sortProducts() {
        const sorted = [...this.filteredProducts];

        switch(this.sortBy) {
            case 'name':
                sorted.sort((a, b) => a.name.localeCompare(b.name));
                break;
            case 'price_asc':
                sorted.sort((a, b) => a.price - b.price);
                break;
            case 'price_desc':
                sorted.sort((a, b) => b.price - a.price);
                break;
        }

        this.filteredProducts = sorted;
    },

    toggleView() {
        this.viewMode = this.viewMode === 'grid' ? 'list' : 'grid';
    }
}));

// Messages Component
Alpine.data('messagesManager', () => ({
    unreadCount: 0,
    messages: [],
    newMessage: '',
    sending: false,

    init() {
        this.updateUnreadCount();
        setInterval(() => this.updateUnreadCount(), 30000); // Every 30s
    },

    async updateUnreadCount() {
        try {
            const response = await axios.get('/messages/unread-count');
            this.unreadCount = response.data.count;
            this.updateBadge();
        } catch (error) {
            console.error('Error updating message count:', error);
        }
    },

    updateBadge() {
        const badge = document.getElementById('message-count');
        if (badge) {
            badge.textContent = this.unreadCount;
            badge.style.display = this.unreadCount > 0 ? 'inline' : 'none';
        }
    },

    async sendMessage(recipientId) {
        if (!this.newMessage.trim()) return;

        this.sending = true;
        try {
            await axios.post('/messages/send', {
                recipient_id: recipientId,
                message: this.newMessage
            });

            this.newMessage = '';
            window.notyf.success('Message envoyé !');
            this.updateUnreadCount();
        } catch (error) {
            window.notyf.error('Erreur lors de l\'envoi');
        } finally {
            this.sending = false;
        }
    }
}));

// Form Validation Component
Alpine.data('formValidator', (rules = {}) => ({
    errors: {},
    submitting: false,

    validateField(field, value) {
        const fieldRules = rules[field];
        if (!fieldRules) return true;

        // Required
        if (fieldRules.required && !value) {
            this.errors[field] = 'Ce champ est requis';
            return false;
        }

        // Email
        if (fieldRules.email && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                this.errors[field] = 'Email invalide';
                return false;
            }
        }

        // Min length
        if (fieldRules.min && value.length < fieldRules.min) {
            this.errors[field] = `Minimum ${fieldRules.min} caractères`;
            return false;
        }

        // Max length
        if (fieldRules.max && value.length > fieldRules.max) {
            this.errors[field] = `Maximum ${fieldRules.max} caractères`;
            return false;
        }

        delete this.errors[field];
        return true;
    },

    async submitForm(callback) {
        this.submitting = true;
        try {
            await callback();
            this.errors = {};
        } catch (error) {
            if (error.response?.data?.errors) {
                this.errors = error.response.data.errors;
            }
        } finally {
            this.submitting = false;
        }
    }
}));

// Sidebar Toggle Component
Alpine.data('sidebar', () => ({
    open: false,

    toggle() {
        this.open = !this.open;
    },

    close() {
        this.open = false;
    }
}));

// Search Component with Debounce
Alpine.data('searchBox', (delay = 300) => ({
    query: '',
    results: [],
    searching: false,
    timeout: null,

    search() {
        clearTimeout(this.timeout);

        if (!this.query.trim()) {
            this.results = [];
            return;
        }

        this.timeout = setTimeout(async () => {
            this.searching = true;
            try {
                const response = await axios.get('/products/search', {
                    params: { q: this.query }
                });
                this.results = response.data;
            } catch (error) {
                console.error('Search error:', error);
            } finally {
                this.searching = false;
            }
        }, delay);
    }
}));

// Start Alpine
Alpine.start();

// Export for use in other modules
export { Alpine, axios, Swal };
