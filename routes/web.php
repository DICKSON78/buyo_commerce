<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

// Home route - Public access
Route::get('/', [HomeController::class, 'index'])->name('home');

// === PUBLIC PRODUCT ROUTES ===
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/category/{categorySlug}', [ProductController::class, 'byCategory'])->name('products.byCategory');
Route::get('/products/featured', [ProductController::class, 'featured'])->name('products.featured');
Route::get('/search', [ProductController::class, 'search'])->name('products.search');

// === NEW AJAX FILTER ROUTE ===
Route::post('/products/filter', [ProductController::class, 'filter'])->name('products.filter');

// === AUTHENTICATION ROUTES ===
Route::get('/join', [AuthController::class, 'choose'])->name('choose');

// Customer Authentication
Route::prefix('customer')->group(function () {
    Route::get('/sign-in', [AuthController::class, 'customerLogin'])->name('login.customer');
    Route::get('/sign-up', [AuthController::class, 'customerRegister'])->name('register.customer');
    Route::post('/sign-in', [AuthController::class, 'processCustomerLogin'])->name('customer.authenticate');
    Route::post('/sign-up', [AuthController::class, 'processCustomerRegistration'])->name('customer.register');
});

// Seller Authentication
Route::prefix('seller')->group(function () {
    Route::get('/sign-in', [AuthController::class, 'sellerLogin'])->name('login.seller');
    Route::get('/sign-up', [AuthController::class, 'sellerRegister'])->name('register.seller');
    Route::post('/sign-in', [AuthController::class, 'processSellerLogin'])->name('seller.authenticate');
    Route::post('/sign-up', [AuthController::class, 'processSellerRegistration'])->name('seller.register');
});

// Common Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password reset routes
Route::post('/customer/forgot-password', [AuthController::class, 'sendPasswordResetLink'])->name('customer.password.email');

// === PROFILE ROUTES ===
Route::prefix('profile')->name('profile.')->group(function () {
    // Customer Profile
    Route::get('/customer', [ProfileController::class, 'customerProfile'])->name('customer');
    Route::put('/customer', [ProfileController::class, 'updateCustomerProfile'])->name('customer.update');
    
    // Seller Profile
    Route::get('/seller', [ProfileController::class, 'sellerProfile'])->name('seller');
    Route::put('/seller', [ProfileController::class, 'updateSellerProfile'])->name('seller.update');
    
    // Common Profile Actions
    Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('change-password');
    Route::delete('/picture', [ProfileController::class, 'deleteProfilePicture'])->name('delete-picture');
    Route::get('/completion', [ProfileController::class, 'getProfileCompletion'])->name('completion');
});

// === PROTECTED ROUTES ===
Route::middleware(['auth'])->group(function () {

    // === DASHBOARD SWITCHING ROUTES ===
    Route::get('/switch-to-seller', function () {
        $user = Auth::user();

        // Check if user has seller profile
        if (!$user->seller) {
            return redirect()->route('register.seller')
                ->with('error', 'Tafadhali jisajili kama muuzaji kwanza ili uweze kupost bidhaa zako.');
        }

        return redirect()->route('seller.dashboard')
            ->with('success', 'Umeingia kwenye seller dashboard! Sasa unaweza kuuza na kununua.');
    })->name('switch.to.seller');

    Route::get('/switch-to-customer', function () {
        return redirect()->route('customer.dashboard')
            ->with('success', 'Umeingia kwenye customer dashboard!');
    })->name('switch.to.customer');

    // === CUSTOMER ROUTES - WATEJA NA WAUZAJI WANAWEZA KUFIKIA ===
    Route::prefix('customer')->middleware(['customer'])->group(function () {
        // Dashboard & Main Pages
        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
        Route::get('/shop', [CustomerController::class, 'shop'])->name('customer.shop');
        Route::get('/profile', [CustomerController::class, 'profile'])->name('customer.profile');
        Route::post('/profile/update', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');
        
        // === NEW ROUTES FOR SEPARATE SETTINGS AND ACCOUNT ===
        Route::get('/settings', [CustomerController::class, 'settings'])->name('customer.settings');
        Route::get('/account', [CustomerController::class, 'account'])->name('customer.account');
        Route::post('/settings/update', [CustomerController::class, 'updateSettings'])->name('customer.settings.update');
        Route::post('/account/update', [CustomerController::class, 'updateAccount'])->name('customer.account.update');

        // Cart Routes
        Route::get('/cart', [CustomerController::class, 'viewCart'])->name('customer.cart');
        Route::post('/cart/add', [CustomerController::class, 'addToCart'])->name('customer.cart.add');
        Route::put('/cart/update', [CustomerController::class, 'updateCart'])->name('customer.cart.update');
        Route::delete('/cart/remove', [CustomerController::class, 'removeFromCart'])->name('customer.cart.remove');

        // Checkout & Orders
        Route::get('/checkout', [CustomerController::class, 'checkout'])->name('customer.checkout');
        Route::post('/checkout/place-order', [CustomerController::class, 'placeOrder'])->name('customer.checkout.place');
        Route::get('/orders', [CustomerController::class, 'orderHistory'])->name('customer.orders');
        Route::get('/orders/{id}', [CustomerController::class, 'showOrder'])->name('customer.orders.show');

        // AJAX API Routes
        Route::prefix('api')->group(function () {
            Route::get('/orders/{id}/view', [CustomerController::class, 'viewOrder'])->name('customer.api.orders.view');
            Route::get('/orders/{id}/track', [CustomerController::class, 'trackOrder'])->name('customer.api.orders.track');
            Route::get('/orders/{id}/download-receipt', [CustomerController::class, 'downloadReceipt'])->name('customer.api.receipts.download');
            Route::get('/orders/{id}/print-receipt', [CustomerController::class, 'printReceipt'])->name('customer.api.receipts.print');
            Route::get('/conversations', [CustomerController::class, 'getSellerConversations'])->name('customer.api.conversations');
            Route::post('/conversations/start', [CustomerController::class, 'startConversation'])->name('customer.api.conversations.start');
            Route::post('/messages/send', [CustomerController::class, 'sendMessageToSeller'])->name('customer.api.messages.send');
            Route::get('/notifications', [CustomerController::class, 'getNotifications'])->name('customer.api.notifications');
            Route::post('/notifications/{id}/read', [CustomerController::class, 'markNotificationAsRead'])->name('customer.api.notifications.read');
            Route::get('/dashboard/stats', [CustomerController::class, 'getDashboardStats'])->name('customer.api.dashboard.stats');
        });
    });

    // === SELLER ROUTES - WATEJA NA WAUZAJI WANAWEZA KUFIKIA ===
    Route::prefix('seller')->middleware(['seller'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');

        // Products Management
        Route::get('/products/create', [SellerController::class, 'createProduct'])->name('seller.products.create');
        Route::post('/products', [SellerController::class, 'storeProduct'])->name('seller.products.store');
        Route::get('/products', [SellerController::class, 'products'])->name('seller.products');
        Route::get('/products/{id}/edit', [SellerController::class, 'editProduct'])->name('seller.products.edit');
        Route::put('/products/{id}', [SellerController::class, 'updateProduct'])->name('seller.products.update');
        Route::delete('/products/{id}', [SellerController::class, 'deleteProduct'])->name('seller.products.delete');
        Route::get('/my-purchase-orders', [SellerController::class, 'myPurchaseOrders'])->name('seller.my-purchase-orders');
        Route::get('/my-purchase-orders/{id}', [SellerController::class, 'viewPurchaseOrder'])->name('seller.purchase-orders.show');
        
        // Existing sales orders routes
        Route::get('/orders', [SellerController::class, 'orders'])->name('seller.orders');
        Route::get('/orders/{id}', [SellerController::class, 'viewOrder'])->name('seller.orders.show');
        Route::put('/orders/{id}/status', [SellerController::class, 'updateOrderStatus'])->name('seller.orders.update-status');

        // Messages
        Route::get('/messages', [SellerController::class, 'messages'])->name('seller.messages');
        Route::get('/messages/{id}', [SellerController::class, 'viewConversation'])->name('seller.messages.show');
        Route::post('/messages/{id}/reply', [SellerController::class, 'sendReply'])->name('seller.messages.reply');

        // Profile & Analytics
        Route::get('/profile', [SellerController::class, 'profile'])->name('seller.profile');
        Route::post('/profile/update', [SellerController::class, 'updateProfile'])->name('seller.profile.update');
        Route::get('/analytics', [SellerController::class, 'analytics'])->name('seller.analytics');
        
        // === NEW ROUTES FOR SEPARATE SETTINGS AND ACCOUNT ===
        Route::get('/settings', [SellerController::class, 'settings'])->name('seller.settings');
        Route::get('/account', [SellerController::class, 'account'])->name('seller.account');
        Route::post('/settings/update', [SellerController::class, 'updateSettings'])->name('seller.settings.update');
        Route::post('/account/update', [SellerController::class, 'updateAccount'])->name('seller.account.update');

        // AJAX API Routes
        Route::prefix('api')->group(function () {
            Route::get('/dashboard/stats', [SellerController::class, 'getDashboardStats'])->name('seller.api.dashboard.stats');
        });
    });
});

// Public seller store routes
Route::get('/store/{seller_slug}', [SellerController::class, 'publicStore'])->name('seller.public.store');
Route::get('/store/{seller_slug}/products', [SellerController::class, 'storeProducts'])->name('seller.store.products');

// Legacy routes (redirects)
Route::get('/login', function () { return redirect()->route('choose'); });
Route::get('/register', function () { return redirect()->route('choose'); });
Route::get('/signin', function () { return redirect()->route('choose'); });
Route::get('/signup', function () { return redirect()->route('choose'); });

// API Routes for AJAX calls
Route::prefix('api')->group(function () {
    Route::get('/featured-products', [ProductController::class, 'getFeaturedProducts'])->name('api.featured.products');
    Route::get('/categories', [ProductController::class, 'getCategories'])->name('api.categories');
    Route::get('/regions', [HomeController::class, 'getRegions'])->name('api.regions');
    Route::get('/user/status', [AuthController::class, 'getUserStatus'])->name('api.user.status');
});

// Store intended URL for guest checkout
Route::post('/store-intended-url', [AuthController::class, 'storeIntendedUrl'])->name('store.intended.url');

// API Routes for regions
Route::get('/api/regions', [HomeController::class, 'getRegions'])->name('api.regions');