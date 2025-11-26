<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

// === PUBLIC ROUTES - WOTE WANAWEZA KUFIKIA BILA LOGIN ===

// Home route - Public access
Route::get('/', [HomeController::class, 'index'])->name('home');

// === PUBLIC PRODUCT ROUTES - BIDHAA ZOTE ZIWE PUBLIC ===
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/category/{categorySlug}', [ProductController::class, 'byCategory'])->name('products.byCategory');
Route::get('/products/featured', [ProductController::class, 'featured'])->name('products.featured');
Route::get('/search', [ProductController::class, 'search'])->name('products.search');

// === PUBLIC CUSTOMER ROUTES - CUSTOMER AWEZE KUFIKIA BILA LOGIN ===
Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
Route::get('/customer/shop', [CustomerController::class, 'shop'])->name('customer.shop');
Route::get('/customer/profile', [CustomerController::class, 'profile'])->name('customer.profile');
Route::get('/customer/orders', [CustomerController::class, 'orders'])->name('customer.orders');
Route::get('/customer/orders/{id}', [CustomerController::class, 'showOrder'])->name('customer.orders.show');
Route::get('/customer/cart', [CustomerController::class, 'viewCart'])->name('customer.cart');
Route::get('/customer/checkout', [CustomerController::class, 'checkout'])->name('customer.checkout'); // GUEST FRIENDLY
Route::get('/customer/settings', [CustomerController::class, 'settings'])->name('customer.settings');
Route::get('/customer/account', [CustomerController::class, 'account'])->name('customer.account');
Route::get('/customer/conversations', [CustomerController::class, 'conversations'])->name('customer.conversations');
Route::get('/customer/favorites', [CustomerController::class, 'favorites'])->name('customer.favorites');

// === PUBLIC CUSTOMER ACTION ROUTES - GUEST FRIENDLY ===
Route::post('/customer/cart/add', [CustomerController::class, 'addToCart'])->name('customer.cart.add');
Route::put('/customer/cart/update', [CustomerController::class, 'updateCart'])->name('customer.cart.update');
Route::delete('/customer/cart/remove', [CustomerController::class, 'removeFromCart'])->name('customer.cart.remove');
Route::post('/customer/checkout/place-order', [CustomerController::class, 'placeOrder'])->name('customer.checkout.place'); // GUEST FRIENDLY
Route::post('/customer/guest-checkout-registration', [CustomerController::class, 'guestCheckoutRegistration'])->name('customer.guest.checkout.registration');

// === PUBLIC CUSTOMER API ROUTES ===
Route::prefix('customer/api')->group(function () {
    Route::get('/orders/{id}/view', [CustomerController::class, 'viewOrder'])->name('customer.api.orders.view');
    Route::get('/orders/{id}/track', [CustomerController::class, 'trackOrder'])->name('customer.api.orders.track');
    Route::get('/orders/{id}/download-receipt', [CustomerController::class, 'downloadReceipt'])->name('customer.api.receipts.download');
    Route::get('/orders/{id}/print-receipt', [CustomerController::class, 'printReceipt'])->name('customer.api.receipts.print');
    Route::get('/conversations', [CustomerController::class, 'getSellerConversations'])->name('customer.api.conversations');
    Route::post('/conversations/start', [CustomerController::class, 'startConversation'])->name('customer.api.conversations.start');
    Route::post('/messages/send', [CustomerController::class, 'sendMessageToSeller'])->name('customer.api.messages.send');

    // === NEW ROUTE FOR MESSAGING FROM PRODUCT PAGE ===
    Route::post('/messages/send-from-product', [CustomerController::class, 'sendMessageFromProduct'])->name('customer.api.messages.send.from.product');

    Route::get('/notifications', [CustomerController::class, 'getNotifications'])->name('customer.api.notifications');
    Route::post('/notifications/{id}/read', [CustomerController::class, 'markNotificationAsRead'])->name('customer.api.notifications.read');
    Route::get('/dashboard/stats', [CustomerController::class, 'getDashboardStats'])->name('customer.api.dashboard.stats');
});

// === PROTECTED CUSTOMER ROUTES (REQUIRE LOGIN) ===
Route::middleware(['auth'])->group(function () {
    Route::post('/customer/profile/update', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');
    Route::post('/customer/settings/update', [CustomerController::class, 'updateSettings'])->name('customer.settings.update');
    Route::post('/customer/account/update', [CustomerController::class, 'updateAccount'])->name('customer.account.update');
    Route::post('/customer/favorites/add/{productId}', [CustomerController::class, 'addToFavorites'])->name('customer.favorites.add');
    Route::delete('/customer/favorites/remove/{productId}', [CustomerController::class, 'removeFromFavorites'])->name('customer.favorites.remove');
});

// === PUBLIC SELLER STORE ROUTES - MADUKA YA WAUZAJI YAWE PUBLIC ===
Route::get('/store/{seller_slug}', [SellerController::class, 'publicStore'])->name('seller.public.store');
Route::get('/store/{seller_slug}/products', [SellerController::class, 'storeProducts'])->name('seller.store.products');

// === PUBLIC AJAX ROUTES ===
Route::post('/products/filter', [ProductController::class, 'filter'])->name('products.filter');
Route::get('/products/search/live', [ProductController::class, 'liveSearch'])->name('products.search.live');

// === PUBLIC MESSAGING ROUTES ===
Route::post('/contact-seller', [CustomerController::class, 'contactSellerFromProduct'])->name('contact.seller.from.product');

// === AUTHENTICATION ROUTES - PUBLIC ===
Route::get('/join', [AuthController::class, 'choose'])->name('choose');

// Customer Authentication (optional - kwa wale watakaokua na account)
Route::prefix('customer')->group(function () {
    Route::get('/sign-in', [AuthController::class, 'customerLogin'])->name('login.customer');
    Route::get('/sign-up', [AuthController::class, 'customerRegister'])->name('register.customer');
    Route::post('/sign-in', [AuthController::class, 'processCustomerLogin'])->name('customer.authenticate');
    Route::post('/sign-up', [AuthController::class, 'processCustomerRegistration'])->name('customer.register');
});

// Seller Authentication (REQUIRED - seller anahitaji kujiandikisha)
Route::prefix('seller')->group(function () {
    Route::get('/sign-in', [AuthController::class, 'sellerLogin'])->name('login.seller');
    Route::get('/sign-up', [AuthController::class, 'sellerRegister'])->name('register.seller');
    Route::post('/sign-in', [AuthController::class, 'processSellerLogin'])->name('seller.authenticate');
    Route::post('/sign-up', [AuthController::class, 'processSellerRegistration'])->name('seller.register');
});

// Store intended URL for guest checkout
Route::post('/store-intended-url', [AuthController::class, 'storeIntendedUrl'])->name('store.intended.url');

// === PROTECTED ROUTES - SELLER ROUTES ONLY ZINAHITAJI LOGIN ===

// Common Logout Route (kwa wale wanaokuwa na account)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password reset routes
Route::post('/customer/forgot-password', [AuthController::class, 'sendPasswordResetLink'])->name('customer.password.email');

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

    // === PROFILE ROUTES - ZOTE ZINAHITAJI LOGIN ===
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

    // === SELLER ROUTES ONLY - WAUZAJI WANAWEZA KUFIKIA BAADA YA LOGIN ===
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

        // Sales orders routes (orders za wateja)
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

        // Settings and Account
        Route::get('/settings', [SellerController::class, 'settings'])->name('seller.settings');
        Route::post('/settings/update', [SellerController::class, 'updateSettings'])->name('seller.settings.update');
        Route::get('/account', [SellerController::class, 'account'])->name('seller.account');
        Route::post('/account/update', [SellerController::class, 'updateAccount'])->name('seller.account.update');

        // AJAX API Routes
        Route::prefix('api')->group(function () {
            Route::get('/dashboard/stats', [SellerController::class, 'getDashboardStats'])->name('seller.api.dashboard.stats');
        });
    });
});

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

// API Routes for regions
Route::get('/api/regions', [HomeController::class, 'getRegions'])->name('api.regions');