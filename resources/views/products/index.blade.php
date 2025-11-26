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
        -webkit-overflow-scrolling: touch;
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

    /* === ENHANCED CATEGORY STYLING === */
    .category-icon {
        color: #6b7280;
        transition: all 0.3s ease;
    }

    .category-btn:hover .category-icon {
        color: #10b981;
        transform: scale(1.1);
    }

    .category-btn.active .category-icon {
        color: #10b981;
    }

    .dark .category-icon {
        color: #9ca3af;
    }

    .dark .category-btn:hover .category-icon {
        color: #34d399;
    }

    .dark .category-btn.active .category-icon {
        color: #34d399;
    }

    /* === ENHANCED BOTTOM SHEET POSITIONING === */
    .enhanced-bottom-sheet {
        position: fixed;
        bottom: -100%;
        left: 0;
        right: 0;
        background: white;
        border-radius: 24px 24px 0 0;
        box-shadow: 0 -20px 40px rgba(0, 0, 0, 0.1);
        transition: bottom 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1000;
        max-height: 70vh;
        overflow-y: auto;
        margin-bottom: 80px;
    }

    .enhanced-bottom-sheet.active {
        bottom: 0;
    }

    .dark .enhanced-bottom-sheet {
        background: #1f2937;
        box-shadow: 0 -20px 40px rgba(0, 0, 0, 0.3);
    }

    /* === AJAX LOADING STYLES === */
    .ajax-loading {
        display: none;
        text-align: center;
        padding: 20px;
    }

    .ajax-loading.show {
        display: block;
    }

    .loading-spinner-small {
        border: 2px solid #f3f4f6;
        border-top: 2px solid #10b981;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        animation: spin 1s linear infinite;
        display: inline-block;
        margin-right: 8px;
    }

    /* === PRODUCT CARD STYLES === */
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

    /* === CART BADGE STYLES === */
    .cart-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #ef4444;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
        border: 2px solid white;
    }

    .dark .cart-badge {
        border-color: #1f2937;
    }

    /* === MOBILE CATEGORIES MARGIN === */
    .mobile-categories-container {
        margin-top: 0.5rem;
        margin-bottom: 1.5rem;
    }

    /* Price tag styling */
    .price-tag {
        background: #10b981;
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.875rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Sale badge */
    .sale-badge {
        background: #ef4444;
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
        background: #f0fdf4 !important;
    }

    .category-btn.active {
        background: #dcfce7 !important;
        border-color: #10b981;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .dark .category-btn:hover {
        background: #052e16 !important;
    }

    .dark .category-btn.active {
        background: #064e3b !important;
        border-color: #10b981;
    }

    /* Modal styles */
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

    .bottom-sheet-content {
        background: white;
        color: #1f2937;
        padding: 20px;
    }

    .dark .bottom-sheet-content {
        background: #1f2937;
        color: #f9fafb;
    }

    .bottom-sheet-handle {
        width: 48px;
        height: 5px;
        background: #d1d5db;
        border-radius: 3px;
        margin: 16px auto;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Sticky categories */
    .sticky-categories {
        position: scroll;
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

    /* Category scroll container */
    .category-scroll-container {
        position: relative;
        overflow: hidden;
    }

    /* Product gap */
    .product-gap {
        margin-bottom: 1.5rem;
    }

    /* === ENHANCED STYLES FROM SECOND CODE === */
    .product-slide-in {
        animation: slideInFromRight 0.6s ease-out;
    }

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

    .seller-fade {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .trending-fade {
        animation: slideIn 0.5s ease-in-out;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .shimmer {
        animation: shimmer 2s infinite linear;
        background: linear-gradient(to right, #f6f7f8 8%, #edeef1 18%, #f6f7f8 33%);
        background-size: 800px 104px;
    }

    @keyframes shimmer {
        0% { background-position: -468px 0; }
        100% { background-position: 468px 0; }
    }

    .infinite-scroll-loader {
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .infinite-scroll-loader.show {
        opacity: 1;
    }

    .price-input {
        border: 2px solid #d1d5db;
        transition: all 0.3s ease;
    }

    .price-input:focus {
        border-color: #10b981;
        ring-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

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

    .category-scroll-fade {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 40px;
        pointer-events: none;
        z-index: 5;
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

    .scroll-to-top-btn {
        position: fixed;
        bottom: 80px;
        right: 16px;
        width: 50px;
        height: 50px;
        background: #10b981;
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

    .loading-spinner {
        border: 3px solid #f3f4f6;
        border-top: 3px solid #10b981;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
        margin: 20px auto;
    }

    .bottom-nav-active {
        color: #10b981;
        background: #f0fdf4;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }

    .dark .bottom-nav-active {
        background: #052e16;
    }

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

    .product-image-fallback {
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
    }

    .dark .product-image-fallback {
        background: #374151;
        color: #6b7280;
    }

    .trending-container {
        height: 220px;
        overflow: hidden;
        position: relative;
    }

    .trending-item {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.5s ease-in-out;
    }

    .trending-item.active {
        opacity: 1;
        transform: translateY(0);
    }

    .dropdown-content {
        position: absolute;
        right: 0;
        top: 100%;
        margin-top: 0.5rem;
        width: 16rem;
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border: 1px solid #e5e7eb;
        z-index: 50;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
    }

    .dark .dropdown-content {
        background: #1f2937;
        border-color: #374151;
    }

    .dropdown-content.active {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .contact-modal {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 50;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .contact-modal.active {
        opacity: 1;
        visibility: visible;
    }

    .contact-modal-content {
        background: white;
        border-radius: 1rem;
        max-width: 28rem;
        width: 100%;
        padding: 1.5rem;
        position: relative;
        transform: scale(0.95);
        transition: transform 0.3s ease;
    }

    .dark .contact-modal-content {
        background: #1f2937;
    }

    .contact-modal.active .contact-modal-content {
        transform: scale(1);
    }

    /* Message Seller Button Styles */
    .message-seller-btn {
        background: linear-gradient(135deg, #3B82F6, #1D4ED8);
        color: white;
        border: none;
        padding: 10px 16px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
    }

    .message-seller-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
        background: linear-gradient(135deg, #2563EB, #1E40AF);
    }

    .message-seller-btn:active {
        transform: translateY(0);
    }

    .dark .message-seller-btn {
        background: linear-gradient(135deg, #1E40AF, #1E3A8A);
    }

    .dark .message-seller-btn:hover {
        background: linear-gradient(135deg, #1D4ED8, #1E3A8A);
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

                    <!-- Advanced Filters Dropdown -->
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

                                <!-- Region Filter -->
                            <div>
                                <label for="region" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Region
                                </label>
                                <select
                                    id="region"
                                    name="region"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm bg-white dark:bg-gray-700 transition-colors duration-200"
                                >
                                    <option value="">All Regions</option>
                                    @foreach($regions as $region)
                                        <option value="{{ $region }}"
                                            {{ request('region') == $region ? 'selected' : '' }}>
                                            {{ $region }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Condition Filter -->
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
                <a href="{{ route('seller.dashboard') }}" class="text-white hover:text-yellow-300 transition-colors relative" title="Messages">
                    <i class="fas fa-envelope text-lg"></i>
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold message-count">0</span>
                </a>
                @endauth

                <!-- Cart -->
                <button onclick="openCart()" class="text-white hover:text-yellow-300 transition-colors relative" title="Cart">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span class="cart-badge cart-count">0</span>
                </button>

                <!-- Sell Button - Dynamic based on user status -->
                @auth
                    @php
                        $user = Auth::user();
                        $isSeller = $user->user_type === 'seller';
                        $hasSellerProfile = $user->seller ? true : false;
                    @endphp

                    @if($isSeller)
                        <a href="{{ route('seller.dashboard') }}" class="bg-yellow-500 dark:bg-yellow-600 text-gray-900 dark:text-gray-100 px-4 py-2 rounded-lg font-semibold hover:bg-yellow-400 dark:hover:bg-yellow-500 transition-colors flex items-center space-x-2 shadow-lg">
                            <i class="fas fa-plus"></i>
                            <span>Post Product</span>
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
                    <!-- Not logged in - Show ONLY Become Seller button -->
                    <a href="{{ route('register.seller') }}" class="bg-yellow-500 dark:bg-yellow-600 text-gray-900 dark:text-gray-100 px-4 py-2 rounded-lg font-semibold hover:bg-yellow-400 dark:hover:bg-yellow-500 transition-colors flex items-center space-x-2 shadow-lg">
                        <i class="fas fa-store"></i>
                        <span>Become Seller</span>
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="lg:hidden flex items-center space-x-3">
                <button onclick="openCart()" class="text-white hover:text-yellow-300 transition-colors relative" title="Cart">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span class="cart-badge cart-count">0</span>
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- Filter Tags Container -->
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

<!-- AJAX Loading Indicator -->
<div id="ajaxLoading" class="ajax-loading">
    <div class="loading-spinner-small"></div>
    <span class="text-gray-600 dark:text-gray-400">Loading products...</span>
</div>

<script>
    // === GLOBAL VARIABLES ===
    let selectedCategories = [];
    let currentPage = 1;
    let isLoading = false;
    let hasMore = true;
    let cartItems = JSON.parse(localStorage.getItem('buyo_cart')) || [];

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
            if (filterTagsContainer && selectedCategories.length > 0) {
                filterTagsContainer.classList.remove('hidden');
            }
        } else {
            nav.classList.remove('nav-scrolled');
            if (categories) {
                categories.classList.remove('scrolled');
            }
            if (filterTagsContainer) {
                filterTagsContainer.classList.add('hidden');
            }
        }

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

    // === CATEGORY MANAGEMENT ===
    function initializeCategories() {
        const urlParams = new URLSearchParams(window.location.search);
        const categoriesParam = urlParams.get('categories');
        selectedCategories = categoriesParam ? categoriesParam.split(',') : [];

        updateCategoryUI();
        updateFilterTagsDisplay();
    }

    function toggleCategory(categoryId, categoryName) {
        if (selectedCategories.includes(categoryId)) {
            selectedCategories = selectedCategories.filter(id => id !== categoryId);
        } else {
            selectedCategories.push(categoryId);
        }

        updateCategoryUI();
        updateFilterTagsDisplay();

        loadProductsByCategories();
    }

    function updateCategoryUI() {
        document.querySelectorAll('.category-btn').forEach(btn => {
            const categoryId = btn.getAttribute('data-category-id');
            if (categoryId && selectedCategories.includes(categoryId)) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
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

        filterTagsContainer.classList.remove('hidden');

        let tagsHtml = '';
        selectedCategories.forEach(categoryId => {
            const categoryButton = document.querySelector(`[data-category-id="${categoryId}"]`);
            if (categoryButton) {
                const categoryName = categoryButton.querySelector('.category-name').textContent.trim();
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
        updateFilterTagsDisplay();
        loadProductsByCategories();
    }

    function clearFilters() {
        selectedCategories = [];
        updateCategoryUI();

        const filterTagsContainer = document.getElementById('filterTagsContainer');
        if (filterTagsContainer) {
            filterTagsContainer.classList.add('hidden');
        }

        const form = document.getElementById('searchForm');
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => {
            if (input.name !== 'search') {
                input.value = '';
            }
        });

        const categoriesInput = form.querySelector('input[name="categories"]');
        if (categoriesInput) {
            categoriesInput.remove();
        }

        form.submit();
    }

    // === AJAX PRODUCT LOADING ===
    function loadProductsByCategories() {
        if (isLoading) return;

        isLoading = true;
        currentPage = 1;
        hasMore = true;

        showLoading(true);

        const formData = new FormData();
        if (selectedCategories.length > 0) {
            formData.append('categories', selectedCategories.join(','));
        }
        formData.append('page', currentPage);

        fetch('{{ route("products.filter") }}', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateProductFeed(data.products);
                hasMore = data.hasMore;
                currentPage++;
            }
        })
        .catch(error => {
            console.error('Error loading products:', error);
            showNotification('Error loading products', 'error');
        })
        .finally(() => {
            isLoading = false;
            showLoading(false);
        });
    }

    function loadMoreProducts() {
        if (isLoading || !hasMore) return;

        isLoading = true;
        showLoading(true);

        const formData = new FormData();
        if (selectedCategories.length > 0) {
            formData.append('categories', selectedCategories.join(','));
        }
        formData.append('page', currentPage);

        fetch('{{ route("products.filter") }}', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                appendProducts(data.products);
                hasMore = data.hasMore;
                currentPage++;
            }
        })
        .catch(error => {
            console.error('Error loading more products:', error);
        })
        .finally(() => {
            isLoading = false;
            showLoading(false);
        });
    }

    function updateProductFeed(products) {
        const productFeed = document.getElementById('productFeed');
        if (!productFeed) return;

        if (products.length === 0) {
            productFeed.innerHTML = `
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-search text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-3">No products found</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-lg mb-6">Try selecting different categories.</p>
                </div>
            `;
            return;
        }

        let productsHtml = '';
        products.forEach(product => {
            productsHtml += generateProductHtml(product);
        });

        productFeed.innerHTML = productsHtml;
        initializeProductInteractions();
    }

    function appendProducts(products) {
        const productFeed = document.getElementById('productFeed');
        if (!productFeed || products.length === 0) return;

        products.forEach(product => {
            const productHtml = generateProductHtml(product);
            productFeed.insertAdjacentHTML('beforeend', productHtml);
        });

        initializeProductInteractions();
    }

    function generateProductHtml(product) {
        const mainImage = product.product_images && product.product_images.length > 0
            ? '{{ asset("storage/") }}/' + product.product_images[0].image_path
            : 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=500';

        return `
            <div class="product-card bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden product-slide-in">
                <!-- Seller Header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg">
                            ${product.seller_store_name ? product.seller_store_name.substring(0, 2).toUpperCase() : 'SL'}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 dark:text-gray-100 text-sm">${product.seller_store_name || 'Seller'}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center space-x-1">
                                <i class="fas fa-map-marker-alt text-green-600"></i>
                                <span>${product.seller_business_place || 'Online'}</span>
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button class="share-btn text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors duration-300"
                                data-product-id="${product.id}"
                                data-product-name="${product.name}"
                                data-product-image="${mainImage}">
                            <i class="fas fa-share-alt text-lg"></i>
                        </button>
                    </div>
                </div>

                <!-- Product Image -->
                <div class="relative">
                    <img src="${mainImage}" alt="${product.name}"
                         class="w-full h-80 object-cover product-image">

                    ${product.compare_price && product.compare_price > product.price ? `
                        <div class="sale-badge absolute top-4 right-4">
                            <i class="fas fa-tag mr-1"></i>
                            ${Math.round(((product.compare_price - product.price) / product.compare_price) * 100)}% OFF
                        </div>
                    ` : ''}
                </div>

                <!-- Product Details -->
                <div class="p-5">
                    <h3 class="font-bold text-xl text-gray-800 dark:text-gray-100 mb-3 leading-tight">${product.name}</h3>

                    <div class="flex items-center space-x-3 mb-4">
                        <span class="price-tag">
                            <i class="fas fa-tag mr-1"></i>
                            TZS ${Number(product.price).toLocaleString()}
                        </span>
                        ${product.compare_price && product.compare_price > product.price ? `
                            <span class="text-gray-500 text-sm line-through font-medium">TZS ${Number(product.compare_price).toLocaleString()}</span>
                        ` : ''}
                    </div>

                    <p class="text-gray-600 dark:text-gray-400 text-base leading-relaxed mb-5">${product.description ? product.description.substring(0, 200) + (product.description.length > 200 ? '...' : '') : ''}</p>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button onclick="addToCart(${product.id}, '${product.name.replace(/'/g, "\\'")}', ${product.price})"
                                class="w-full bg-green-600 hover:bg-green-700 text-white py-3.5 rounded-xl font-semibold transition-all duration-300 flex items-center justify-center space-x-3 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <i class="fas fa-shopping-cart text-lg"></i>
                            <span class="text-base">Add to Cart</span>
                        </button>

                        <!-- Message Seller Button -->
                        <button onclick="messageSeller(${product.id}, '${product.seller_store_name || 'Seller'}', ${product.seller_id || '0'})"
                                class="message-seller-btn">
                            <i class="fas fa-comment-dots"></i>
                            <span>Message Seller</span>
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    // === ENHANCED CART MANAGEMENT ===
    function updateCartDisplay() {
        const totalItems = cartItems.reduce((sum, item) => sum + item.quantity, 0);

        document.querySelectorAll('.cart-count').forEach(el => {
            el.textContent = totalItems;
            el.style.display = totalItems > 0 ? 'flex' : 'none';
        });

        updateCartModal();
    }

    function updateCartModal() {
        const cartItemsContainer = document.getElementById('cartItems');
        const mobileCartItemsContainer = document.getElementById('mobileCartItems');
        const subtotal = cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const total = subtotal + 15000;

        document.querySelectorAll('.cart-subtotal').forEach(el => {
            el.textContent = `TZS ${subtotal.toLocaleString()}`;
        });

        document.querySelectorAll('.cart-total').forEach(el => {
            el.textContent = `TZS ${total.toLocaleString()}`;
        });

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
        // Guest users can add to cart without authentication
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

        showNotification(`${productName} added to cart!`, 'success');

        if (window.innerWidth < 1024) {
            openCart();
        }
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

    // === ENHANCED BOTTOM SHEETS ===
    function openCart() {
        if (window.innerWidth >= 1024) {
            document.getElementById('desktopCartModal').classList.add('active');
            document.getElementById('desktopCartOverlay').classList.add('active');
        } else {
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

    function proceedToCheckout() {
        // Check if user is logged in
        fetch('{{ route("api.user.status") }}')
            .then(response => response.json())
            .then(data => {
                if (!data.is_logged_in) {
                    // Store intended URL and redirect to checkout/registration page
                    fetch('{{ route("store.intended.url") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            intended_url: window.location.href,
                            action: 'checkout'
                        })
                    })
                    .then(() => {
                        // Redirect to checkout page where user can register
                        window.location.href = '{{ route("customer.checkout") }}';
                    });
                    return;
                }

                // User is logged in, proceed with checkout
                window.location.href = '{{ route("customer.checkout") }}';
            })
            .catch(error => {
                console.error('Error checking user status:', error);
                showNotification('Hitilafu imetokea. Tafadhali jaribu tena.', 'error');
            });
    }

    // === MESSAGE SELLER FUNCTIONALITY ===
    function messageSeller(productId, sellerName, sellerId) {
        // Check if user is logged in
        fetch('{{ route("api.user.status") }}')
            .then(response => response.json())
            .then(data => {
                if (!data.is_logged_in) {
                    // Store intended URL and redirect to checkout/registration page
                    fetch('{{ route("store.intended.url") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            intended_url: window.location.href,
                            action: 'message_seller'
                        })
                    })
                    .then(() => {
                        // Redirect to checkout page where user can register
                        window.location.href = '{{ route("customer.checkout") }}?action=message&product_id=' + productId;
                    });
                    return;
                }

                // User is logged in, proceed with messaging
                const productName = document.querySelector(`[data-product-id="${productId}"]`)?.dataset.productName || 'this product';

                // Create a default message
                const defaultMessage = `Habari, nina hamu ya kujua zaidi kuhusu bidhaa yako "${productName}". Je, ipo available? Na bei ni fixed?`;

                // Open contact modal with pre-filled message
                openContactModal(productId, sellerName, sellerId, defaultMessage);
            })
            .catch(error => {
                console.error('Error checking user status:', error);
                showNotification('Hitilafu imetokea. Tafadhali jaribu tena.', 'error');
            });
    }

    function openContactModal(productId, sellerName, sellerId, defaultMessage = '') {
        document.getElementById('sellerName').textContent = sellerName;
        document.getElementById('productId').value = productId;
        document.getElementById('sellerId').value = sellerId;
        document.getElementById('message').value = defaultMessage;

        const modal = document.getElementById('contactSellerModal');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeContactModal() {
        const modal = document.getElementById('contactSellerModal');
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    function sendMessageToSeller(event) {
        event.preventDefault();

        const formData = new FormData(event.target);
        const productId = formData.get('product_id');
        const sellerId = formData.get('seller_id');
        const message = formData.get('message');

        // Send message via AJAX
        fetch('{{ route("customer.api.messages.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                product_id: productId,
                seller_id: sellerId,
                message: message
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Ujumbe umetumwa kikamilifu kwa muuzaji!', 'success');
                closeContactModal();

                // Clear form
                event.target.reset();
            } else {
                showNotification(data.message || 'Hitilafu imetokea. Tafadhali jaribu tena.', 'error');
            }
        })
        .catch(error => {
            console.error('Error sending message:', error);
            showNotification('Hitilafu imetokea. Tafadhali jaribu tena.', 'error');
        });
    }

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

    // === UTILITY FUNCTIONS ===
    function showLoading(show) {
        const loadingElement = document.getElementById('ajaxLoading');
        if (loadingElement) {
            loadingElement.classList.toggle('show', show);
        }
    }

    function showNotification(message, type = 'info') {
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

    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    function scrollToCategories() {
        const categoriesElement = document.getElementById('stickyCategories');
        if (categoriesElement) {
            const offset = 80;
            const elementPosition = categoriesElement.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - offset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }
    }

    function initializeProductInteractions() {
        document.querySelectorAll('.share-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const productName = this.dataset.productName;
                const productImage = this.dataset.productImage || 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=500';

                openShareSheet(productId, productName, productImage);
            });
        });

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

            const startAutoScroll = () => {
                autoScrollInterval = setInterval(() => {
                    const nextIndex = (currentIndex + 1) % images.length;
                    scrollToImage(nextIndex);
                }, 5000);
            };

            const stopAutoScroll = () => {
                clearInterval(autoScrollInterval);
            };

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

            startAutoScroll();

            carousel.addEventListener('mouseenter', stopAutoScroll);
            carousel.addEventListener('mouseleave', startAutoScroll);

            updateIndicators();
        });
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
            <div class="seller-fade flex items-center space-x-3 p-3 bg-green-50 dark:bg-gray-700 rounded-xl border border-green-200 dark:border-gray-600 cursor-pointer group hover:shadow-lg transition-all duration-300">
                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg">
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

    // === ENHANCED ROTATING TRENDING PRODUCTS ===
    let currentTrendingIndex = 0;
    let trendingProducts = @json(($trendingProducts ?? collect())->take(3));
    let trendingInterval;

    function startTrendingRotation() {
        if (trendingProducts.length <= 1) return;

        const trendingContainer = document.getElementById('trendingContainer');
        if (!trendingContainer) return;

        let trendingHtml = '';
        trendingProducts.forEach((product, index) => {
            trendingHtml += `
                <div class="trending-item ${index === 0 ? 'active' : ''}">
                    <div class="flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-gray-200 dark:border-gray-600">
                        <img src="${product.product_images && product.product_images.length > 0 ? '{{ asset("storage/") }}/' + product.product_images[0].image_path : 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=100'}"
                             alt="${product.name}"
                             class="w-16 h-16 object-cover rounded-xl shadow-sm group-hover:scale-110 transition-transform duration-300">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-800 dark:text-gray-100 text-sm leading-tight group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">${product.name.length > 30 ? product.name.substring(0, 30) + '...' : product.name}</p>
                            <p class="text-green-600 dark:text-green-400 font-bold text-base mt-1">TZS ${product.price.toLocaleString()}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center space-x-1">
                                <i class="fas fa-eye"></i>
                                <span>${product.view_count || 0} views</span>
                            </p>
                        </div>
                    </div>
                </div>
            `;
        });

        trendingContainer.innerHTML = trendingHtml;

        trendingInterval = setInterval(() => {
            rotateTrendingProducts();
        }, 4000);
    }

    function rotateTrendingProducts() {
        if (trendingProducts.length <= 1) return;

        const trendingItems = document.querySelectorAll('.trending-item');
        if (trendingItems.length === 0) return;

        trendingItems.forEach(item => item.classList.remove('active'));

        currentTrendingIndex = (currentTrendingIndex + 1) % trendingItems.length;
        trendingItems[currentTrendingIndex].classList.add('active');
    }

    // === INITIALIZATION ===
    document.addEventListener('DOMContentLoaded', function() {
        initializeTheme();
        initializeCategories();
        updateCartDisplay();
        initializeProductInteractions();

        if (document.getElementById('rotatingSellers')) {
            rotateSellers();
            setInterval(rotateSellers, 20000);
        }

        if (document.getElementById('trendingContainer')) {
            startTrendingRotation();
        }

        window.addEventListener('scroll', function() {
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 500) {
                loadMoreProducts();
            }
        });

        document.addEventListener('click', (e) => {
            if (e.target.id === 'desktopCartOverlay' || e.target.id === 'mobileCartOverlay' || e.target.id === 'shareOverlay') {
                closeCart();
                closeShareSheet();
            }

            const contactModal = document.getElementById('contactSellerModal');
            if (contactModal && e.target === contactModal) {
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

        document.querySelectorAll('img').forEach(img => {
            img.addEventListener('error', function() {
                this.src = 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=500';
                this.alt = 'Image not available';
            });
        });
    });

    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            closeCart();
            closeShareSheet();
        }
    });
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

        <button onclick="proceedToCheckout()" class="w-full bg-green-600 hover:bg-green-700 text-white py-4 rounded-xl font-semibold transition-all duration-300 flex items-center justify-center space-x-3 shadow-lg hover:shadow-xl">
            <i class="fas fa-lock"></i>
            <span class="text-lg">Proceed to Checkout</span>
        </button>
    </div>
</div>

<!-- Enhanced Mobile Cart Bottom Sheet -->
<div class="modal-overlay" id="mobileCartOverlay" onclick="closeCart()"></div>
<div class="enhanced-bottom-sheet" id="mobileCartSheet">
    <div class="bottom-sheet-handle"></div>
    <div class="bottom-sheet-content p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100">Your Cart</h3>
            <button onclick="closeCart()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div id="mobileCartItems" class="space-y-4 mb-4 max-h-48 overflow-y-auto">
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

<!-- Enhanced Share Bottom Sheet -->
<div class="modal-overlay" id="shareOverlay" onclick="closeShareSheet()"></div>
<div class="enhanced-bottom-sheet" id="shareBottomSheet">
    <div class="bottom-sheet-handle"></div>
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
            <button onclick="shareToPlatform('copy')" class="flex flex-col items-center space-y-2 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                <i class="fas fa-link text-gray-600 dark:text-gray-400 text-2xl"></i>
                <span class="text-xs font-medium text-gray-700 dark:text-gray-300">Copy Link</span>
            </button>
        </div>
    </div>
</div>

<!-- Enhanced Contact Seller Modal -->
<div id="contactSellerModal" class="contact-modal">
    <div class="contact-modal-content">
        <button onclick="closeContactModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
            <i class="fas fa-times text-xl"></i>
        </button>
        <div class="text-center mb-6">
            <div class="w-20 h-20 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
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
            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold transition-all duration-300 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl transform hover:scale-105">
                <i class="fas fa-paper-plane"></i>
                <span class="text-lg">Send Message</span>
            </button>
        </form>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-8xl mx-auto px-3 sm:px-6 pt-24 pb-24">
    <!-- Enhanced Mobile Categories Bar -->
    <div id="stickyCategories" class="lg:hidden sticky-categories bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-4 mobile-categories-container z-30" style="top: 80px;">
        <div class="category-scroll-container relative">
            <div class="categories-scroll">
                @foreach($categories as $category)
                <button data-category-id="{{ $category->id }}"
                        onclick="toggleCategory('{{ $category->id }}', '{{ $category->name }}')"
                        class="category-btn flex flex-col items-center cursor-pointer group flex-shrink-0 p-3 rounded-xl bg-white dark:bg-gray-800 hover:shadow-md transition-all duration-300">
                    <div class="relative">
                        <div class="w-14 h-14 rounded-full bg-gray-100 dark:bg-gray-700 shadow-lg flex items-center justify-center group-hover:bg-green-100 dark:group-hover:bg-green-900 transition-colors">
                            <i class="fas fa-{{ \App\Http\Controllers\ProductController::getCategoryIconStatic($category->name) }} category-icon text-lg"></i>
                        </div>
                        <div class="absolute -top-1 -right-1 bg-yellow-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold border-2 border-white dark:border-gray-800 shadow-lg">
                            {{ $category->products_count ?? 0 }}
                        </div>
                    </div>
                    <span class="category-name text-xs font-semibold text-gray-700 dark:text-gray-300 mt-2 truncate max-w-16 text-center">
                        {{ $category->name }}
                    </span>
                </button>
                @endforeach
            </div>
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
                    <button data-category-id="{{ $category->id }}"
                            onclick="toggleCategory('{{ $category->id }}', '{{ $category->name }}')"
                            class="category-btn w-full flex items-center justify-between p-3 rounded-xl bg-white dark:bg-gray-800 hover:shadow-md transition-all duration-300 group">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center group-hover:bg-green-100 dark:group-hover:bg-green-900 transition-colors">
                                <i class="fas fa-{{ \App\Http\Controllers\ProductController::getCategoryIconStatic($category->name) }} category-icon text-sm"></i>
                            </div>
                            <span class="category-name text-gray-700 dark:text-gray-300 font-medium text-sm group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">{{ $category->name }}</span>
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
                        <div class="flex items-center space-x-3 p-3 bg-green-50 dark:bg-gray-700 rounded-xl border border-green-200 dark:border-gray-600 cursor-pointer group hover:shadow-lg transition-all duration-300">
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg">
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

        <!-- Product Feed -->
        <div class="flex-1 min-w-0">
            <div id="productFeed" class="space-y-6 pb-8">
                @include('partials.products.product_post')
            </div>
        </div>

        <!-- Enhanced Right Sidebar with Rotating Trending Products -->
        <div class="sidebar-wide hidden lg:block xl:hidden 2xl:block bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 h-fit sticky top-32 shadow-lg">
            <div class="mb-8">
                <h3 class="font-bold text-xl text-gray-800 dark:text-gray-100 mb-4 flex items-center space-x-2">
                    <i class="fas fa-fire text-red-500"></i>
                    <span>Trending Now</span>
                </h3>
                <div id="trendingContainer" class="trending-container">
                    @if($trendingProducts->count() > 0)
                        @foreach($trendingProducts->take(3) as $trending)
                        <div class="trending-item {{ $loop->first ? 'active' : '' }}">
                            <div class="flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-gray-200 dark:border-gray-600">
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
                <button onclick="openCart()" class="w-full bg-green-600 hover:bg-green-700 text-white py-3.5 rounded-xl font-semibold transition-all duration-300 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-shopping-bag"></i>
                    <span>View Cart</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
