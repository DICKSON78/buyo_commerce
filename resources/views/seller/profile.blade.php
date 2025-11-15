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
</style>

<!-- ADD NAVIGATION BAR -->
<nav id="mainNav" class="fixed top-0 w-full nav-green shadow-sm z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-3 sm:px-6">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center">
                        <i class="fas fa-store text-green-600 dark:text-green-400 text-lg"></i>
                    </div>
                    <span class="text-white font-bold text-xl hidden sm:block">My Profile</span>
                </div>
            </div>



            

               
            </div>
        </div>
    </div>
</nav>

@php
    // FALLBACK: Weka default values kama variables hazipo
    $sellerProducts = $sellerProducts ?? collect([]);
    $productStats = $productStats ?? ['total' => 0, 'active' => 0, 'sold' => 0];
@endphp

<!-- Instagram Style Profile -->
<div class="max-w-4xl mx-auto px-2 sm:px-4 pt-24 pb-24"> <!-- Changed pt-16 to pt-24 for the nav bar -->
    <!-- Profile Header - Instagram Style -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
        <div class="p-6">
            <div class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8">
                <!-- Profile Picture -->
                <div class="relative flex-shrink-0">
                    <div class="w-24 h-24 md:w-32 md:h-32 bg-gradient-to-r from-green-400 to-green-600 rounded-full flex items-center justify-center text-white text-2xl font-bold overflow-hidden border-4 border-white dark:border-gray-800 shadow-lg">
                        @if($seller->logo && Storage::exists('public/' . $seller->logo))
                            <img src="{{ asset('storage/' . $seller->logo) }}"
                                 alt="{{ $seller->store_name }}"
                                 class="w-full h-full rounded-full object-cover">
                        @else
                            {{ strtoupper(substr($seller->store_name ?? 'S', 0, 1)) }}
                        @endif
                    </div>
                </div>

                <!-- Profile Info -->
                <div class="flex-1 text-center md:text-left">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                        <div>
                            <h1 class="text-2xl font-light text-gray-800 dark:text-gray-100">{{ $seller->store_name ?? 'My Store' }}</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1 text-sm">{{ $user->username ?? '@seller' }}</p>
                        </div>
                        <div class="mt-4 md:mt-0 flex space-x-3">
                            <a href="{{ route('seller.products.create') }}"
                               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center text-sm">
                                <i class="fas fa-plus mr-2"></i>Add Product
                            </a>
                        </div>
                    </div>

                    <!-- Stats for Seller - Instagram Style -->
                    <div class="flex justify-center md:justify-start space-x-8 text-center mb-4">
                        <div>
                            <span class="block text-lg font-bold text-gray-800 dark:text-gray-100">
                                {{ $productStats['total'] ?? 0 }}
                            </span>
                            <span class="text-gray-600 dark:text-gray-400 text-sm">Products</span>
                        </div>
                        <div>
                            <span class="block text-lg font-bold text-gray-800 dark:text-gray-100">
                                {{ $seller->total_sales ?? 0 }}
                            </span>
                            <span class="text-gray-600 dark:text-gray-400 text-sm">Sales</span>
                        </div>
                        <div>
                            <span class="block text-lg font-bold text-gray-800 dark:text-gray-100">
                                {{ number_format($seller->rating ?? 0, 1) }}
                            </span>
                            <span class="text-gray-600 dark:text-gray-400 text-sm">Rating</span>
                        </div>
                    </div>

                    <!-- Store Description -->
                    <div class="mt-4">
                        <h2 class="font-semibold text-gray-800 dark:text-gray-100 text-sm">
                            {{ $user->full_name ?? 'Store Owner' }}
                        </h2>
                        <p class="text-gray-800 dark:text-gray-200 text-sm mt-2">
                            {{ $seller->store_description ?? 'No store description yet. Add a description to tell customers about your business.' }}
                        </p>

                        <!-- Location Info -->
                        <div class="mt-3 flex items-center text-gray-600 dark:text-gray-400 text-sm">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span>
                                {{ $seller->business_place ?? 'Location not set' }}, {{ $seller->business_region ?? 'Region not set' }}
                            </span>
                        </div>

                        <!-- Member Since -->
                        <div class="mt-2 flex items-center text-gray-600 dark:text-gray-400 text-sm">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            <span>
                                Member since {{ $seller->created_at->format('F Y') }}
                            </span>
                        </div>

                        <!-- Verification Badge -->
                        @if($seller->is_verified)
                        <div class="inline-flex items-center mt-3 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded-full text-xs">
                            <i class="fas fa-check-circle mr-1"></i>
                            Verified Seller
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid - Instagram Style -->
    <div class="mb-6">
        @if($sellerProducts->count() > 0)
            <!-- Products Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
                @foreach($sellerProducts as $product)
                <div class="relative group bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all duration-300">
                    <!-- Product Image -->
                    <a href="{{ route('seller.products.edit', $product->id) }}" class="block aspect-square">
                        @if($product->images && $product->images->count() > 0)
                            @php
                                $primaryImage = $product->images->where('is_primary', true)->first() ?? $product->images->first();
                            @endphp
                            <img src="{{ asset('storage/' . $primaryImage->image_path) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 rounded-t-xl">
                        @else
                            <div class="w-full h-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center rounded-t-xl">
                                <i class="fas fa-box text-gray-400 text-2xl"></i>
                            </div>
                        @endif

                        <!-- Product Overlay on Hover -->
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100 rounded-t-xl">
                            <div class="text-white text-center p-3">
                                <h3 class="font-semibold text-sm mb-1 line-clamp-2">{{ Str::limit($product->name, 40) }}</h3>
                                <p class="text-sm font-bold mb-2">TZS {{ number_format($product->price) }}</p>
                                <div class="flex justify-center space-x-3 text-xs">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-eye"></i>
                                        <span>{{ $product->view_count ?? 0 }}</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-shopping-cart"></i>
                                        <span>{{ $product->sold_count ?? 0 }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- Product Info (Like Dashboard Cards) -->
                    <div class="p-3">
                        <h3 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1 truncate">{{ $product->name }}</h3>
                        <div class="flex justify-between items-center">
                            <p class="text-green-600 dark:text-green-400 font-bold text-sm">TZS {{ number_format($product->price) }}</p>
                            <span class="px-2 py-1 rounded-full text-xs {{ $product->stock_quantity > 10 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' }}">
                                {{ $product->stock_quantity }} left
                            </span>
                        </div>
                        <div class="flex justify-between items-center mt-2 text-xs text-gray-500 dark:text-gray-400">
                            <span>{{ $product->sold_count ?? 0 }} sold</span>
                            <div class="flex space-x-1">
                                <button onclick="openEditModal({{ $product->id }})"
                                        class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="openDeleteModal({{ $product->id }})"
                                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product Status Badge -->
                    <div class="absolute top-2 left-2">
                        @if($product->status === 'sold')
                            <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">Sold</span>
                        @elseif(($product->stock_quantity ?? 0) == 0)
                            <span class="bg-gray-500 text-white text-xs px-2 py-1 rounded-full">Out of Stock</span>
                        @elseif($product->is_featured)
                            <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded-full">Featured</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Show total products count -->
            <div class="text-center mt-6">
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    Showing {{ $sellerProducts->count() }} of {{ $productStats['total'] ?? 0 }} products
                </p>

                @if(($productStats['total'] ?? 0) > $sellerProducts->count())
                <a href="{{ route('seller.products.index') }}"
                   class="inline-block mt-2 text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 text-sm font-medium">
                    View all products →
                </a>
                @endif
            </div>

        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-camera text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">No Products Yet</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4 max-w-md mx-auto">
                    Start building your store by adding your first product. Show customers what you have to offer!
                </p>
                <a href="{{ route('seller.products.create') }}"
                   class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i>Add Your First Product
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Bottom Navigation - Same as Dashboard -->
@include('partials.bottom_nav')

<!-- Delete Product Modal (Same as Dashboard) -->
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

    // === DROPDOWN FUNCTION ===
    function toggleDropdown() {
        document.getElementById('accountDropdown').classList.toggle('active');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        const dropdown = document.getElementById('accountDropdown');
        if (dropdown && !dropdown.contains(e.target)) {
            dropdown.classList.remove('active');
        }
    });

    // === DARK MODE TOGGLE ===
    const themeToggle = document.getElementById('themeToggle');
    const html = document.documentElement;

    if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        html.classList.add('dark');
        if (themeToggle) themeToggle.innerHTML = '<i class="fas fa-sun text-lg"></i>';
    } else {
        if (themeToggle) themeToggle.innerHTML = '<i class="fas fa-moon text-lg"></i>';
    }

    if (themeToggle) {
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
    }

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

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target.id === 'deleteModal') {
            closeDeleteModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>

<style>
    /* Instagram-like grid styles */
    .grid.grid-cols-2 {
        grid-template-columns: repeat(2, 1fr);
    }

    @media (min-width: 768px) {
        .grid.grid-cols-2 {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    .aspect-square {
        aspect-ratio: 1 / 1;
    }

    /* Smooth hover effects */
    .group:hover .group-hover\:scale-105 {
        transform: scale(1.05);
    }

    /* Line clamp for text truncation */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Dropdown styles */
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

    /* Custom animations */
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

    .grid > div {
        animation: fadeIn 0.5s ease-out;
    }

    /* Stagger animation for grid items */
    .grid > div:nth-child(odd) { animation-delay: 0.1s; }
    .grid > div:nth-child(even) { animation-delay: 0.2s; }
</style>
@endsection