@extends('layouts.shop')
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

    /* Categories scroll styling - IMPROVED SCROLL BEHAVIOR */
    .categories-scroll {
        display: flex;
        overflow-x: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
        gap: 12px;
        padding: 8px 0;
        scroll-behavior: smooth;
    }

    .categories-scroll::-webkit-scrollbar {
        display: none;
    }

    /* Multiple selection styling - FIXED POSITION */
    .filter-tags-container {
        position: sticky;
        top: 64px;
        z-index: 45;
        background: white;
        padding: 8px 0;
        border-bottom: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .dark .filter-tags-container {
        background: #111827;
        border-bottom-color: #374151;
    }

    .filter-tag {
        display: inline-flex;
        align-items: center;
        background: #dcfce7;
        color: #166534;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        margin: 2px;
        border: 1px solid #bbf7d0;
        font-weight: 500;
    }

    .dark .filter-tag {
        background: #052e16;
        color: #86efac;
        border-color: #065f46;
    }

    .filter-tag button {
        margin-left: 6px;
        background: none;
        border: none;
        color: #166534;
        cursor: pointer;
        font-weight: bold;
        font-size: 14px;
    }

    .dark .filter-tag button {
        color: #86efac;
    }

    /* Product slide animation */
    @keyframes slideInFromRight {
        from { 
            opacity: 0; 
            transform: translateX(30px); 
        }
        to { 
            opacity: 1; 
            transform: translateX(0); 
        }
    }

    .product-slide-in {
        animation: slideInFromRight 0.6s ease-out;
    }

    /* Rotating sellers animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .seller-fade {
        animation: fadeIn 0.5s ease-in-out;
    }

    /* Trending products animation */
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .trending-fade {
        animation: slideIn 0.5s ease-in-out;
    }

    /* Loading animations */
    @keyframes shimmer {
        0% { background-position: -468px 0; }
        100% { background-position: 468px 0; }
    }

    .shimmer {
        animation: shimmer 2s infinite linear;
        background: linear-gradient(to right, #f6f7f8 8%, #edeef1 18%, #f6f7f8 33%);
        background-size: 800px 104px;
    }

    /* Product card enhancements */
    .product-card {
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .dark .product-card {
        border-color: #374151;
    }

    .dark .product-card:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
    }

    /* Price tag styling */
    .price-tag {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.875rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Sale badge */
    .sale-badge {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Category button enhancements */
    .category-btn {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .category-btn:hover {
        transform: scale(1.05);
        background: linear-gradient(135deg, #f0fdf4, #dcfce7) !important;
    }

    .category-btn.active {
        background: linear-gradient(135deg, #dcfce7, #bbf7d0) !important;
        border-color: #10b981;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .dark .category-btn:hover {
        background: linear-gradient(135deg, #052e16, #064e3b) !important;
    }

    .dark .category-btn.active {
        background: linear-gradient(135deg, #064e3b, #047857) !important;
        border-color: #10b981;
    }

    /* Infinite scroll loader */
    .infinite-scroll-loader {
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .infinite-scroll-loader.show {
        opacity: 1;
    }

    /* Price range input styling */
    .price-input {
        border: 2px solid #d1d5db;
        transition: all 0.3s ease;
    }

    .price-input:focus {
        border-color: #10b981;
        ring-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    /* Share bottom sheet - FIXED VISIBILITY */
    .share-bottom-sheet {
        position: fixed;
        bottom: -100%;
        left: 0;
        right: 0;
        background: white;
        border-radius: 24px 24px 0 0;
        box-shadow: 0 -20px 40px rgba(0, 0, 0, 0.1);
        transition: bottom 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1000;
        max-height: 80vh;
        overflow-y: auto;
    }

    .share-bottom-sheet.active {
        bottom: 0;
    }

    .share-bottom-sheet-handle {
        width: 48px;
        height: 5px;
        background: #d1d5db;
        border-radius: 3px;
        margin: 16px auto;
    }

    .dark .share-bottom-sheet {
        background: #1f2937;
        box-shadow: 0 -20px 40px rgba(0, 0, 0, 0.3);
    }

    /* Sticky categories - IMPROVED SCROLLING BEHAVIOR */
    .sticky-categories {
        position: sticky;
        top: 80px;
        z-index: 40;
        background: white;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .dark .sticky-categories {
        background: #111827;
    }

    .sticky-categories.scrolled {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* FIXED: Bottom sheet modal content visibility */
    .bottom-sheet-content {
        background: white;
        color: #1f2937;
        padding: 20px;
    }

    .dark .bottom-sheet-content {
        background: #1f2937;
        color: #f9fafb;
    }

    /* FIXED: Image display issues */
    .product-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
        display: block;
    }

    .carousel-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* FIXED: Modal overlay improvements */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(8px);
        z-index: 999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    /* FIXED: Desktop modal */
    .desktop-modal {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.9);
        background: white;
        border-radius: 16px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        max-width: 90vw;
        width: 400px;
        max-height: 80vh;
        overflow-y: auto;
    }

    .desktop-modal.active {
        opacity: 1;
        visibility: visible;
        transform: translate(-50%, -50%) scale(1);
    }

    .dark .desktop-modal {
        background: #1f2937;
    }

    /* NEW: Enhanced scroll behavior for mobile categories */
    .category-scroll-container {
        position: relative;
        overflow: hidden;
    }

    .category-scroll-fade {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 40px;
        pointer-events: none;
        z-index: 10;
        transition: opacity 0.3s ease;
    }

    .category-scroll-fade-left {
        left: 0;
        background: linear-gradient(90deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0) 100%);
    }

    .category-scroll-fade-right {
        right: 0;
        background: linear-gradient(270deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0) 100%);
    }

    .dark .category-scroll-fade-left {
        background: linear-gradient(90deg, rgba(17,24,39,0.9) 0%, rgba(17,24,39,0) 100%);
    }

    .dark .category-scroll-fade-right {
        background: linear-gradient(270deg, rgba(17,24,39,0.9) 0%, rgba(17,24,39,0) 100%);
    }

    .category-scroll-fade.hidden {
        opacity: 0;
    }

    /* Scroll to top button */
    .scroll-to-top-btn {
        position: fixed;
        bottom: 80px;
        right: 16px;
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        border-radius: 50%;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        cursor: pointer;
        z-index: 100;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .scroll-to-top-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
    }

    .scroll-to-top-btn.hidden {
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
    }

    /* Loading spinner */
    .loading-spinner {
        border: 3px solid #f3f4f6;
        border-top: 3px solid #10b981;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
        margin: 20px auto;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Enhanced Bottom Navigation */
    .bottom-nav-active {
        color: #10b981;
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }

    .dark .bottom-nav-active {
        background: linear-gradient(135deg, #052e16, #064e3b);
    }

    /* Ensure bottom nav doesn't cover content */
    body {
        padding-bottom: 5rem;
    }

    /* Enhanced Bottom Sheet - FIXED VISIBILITY */
    .bottom-sheet {
        position: fixed;
        bottom: -100%;
        left: 0;
        right: 0;
        background: white;
        border-radius: 24px 24px 0 0;
        box-shadow: 0 -20px 40px rgba(0, 0, 0, 0.1);
        transition: bottom 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1000;
        max-height: 80vh;
        overflow-y: auto;
    }

    .bottom-sheet.active {
        bottom: 0;
    }

    .bottom-sheet-handle {
        width: 48px;
        height: 5px;
        background: #d1d5db;
        border-radius: 3px;
        margin: 16px auto;
    }

    /* Dark mode support */
    .dark .bottom-sheet {
        background: #1f2937;
        box-shadow: 0 -20px 40px rgba(0, 0, 0, 0.3);
    }

    /* Smooth transitions for all interactive elements */
    * {
        transition-property: color, background-color, border-color, transform, box-shadow;
        transition-duration: 300ms;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* FIXED: Ensure images are properly displayed */
    img {
        display: block;
        max-width: 100%;
        height: auto;
    }

    /* FIXED: Carousel image styling */
    .carousel-container img {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    /* FIXED: Product image fallback */
    .product-image-fallback {
        background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
    }

    .dark .product-image-fallback {
        background: linear-gradient(135deg, #374151, #4b5563);
        color: #6b7280;
    }
</style>

<!-- Top Navigation Bar -->
<nav id="mainNav" class="fixed top-0 w-full nav-green shadow-sm z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-3 sm:px-6">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center shadow-lg">
                        <i class="fas fa-store text-green-600 dark:text-green-400 text-lg"></i>
                    </div>
                    <span class="text-white font-bold text-xl hidden sm:block">Buyo</span>
                </a>
            </div>

            <!-- Enhanced Search Bar with Advanced Filters -->
            <div class="flex-1 max-w-2xl mx-2 sm:mx-4">
                <form action="{{ route('products.index') }}" method="GET" id="searchForm" class="relative">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Search products, categories, sellers..." value="{{ request('search') }}"
                               class="w-full pl-12 pr-24 py-3 rounded-full border-0 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm sm:text-base bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 shadow-sm">
                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-500">
                            <i class="fas fa-search"></i>
                        </div>
                        <button type="button" onclick="toggleAdvancedFilters()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-500 hover:text-green-600 dark:hover:text-green-400 transition-colors">
                            <i class="fas fa-sliders-h text-sm"></i>
                        </button>
                    </div>
                    
                    <!-- Advanced Filters Dropdown - FIXED: Removed brand filter -->
                    <div id="advancedFilters" class="absolute top-full left-0 right-0 mt-2 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-4 z-40 hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Price Range -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Price Range (TZS)</label>
                                <div class="flex space-x-2">
                                    <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}"
                                           class="w-full px-3 py-2 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm price-input">
                                    <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}"
                                           class="w-full px-3 py-2 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm price-input">
                                </div>
                            </div>
                            
                            <!-- Seller Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Seller</label>
                                <input type="text" name="seller" placeholder="Seller name" value="{{ request('seller') }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 text-sm">
                            </div>
                            
                            <!-- Region Filter (Dynamic from Database) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Region</label>
                                <select name="region" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 text-sm bg-white dark:bg-gray-700">
                                    <option value="">All Regions</option>
                                    @foreach($regions as $region)
                                        <option value="{{ $region }}" {{ request('region') == $region ? 'selected' : '' }}>{{ $region }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Condition Filter (Dynamic from Database) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Condition</label>
                                <select name="condition" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 text-sm bg-white dark:bg-gray-700">
                                    <option value="">All Conditions</option>
                                    @foreach($conditions as $condition)
                                        <option value="{{ $condition }}" {{ request('condition') == $condition ? 'selected' : '' }}>{{ ucfirst($condition) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Location Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Location</label>
                                <input type="text" name="location" placeholder="City or Region" value="{{ request('location') }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 text-sm">
                            </div>

                            <!-- Sort Options -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sort By</label>
                                <select name="sort" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 text-sm bg-white dark:bg-gray-700">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                                    <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-2 mt-4">
                            <button type="button" onclick="clearFilters()" class="px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors">
                                Clear All
                            </button>
                            <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors">
                                Apply Filters
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Desktop Navigation Icons -->
            <div class="hidden lg:flex items-center space-x-4">
                <!-- Messages Icon -->
                @auth
                <a href="{{ route('messages.index') }}" class="text-white hover:text-yellow-300 transition-colors relative" title="Messages">
                    <i class="fas fa-envelope text-lg"></i>
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold message-count">0</span>
                </a>
                @endauth

                <!-- Cart -->
                <button onclick="openCart()" class="text-white hover:text-yellow-300 transition-colors relative" title="Cart">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span class="absolute -top-2 -right-2 bg-yellow-500 text-gray-900 dark:text-gray-100 text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold cart-count">0</span>
                </button>

                <!-- Sell Button - Dynamic based on user status -->
                @auth
                    @php
                        $user = Auth::user();
                        $isSeller = $user->user_type === 'seller';
                        $hasSellerProfile = $user->seller ? true : false;
                    @endphp

                    @if($isSeller)
                        <a href="{{ route('seller.products.create') }}" class="bg-yellow-500 dark:bg-yellow-600 text-gray-900 dark:text-gray-100 px-4 py-2 rounded-lg font-semibold hover:bg-yellow-400 dark:hover:bg-yellow-500 transition-colors flex items-center space-x-2 shadow-lg">
                            <i class="fas fa-plus"></i>
                            <span>Sell Product</span>
                        </a>
                    @else
                        <a href="{{ route('register.seller') }}" class="bg-yellow-500 dark:bg-yellow-600 text-gray-900 dark:text-gray-100 px-4 py-2 rounded-lg font-semibold hover:bg-yellow-400 dark:hover:bg-yellow-500 transition-colors flex items-center space-x-2 shadow-lg">
                            <i class="fas fa-store"></i>
                            <span>Become Seller</span>
                        </a>
                    @endif

                    <!-- Enhanced User Account Dropdown -->
                    <div class="dropdown relative" id="accountDropdown">
                        <button onclick="toggleDropdown()" class="text-white hover:text-yellow-300 transition-colors relative flex items-center justify-center w-10 h-10" title="Account">
                            <div class="w-10 h-10 bg-yellow-500 rounded-full flex items-center justify-center text-gray-900 dark:text-gray-100 font-bold text-sm shadow-lg border-2 border-white">
                                {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                            </div>
                        </button>
                        <div class="dropdown-content absolute right-0 top-full mt-2 w-64 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 py-2 z-50 opacity-0 invisible transition-all duration-300 transform translate-y-2">
                            <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                                <p class="font-semibold text-gray-800 dark:text-gray-100 text-sm">{{ Auth::user()->full_name ?? Auth::user()->username }}</p>
                                <p class="text-gray-500 dark:text-gray-400 text-xs">{{ Auth::user()->email ?? 'No email' }}</p>
                            </div>
                            
                            <!-- Show current dashboard -->
                            @if($isSeller)
                                <a href="{{ route('seller.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-green-900 border-l-4 border-green-600">
                                    <i class="fas fa-store text-green-600 w-5"></i>
                                    <span>Seller Dashboard</span>
                                </a>
                                <a href="{{ route('customer.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <i class="fas fa-shopping-cart w-5"></i>
                                    <span>Customer Dashboard</span>
                                </a>
                            @else
                                <a href="{{ route('customer.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-green-900 border-l-4 border-green-600">
                                    <i class="fas fa-shopping-cart text-green-600 w-5"></i>
                                    <span>Customer Dashboard</span>
                                </a>
                                @if($hasSellerProfile)
                                    <a href="{{ route('seller.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <i class="fas fa-store w-5"></i>
                                        <span>Seller Dashboard</span>
                                    </a>
                                @endif
                            @endif

                            <a href="{{ $isSeller ? route('seller.profile') : route('customer.profile') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fas fa-user-circle w-5"></i>
                                <span>View Profile</span>
                            </a>
                            <a href="#" class="flex items-center space-x-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fas fa-cog w-5"></i>
                                <span>Settings</span>
                            </a>
                            <div class="border-t border-gray-100 dark:border-gray-700 mt-2 pt-2">
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center space-x-3 px-4 py-3 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900">
                                    <i class="fas fa-sign-out-alt w-5"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Not logged in -->
                    <a href="{{ route('login.customer') }}" class="text-white hover:text-yellow-300 transition-colors font-semibold">
                        Login
                    </a>
                    <a href="{{ route('register.customer') }}" class="bg-yellow-500 dark:bg-yellow-600 text-gray-900 dark:text-gray-100 px-4 py-2 rounded-lg font-semibold hover:bg-yellow-400 dark:hover:bg-yellow-500 transition-colors shadow-lg">
                        Register
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="lg:hidden flex items-center space-x-3">
                <button onclick="openCart()" class="text-white hover:text-yellow-300 transition-colors relative" title="Cart">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span class="absolute -top-2 -right-2 bg-yellow-500 text-gray-900 dark:text-gray-100 text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold cart-count">0</span>
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- Filter Tags Container - FIXED POSITION -->
<div id="filterTagsContainer" class="filter-tags-container hidden">
    <div id="filterTags" class="flex flex-wrap gap-2 max-w-7xl mx-auto px-3 sm:px-6">
        <!-- Filter tags will be dynamically added here -->
    </div>
</div>

<!-- Logout Form -->
@auth
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
</form>
@endauth

@include('partials.bottom_nav')

<!-- Scroll to Top Button -->
<button id="scrollToTopBtn" class="scroll-to-top-btn hidden" onclick="scrollToTop()" title="Scroll to Top">
    <i class="fas fa-arrow-up text-white"></i>
</button>

<script>
    // === NAVIGATION SCROLL EFFECT ===
    window.addEventListener('scroll', function() {
        const nav = document.getElementById('mainNav');
        const categories = document.getElementById('stickyCategories');
        const filterTagsContainer = document.getElementById('filterTagsContainer');
        const scrollToTopBtn = document.getElementById('scrollToTopBtn');
        
        if (window.scrollY > 50) {
            nav.classList.add('nav-scrolled');
            if (categories) {
                categories.classList.add('scrolled');
            }
            // Show filter tags when scrolled
            if (filterTagsContainer && selectedCategories.length > 0) {
                filterTagsContainer.classList.remove('hidden');
            }
        } else {
            nav.classList.remove('nav-scrolled');
            if (categories) {
                categories.classList.remove('scrolled');
            }
            // Hide filter tags at top
            if (filterTagsContainer) {
                filterTagsContainer.classList.add('hidden');
            }
        }

        // Show/hide scroll to top button
        if (scrollToTopBtn) {
            if (window.scrollY > 300) {
                scrollToTopBtn.classList.remove('hidden');
            } else {
                scrollToTopBtn.classList.add('hidden');
            }
        }
    });

    // === AUTOMATIC DEVICE THEME DETECTION ===
    const html = document.documentElement;

    function initializeTheme() {
        const savedTheme = localStorage.getItem('theme');
        const systemTheme = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        const themeToApply = savedTheme || systemTheme;
        html.classList.toggle('dark', themeToApply === 'dark');
        localStorage.setItem('theme', themeToApply);
    }

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
        if (!localStorage.getItem('theme')) {
            html.classList.toggle('dark', e.matches);
            localStorage.setItem('theme', e.matches ? 'dark' : 'light');
        }
    });

    // === ENHANCED DROPDOWN ===
    function toggleDropdown() {
        const dropdown = document.getElementById('accountDropdown');
        const content = dropdown.querySelector('.dropdown-content');
        content.classList.toggle('opacity-0');
        content.classList.toggle('invisible');
        content.classList.toggle('translate-y-2');
    }

    document.addEventListener('click', (e) => {
        const dropdown = document.getElementById('accountDropdown');
        if (dropdown && !dropdown.contains(e.target)) {
            const content = dropdown.querySelector('.dropdown-content');
            content.classList.add('opacity-0', 'invisible', 'translate-y-2');
        }
    });

    // === ADVANCED FILTERS ===
    function toggleAdvancedFilters() {
        const filters = document.getElementById('advancedFilters');
        filters.classList.toggle('hidden');
    }

    // === ENHANCED CATEGORY SELECTION ===
    let selectedCategories = getCurrentCategories();

    function getCurrentCategories() {
        const urlParams = new URLSearchParams(window.location.search);
        const categoriesParam = urlParams.get('categories');
        return categoriesParam ? categoriesParam.split(',') : [];
    }

    function filterByCategory(categoryId, categoryName) {
        // Toggle category selection
        if (selectedCategories.includes(categoryId)) {
            // Remove category
            selectedCategories = selectedCategories.filter(id => id !== categoryId);
        } else {
            // Add category
            selectedCategories.push(categoryId);
        }

        // Update UI
        updateCategoryUI();
        
        // Submit filter
        submitCategoryFilter();
    }

    function updateCategoryUI() {
        // Update active states for category buttons
        document.querySelectorAll('.category-btn').forEach(btn => {
            const categoryId = extractCategoryIdFromButton(btn);
            if (categoryId && selectedCategories.includes(categoryId)) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });

        // Update filter tags display
        updateFilterTagsDisplay();
    }

    function extractCategoryIdFromButton(button) {
        const onclickAttr = button.getAttribute('onclick');
        if (onclickAttr) {
            const match = onclickAttr.match(/'([^']+)'/);
            return match ? match[1] : null;
        }
        return null;
    }

    function updateFilterTagsDisplay() {
        const filterTagsContainer = document.getElementById('filterTagsContainer');
        const filterTags = document.getElementById('filterTags');
        
        if (!filterTagsContainer || !filterTags) return;

        if (selectedCategories.length === 0) {
            filterTagsContainer.classList.add('hidden');
            filterTags.innerHTML = '';
            return;
        }

        // Show container and populate tags
        filterTagsContainer.classList.remove('hidden');
        
        let tagsHtml = '';
        selectedCategories.forEach(categoryId => {
            const categoryButton = document.querySelector(`[onclick*="${categoryId}"]`);
            if (categoryButton) {
                const categoryName = categoryButton.querySelector('span').textContent.trim();
                tagsHtml += `
                    <div class="filter-tag">
                        <i class="fas fa-tag mr-1 text-xs"></i>
                        ${categoryName}
                        <button type="button" onclick="removeCategoryFilter('${categoryId}')">×</button>
                    </div>
                `;
            }
        });
        
        filterTags.innerHTML = tagsHtml;
    }

    function removeCategoryFilter(categoryId) {
        selectedCategories = selectedCategories.filter(cat => cat !== categoryId);
        updateCategoryUI();
        submitCategoryFilter();
    }

    function submitCategoryFilter() {
        const form = document.getElementById('searchForm');
        const categoriesInput = document.createElement('input');
        categoriesInput.type = 'hidden';
        categoriesInput.name = 'categories';
        categoriesInput.value = selectedCategories.join(',');
        
        // Remove existing categories input if any
        const existingInput = form.querySelector('input[name="categories"]');
        if (existingInput) {
            existingInput.remove();
        }
        
        if (selectedCategories.length > 0) {
            form.appendChild(categoriesInput);
        }
        
        form.submit();
    }

    function clearFilters() {
        // Clear selected categories
        selectedCategories = [];
        updateCategoryUI();
        
        // Remove all filter tags
        const filterTagsContainer = document.getElementById('filterTagsContainer');
        if (filterTagsContainer) {
            filterTagsContainer.classList.add('hidden');
        }
        
        // Clear URL parameters and submit form
        const form = document.getElementById('searchForm');
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => {
            if (input.name !== 'search') {
                input.value = '';
            }
        });
        
        // Remove categories input if exists
        const categoriesInput = form.querySelector('input[name="categories"]');
        if (categoriesInput) {
            categoriesInput.remove();
        }
        
        form.submit();
    }

    // === SCROLL TO TOP FUNCTION ===
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // === SCROLL TO CATEGORIES ===
    function scrollToCategories() {
        const categoriesElement = document.getElementById('stickyCategories');
        if (categoriesElement) {
            const offset = 80; // Height of fixed navigation
            const elementPosition = categoriesElement.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - offset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }
    }

    // === ENHANCED CART MANAGEMENT ===
    let cartItems = JSON.parse(localStorage.getItem('buyo_cart')) || [];

    function updateCartDisplay() {
        const totalItems = cartItems.reduce((sum, item) => sum + item.quantity, 0);
        const subtotal = cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const total = subtotal + 15000;

        document.querySelectorAll('.cart-count').forEach(el => {
            el.textContent = totalItems;
        });

        document.querySelectorAll('.cart-subtotal').forEach(el => {
            el.textContent = `TZS ${subtotal.toLocaleString()}`;
        });

        document.querySelectorAll('.cart-total').forEach(el => {
            el.textContent = `TZS ${total.toLocaleString()}`;
        });

        updateCartItems();
    }

    function updateCartItems() {
        const cartItemsContainer = document.getElementById('cartItems');
        const mobileCartItemsContainer = document.getElementById('mobileCartItems');

        if (cartItemsContainer) {
            cartItemsContainer.innerHTML = cartItems.map(item => `
                <div class="flex items-center space-x-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="w-12 h-12 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-box text-gray-500"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800 dark:text-gray-100 text-sm">${item.name}</p>
                        <p class="text-green-600 dark:text-green-400 font-semibold">TZS ${item.price.toLocaleString()}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button onclick="updateCartItemQuantity(${item.id}, -1)" class="w-6 h-6 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-minus text-xs"></i>
                        </button>
                        <span class="text-sm font-medium">${item.quantity}</span>
                        <button onclick="updateCartItemQuantity(${item.id}, 1)" class="w-6 h-6 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-plus text-xs"></i>
                        </button>
                    </div>
                </div>
            `).join('') || '<p class="text-gray-500 text-center py-4">Your cart is empty</p>';
        }

        if (mobileCartItemsContainer) {
            mobileCartItemsContainer.innerHTML = cartItems.map(item => `
                <div class="flex items-center space-x-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="w-12 h-12 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-box text-gray-500"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800 dark:text-gray-100 text-sm">${item.name}</p>
                        <p class="text-green-600 dark:text-green-400 font-semibold">TZS ${item.price.toLocaleString()}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button onclick="updateCartItemQuantity(${item.id}, -1)" class="w-6 h-6 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-minus text-xs"></i>
                        </button>
                        <span class="text-sm font-medium">${item.quantity}</span>
                        <button onclick="updateCartItemQuantity(${item.id}, 1)" class="w-6 h-6 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-plus text-xs"></i>
                        </button>
                    </div>
                </div>
            `).join('') || '<p class="text-gray-500 text-center py-4">Your cart is empty</p>';
        }
    }

    function addToCart(productId, productName, productPrice) {
        // Check if user is logged in
        fetch('{{ route("api.user.status") }}')
            .then(response => response.json())
            .then(data => {
                if (!data.is_logged_in) {
                    // Store intended URL and redirect to registration
                    fetch('{{ route("store.intended.url") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            intended_url: window.location.href
                        })
                    })
                    .then(() => {
                        showNotification('Tafadhali jisajili kwanza ili uweze kununua bidhaa', 'error');
                        window.location.href = '{{ route("register.customer") }}';
                    });
                    return;
                }

                // User is logged in, proceed with adding to cart
                const existingItem = cartItems.find(item => item.id === productId);

                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cartItems.push({
                        id: productId,
                        name: productName,
                        price: productPrice,
                        quantity: 1
                    });
                }

                localStorage.setItem('buyo_cart', JSON.stringify(cartItems));
                updateCartDisplay();

                showNotification(`${productName} imeongezwa kwenye cart!`, 'success');

                // Auto-open cart on mobile
                if (window.innerWidth < 1024) {
                    openCart();
                }
            })
            .catch(error => {
                console.error('Error checking user status:', error);
                showNotification('Hitilafu imetokea. Tafadhali jaribu tena.', 'error');
            });
    }

    function updateCartItemQuantity(productId, change) {
        const item = cartItems.find(item => item.id === productId);
        if (item) {
            item.quantity += change;
            if (item.quantity <= 0) {
                cartItems = cartItems.filter(item => item.id !== productId);
            }
            localStorage.setItem('buyo_cart', JSON.stringify(cartItems));
            updateCartDisplay();
        }
    }

    // === ENHANCED CART MODAL/BOTTOM SHEET ===
    function openCart() {
        if (window.innerWidth >= 1024) {
            // Desktop - use modal
            document.getElementById('desktopCartModal').classList.add('active');
            document.getElementById('desktopCartOverlay').classList.add('active');
        } else {
            // Mobile - use bottom sheet
            document.getElementById('mobileCartSheet').classList.add('active');
            document.getElementById('mobileCartOverlay').classList.add('active');
        }
        document.body.style.overflow = 'hidden';
    }

    function closeCart() {
        document.getElementById('desktopCartModal').classList.remove('active');
        document.getElementById('mobileCartSheet').classList.remove('active');
        document.getElementById('desktopCartOverlay').classList.remove('active');
        document.getElementById('mobileCartOverlay').classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    // === SHARE BOTTOM SHEET ===
    function openShareSheet(productId, productName, productImage) {
        document.getElementById('shareProductId').value = productId;
        document.getElementById('shareProductName').textContent = productName;
        document.getElementById('shareProductImage').src = productImage;
        
        document.getElementById('shareBottomSheet').classList.add('active');
        document.getElementById('shareOverlay').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeShareSheet() {
        document.getElementById('shareBottomSheet').classList.remove('active');
        document.getElementById('shareOverlay').classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    function shareToPlatform(platform) {
        const productName = document.getElementById('shareProductName').textContent;
        const productUrl = window.location.href;
        let shareUrl = '';

        switch(platform) {
            case 'whatsapp':
                shareUrl = `https://wa.me/?text=Check out this product: ${productName} - ${productUrl}`;
                break;
            case 'facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(productUrl)}`;
                break;
            case 'twitter':
                shareUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(productName)}&url=${encodeURIComponent(productUrl)}`;
                break;
            case 'telegram':
                shareUrl = `https://t.me/share/url?url=${encodeURIComponent(productUrl)}&text=${encodeURIComponent(productName)}`;
                break;
            case 'copy':
                navigator.clipboard.writeText(productUrl).then(() => {
                    showNotification('Link copied to clipboard!', 'success');
                });
                closeShareSheet();
                return;
        }

        window.open(shareUrl, '_blank', 'width=600,height=400');
        closeShareSheet();
    }

    // === ENHANCED PRODUCT INTERACTIONS ===
    function initializeProductInteractions() {
        // Enhanced carousel functionality
        document.querySelectorAll('.carousel-container').forEach(carousel => {
            const images = carousel.querySelectorAll('img');
            const indicators = carousel.parentElement.querySelectorAll('.indicator');
            if (images.length <= 1) return;

            let currentIndex = 0;
            let autoScrollInterval;

            const updateIndicators = () => {
                indicators.forEach((ind, i) => {
                    ind.classList.toggle('opacity-100', i === currentIndex);
                    ind.classList.toggle('opacity-50', i !== currentIndex);
                });
            };

            const scrollToImage = (index) => {
                currentIndex = index;
                images[index].scrollIntoView({ behavior: 'smooth', inline: 'center' });
                updateIndicators();
            };

            // Auto-scroll every 5 seconds
            const startAutoScroll = () => {
                autoScrollInterval = setInterval(() => {
                    const nextIndex = (currentIndex + 1) % images.length;
                    scrollToImage(nextIndex);
                }, 5000);
            };

            const stopAutoScroll = () => {
                clearInterval(autoScrollInterval);
            };

            // Touch and mouse events
            let startX = 0;
            const handleEnd = (endX) => {
                const diff = startX - endX;
                if (Math.abs(diff) > 50) {
                    if (diff > 0 && currentIndex < images.length - 1) {
                        scrollToImage(currentIndex + 1);
                    } else if (diff < 0 && currentIndex > 0) {
                        scrollToImage(currentIndex - 1);
                    }
                }
            };

            carousel.addEventListener('mousedown', e => { startX = e.clientX; stopAutoScroll(); });
            carousel.addEventListener('touchstart', e => { startX = e.touches[0].clientX; stopAutoScroll(); });
            carousel.addEventListener('mouseup', e => { handleEnd(e.clientX); startAutoScroll(); });
            carousel.addEventListener('touchend', e => { handleEnd(e.changedTouches[0].clientX); startAutoScroll(); });

            indicators.forEach((ind, i) => {
                ind.addEventListener('click', () => {
                    stopAutoScroll();
                    scrollToImage(i);
                    startAutoScroll();
                });
            });

            // Start auto-scroll
            startAutoScroll();

            // Pause auto-scroll on hover
            carousel.addEventListener('mouseenter', stopAutoScroll);
            carousel.addEventListener('mouseleave', startAutoScroll);

            updateIndicators();
        });

        // Enhanced like button functionality
        document.querySelectorAll('.like-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const isLiked = this.classList.contains('fas');
                this.classList.toggle('far');
                this.classList.toggle('fas');
                this.classList.toggle('text-red-500');
                
                if (!isLiked) {
                    this.classList.add('animate-pulse');
                    setTimeout(() => this.classList.remove('animate-pulse'), 600);
                }

                const productId = this.dataset.productId;
                // AJAX call to save like
            });
        });

        // Share button functionality
        document.querySelectorAll('.share-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const productName = this.dataset.productName;
                const productImage = this.dataset.productImage || 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=500';
                
                openShareSheet(productId, productName, productImage);
            });
        });
    }

    // Initialize everything when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        initializeTheme();
        updateCartDisplay();
        initializeProductInteractions();
        
        // Initialize categories
        updateCategoryUI();
        
        // Show filter tags if categories are selected and page is scrolled
        if (selectedCategories.length > 0 && window.scrollY > 50) {
            const filterTagsContainer = document.getElementById('filterTagsContainer');
            if (filterTagsContainer) {
                filterTagsContainer.classList.remove('hidden');
            }
        }

        // Initialize rotating content only if elements exist
        if (document.getElementById('rotatingSellers')) {
            rotateSellers();
            setInterval(rotateSellers, 20000);
        }
        
        if (document.getElementById('trendingProducts')) {
            startTrendingRotation();
        }

        // Close modals when clicking outside
        document.addEventListener('click', (e) => {
            if (e.target.id === 'desktopCartOverlay' || e.target.id === 'mobileCartOverlay' || e.target.id === 'shareOverlay') {
                closeCart();
                closeShareSheet();
            }
            const contactModal = document.getElementById('contactSellerModal');
            if (contactModal && contactModal.classList.contains('active') && e.target === contactModal) {
                closeContactModal();
            }
            const advancedFilters = document.getElementById('advancedFilters');
            if (advancedFilters && !advancedFilters.contains(e.target) && !e.target.closest('form')) {
                advancedFilters.classList.add('hidden');
            }
            
            const dropdown = document.getElementById('accountDropdown');
            if (dropdown && !dropdown.contains(e.target)) {
                const content = dropdown.querySelector('.dropdown-content');
                content.classList.add('opacity-0', 'invisible', 'translate-y-2');
            }
        });

        // FIXED: Ensure images load properly
        document.querySelectorAll('img').forEach(img => {
            img.addEventListener('error', function() {
                this.src = 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=500';
                this.alt = 'Image not available';
            });
        });
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            closeCart();
            closeShareSheet();
        }
    });

    // Utility functions
    function showNotification(message, type = 'info') {
        // Create a simple notification system
        const notification = document.createElement('div');
        notification.className = `fixed top-20 right-4 z-50 p-4 rounded-lg shadow-lg ${
            type === 'success' ? 'bg-green-500 text-white' : 
            type === 'error' ? 'bg-red-500 text-white' : 
            'bg-blue-500 text-white'
        }`;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    function proceedToCheckout() {
        // Implementation for checkout
        console.log('Proceeding to checkout');
        showNotification('Proceeding to checkout...', 'success');
    }

    function openContactModal(productId, sellerName, sellerId) {
        // Implementation for contact modal
        console.log('Opening contact modal', productId, sellerName, sellerId);
        showNotification('Opening contact form for ' + sellerName, 'info');
    }

    function closeContactModal() {
        // Implementation for closing contact modal
        console.log('Closing contact modal');
    }

    function sendMessageToSeller(event) {
        event.preventDefault();
        // Implementation for sending message
        console.log('Sending message to seller');
        showNotification('Message sent successfully!', 'success');
    }

    function showLoginAlert() {
        showNotification('Tafadhali ingia kwenye akaunti yako kwanza', 'error');
    }

    // === ENHANCED ROTATING SELLERS ===
    let currentSellerIndex = 0;
    let sellers = @json($recentSellers->take(5));

    function rotateSellers() {
        if (sellers.length <= 1) return;
        
        const sellerContainer = document.getElementById('rotatingSellers');
        if (!sellerContainer) return;
        
        currentSellerIndex = (currentSellerIndex + 1) % sellers.length;
        const seller = sellers[currentSellerIndex];
        
        sellerContainer.innerHTML = `
            <div class="seller-fade flex items-center space-x-3 p-3 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-gray-700 dark:to-gray-800 rounded-xl border border-green-200 dark:border-gray-600 cursor-pointer group hover:shadow-lg transition-all duration-300">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg">
                    ${seller.store_name ? seller.store_name.substring(0, 2).toUpperCase() : 'SL'}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-800 dark:text-gray-100 text-sm truncate group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">${seller.store_name || 'Seller'}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">📍 ${seller.business_place || 'Online'}</p>
                </div>
                <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded-full font-semibold shadow-sm">${seller.products_count || 0} items</span>
            </div>
        `;
    }

    // === ROTATING TRENDING PRODUCTS ===
    let currentTrendingIndex = 0;
    let trendingProducts = @json(($trendingProducts ?? collect())->take(5));
    let trendingInterval;

    function startTrendingRotation() {
        if (trendingProducts.length <= 1) return;
        
        trendingInterval = setInterval(() => {
            rotateTrendingProducts();
        }, 4000);
    }

    function rotateTrendingProducts() {
        if (trendingProducts.length <= 1) return;
        
        const trendingContainer = document.getElementById('trendingProducts');
        if (!trendingContainer) return;
        
        currentTrendingIndex = (currentTrendingIndex + 1) % trendingProducts.length;
        const trending = trendingProducts[currentTrendingIndex];
        
        trendingContainer.innerHTML = `
            <div class="trending-fade flex items-center space-x-4 p-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-gray-200 dark:border-gray-600">
                <img src="${trending.product_images && trending.product_images.length > 0 ? '{{ asset("storage/") }}/' + trending.product_images[0].image_path : 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=100'}" 
                     alt="${trending.name}" 
                     class="w-16 h-16 object-cover rounded-xl shadow-sm group-hover:scale-110 transition-transform duration-300">
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-800 dark:text-gray-100 text-sm leading-tight group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">${trending.name.length > 30 ? trending.name.substring(0, 30) + '...' : trending.name}</p>
                    <p class="text-green-600 dark:text-green-400 font-bold text-base mt-1">TZS ${trending.price.toLocaleString()}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center space-x-1">
                        <i class="fas fa-eye"></i>
                        <span>${trending.view_count || 0} views</span>
                    </p>
                </div>
            </div>
        `;
    }
</script>

<!-- Enhanced Desktop Cart Modal -->
<div class="modal-overlay" id="desktopCartOverlay" onclick="closeCart()"></div>
<div class="desktop-modal hidden lg:block" id="desktopCartModal">
    <div class="bottom-sheet-content p-6 max-h-96 overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-2xl text-gray-800 dark:text-gray-100">Your Cart</h3>
            <button onclick="closeCart()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <div id="cartItems" class="space-y-4 mb-6">
            <!-- Cart items will be dynamically added here -->
        </div>

        <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mb-6">
            <div class="flex justify-between items-center mb-3">
                <span class="text-gray-600 dark:text-gray-400 text-lg">Subtotal:</span>
                <span class="font-semibold text-lg cart-subtotal">TZS 0</span>
            </div>
            <div class="flex justify-between items-center mb-3">
                <span class="text-gray-600 dark:text-gray-400 text-lg">Shipping:</span>
                <span class="font-semibold text-lg">TZS 15,000</span>
            </div>
            <div class="flex justify-between items-center text-xl font-bold pt-3 border-t border-gray-200 dark:border-gray-700">
                <span>Total:</span>
                <span class="text-green-600 dark:text-green-400 cart-total">TZS 15,000</span>
            </div>
        </div>

        <button onclick="proceedToCheckout()" class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white py-4 rounded-xl font-semibold transition-all duration-300 flex items-center justify-center space-x-3 shadow-lg hover:shadow-xl">
            <i class="fas fa-lock"></i>
            <span class="text-lg">Proceed to Checkout</span>
        </button>
    </div>
</div>

<!-- Mobile Cart Bottom Sheet -->
<div class="modal-overlay" id="mobileCartOverlay" onclick="closeCart()"></div>
<div class="bottom-sheet" id="mobileCartSheet">
    <div class="bottom-sheet-handle"></div>
    <div class="bottom-sheet-content p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100">Your Cart (<span class="cart-count">0</span> items)</h3>
            <button onclick="closeCart()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div id="mobileCartItems" class="space-y-4 mb-4 max-h-60 overflow-y-auto">
            <!-- Mobile cart items will be dynamically added here -->
        </div>

        <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mb-4">
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                <span class="font-semibold cart-subtotal">TZS 0</span>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600 dark:text-gray-400">Shipping:</span>
                <span class="font-semibold">TZS 15,000</span>
            </div>
            <div class="flex justify-between items-center text-lg font-bold">
                <span>Total:</span>
                <span class="text-green-600 dark:text-green-400 cart-total">TZS 15,000</span>
            </div>
        </div>

        <button onclick="proceedToCheckout()" class="w-full bg-green-600 dark:bg-green-700 hover:bg-green-700 dark:hover:bg-green-800 text-white py-3 rounded-lg font-semibold transition-colors duration-300 flex items-center justify-center space-x-2">
            <i class="fas fa-lock"></i>
            <span>Proceed to Checkout</span>
        </button>
    </div>
</div>

<!-- Share Bottom Sheet -->
<div class="modal-overlay" id="shareOverlay" onclick="closeShareSheet()"></div>
<div class="share-bottom-sheet" id="shareBottomSheet">
    <div class="share-bottom-sheet-handle"></div>
    <div class="bottom-sheet-content p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-xl text-gray-800 dark:text-gray-100">Share Product</h3>
            <button onclick="closeShareSheet()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <div class="flex items-center space-x-4 mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
            <img id="shareProductImage" src="" alt="Product" class="w-16 h-16 object-cover rounded-lg">
            <div class="flex-1">
                <p id="shareProductName" class="font-semibold text-gray-800 dark:text-gray-100 text-sm"></p>
                <p class="text-green-600 dark:text-green-400 font-semibold text-xs mt-1">Share this amazing product!</p>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 mb-6">
            <button onclick="shareToPlatform('whatsapp')" class="flex flex-col items-center space-y-2 p-4 bg-green-50 dark:bg-green-900 rounded-xl hover:bg-green-100 dark:hover:bg-green-800 transition-colors">
                <i class="fab fa-whatsapp text-green-600 dark:text-green-400 text-2xl"></i>
                <span class="text-xs font-medium text-gray-700 dark:text-gray-300">WhatsApp</span>
            </button>
            <button onclick="shareToPlatform('facebook')" class="flex flex-col items-center space-y-2 p-4 bg-blue-50 dark:bg-blue-900 rounded-xl hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors">
                <i class="fab fa-facebook text-blue-600 dark:text-blue-400 text-2xl"></i>
                <span class="text-xs font-medium text-gray-700 dark:text-gray-300">Facebook</span>
            </button>
            <button onclick="shareToPlatform('twitter')" class="flex flex-col items-center space-y-2 p-4 bg-blue-50 dark:bg-blue-900 rounded-xl hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors">
                <i class="fab fa-twitter text-blue-400 dark:text-blue-300 text-2xl"></i>
                <span class="text-xs font-medium text-gray-700 dark:text-gray-300">Twitter</span>
            </button>
            <button onclick="shareToPlatform('telegram')" class="flex flex-col items-center space-y-2 p-4 bg-blue-50 dark:bg-blue-900 rounded-xl hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors">
                <i class="fab fa-telegram text-blue-500 dark:text-blue-400 text-2xl"></i>
                <span class="text-xs font-medium text-gray-700 dark:text-gray-300">Telegram</span>
            </button>
            <button onclick="shareToPlatform('copy')" class="flex flex-col items-center space-y-2 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                <i class="fas fa-link text-gray-600 dark:text-gray-400 text-2xl"></i>
                <span class="text-xs font-medium text-gray-700 dark:text-gray-300">Copy Link</span>
            </button>
            <button onclick="closeShareSheet()" class="flex flex-col items-center space-y-2 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                <i class="fas fa-times text-gray-600 dark:text-gray-400 text-2xl"></i>
                <span class="text-xs font-medium text-gray-700 dark:text-gray-300">Cancel</span>
            </button>
        </div>
        <input type="hidden" id="shareProductId">
    </div>
</div>

<!-- Enhanced Contact Seller Modal -->
<div id="contactSellerModal" class="contact-modal fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 opacity-0 invisible transition-all duration-300">
    <div class="contact-modal-content bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full p-6 relative transform scale-95 transition-transform duration-300">
        <button onclick="closeContactModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
            <i class="fas fa-times text-xl"></i>
        </button>
        <div class="text-center mb-6">
            <div class="w-20 h-20 bg-gradient-to-br from-green-100 to-emerald-100 dark:from-green-900 dark:to-emerald-900 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="fas fa-store text-green-600 dark:text-green-400 text-3xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Message Seller</h2>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Send a message to <span id="sellerName" class="font-semibold text-green-600 dark:text-green-400"></span></p>
        </div>
        <form id="contactSellerForm" onsubmit="sendMessageToSeller(event)" class="space-y-4">
            @csrf
            <input type="hidden" id="productId" name="product_id">
            <input type="hidden" id="sellerId" name="seller_id">
            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Your Message</label>
                <textarea id="message" name="message" rows="4"
                          class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 resize-none transition-all duration-300"
                          placeholder="Hello, I'm interested in this product. Could you tell me more about it? Please include any specific questions you have about size, color, availability, etc."
                          required></textarea>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Press Ctrl+Enter to send quickly</p>
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white py-3 rounded-xl font-semibold transition-all duration-300 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl transform hover:scale-105">
                <i class="fas fa-paper-plane"></i>
                <span class="text-lg">Send Message</span>
            </button>
        </form>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-8xl mx-auto px-3 sm:px-6 pt-24 pb-24">
    <!-- Enhanced Mobile Categories Bar with IMPROVED SCROLL BEHAVIOR -->
    <div id="stickyCategories" class="lg:hidden sticky-categories bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-4 mb-6 z-30" style="top: 80px;">
        <div class="category-scroll-container relative">
            <div class="category-scroll-fade category-scroll-fade-left hidden"></div>
            <div class="categories-scroll">
                @foreach($categories as $category)
                <button onclick="filterByCategory('{{ $category->id }}', '{{ $category->name }}')" 
                        class="category-btn flex flex-col items-center cursor-pointer group flex-shrink-0 p-3 rounded-xl bg-white dark:bg-gray-800 hover:shadow-md transition-all duration-300 {{ in_array($category->id, explode(',', request('categories', ''))) ? 'active' : '' }}">
                    <div class="relative">
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 shadow-lg flex items-center justify-center">
                            <i class="fas fa-{{ $category->icon ?? 'tag' }} text-white text-lg"></i>
                        </div>
                        <div class="absolute -top-1 -right-1 bg-yellow-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold border-2 border-white dark:border-gray-800 shadow-lg">
                            {{ $category->products_count ?? 0 }}
                        </div>
                    </div>
                    <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 mt-2 truncate max-w-16 text-center">
                        {{ $category->name }}
                    </span>
                </button>
                @endforeach
            </div>
            <div class="category-scroll-fade category-scroll-fade-right"></div>
        </div>
    </div>

    <div class="flex gap-8 xl:gap-12">
        <!-- Enhanced Left Sidebar -->
        <div class="sidebar-wide hidden xl:block bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 h-fit sticky top-32 shadow-lg">
            <div class="mb-8">
                <h3 class="font-bold text-xl text-gray-800 dark:text-gray-100 mb-4 flex items-center space-x-2">
                    <i class="fas fa-layer-group text-green-600"></i>
                    <span>Categories</span>
                </h3>
                <div class="space-y-2 max-h-96 overflow-y-auto pr-2">
                    @foreach($categories as $category)
                    <button onclick="filterByCategory('{{ $category->id }}', '{{ $category->name }}')" 
                            class="category-btn w-full flex items-center justify-between p-3 rounded-xl bg-white dark:bg-gray-800 hover:shadow-md transition-all duration-300 group {{ in_array($category->id, explode(',', request('categories', ''))) ? 'active' : '' }}">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-100 to-emerald-100 dark:from-green-900 dark:to-emerald-900 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-{{ $category->icon ?? 'tag' }} text-green-600 dark:text-green-400 text-sm"></i>
                            </div>
                            <span class="text-gray-700 dark:text-gray-300 font-medium text-sm group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">{{ $category->name }}</span>
                        </div>
                        <span class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs px-2 py-1 rounded-full font-semibold shadow-sm">{{ $category->products_count ?? 0 }}</span>
                    </button>
                    @endforeach
                </div>
            </div>

            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <h3 class="font-bold text-xl text-gray-800 dark:text-gray-100 mb-4 flex items-center space-x-2">
                    <i class="fas fa-store text-green-600"></i>
                    <span>Active Sellers</span>
                </h3>
                <div id="rotatingSellers" class="space-y-3">
                    @if($recentSellers->count() > 0)
                        @foreach($recentSellers->take(3) as $seller)
                        <div class="flex items-center space-x-3 p-3 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-gray-700 dark:to-gray-800 rounded-xl border border-green-200 dark:border-gray-600 cursor-pointer group hover:shadow-lg transition-all duration-300">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                {{ substr($seller->store_name ?? 'SL', 0, 2) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-800 dark:text-gray-100 text-sm truncate group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">{{ $seller->store_name ?? 'Seller' }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">📍 {{ $seller->business_place ?? 'Online' }}</p>
                            </div>
                            <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded-full font-semibold shadow-sm">{{ $seller->products_count ?? 0 }} items</span>
                        </div>
                        @endforeach
                    @else
                        <p class="text-gray-500 text-center py-4">No active sellers found</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Enhanced Main Product Feed -->
        <div class="flex-1 min-w-0">
            <div id="productFeed" class="space-y-6 pb-8">
                @forelse($products as $product)
                <div class="product-card bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <!-- Seller Header -->
                    <div class="flex items-center justify-between p-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                {{ substr($product->seller->store_name ?? 'SL', 0, 2) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800 dark:text-gray-100 text-sm">{{ $product->seller->store_name ?? 'Seller' }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center space-x-1">
                                    <i class="fas fa-map-marker-alt text-green-600"></i>
                                    <span>{{ $product->seller->business_place ?? 'Online' }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            @auth
                            <button onclick="openContactModal({{ $product->id }}, '{{ $product->seller->store_name ?? 'Seller' }}', {{ $product->seller->user_id ?? 0 }})" class="text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors duration-300" title="Message Seller">
                                <i class="fas fa-envelope text-lg"></i>
                            </button>
                            @else
                            <button onclick="showLoginAlert()" class="text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors duration-300" title="Message Seller">
                                <i class="fas fa-envelope text-lg"></i>
                            </button>
                            @endauth
                            <button class="share-btn text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors duration-300" 
                                    title="Share"
                                    data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $product->name }}"
                                    data-product-image="{{ $product->productImages->first() ? asset('storage/' . $product->productImages->first()->image_path) : 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=500' }}">
                                <i class="fas fa-share-alt text-lg"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Product Images Carousel - FIXED IMAGE DISPLAY -->
                    <div class="relative">
                        @if($product->productImages && $product->productImages->count() > 0)
                        <div class="carousel-container flex overflow-x-auto snap-x snap-mandatory scrollbar-hide" style="height: 450px;">
                            @foreach($product->productImages as $image)
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}" 
                                 class="carousel-image w-full h-full object-cover snap-center flex-shrink-0 transition-transform duration-500">
                            @endforeach
                        </div>
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                            @foreach($product->productImages as $index => $image)
                            <div class="w-3 h-3 bg-white rounded-full opacity-{{ $index === 0 ? '100' : '50' }} indicator cursor-pointer transition-all duration-300 hover:opacity-100 hover:scale-125"></div>
                            @endforeach
                        </div>
                        @else
                        <div class="w-full h-80 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-6xl"></i>
                        </div>
                        @endif

                        @if($product->compare_price && $product->compare_price > $product->price)
                        <div class="sale-badge absolute top-4 right-4">
                            <i class="fas fa-tag mr-1"></i>
                            {{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}% OFF
                        </div>
                        @endif
                    </div>

                    <!-- Engagement Actions -->
                    <div class="flex items-center justify-between p-4 border-b border-gray-100 dark:border-gray-700">
                        <div class="flex items-center space-x-4">
                            <button class="text-2xl text-gray-400 hover:text-red-500 transition-colors duration-300 like-btn" data-product-id="{{ $product->id }}">
                                <i class="far fa-heart"></i>
                            </button>
                            <button class="text-2xl text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors duration-300">
                                <i class="far fa-comment"></i>
                            </button>
                            <button class="share-btn text-2xl text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors duration-300"
                                    data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $product->name }}"
                                    data-product-image="{{ $product->productImages->first() ? asset('storage/' . $product->productImages->first()->image_path) : 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=500' }}">
                                <i class="far fa-share-square"></i>
                            </button>
                        </div>
                        <button class="text-2xl text-gray-400 hover:text-yellow-500 transition-colors duration-300">
                            <i class="far fa-bookmark"></i>
                        </button>
                    </div>

                    <!-- Product Details -->
                    <div class="p-5">
                        <h3 class="font-bold text-xl text-gray-800 dark:text-gray-100 mb-3 leading-tight">{{ $product->name }}</h3>
                        
                        <div class="flex items-center space-x-3 mb-4">
                            <span class="price-tag">
                                <i class="fas fa-tag mr-1"></i>
                                TZS {{ number_format($product->price) }}
                            </span>
                            @if($product->compare_price && $product->compare_price > $product->price)
                            <span class="text-gray-500 text-sm line-through font-medium">TZS {{ number_format($product->compare_price) }}</span>
                            @endif
                        </div>

                        <p class="text-gray-600 dark:text-gray-400 text-base leading-relaxed mb-5">{{ Str::limit($product->description, 200) }}</p>

                        <!-- Action Buttons -->
                        <div class="space-y-3">
                            <button onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }})" 
                                    class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white py-3.5 rounded-xl font-semibold transition-all duration-300 flex items-center justify-center space-x-3 shadow-lg hover:shadow-xl transform hover:scale-105">
                                <i class="fas fa-shopping-cart text-lg"></i>
                                <span class="text-base">Add to Cart</span>
                            </button>

                            @auth
                            <button onclick="openContactModal({{ $product->id }}, '{{ $product->seller->store_name ?? 'Seller' }}', {{ $product->seller->user_id ?? 0 }})" 
                                    class="w-full border-2 border-green-600 text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900 py-3.5 rounded-xl font-semibold transition-all duration-300 flex items-center justify-center space-x-3 hover:shadow-lg">
                                <i class="fas fa-envelope text-lg"></i>
                                <span class="text-base">Message Seller</span>
                            </button>
                            @else
                            <button onclick="showLoginAlert()" 
                                    class="w-full border-2 border-green-600 text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900 py-3.5 rounded-xl font-semibold transition-all duration-300 flex items-center justify-center space-x-3 hover:shadow-lg">
                                <i class="fas fa-envelope text-lg"></i>
                                <span class="text-base">Message Seller</span>
                            </button>
                            @endauth
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-12 text-center">
                    <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-search text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-3">No products found</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-lg mb-6">Try adjusting your search criteria or browse different categories.</p>
                    <button onclick="clearFilters()" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-xl font-semibold transition-colors duration-300">
                        Clear Filters
                    </button>
                </div>
                @endforelse

                <!-- Pagination -->
                @if($products->hasPages())
                <div class="flex justify-center mt-8">
                    {{ $products->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- Enhanced Right Sidebar with Rotating Trending Products -->
        <div class="sidebar-wide hidden lg:block xl:hidden 2xl:block bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 h-fit sticky top-32 shadow-lg">
            <div class="mb-8">
                <h3 class="font-bold text-xl text-gray-800 dark:text-gray-100 mb-4 flex items-center space-x-2">
                    <i class="fas fa-fire text-red-500"></i>
                    <span>Trending Now</span>
                </h3>
                <div id="trendingProducts" class="space-y-4">
                    @if($trendingProducts->count() > 0)
                        @foreach($trendingProducts->take(3) as $trending)
                        <div class="flex items-center space-x-4 p-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-gray-200 dark:border-gray-600">
                            <img src="{{ $trending->productImages->first() ? asset('storage/' . $trending->productImages->first()->image_path) : 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=100' }}" 
                                 alt="{{ $trending->name }}" 
                                 class="w-16 h-16 object-cover rounded-xl shadow-sm group-hover:scale-110 transition-transform duration-300">
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-800 dark:text-gray-100 text-sm leading-tight group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">{{ Str::limit($trending->name, 30) }}</p>
                                <p class="text-green-600 dark:text-green-400 font-bold text-base mt-1">TZS {{ number_format($trending->price) }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center space-x-1">
                                    <i class="fas fa-eye"></i>
                                    <span>{{ $trending->view_count || 0 }} views</span>
                                </p>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-gray-500 text-center py-4">No trending products</p>
                    @endif
                </div>
            </div>

            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-xl text-gray-800 dark:text-gray-100 flex items-center space-x-2">
                        <i class="fas fa-shopping-cart text-green-600"></i>
                        <span>Your Cart</span>
                    </h3>
                    <span class="bg-green-600 text-white text-sm px-3 py-1 rounded-full font-semibold shadow-sm cart-count">0 items</span>
                </div>
                <p class="text-gray-600 dark:text-gray-400 text-lg mb-4 font-semibold cart-total">Total: TZS 0</p>
                <button onclick="openCart()" class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white py-3.5 rounded-xl font-semibold transition-all duration-300 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-shopping-bag"></i>
                    <span>View Cart</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection