@extends('layouts.dashboards.seller')

@section('contents')
<style>
    /* === NAVIGATION SCROLL EFFECT STYLES === */
    .nav-scrolled {
        background: rgba(0, 128, 0, 0.85) !important;
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.1);
    }

    .nav-green {
        background: #008000;
        transition: all 0.3s ease;
    }

    .dark .nav-green {
        background: #0a5c0a;
    }

    .nav-scrolled.dark {
        background: rgba(10, 92, 10, 0.95) !important;
    }

    /* Mobile Tabs Styles */
    .mobile-tab {
        flex: 1;
        padding: 12px 8px;
        text-align: center;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
        background: white;
        color: #6b7280;
        font-size: 12px;
        min-width: 80px;
    }

    .dark .mobile-tab {
        background: #1f2937;
        color: #9ca3af;
    }

    .mobile-tab.active {
        border-bottom-color: #059669;
        color: #059669;
        background: #f0fdf4;
    }

    .dark .mobile-tab.active {
        background: #064e3b;
        color: #34d399;
    }

    .mobile-tab i {
        margin-bottom: 4px;
        font-size: 14px;
    }

    /* Scrollbar hiding for mobile */
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
</style>

<!-- Top Navigation Bar -->
<nav id="mainNav" class="fixed top-0 w-full nav-green shadow-sm z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-3 sm:px-6">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <div class="hidden sm:flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center">
                        <i class="fas fa-store text-green-600 dark:text-green-400 text-lg"></i>
                    </div>
                    <span class="text-white font-bold text-xl">Buyo Seller - {{ $seller->store_name }}</span>
                </div>
                <div class="sm:hidden w-10 h-10 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center">
                    <i class="fas fa-store text-green-600 dark:text-green-400 text-lg"></i>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="flex-1 max-w-xl mx-2 sm:mx-4">
                <form class="relative">
                    <input type="text" placeholder="Search products, orders..."
                           class="w-full pl-10 pr-4 py-2 rounded-full border-0 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm sm:text-base bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400">
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-500">
                        <i class="fas fa-search"></i>
                    </div>
                </form>
            </div>

            <!-- Navigation Icons -->
            <div class="flex items-center space-x-3 sm:space-x-4">
                <!-- Dark Mode Toggle -->
                <button id="themeToggle" class="text-white hover:text-yellow-300 transition-colors" title="Toggle Dark Mode">
                    <i class="fas fa-moon text-lg"></i>
                </button>

                <!-- Notifications -->
                <button class="text-white hover:text-yellow-300 transition-colors relative">
                    <i class="fas fa-bell text-lg"></i>
                    <span class="absolute -top-2 -right-2 bg-yellow-500 text-gray-900 dark:text-gray-100 text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">{{ $stats['pending_orders'] }}</span>
                </button>

                <!-- Messages -->
                <button class="text-white hover:text-yellow-300 transition-colors relative">
                    <i class="fas fa-comments text-lg"></i>
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">{{ $stats['unread_messages'] }}</span>
                </button>

                <!-- User Account Dropdown -->
                <div class="dropdown" id="accountDropdown">
                    <button onclick="toggleDropdown()" class="text-white hover:text-yellow-300 transition-colors relative" title="Account">
                        <i class="fas fa-user text-lg"></i>
                        <span class="absolute -top-2 -right-2 bg-yellow-500 text-gray-900 dark:text-gray-100 text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">{{ substr($user->full_name, 0, 2) }}</span>
                    </button>
                    <div class="dropdown-content">
                        <a href="{{ route('seller.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Seller Dashboard</a>
                        <a href="{{ route('customer.dashboard') }}"><i class="fas fa-user-circle"></i> Customer Dashboard</a>
                        <a href="{{ route('seller.profile') }}"><i class="fas fa-cog"></i> Settings</a>
                        <a href="#" class="text-red-600 dark:text-red-400"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Product Creation Modal -->
<div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-2xl mx-auto shadow-xl">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-3">
                <button onclick="closeProductModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <i class="fas fa-arrow-left text-xl"></i>
                </button>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Create New Product</h2>
            </div>
            <button onclick="closeProductModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Progress Steps -->
        <div class="px-6 pt-4">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white font-bold text-sm">1</div>
                    <span class="text-sm font-medium text-gray-800 dark:text-gray-200">Basic Info</span>
                </div>
                <div class="flex-1 h-1 bg-gray-200 dark:bg-gray-700 mx-2"></div>
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center text-gray-600 dark:text-gray-400 font-bold text-sm">2</div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Details</span>
                </div>
                <div class="flex-1 h-1 bg-gray-200 dark:bg-gray-700 mx-2"></div>
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center text-gray-600 dark:text-gray-400 font-bold text-sm">3</div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Media</span>
                </div>
            </div>
        </div>

        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf
            
            <!-- Step 1: Basic Information -->
            <div id="step1" class="step-content p-6">
                <!-- Product Name -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Product Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                           class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200" 
                           placeholder="What are you selling?" required>
                </div>

                <!-- Category -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Product Type -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Product Type</label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="product-type-option">
                            <input type="radio" name="product_type" value="physical" checked class="hidden">
                            <div class="option-content p-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl text-center cursor-pointer transition-all hover:border-green-500">
                                <i class="fas fa-box text-gray-400 text-lg mb-1"></i>
                                <span class="block text-xs font-medium text-gray-600 dark:text-gray-400">Physical</span>
                            </div>
                        </label>
                        
                        <label class="product-type-option">
                            <input type="radio" name="product_type" value="digital" class="hidden">
                            <div class="option-content p-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl text-center cursor-pointer transition-all hover:border-green-500">
                                <i class="fas fa-file-pdf text-gray-400 text-lg mb-1"></i>
                                <span class="block text-xs font-medium text-gray-600 dark:text-gray-400">Digital</span>
                            </div>
                        </label>
                        
                        <label class="product-type-option">
                            <input type="radio" name="product_type" value="ticket" class="hidden">
                            <div class="option-content p-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl text-center cursor-pointer transition-all hover:border-green-500">
                                <i class="fas fa-ticket-alt text-gray-400 text-lg mb-1"></i>
                                <span class="block text-xs font-medium text-gray-600 dark:text-gray-400">Ticket</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Next Button -->
                <button type="button" onclick="nextStep(2)" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold transition-colors">
                    Continue
                </button>
            </div>

            <!-- Step 2: Pricing & Details -->
            <div id="step2" class="step-content p-6 hidden">
                <!-- Price -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Price (TZS) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">TZS</span>
                        <input type="number" name="price" value="{{ old('price') }}" 
                               class="w-full border border-gray-300 dark:border-gray-600 rounded-xl pl-12 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200" 
                               placeholder="0.00" step="0.01" min="0" required>
                    </div>
                </div>

                <!-- Stock -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Stock Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="stock_quantity" value="{{ old('stock_quantity', 1) }}" 
                           class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200" 
                           placeholder="How many?" min="0" required>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" rows="4" 
                              class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 resize-none" 
                              placeholder="Describe your product..." required>{{ old('description') }}</textarea>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex space-x-3">
                    <button type="button" onclick="prevStep(1)" class="flex-1 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 py-3 rounded-xl font-medium transition-colors">
                        Back
                    </button>
                    <button type="button" onclick="nextStep(3)" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold transition-colors">
                        Continue
                    </button>
                </div>
            </div>

            <!-- Step 3: Media Upload -->
            <div id="step3" class="step-content p-6 hidden">
                <!-- Image Upload -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Product Images</label>
                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-green-500 dark:hover:border-green-400 transition-colors cursor-pointer" onclick="document.getElementById('product-images').click()">
                        <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-3"></i>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">Tap to upload photos</p>
                        <p class="text-gray-500 dark:text-gray-500 text-xs">PNG, JPG up to 5MB</p>
                        <input type="file" name="images[]" multiple accept="image/*" class="hidden" id="product-images">
                    </div>
                </div>

                <!-- Image Preview -->
                <div id="image-preview" class="grid grid-cols-3 gap-3 mb-6 hidden">
                    <!-- Images will be previewed here -->
                </div>

                <!-- Submit Buttons -->
                <div class="flex space-x-3">
                    <button type="button" onclick="prevStep(2)" class="flex-1 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 py-3 rounded-xl font-medium transition-colors">
                        Back
                    </button>
                    <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold transition-colors">
                        Post Product
                    </button>
                </div>

                <!-- Save as Draft -->
                <button type="button" onclick="saveAsDraft()" class="w-full mt-3 bg-gray-600 hover:bg-gray-700 text-white py-3 rounded-xl font-medium transition-colors">
                    Save as Draft
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Main Dashboard Content -->
<div class="max-w-7xl mx-auto px-2 sm:px-4 pt-20 pb-20">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div class="flex items-center space-x-4 mb-4 sm:mb-0">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Seller Dashboard</h1>
                <p class="text-gray-600 dark:text-gray-400">Welcome back, Track your Customers and Orders.</p>
            </div>
        </div>
        <!-- Add Product Button - Opens Modal -->
        <button onclick="openProductModal()" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center space-x-2 w-fit">
            <i class="fas fa-plus-circle"></i>
            <span>Add Product</span>
        </button>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 dark:bg-green-900 dark:border-green-700 dark:text-green-200">
            {{ session('success') }}
        </div>
    @endif

    <!-- Mobile Tabs Navigation -->
    <div class="sm:hidden bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-4 overflow-x-auto scrollbar-hide">
        <div class="flex">
            <button class="mobile-tab active flex flex-col items-center justify-center px-4 py-3 min-w-20 text-center" data-tab="overview-section">
                <i class="fas fa-tachometer-alt text-sm mb-1"></i>
                <span class="text-xs font-medium">Dashboard</span>
            </button>
            <button class="mobile-tab flex flex-col items-center justify-center px-4 py-3 min-w-20 text-center" data-tab="products-section">
                <i class="fas fa-boxes text-sm mb-1"></i>
                <span class="text-xs font-medium">Products</span>
            </button>
            <button class="mobile-tab flex flex-col items-center justify-center px-4 py-3 min-w-20 text-center" data-tab="orders-section">
                <i class="fas fa-shopping-cart text-sm mb-1"></i>
                <span class="text-xs font-medium">Orders</span>
            </button>
            <button class="mobile-tab flex flex-col items-center justify-center px-4 py-3 min-w-20 text-center" data-tab="messages-section">
                <i class="fas fa-comments text-sm mb-1"></i>
                <span class="text-xs font-medium">Messages</span>
            </button>
        </div>
    </div>

    <!-- Desktop Tabs Navigation -->
    <div class="hidden sm:block mb-6">
        <div class="flex space-x-4 border-b border-gray-200 dark:border-gray-700" role="tablist">
            <button id="overviewTab" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-t-md focus:outline-none focus:ring-2 focus:ring-green-300 transition-all duration-200" role="tab" aria-selected="true" aria-controls="overview-section">
                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
            </button>
            <button id="productsTab" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-t-md hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-green-300 transition-all duration-200" role="tab" aria-selected="false" aria-controls="products-section">
                <i class="fas fa-boxes mr-2"></i> Manage Products
            </button>
            <button id="ordersTab" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-t-md hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-green-300 transition-all duration-200" role="tab" aria-selected="false" aria-controls="orders-section">
                <i class="fas fa-shopping-cart mr-2"></i> View Orders
            </button>
            <button id="messagesTab" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-t-md hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-green-300 transition-all duration-200" role="tab" aria-selected="false" aria-controls="messages-section">
                <i class="fas fa-comments mr-2"></i> Customer Messages
            </button>
        </div>
    </div>

    <!-- Sections Container -->
    <div class="sections-container">
        <!-- Overview Section -->
        <div id="overview-section" class="section active">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stat-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Total Revenue</p>
                            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">TZS {{ number_format($stats['total_revenue']) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                            <i class="fas fa-money-bill-wave text-green-600 dark:text-green-400 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-green-600 dark:text-green-400 text-sm mt-2">
                        <i class="fas fa-arrow-up mr-1"></i> 
                        {{ $stats['revenue_growth'] ?? '15%' }} from last month
                    </p>
                </div>

                <div class="stat-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Total Orders</p>
                            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $stats['total_orders'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                            <i class="fas fa-shopping-cart text-blue-600 dark:text-blue-400 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-green-600 dark:text-green-400 text-sm mt-2">
                        <i class="fas fa-arrow-up mr-1"></i> 
                        {{ $stats['order_growth'] ?? '8%' }} from last month
                    </p>
                </div>

                <div class="stat-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Products</p>
                            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $stats['product_count'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                            <i class="fas fa-box text-purple-600 dark:text-purple-400 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-green-600 dark:text-green-400 text-sm mt-2">
                        <i class="fas fa-plus mr-1"></i> 
                        {{ $stats['new_products'] ?? '2' }} new this week
                    </p>
                </div>

                <div class="stat-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Rating</p>
                            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ number_format($stats['rating'], 1) }}/5</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center">
                            <i class="fas fa-star text-yellow-600 dark:text-yellow-400 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-green-600 dark:text-green-400 text-sm mt-2">
                        Based on {{ $stats['total_reviews'] ?? '0' }} customer reviews
                    </p>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Products & Recent Activity -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Products Overview -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Recent Products</h2>
                            <button class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 font-medium" onclick="switchToTab('productsTab')">
                                View All
                            </button>
                        </div>

                        <!-- Products Grid -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @forelse($recentProducts as $product)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-md transition-shadow bg-white dark:bg-gray-800">
                                <div class="relative">
                                    <img src="{{ $product->images ? asset('storage/' . $product->images[0]) : 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=300' }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-20 sm:h-24 object-cover">
                                    <div class="absolute top-1 right-1">
                                        <span class="bg-black bg-opacity-50 text-white text-xs px-1 rounded">
                                            {{ $product->stock_quantity }} left
                                        </span>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <h3 class="font-semibold text-gray-800 dark:text-gray-100 text-xs mb-1 truncate">{{ $product->name }}</h3>
                                    <p class="text-green-600 dark:text-green-400 font-bold text-xs">TZS {{ number_format($product->price) }}</p>
                                    <div class="flex justify-between items-center mt-1">
                                        <span class="text-gray-500 dark:text-gray-400 text-xs">
                                            {{ $product->sold_count }} sold
                                        </span>
                                        <div class="flex space-x-1">
                                            <button onclick="openEditModal({{ $product->id }})" 
                                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-xs">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button onclick="openDeleteModal({{ $product->id }})" 
                                                    class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-xs">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-span-full text-center py-8">
                                <i class="fas fa-box-open text-gray-400 text-4xl mb-4"></i>
                                <p class="text-gray-600 dark:text-gray-400 mb-2">No products yet</p>
                                <button class="text-green-600 hover:text-green-700 font-medium" onclick="openProductModal()">
                                    Add your first product
                                </button>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Recent Orders</h2>
                            <button class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 font-medium" onclick="switchToTab('ordersTab')">
                                View All
                            </button>
                        </div>

                        <div class="space-y-4">
                            @forelse($recentOrders as $order)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="font-semibold text-gray-800 dark:text-gray-100">Order #{{ $order->order_number }}</h3>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                                            {{ $order->user->full_name ?? $order->user->username }}
                                        </p>
                                    </div>
                                    <span class="px-2 py-1 rounded-full text-xs {{ $order->getStatusBadgeClass() }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-green-600 dark:text-green-400 font-semibold">
                                        TZS {{ number_format($order->total_amount) }}
                                    </span>
                                    <span class="text-gray-500 dark:text-gray-400">
                                        {{ $order->created_at->format('M d, Y') }}
                                    </span>
                                </div>
                                
                                <div class="mt-2 flex space-x-2">
                                    <button class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-xs" onclick="viewOrderDetails({{ $order->id }})">
                                        <i class="fas fa-eye mr-1"></i> View Details
                                    </button>
                                    @if($order->status === 'pending')
                                    <button class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 text-xs">
                                        <i class="fas fa-check mr-1"></i> Process
                                    </button>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8">
                                <i class="fas fa-shopping-cart text-gray-400 text-4xl mb-4"></i>
                                <p class="text-gray-600 dark:text-gray-400">No orders yet</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Column - Quick Stats & Messages -->
                <div class="space-y-8">
                    <!-- Store Performance -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Store Performance</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600 dark:text-gray-400">Conversion Rate</span>
                                    <span class="font-semibold text-gray-800 dark:text-gray-100">{{ $stats['conversion_rate'] ?? '3.2' }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ $stats['conversion_rate'] ?? '3.2' }}%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600 dark:text-gray-400">Average Order Value</span>
                                    <span class="font-semibold text-gray-800 dark:text-gray-100">TZS {{ number_format($stats['average_order_value'] ?? 0) }}</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: 65%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600 dark:text-gray-400">Customer Satisfaction</span>
                                    <span class="font-semibold text-gray-800 dark:text-gray-100">{{ number_format($stats['satisfaction_rate'] ?? 4.5, 1) }}/5</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-yellow-600 h-2 rounded-full" style="width: 90%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Messages -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Recent Messages</h2>
                            <button class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 text-sm" onclick="switchToTab('messagesTab')">
                                View All
                            </button>
                        </div>

                        <div class="space-y-3">
                            @foreach($recentMessages as $message)
                            <div class="flex items-start space-x-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                    {{ substr($message->customer_name, 0, 2) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start">
                                        <h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm truncate">
                                            {{ $message->customer_name }}
                                        </h4>
                                        <span class="text-gray-500 dark:text-gray-400 text-xs whitespace-nowrap">
                                            {{ $message->time_ago }}
                                        </span>
                                    </div>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm truncate">
                                        {{ $message->preview }}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                            
                            @if(count($recentMessages) === 0)
                            <div class="text-center py-4">
                                <i class="fas fa-comments text-gray-400 text-2xl mb-2"></i>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">No new messages</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Tips -->
                    <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-xl p-6">
                        <h3 class="font-semibold text-blue-800 dark:text-blue-200 mb-3 flex items-center">
                            <i class="fas fa-lightbulb mr-2"></i> Seller Tips
                        </h3>
                        <ul class="space-y-2 text-blue-700 dark:text-blue-300 text-sm">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mr-2 mt-0.5 text-green-500"></i>
                                <span>Upload high-quality product images</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mr-2 mt-0.5 text-green-500"></i>
                                <span>Respond to customer messages quickly</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mr-2 mt-0.5 text-green-500"></i>
                                <span>Update product stock regularly</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mr-2 mt-0.5 text-green-500"></i>
                                <span>Process orders within 24 hours</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div id="products-section" class="section">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 space-y-4 sm:space-y-0">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Manage Products</h2>
                    <button onclick="openProductModal()" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center space-x-2 w-full sm:w-auto justify-center">
                        <i class="fas fa-plus-circle"></i>
                        <span>Add New Product</span>
                    </button>
                </div>

                <!-- Products Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-600">
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-600 dark:text-gray-400">Product</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-600 dark:text-gray-400">Price</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-600 dark:text-gray-400">Stock</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-600 dark:text-gray-400">Status</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-600 dark:text-gray-400">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentProducts as $product)
                            <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="py-3 px-4">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $product->images ? asset('storage/' . $product->images[0]) : 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=100' }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-10 h-10 object-cover rounded">
                                        <div>
                                            <p class="font-medium text-gray-800 dark:text-gray-100 text-sm">{{ $product->name }}</p>
                                            <p class="text-gray-500 dark:text-gray-400 text-xs">{{ $product->sold_count }} sold</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <p class="text-green-600 dark:text-green-400 font-semibold">TZS {{ number_format($product->price) }}</p>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 rounded-full text-xs {{ $product->stock_quantity > 10 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' }}">
                                        {{ $product->stock_quantity }} in stock
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Active
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex space-x-2">
                                        <button onclick="openEditModal({{ $product->id }})" 
                                                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="openDeleteModal({{ $product->id }})" 
                                                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center">
                                    <i class="fas fa-box-open text-gray-400 text-4xl mb-4"></i>
                                    <p class="text-gray-600 dark:text-gray-400 mb-2">No products yet</p>
                                    <button class="text-green-600 hover:text-green-700 font-medium" onclick="openProductModal()">
                                        Add your first product
                                    </button>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Orders Section -->
        <div id="orders-section" class="section">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Recent Orders</h2>

                <div class="space-y-4">
                    @forelse($recentOrders as $order)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-4">
                            <div class="flex items-center space-x-4 mb-3 lg:mb-0">
                                @if($order->items->first() && $order->items->first()->product)
                                    <img src="{{ $order->items->first()->product->images ? asset('storage/' . $order->items->first()->product->images[0]) : 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=100' }}" 
                                         alt="{{ $order->items->first()->product->name }}" 
                                         class="w-16 h-16 object-cover rounded-lg">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-box text-gray-400"></i>
                                    </div>
                                @endif
                                <div>
                                    <h3 class="font-bold text-gray-800 dark:text-gray-100">
                                        @if($order->items->first() && $order->items->first()->product)
                                            {{ $order->items->first()->product->name }}
                                        @else
                                            Order #{{ $order->order_number }}
                                        @endif
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">Order #{{ $order->order_number }}</p>
                                    <p class="text-green-600 dark:text-green-400 font-semibold">TZS {{ number_format($order->total_amount, 2) }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                                <span class="px-3 py-1 rounded-full text-sm {{ $order->getStatusBadgeClass() }}">{{ ucfirst($order->status) }}</span>
                                <span class="px-3 py-1 rounded-full text-sm {{ $order->getPaymentBadgeClass() }}">{{ ucfirst($order->getPaymentStatus()) }}</span>
                            </div>
                        </div>
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-center space-x-4 mb-2 lg:mb-0">
                                <span><i class="fas fa-calendar mr-1"></i> Ordered: {{ $order->created_at->format('d M Y') }}</span>
                                <span><i class="fas fa-truck mr-1"></i> 
                                    @if($order->status === 'delivered')
                                        Delivered: {{ $order->updated_at->format('d M Y') }}
                                    @else
                                        Estimated: {{ $order->created_at->addDays(5)->format('d M Y') }}
                                    @endif
                                </span>
                            </div>
                            <div class="flex space-x-2">
                                <button onclick="viewOrderDetails({{ $order->id }})" class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 px-3 py-1 border border-green-600 rounded-lg transition-colors">
                                    <i class="fas fa-eye mr-1"></i> View Details
                                </button>
                                @if($order->status === 'pending')
                                <button class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 px-3 py-1 border border-blue-600 rounded-lg transition-colors">
                                    <i class="fas fa-check mr-1"></i> Process
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <i class="fas fa-shopping-cart text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-600 dark:text-gray-400">No orders yet</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Messages Section -->
        <div id="messages-section" class="section">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Customer Messages</h2>

                <div class="space-y-4">
                    @foreach($recentMessages as $message)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ substr($message->customer_name, 0, 2) }}
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 dark:text-gray-100">{{ $message->customer_name }}</h4>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $message->customer_email }}</p>
                                </div>
                            </div>
                            <span class="text-gray-500 dark:text-gray-400 text-sm">{{ $message->time_ago }}</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-3">{{ $message->preview }}</p>
                        <div class="flex space-x-2">
                            <button class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 px-3 py-1 border border-green-600 rounded-lg transition-colors text-sm">
                                <i class="fas fa-reply mr-1"></i> Reply
                            </button>
                            <button class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 px-3 py-1 border border-blue-600 rounded-lg transition-colors text-sm">
                                <i class="fas fa-eye mr-1"></i> View Conversation
                            </button>
                        </div>
                    </div>
                    @endforeach
                    
                    @if(count($recentMessages) === 0)
                    <div class="text-center py-8">
                        <i class="fas fa-comments text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-600 dark:text-gray-400">No messages yet</p>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Customer messages will appear here</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Navigation - For ALL devices (Mobile, Tablet, Desktop) -->
@include('partials.bottom_nav')

<!-- Delete Product Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 max-w-md w-full mx-4">
        <div class="flex items-center justify-center w-16 h-16 bg-red-100 dark:bg-red-900 rounded-full mx-auto mb-4">
            <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 text-center mb-2">Delete Product</h3>
        <p class="text-gray-600 dark:text-gray-400 text-center mb-6">Are you sure you want to delete this product? This action cannot be undone.</p>
        <div class="flex space-x-3">
            <button onclick="closeDeleteModal()" class="flex-1 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 py-3 rounded-lg font-semibold transition-colors">
                Cancel
            </button>
            <form id="deleteForm" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-lg font-semibold transition-colors">
                    Delete Product
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // === NAVIGATION SCROLL EFFECT ===
    window.addEventListener('scroll', function() {
        const nav = document.getElementById('mainNav');
        if (window.scrollY > 50) {
            nav.classList.add('nav-scrolled');
        } else {
            nav.classList.remove('nav-scrolled');
        }
    });

    // === DARK MODE TOGGLE ===
    const themeToggle = document.getElementById('themeToggle');
    const html = document.documentElement;

    if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        html.classList.add('dark');
        themeToggle.innerHTML = '<i class="fas fa-sun text-lg"></i>';
    } else {
        themeToggle.innerHTML = '<i class="fas fa-moon text-lg"></i>';
    }

    themeToggle.addEventListener('click', () => {
        html.classList.toggle('dark');
        if (html.classList.contains('dark')) {
            localStorage.setItem('theme', 'dark');
            themeToggle.innerHTML = '<i class="fas fa-sun text-lg"></i>';
        } else {
            localStorage.setItem('theme', 'light');
            themeToggle.innerHTML = '<i class="fas fa-moon text-lg"></i>';
        }
    });

    // === DROPDOWN ===
    function toggleDropdown() {
        document.getElementById('accountDropdown').classList.toggle('active');
    }
    document.addEventListener('click', (e) => {
        const dropdown = document.getElementById('accountDropdown');
        if (!dropdown.contains(e.target)) {
            dropdown.classList.remove('active');
        }
    });

    // === AUTOMATIC TAB ACTIVATION ===
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tabs automatically - Dashboard will be active by default
        initializeTabs();
        
        // Set up event listeners for both desktop and mobile tabs
        setupTabEventListeners();
    });

    function initializeTabs() {
        // Hide all sections first
        document.querySelectorAll('.section').forEach(section => {
            section.classList.remove('active');
        });
        
        // Show overview section by default
        document.getElementById('overview-section').classList.add('active');
        
        // Update desktop tabs - set overview as active
        document.querySelectorAll('[role="tab"]').forEach(tab => {
            tab.classList.remove('bg-green-600', 'text-white');
            tab.classList.add('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
        });
        document.getElementById('overviewTab').classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
        document.getElementById('overviewTab').classList.add('bg-green-600', 'text-white');
        
        // Update mobile tabs - set overview as active
        document.querySelectorAll('.mobile-tab').forEach(tab => {
            tab.classList.remove('active');
        });
        document.querySelector('.mobile-tab[data-tab="overview-section"]').classList.add('active');
        
        // Store current tab in session storage
        sessionStorage.setItem('currentTab', 'overviewTab');
    }

    function setupTabEventListeners() {
        // Desktop tabs
        const desktopTabs = document.querySelectorAll('[role="tab"]');
        desktopTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                switchToTab(this.id);
            });
        });
        
        // Mobile tabs
        const mobileTabs = document.querySelectorAll('.mobile-tab');
        mobileTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const tabName = this.getAttribute('data-tab');
                
                // Hide all sections
                document.querySelectorAll('.section').forEach(section => {
                    section.classList.remove('active');
                });
                
                // Show selected section
                document.getElementById(tabName).classList.add('active');
                
                // Update mobile tabs
                mobileTabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                // Update desktop tabs
                const correspondingDesktopTab = document.getElementById(tabName.replace('-section', 'Tab'));
                if (correspondingDesktopTab) {
                    desktopTabs.forEach(t => {
                        t.classList.remove('bg-green-600', 'text-white');
                        t.classList.add('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
                    });
                    correspondingDesktopTab.classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
                    correspondingDesktopTab.classList.add('bg-green-600', 'text-white');
                }
                
                // Store current tab
                sessionStorage.setItem('currentTab', tabName.replace('-section', 'Tab'));
            });
        });
    }

    // === TAB SWITCHING FUNCTIONALITY ===
    function switchToTab(tabId) {
        // Hide all sections
        document.querySelectorAll('.section').forEach(section => {
            section.classList.remove('active');
        });
        
        // Show selected section
        const targetSection = document.getElementById(tabId.replace('Tab', '-section'));
        if (targetSection) {
            targetSection.classList.add('active');
        }
        
        // Update active tab buttons
        document.querySelectorAll('[role="tab"]').forEach(tab => {
            tab.classList.remove('bg-green-600', 'text-white');
            tab.classList.add('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
        });
        
        // Update mobile tabs
        document.querySelectorAll('.mobile-tab').forEach(tab => {
            tab.classList.remove('active');
        });
        
        // Activate selected tab
        const activeTab = document.getElementById(tabId);
        if (activeTab) {
            activeTab.classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
            activeTab.classList.add('bg-green-600', 'text-white');
        }
        
        // Activate mobile tab
        const mobileTab = document.querySelector(`.mobile-tab[data-tab="${tabId.replace('Tab', '-section')}"]`);
        if (mobileTab) {
            mobileTab.classList.add('active');
        }
        
        // Store current tab in session storage
        sessionStorage.setItem('currentTab', tabId);
    }

    // === PRODUCT MODAL FUNCTIONS ===
    function openProductModal() {
        document.getElementById('productModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        resetForm();
    }

    function closeProductModal() {
        document.getElementById('productModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function resetForm() {
        // Reset to step 1
        showStep(1);
        
        // Reset form fields
        document.getElementById('productForm').reset();
        
        // Clear image preview
        document.getElementById('image-preview').innerHTML = '';
        document.getElementById('image-preview').classList.add('hidden');
        
        // Reset product type selection
        document.querySelectorAll('.product-type-option .option-content').forEach(content => {
            content.classList.remove('border-green-500', 'bg-green-50', 'dark:bg-green-900');
            content.classList.add('border-gray-200', 'dark:border-gray-600');
        });
        // Set physical as default
        const physicalOption = document.querySelector('.product-type-option input[value="physical"]');
        if (physicalOption) {
            physicalOption.checked = true;
            const content = physicalOption.nextElementSibling;
            content.classList.remove('border-gray-200', 'dark:border-gray-600');
            content.classList.add('border-green-500', 'bg-green-50', 'dark:bg-green-900');
        }
    }

    // Step Navigation
    function showStep(stepNumber) {
        // Hide all steps
        document.querySelectorAll('.step-content').forEach(step => {
            step.classList.add('hidden');
        });
        
        // Show current step
        document.getElementById('step' + stepNumber).classList.remove('hidden');
        
        // Update progress indicators
        updateProgress(stepNumber);
    }

    function nextStep(next) {
        // Basic validation before proceeding
        if (validateStep(next - 1)) {
            showStep(next);
        }
    }

    function prevStep(prev) {
        showStep(prev);
    }

    function updateProgress(currentStep) {
        // Reset all steps
        const steps = document.querySelectorAll('[class*="flex items-center space-x-2"]');
        steps.forEach((step, index) => {
            const number = step.querySelector('div');
            const text = step.querySelector('span');
            
            if (index + 1 === currentStep) {
                number.className = 'w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white font-bold text-sm';
                text.className = 'text-sm font-medium text-gray-800 dark:text-gray-200';
            } else if (index + 1 < currentStep) {
                number.className = 'w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white font-bold text-sm';
                text.className = 'text-sm font-medium text-gray-800 dark:text-gray-200';
            } else {
                number.className = 'w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center text-gray-600 dark:text-gray-400 font-bold text-sm';
                text.className = 'text-sm font-medium text-gray-500 dark:text-gray-400';
            }
        });
    }

    function validateStep(step) {
        switch(step) {
            case 1:
                const name = document.querySelector('input[name="name"]');
                const category = document.querySelector('select[name="category_id"]');
                
                if (!name.value.trim()) {
                    alert('Please enter a product name');
                    name.focus();
                    return false;
                }
                
                if (!category.value) {
                    alert('Please select a category');
                    category.focus();
                    return false;
                }
                break;
                
            case 2:
                const price = document.querySelector('input[name="price"]');
                const description = document.querySelector('textarea[name="description"]');
                
                if (!price.value || parseFloat(price.value) <= 0) {
                    alert('Please enter a valid price');
                    price.focus();
                    return false;
                }
                
                if (!description.value.trim()) {
                    alert('Please enter a product description');
                    description.focus();
                    return false;
                }
                break;
        }
        return true;
    }

    // Image Preview Functionality
    const imageInput = document.getElementById('product-images');
    const imagePreview = document.getElementById('image-preview');

    if (imageInput) {
        imageInput.addEventListener('change', function() {
            imagePreview.innerHTML = '';
            imagePreview.classList.remove('hidden');

            for (let file of this.files) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewItem = document.createElement('div');
                        previewItem.className = 'relative group';
                        previewItem.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border border-gray-200 dark:border-gray-600">
                            <button type="button" onclick="removeImage(this)" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-times"></i>
                            </button>
                        `;
                        imagePreview.appendChild(previewItem);
                    }
                    reader.readAsDataURL(file);
                }
            }
        });
    }

    function removeImage(button) {
        button.closest('.relative').remove();
        if (imagePreview.children.length === 0) {
            imagePreview.classList.add('hidden');
        }
    }

    // Product Type Selection
    document.querySelectorAll('.product-type-option').forEach(option => {
        option.addEventListener('click', function() {
            // Remove active class from all options
            document.querySelectorAll('.product-type-option .option-content').forEach(content => {
                content.classList.remove('border-green-500', 'bg-green-50', 'dark:bg-green-900');
                content.classList.add('border-gray-200', 'dark:border-gray-600');
            });
            
            // Add active class to selected option
            const content = this.querySelector('.option-content');
            content.classList.remove('border-gray-200', 'dark:border-gray-600');
            content.classList.add('border-green-500', 'bg-green-50', 'dark:bg-green-900');
        });
    });

    // Save as Draft
    function saveAsDraft() {
        const form = document.getElementById('productForm');
        const draftInput = document.createElement('input');
        draftInput.type = 'hidden';
        draftInput.name = 'status';
        draftInput.value = 'draft';
        form.appendChild(draftInput);
        form.submit();
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target.id === 'productModal') {
            closeProductModal();
        }
        if (e.target.id === 'deleteModal') {
            closeDeleteModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeProductModal();
            closeDeleteModal();
        }
    });

    // === DELETE MODAL FUNCTIONS ===
    function openDeleteModal(productId) {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteForm').action = `/seller/products/${productId}`;
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    function openEditModal(productId) {
        window.location.href = `/seller/products/${productId}/edit`;
    }

    function viewOrderDetails(orderId) {
        // Implement order details view
        console.log('Viewing order details for:', orderId);
    }

    // Auto-refresh dashboard data every 30 seconds
    setInterval(() => {
        // You can add AJAX calls here to refresh stats
        console.log('Refreshing dashboard data...');
    }, 30000);
</script>

<style>
    .nav-green {
        background: #008000;
    }
    .dark .nav-green {
        background: #0a5c0a;
    }
    
    .dropdown {
        position: relative;
        display: inline-block;
    }
    
    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background-color: white;
        min-width: 200px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        border-radius: 12px;
        z-index: 1000;
        overflow: hidden;
        margin-top: 8px;
    }
    
    .dark .dropdown-content {
        background-color: #1f2937;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.5);
    }
    
    .dropdown-content a {
        color: #333;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        font-size: 14px;
        transition: background 0.2s;
    }
    
    .dark .dropdown-content a {
        color: #e5e7eb;
    }
    
    .dropdown-content a:hover {
        background-color: #f1f5f9;
    }
    
    .dark .dropdown-content a:hover {
        background-color: #374151;
    }
    
    .dropdown.active .dropdown-content {
        display: block;
    }
    
    /* Section Styles */
    .sections-container {
        position: relative;
        min-height: 500px;
    }
    
    .section {
        display: none;
    }
    
    .section.active {
        display: block;
        animation: fadeIn 0.3s ease-in-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Product Type Selection */
    .product-type-option input:checked + .option-content {
        border-color: #10b981;
        background: #f0fdf4;
    }
    
    .dark .product-type-option input:checked + .option-content {
        background: #064e3b;
        border-color: #10b981;
    }
    
    .step-content {
        animation: fadeIn 0.3s ease-in-out;
    }
    
    /* Order Status Colors */
    .order-status-pending {
        background: #fef3c7;
        color: #d97706;
    }
    .order-status-processing {
        background: #dbeafe;
        color: #1e40af;
    }
    .order-status-shipped {
        background: #d1fae5;
        color: #065f46;
    }
    .order-status-delivered {
        background: #dcfce7;
        color: #166534;
    }
    .order-status-cancelled {
        background: #fee2e2;
        color: #dc2626;
    }
    
    /* Payment Status Colors */
    .payment-pending {
        background: #fef3c7;
        color: #d97706;
    }
    .payment-completed {
        background: #d1fae5;
        color: #065f46;
    }
    .payment-failed {
        background: #fee2e2;
        color: #dc2626;
    }
    
    /* Smooth transitions */
    .transition-all {
        transition: all 0.3s ease;
    }
</style>
@endsection