<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminCustomerGroupController;
use App\Http\Controllers\Admin\AdminCustomPriceController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminInvoiceController;
use App\Http\Controllers\Admin\AdminReturnController;
use App\Http\Controllers\Admin\AdminQuoteController;
use App\Http\Controllers\Admin\AdminCurrencyController;
use App\Http\Controllers\Admin\AdminIntegrationController;
use App\Http\Controllers\SuperAdmin\TenantController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\ExportController;
use Illuminate\Support\Facades\Route;

// Route pour servir les fichiers storage (nécessaire pour Laravel dev server)
Route::get('/storage/{path}', function ($path) {
    $file = storage_path('app/public/' . $path);

    if (!file_exists($file)) {
        abort(404);
    }

    $mimeType = mime_content_type($file);
    return response()->file($file, [
        'Content-Type' => $mimeType,
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('path', '.*');

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/forgot-password', [AuthController::class, 'showResetPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change-password');
    Route::post('/update-profile', [AuthController::class, 'updateProfile'])->name('update-profile');

    Route::get('/set-locale/{locale}', function ($locale) {
        if (in_array($locale, config('app.supported_locales'))) {
            session(['locale' => $locale]);
            if (auth()->check()) {
                auth()->user()->update(['preferred_language' => $locale]);
            }
        }
        return back();
    })->name('set-locale');
});

Route::middleware(['auth', 'check.role:vendeur'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');

    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/category/{category:slug}', [ProductController::class, 'category'])->name('category');
        Route::get('/search', [ProductController::class, 'search'])->name('search');
        Route::get('/{product:sku}', [ProductController::class, 'show'])->name('show');
    });

    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::put('/update/{itemId}', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{itemId}', [CartController::class, 'remove'])->name('remove');
        Route::post('/clear', [CartController::class, 'clear'])->name('clear');
        Route::get('/count', [CartController::class, 'getCount'])->name('count');
        Route::post('/apply-discount', [CartController::class, 'applyDiscount'])->name('apply-discount');
        Route::post('/remove-discount', [CartController::class, 'removeDiscount'])->name('remove-discount');
    });

    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
        Route::get('/{order:order_number}', [OrderController::class, 'show'])->name('show');
    });

    Route::prefix('wishlist')->name('wishlist.')->group(function () {
        Route::get('/', [WishlistController::class, 'index'])->name('index');
        Route::post('/add', [WishlistController::class, 'add'])->name('add');
        Route::delete('/remove/{itemId}', [WishlistController::class, 'remove'])->name('remove');
        Route::post('/move-to-cart/{itemId}', [WishlistController::class, 'moveToCart'])->name('move-to-cart');
        Route::post('/clear', [WishlistController::class, 'clear'])->name('clear');
        Route::get('/count', [WishlistController::class, 'getCount'])->name('count');
    });

    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::post('/send', [MessageController::class, 'send'])->name('send');
        Route::post('/mark-read/{message}', [MessageController::class, 'markRead'])->name('mark-read');
        Route::get('/unread-count', [MessageController::class, 'unreadCount'])->name('unread-count');
    });

    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('mark-read');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
        Route::delete('/read/all', [NotificationController::class, 'deleteRead'])->name('delete-read');
        Route::get('/api/unread-count', [NotificationController::class, 'unreadCount'])->name('api.unread-count');
        Route::get('/api/recent', [NotificationController::class, 'recent'])->name('api.recent');
    });

    Route::prefix('addresses')->name('addresses.')->group(function () {
        Route::get('/', [AddressController::class, 'index'])->name('index');
        Route::get('/create', [AddressController::class, 'create'])->name('create');
        Route::post('/', [AddressController::class, 'store'])->name('store');
        Route::get('/{address}/edit', [AddressController::class, 'edit'])->name('edit');
        Route::put('/{address}', [AddressController::class, 'update'])->name('update');
        Route::delete('/{address}', [AddressController::class, 'destroy'])->name('destroy');
        Route::post('/{address}/set-default', [AddressController::class, 'setDefault'])->name('set-default');
    });

    Route::prefix('returns')->name('returns.')->group(function () {
        Route::get('/', [ReturnController::class, 'index'])->name('index');
        Route::get('/create', [ReturnController::class, 'create'])->name('create');
        Route::post('/', [ReturnController::class, 'store'])->name('store');
        Route::get('/{return}', [ReturnController::class, 'show'])->name('show');
        Route::delete('/{return}', [ReturnController::class, 'destroy'])->name('destroy');
        Route::get('/order/{order}/items', [ReturnController::class, 'getOrderItems'])->name('order.items');
    });

    // Routes pour les devis (Vendeurs)
    Route::prefix('quotes')->name('quotes.')->group(function () {
        Route::get('/', [QuoteController::class, 'index'])->name('index');
        Route::get('/create', [QuoteController::class, 'create'])->name('create');
        Route::post('/', [QuoteController::class, 'store'])->name('store');
        Route::get('/{quote}', [QuoteController::class, 'show'])->name('show');
        Route::get('/{quote}/pdf', [QuoteController::class, 'downloadPdf'])->name('pdf');
        Route::post('/{quote}/send', [QuoteController::class, 'send'])->name('send');
        Route::post('/{quote}/accept', [QuoteController::class, 'accept'])->name('accept');
        Route::post('/{quote}/reject', [QuoteController::class, 'reject'])->name('reject');
        Route::post('/{quote}/convert', [QuoteController::class, 'convertToOrder'])->name('convert');
    });
});

Route::middleware(['auth', 'check.role:grossiste'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::get('/create', [AdminUserController::class, 'create'])->name('create');
        Route::post('/', [AdminUserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [AdminUserController::class, 'update'])->name('update');
        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
        Route::post('/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('toggle-status');
    });

    Route::prefix('groups')->name('groups.')->group(function () {
        Route::get('/', [AdminCustomerGroupController::class, 'index'])->name('index');
        Route::get('/create', [AdminCustomerGroupController::class, 'create'])->name('create');
        Route::post('/', [AdminCustomerGroupController::class, 'store'])->name('store');
        Route::get('/{group}', [AdminCustomerGroupController::class, 'show'])->name('show');
        Route::get('/{group}/edit', [AdminCustomerGroupController::class, 'edit'])->name('edit');
        Route::put('/{group}', [AdminCustomerGroupController::class, 'update'])->name('update');
        Route::delete('/{group}', [AdminCustomerGroupController::class, 'destroy'])->name('destroy');
        Route::post('/{group}/toggle-status', [AdminCustomerGroupController::class, 'toggleStatus'])->name('toggle-status');
    });

    Route::prefix('custom-prices')->name('custom-prices.')->group(function () {
        Route::get('/', [AdminCustomPriceController::class, 'index'])->name('index');
        Route::get('/create', [AdminCustomPriceController::class, 'create'])->name('create');
        Route::post('/', [AdminCustomPriceController::class, 'store'])->name('store');
        Route::get('/{customPrice}', [AdminCustomPriceController::class, 'show'])->name('show');
        Route::get('/{customPrice}/edit', [AdminCustomPriceController::class, 'edit'])->name('edit');
        Route::put('/{customPrice}', [AdminCustomPriceController::class, 'update'])->name('update');
        Route::delete('/{customPrice}', [AdminCustomPriceController::class, 'destroy'])->name('destroy');
        Route::post('/{customPrice}/toggle-status', [AdminCustomPriceController::class, 'toggleStatus'])->name('toggle-status');
    });

    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [AdminProductController::class, 'index'])->name('index');
        Route::get('/create', [AdminProductController::class, 'create'])->name('create');
        Route::post('/', [AdminProductController::class, 'store'])->name('store');
        Route::get('/test', function() { return view('admin.products.test'); })->name('test');
        Route::get('/{product}/test-images', function(\App\Models\Product $product) {
            // Charger explicitement les images sans filtre tenant
            $images = \App\Models\ProductImage::where('product_id', $product->id)->get();
            return view('admin.products.test-images', compact('product', 'images'));
        })->name('test-images');
        Route::get('/{product}/edit', [AdminProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [AdminProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [AdminProductController::class, 'destroy'])->name('destroy');
        Route::post('/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{product}/update-stock', [AdminProductController::class, 'updateStock'])->name('update-stock');

        // Gestion des images
        Route::delete('/{product}/images/{image}', [AdminProductController::class, 'deleteImage'])->name('delete-image');
        Route::post('/{product}/images/{image}/set-cover', [AdminProductController::class, 'setCoverImage'])->name('set-cover');
    });

    Route::resource('categories', \App\Http\Controllers\Admin\AdminCategoryController::class);
    Route::resource('attributes', \App\Http\Controllers\Admin\AdminAttributeController::class);

    // Gestion des valeurs d'attributs
    Route::post('attributes/{attribute}/values', [\App\Http\Controllers\Admin\AdminAttributeController::class, 'addValue'])->name('attributes.values.add');
    Route::delete('attributes/{attribute}/values/{value}', [\App\Http\Controllers\Admin\AdminAttributeController::class, 'deleteValue'])->name('attributes.values.delete');

    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/{order:order_number}', [AdminOrderController::class, 'show'])->name('show');
        Route::post('/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('update-status');
        Route::post('/{order}/add-notes', [AdminOrderController::class, 'addNotes'])->name('add-notes');
    });

    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::get('/', [AdminInvoiceController::class, 'index'])->name('index');
        Route::get('/export/csv', [AdminInvoiceController::class, 'export'])->name('export');
        Route::get('/{invoice}', [AdminInvoiceController::class, 'show'])->name('show');
        Route::get('/{invoice}/pdf', [AdminInvoiceController::class, 'streamPDF'])->name('pdf');
        Route::get('/{invoice}/download', [AdminInvoiceController::class, 'downloadPDF'])->name('download');
        Route::post('/generate-from-order/{order}', [AdminInvoiceController::class, 'generateFromOrder'])->name('generate-from-order');
        Route::post('/{invoice}/update-status', [AdminInvoiceController::class, 'updateStatus'])->name('update-status');
        Route::post('/{invoice}/mark-sent', [AdminInvoiceController::class, 'markAsSent'])->name('mark-sent');
        Route::post('/{invoice}/mark-paid', [AdminInvoiceController::class, 'markAsPaid'])->name('mark-paid');
    });

    Route::prefix('returns')->name('returns.')->group(function () {
        Route::get('/', [AdminReturnController::class, 'index'])->name('index');
        Route::get('/{return}', [AdminReturnController::class, 'show'])->name('show');
        Route::post('/{return}/approve', [AdminReturnController::class, 'approve'])->name('approve');
        Route::post('/{return}/reject', [AdminReturnController::class, 'reject'])->name('reject');
        Route::post('/{return}/update-status', [AdminReturnController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{return}', [AdminReturnController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-action', [AdminReturnController::class, 'bulkAction'])->name('bulk-action');
        Route::get('/export', [AdminReturnController::class, 'export'])->name('export');
    });

    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessageController::class, 'adminIndex'])->name('index');
        Route::get('/conversation/{user}', [MessageController::class, 'conversation'])->name('conversation');
        Route::post('/send', [MessageController::class, 'adminSend'])->name('send');
    });

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminReportController::class, 'index'])->name('index');
        Route::get('/sales', [\App\Http\Controllers\Admin\AdminReportController::class, 'sales'])->name('sales');
        Route::get('/inventory', [\App\Http\Controllers\Admin\AdminReportController::class, 'inventory'])->name('inventory');
        Route::get('/customers', [\App\Http\Controllers\Admin\AdminReportController::class, 'customers'])->name('customers');
        Route::get('/export/{type}', [\App\Http\Controllers\Admin\AdminReportController::class, 'export'])->name('export');
    });

    // Routes pour la gestion des devis (Admin/Grossiste)
    Route::prefix('quotes')->name('quotes.')->group(function () {
        Route::get('/', [AdminQuoteController::class, 'index'])->name('index');
        Route::get('/create', [AdminQuoteController::class, 'create'])->name('create');
        Route::post('/', [AdminQuoteController::class, 'store'])->name('store');
        Route::get('/{quote}', [AdminQuoteController::class, 'show'])->name('show');
        Route::get('/{quote}/edit', [AdminQuoteController::class, 'edit'])->name('edit');
        Route::put('/{quote}', [AdminQuoteController::class, 'update'])->name('update');
        Route::delete('/{quote}', [AdminQuoteController::class, 'destroy'])->name('destroy');
        Route::get('/{quote}/pdf', [AdminQuoteController::class, 'downloadPdf'])->name('pdf');
        Route::post('/{quote}/send', [AdminQuoteController::class, 'send'])->name('send');
        Route::post('/{quote}/accept', [AdminQuoteController::class, 'accept'])->name('accept');
        Route::post('/{quote}/reject', [AdminQuoteController::class, 'reject'])->name('reject');
        Route::post('/{quote}/convert', [AdminQuoteController::class, 'convertToOrder'])->name('convert');
        Route::get('/{quote}/duplicate', [AdminQuoteController::class, 'duplicate'])->name('duplicate');
        Route::post('/{quote}/approve', [AdminQuoteController::class, 'approve'])->name('approve');
        Route::get('/export/csv', [AdminQuoteController::class, 'export'])->name('export');
        Route::post('/bulk-action', [AdminQuoteController::class, 'bulkAction'])->name('bulk-action');
    });

    // Routes pour la gestion des devises
    Route::prefix('currencies')->name('currencies.')->group(function () {
        Route::get('/', [AdminCurrencyController::class, 'index'])->name('index');
        Route::get('/create', [AdminCurrencyController::class, 'create'])->name('create');
        Route::post('/', [AdminCurrencyController::class, 'store'])->name('store');
        Route::get('/{currency}', [AdminCurrencyController::class, 'show'])->name('show');
        Route::get('/{currency}/edit', [AdminCurrencyController::class, 'edit'])->name('edit');
        Route::put('/{currency}', [AdminCurrencyController::class, 'update'])->name('update');
        Route::delete('/{currency}', [AdminCurrencyController::class, 'destroy'])->name('destroy');
        Route::post('/{currency}/set-default', [AdminCurrencyController::class, 'setDefault'])->name('set-default');
        Route::post('/{currency}/toggle-active', [AdminCurrencyController::class, 'toggleActive'])->name('toggle-active');
    });

    // Routes pour les taux de change
    Route::prefix('exchange-rates')->name('exchange-rates.')->group(function () {
        Route::get('/', [AdminCurrencyController::class, 'rates'])->name('index');
        Route::post('/update', [AdminCurrencyController::class, 'updateRates'])->name('update');
        Route::post('/fetch', [AdminCurrencyController::class, 'fetchRates'])->name('fetch');
        Route::get('/api/get-rate', [AdminCurrencyController::class, 'getRate'])->name('get-rate');
        Route::post('/api/convert', [AdminCurrencyController::class, 'convert'])->name('convert');
    });

    // Routes pour les intégrations ERP/Comptabilité
    Route::prefix('integrations')->name('integrations.')->group(function () {
        Route::get('/', [AdminIntegrationController::class, 'index'])->name('index');
        Route::get('/create', [AdminIntegrationController::class, 'create'])->name('create');
        Route::post('/', [AdminIntegrationController::class, 'store'])->name('store');
        Route::get('/{integration}', [AdminIntegrationController::class, 'show'])->name('show');
        Route::get('/{integration}/edit', [AdminIntegrationController::class, 'edit'])->name('edit');
        Route::put('/{integration}', [AdminIntegrationController::class, 'update'])->name('update');
        Route::delete('/{integration}', [AdminIntegrationController::class, 'destroy'])->name('destroy');
        Route::post('/{integration}/toggle', [AdminIntegrationController::class, 'toggleStatus'])->name('toggle');
        Route::post('/{integration}/test', [AdminIntegrationController::class, 'testConnection'])->name('test');
        Route::post('/{integration}/sync', [AdminIntegrationController::class, 'sync'])->name('sync');
        Route::get('/{integration}/logs', [AdminIntegrationController::class, 'logs'])->name('logs');
    });
});

// Routes Super-Admin (accès plateforme multi-tenant)
Route::middleware(['auth', 'superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    // Dashboard principal
    Route::get('/', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [SuperAdminDashboardController::class, 'analytics'])->name('analytics');

    // Gestion des tenants
    Route::resource('tenants', TenantController::class);

    // Actions spéciales pour les tenants
    Route::patch('tenants/{tenant}/suspend', [TenantController::class, 'suspend'])->name('tenants.suspend');
    Route::patch('tenants/{tenant}/activate', [TenantController::class, 'activate'])->name('tenants.activate');
    Route::patch('tenants/{id}/restore', [TenantController::class, 'restore'])->name('tenants.restore');

    // Exports et rapports
    Route::prefix('export')->name('export.')->group(function () {
        Route::get('tenants', [ExportController::class, 'tenants'])->name('tenants');
        Route::get('tenants/{tenant}', [ExportController::class, 'tenantDetails'])->name('tenant.details');
        Route::get('analytics', [ExportController::class, 'analytics'])->name('analytics');
        Route::get('financial', [ExportController::class, 'financialReport'])->name('financial');
    });
});