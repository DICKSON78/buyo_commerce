<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard - Buyo</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            margin: 0;
            padding: 0;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .nav-green {
            background: #008000;
        }
        .dark .nav-green {
            background: #0a5c0a;
        }
        .product-green { background: #008000; color: white; }
        .dark .product-green { background: #0a5c0a; }
        .product-green-light { background: #e6f4ea; }
        .dark .product-green-light { background: #1a3a2a; }
        .product-green-border { border-color: #008000; }
        .dark .product-green-border { border-color: #0a5c0a; }
        .product-green-text { color: #008000; }
        .dark .product-green-text { color: #4CAF50; }

        /* Dropdown */
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 180px;
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
        .dropdown-content a i {
            margin-right: 8px;
            width: 16px;
        }
        .dropdown.active .dropdown-content {
            display: block;
        }

        /* Dashboard Styles */
        .stat-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .order-status-pending {
            background: #fef3c7;
            color: #d97706;
        }
        .order-status-completed {
            background: #d1fae5;
            color: #065f46;
        }
        .order-status-shipped {
            background: #dbeafe;
            color: #1e40af;
        }
        .order-status-cancelled {
            background: #fee2e2;
            color: #dc2626;
        }
        .nav-tab {
            transition: all 0.3s ease;
        }
        .nav-tab.active {
            background: #008000;
            color: white;
            border-bottom: 3px solid #FFD700;
        }

        /* Mobile Tabs */
        .mobile-tab {
            flex: 1;
            min-width: 0;
            padding: 12px 8px;
            font-size: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .mobile-tab.active {
            color: #008000;
            border-bottom: 2px solid #008000;
        }
        .mobile-tab i {
            margin-bottom: 4px;
            font-size: 16px;
        }

        /* Scrollbar hiding */
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-300">
    <!-- Top Navigation Bar -->
    <nav class="fixed top-0 w-full nav-green shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-3 sm:px-6">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="hidden sm:flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center">
                            <i class="fas fa-store text-green-600 dark:text-green-400 text-lg"></i>
                        </div>
                        <span class="text-white font-bold text-xl">Buyo Seller</span>
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
                        <span class="absolute -top-2 -right-2 bg-yellow-500 text-gray-900 dark:text-gray-100 text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">3</span>
                    </button>

                    <!-- Messages -->
                    <button class="text-white hover:text-yellow-300 transition-colors relative">
                        <i class="fas fa-comments text-lg"></i>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">5</span>
                    </button>

                    <!-- User Account Dropdown -->
                    <div class="dropdown" id="accountDropdown">
                        <button onclick="toggleDropdown()" class="text-white hover:text-yellow-300 transition-colors relative" title="Account">
                            <i class="fas fa-user text-lg"></i>
                            <span class="absolute -top-2 -right-2 bg-yellow-500 text-gray-900 dark:text-gray-100 text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">JM</span>
                        </button>
                        <div class="dropdown-content">
                            <a href="seller-dashboard.html"><i class="fas fa-tachometer-alt"></i> Seller Dashboard</a>
                            <a href="customer-dashboard.html"><i class="fas fa-user-circle"></i> Customer Dashboard</a>
                            <a href="#"><i class="fas fa-cog"></i> Settings</a>
                            <a href="#" class="text-red-600 dark:text-red-400"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-2 sm:px-4 pt-20 pb-20 sm:pb-0">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Seller Dashboard</h1>
            <p class="text-gray-600 dark:text-gray-400">Welcome back, John! Here's your business overview.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stat-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Total Revenue</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">TZS 12.5M</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                        <i class="fas fa-money-bill-wave text-green-600 dark:text-green-400 text-xl"></i>
                    </div>
                </div>
                <p class="text-green-600 dark:text-green-400 text-sm mt-2"><i class="fas fa-arrow-up mr-1"></i> 15% from last month</p>
            </div>

            <div class="stat-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Total Orders</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">156</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-blue-600 dark:text-blue-400 text-xl"></i>
                    </div>
                </div>
                <p class="text-green-600 dark:text-green-400 text-sm mt-2"><i class="fas fa-arrow-up mr-1"></i> 8% from last month</p>
            </div>

            <div class="stat-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Products</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">24</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                        <i class="fas fa-box text-purple-600 dark:text-purple-400 text-xl"></i>
                    </div>
                </div>
                <p class="text-green-600 dark:text-green-400 text-sm mt-2"><i class="fas fa-plus mr-1"></i> 2 new this week</p>
            </div>

            <div class="stat-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Rating</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">4.8/5</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center">
                        <i class="fas fa-star text-yellow-600 dark:text-yellow-400 text-xl"></i>
                    </div>
                </div>
                <p class="text-green-600 dark:text-green-400 text-sm mt-2">Based on 89 reviews</p>
            </div>
        </div>

        <!-- Mobile Tabs Navigation -->
        <div class="lg:hidden bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-4 overflow-x-auto scrollbar-hide">
            <div class="flex">
                <button class="mobile-tab active" data-tab="products-tab">
                    <i class="fas fa-box"></i>
                    <span>Products</span>
                </button>
                <button class="mobile-tab" data-tab="add-product-tab">
                    <i class="fas fa-plus-circle"></i>
                    <span>Add</span>
                </button>
                <button class="mobile-tab" data-tab="orders-tab">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                </button>
                <button class="mobile-tab" data-tab="messages-tab">
                    <i class="fas fa-comments"></i>
                    <span>Messages</span>
                </button>
            </div>
        </div>

        <!-- Main Tabs Content -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Desktop Tabs Header -->
            <div class="hidden lg:block border-b border-gray-200 dark:border-gray-700">
                <div class="flex overflow-x-auto">
                    <button class="tab-button py-4 px-6 font-medium border-b-2 border-green-600 text-green-600 flex items-center active" data-tab="products-tab">
                        <i class="fas fa-box mr-2"></i> My Products
                    </button>
                    <button class="tab-button py-4 px-6 font-medium text-gray-600 dark:text-gray-400 border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 flex items-center" data-tab="add-product-tab">
                        <i class="fas fa-plus-circle mr-2"></i> Add Product
                    </button>
                    <button class="tab-button py-4 px-6 font-medium text-gray-600 dark:text-gray-400 border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 flex items-center" data-tab="orders-tab">
                        <i class="fas fa-shopping-cart mr-2"></i> Orders
                    </button>
                    <button class="tab-button py-4 px-6 font-medium text-gray-600 dark:text-gray-400 border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 flex items-center" data-tab="messages-tab">
                        <i class="fas fa-comments mr-2"></i> Messages
                    </button>
                </div>
            </div>

            <!-- Tab Content: My Products -->
            <div id="products-tab" class="tab-content p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 space-y-3 sm:space-y-0">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">My Products (24)</h2>
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                        <select class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                            <option>All Categories</option>
                            <option>Electronics</option>
                            <option>Fashion</option>
                            <option>Home & Garden</option>
                        </select>
                        <select class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                            <option>Sort by: Newest</option>
                            <option>Sort by: Price</option>
                            <option>Sort by: Name</option>
                        </select>
                    </div>
                </div>

                <!-- Products Grid - Responsive -->
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-3 sm:gap-4">
                    <!-- Product Card 1 -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-md transition-shadow bg-white dark:bg-gray-800">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=300" alt="iPhone" class="w-full h-24 sm:h-32 object-cover">
                        </div>
                        <div class="p-2 sm:p-3">
                            <h3 class="font-bold text-gray-800 dark:text-gray-100 text-xs sm:text-sm mb-1 truncate">iPhone 13 Pro</h3>
                            <p class="text-green-600 dark:text-green-400 font-semibold text-xs sm:text-sm mb-2">TZS 2.5M</p>
                            <div class="flex justify-between items-center text-xs text-gray-600 dark:text-gray-400 mb-2">
                                <span>Sales: 45</span>
                                <span>4.8★</span>
                            </div>
                            <div class="flex space-x-1">
                                <button onclick="openEditModal()" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-1 rounded text-xs font-medium transition-colors">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="openDeleteModal()" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-1 rounded text-xs font-medium transition-colors">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product Card 2 -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-md transition-shadow bg-white dark:bg-gray-800">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=300" alt="Shoes" class="w-full h-24 sm:h-32 object-cover">
                        </div>
                        <div class="p-2 sm:p-3">
                            <h3 class="font-bold text-gray-800 dark:text-gray-100 text-xs sm:text-sm mb-1 truncate">Running Shoes</h3>
                            <p class="text-green-600 dark:text-green-400 font-semibold text-xs sm:text-sm mb-2">TZS 120K</p>
                            <div class="flex justify-between items-center text-xs text-gray-600 dark:text-gray-400 mb-2">
                                <span>Sales: 23</span>
                                <span>4.5★</span>
                            </div>
                            <div class="flex space-x-1">
                                <button onclick="openEditModal()" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-1 rounded text-xs font-medium transition-colors">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="openDeleteModal()" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-1 rounded text-xs font-medium transition-colors">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product Card 3 -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-md transition-shadow bg-white dark:bg-gray-800">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=300" alt="Headphones" class="w-full h-24 sm:h-32 object-cover">
                        </div>
                        <div class="p-2 sm:p-3">
                            <h3 class="font-bold text-gray-800 dark:text-gray-100 text-xs sm:text-sm mb-1 truncate">Wireless Headphones</h3>
                            <p class="text-green-600 dark:text-green-400 font-semibold text-xs sm:text-sm mb-2">TZS 85K</p>
                            <div class="flex justify-between items-center text-xs text-gray-600 dark:text-gray-400 mb-2">
                                <span>Sales: 67</span>
                                <span>4.7★</span>
                            </div>
                            <div class="flex space-x-1">
                                <button onclick="openEditModal()" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-1 rounded text-xs font-medium transition-colors">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="openDeleteModal()" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-1 rounded text-xs font-medium transition-colors">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product Card 4 -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-md transition-shadow bg-white dark:bg-gray-800">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=300" alt="Camera" class="w-full h-24 sm:h-32 object-cover">
                        </div>
                        <div class="p-2 sm:p-3">
                            <h3 class="font-bold text-gray-800 dark:text-gray-100 text-xs sm:text-sm mb-1 truncate">Digital Camera</h3>
                            <p class="text-green-600 dark:text-green-400 font-semibold text-xs sm:text-sm mb-2">TZS 450K</p>
                            <div class="flex justify-between items-center text-xs text-gray-600 dark:text-gray-400 mb-2">
                                <span>Sales: 34</span>
                                <span>4.9★</span>
                            </div>
                            <div class="flex space-x-1">
                                <button onclick="openEditModal()" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-1 rounded text-xs font-medium transition-colors">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="openDeleteModal()" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-1 rounded text-xs font-medium transition-colors">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product Card 5 -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-md transition-shadow bg-white dark:bg-gray-800">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=300" alt="Dress" class="w-full h-24 sm:h-32 object-cover">
                        </div>
                        <div class="p-2 sm:p-3">
                            <h3 class="font-bold text-gray-800 dark:text-gray-100 text-xs sm:text-sm mb-1 truncate">African Print Dress</h3>
                            <p class="text-green-600 dark:text-green-400 font-semibold text-xs sm:text-sm mb-2">TZS 85K</p>
                            <div class="flex justify-between items-center text-xs text-gray-600 dark:text-gray-400 mb-2">
                                <span>Sales: 28</span>
                                <span>4.6★</span>
                            </div>
                            <div class="flex space-x-1">
                                <button onclick="openEditModal()" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-1 rounded text-xs font-medium transition-colors">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="openDeleteModal()" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-1 rounded text-xs font-medium transition-colors">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product Card 6 -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-md transition-shadow bg-white dark:bg-gray-800">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=300" alt="Cake" class="w-full h-24 sm:h-32 object-cover">
                        </div>
                        <div class="p-2 sm:p-3">
                            <h3 class="font-bold text-gray-800 dark:text-gray-100 text-xs sm:text-sm mb-1 truncate">Custom Birthday Cake</h3>
                            <p class="text-green-600 dark:text-green-400 font-semibold text-xs sm:text-sm mb-2">TZS 45K</p>
                            <div class="flex justify-between items-center text-xs text-gray-600 dark:text-gray-400 mb-2">
                                <span>Sales: 19</span>
                                <span>4.8★</span>
                            </div>
                            <div class="flex space-x-1">
                                <button onclick="openEditModal()" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-1 rounded text-xs font-medium transition-colors">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="openDeleteModal()" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-1 rounded text-xs font-medium transition-colors">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Load More -->
                <div class="text-center mt-8">
                    <button class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 px-6 py-2 rounded-lg font-medium transition-colors">
                        Load More Products
                    </button>
                </div>
            </div>

            <!-- Tab Content: Add Product -->
            <div id="add-product-tab" class="tab-content p-4 sm:p-6 hidden">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-6">Add New Product</h2>
                
                <form id="add-product-form" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Product Images -->
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Product Images</label>
                            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 sm:p-6 text-center">
                                <i class="fas fa-cloud-upload-alt text-gray-400 text-2xl sm:text-3xl mb-2"></i>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">Drag & drop images here or click to browse</p>
                                <p class="text-gray-500 dark:text-gray-500 text-xs">Recommended size: 800x800px. Max 5 images.</p>
                                <button type="button" class="mt-3 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                    Browse Files
                                </button>
                            </div>
                        </div>

                        <!-- Product Description -->
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Product Description</label>
                            <textarea id="product-description" rows="4" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200" placeholder="Describe your product in detail..."></textarea>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Product Name -->
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Product Name</label>
                            <input id="product-name" type="text" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200" placeholder="Enter product name">
                        </div>

                        <!-- Category -->
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Category</label>
                            <select id="product-category" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                <option>Select Category</option>
                                <option>Electronics</option>
                                <option>Fashion</option>
                                <option>Home & Garden</option>
                                <option>Vehicles</option>
                                <option>Books</option>
                            </select>
                        </div>

                        <!-- Price & Stock -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Price (TZS)</label>
                                <input id="product-price" type="number" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200" placeholder="0.00">
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Stock Quantity</label>
                                <input id="product-stock" type="number" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200" placeholder="0">
                            </div>
                        </div>

                        <!-- Location -->
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Location</label>
                            <input id="product-location" type="text" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200" placeholder="City, Region">
                        </div>

                        <!-- Tags -->
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Tags</label>
                            <input id="product-tags" type="text" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200" placeholder="Add tags separated by commas">
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold transition-colors flex items-center justify-center">
                                <i class="fas fa-plus-circle mr-2"></i> Post Product
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tab Content: Orders -->
            <div id="orders-tab" class="tab-content p-4 sm:p-6 hidden">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 space-y-3 sm:space-y-0">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Recent Orders (12)</h2>
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                        <select class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                            <option>All Status</option>
                            <option>Pending</option>
                            <option>Shipped</option>
                            <option>Delivered</option>
                            <option>Cancelled</option>
                        </select>
                        <input type="date" class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                <th class="py-3 px-2 sm:px-4 text-left text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400">Order ID</th>
                                <th class="py-3 px-2 sm:px-4 text-left text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400">Customer</th>
                                <th class="py-3 px-2 sm:px-4 text-left text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400">Product</th>
                                <th class="py-3 px-2 sm:px-4 text-left text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400">Amount</th>
                                <th class="py-3 px-2 sm:px-4 text-left text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400">Status</th>
                                <th class="py-3 px-2 sm:px-4 text-left text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400">Date</th>
                                <th class="py-3 px-2 sm:px-4 text-left text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Order 1 -->
                            <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="py-3 px-2 sm:px-4 text-xs sm:text-sm font-medium text-gray-800 dark:text-gray-200">#BH2024001</td>
                                <td class="py-3 px-2 sm:px-4 text-xs sm:text-sm">Sarah Johnson</td>
                                <td class="py-3 px-2 sm:px-4 text-xs sm:text-sm">iPhone 13 Pro</td>
                                <td class="py-3 px-2 sm:px-4 text-xs sm:text-sm font-semibold text-green-600 dark:text-green-400">TZS 2.5M</td>
                                <td class="py-3 px-2 sm:px-4 text-xs sm:text-sm">
                                    <span class="px-2 py-1 rounded-full text-xs order-status-pending">Pending</span>
                                </td>
                                <td class="py-3 px-2 sm:px-4 text-xs sm:text-sm text-gray-600 dark:text-gray-400">15 Jan 2024</td>
                                <td class="py-3 px-2 sm:px-4 text-xs sm:text-sm">
                                    <button class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 mr-2">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Order 2 -->
                            <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="py-3 px-2 sm:px-4 text-xs sm:text-sm font-medium text-gray-800 dark:text-gray-200">#BH2024002</td>
                                <td class="py-3 px-2 sm:px-4 text-xs sm:text-sm">Michael Brown</td>
                                <td class="py-3 px-2 sm:px-4 text-xs sm:text-sm">Running Shoes</td>
                                <td class="py-3 px-2 sm:px-4 text-xs sm:text-sm font-semibold text-green-600 dark:text-green-400">TZS 120K</td>
                                <td class="py-3 px-2 sm:px-4 text-xs sm:text-sm">
                                    <span class="px-2 py-1 rounded-full text-xs order-status-shipped">Shipped</span>
                                </td>
                                <td class="py-3 px-2 sm:px-4 text-xs sm:text-sm text-gray-600 dark:text-gray-400">14 Jan 2024</td>
                                <td class="py-3 px-2 sm:px-4 text-xs sm:text-sm">
                                    <button class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 mr-2">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Order 3 -->
                            <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="py-3 px-2 sm:px-4 text-xs sm:text-sm font-medium text-gray-800 dark:text-gray-200">#BH2024003</td>
                                <td class="py-3 px-2 sm:px-4 text-xs sm:text-sm">Grace Williams</td>
                                <td class="py-3 px-2 sm:px-4 text-xs sm:text-sm">Wireless Headphones</td>
                                <td class="py-3 px-2 sm:px-4 text-xs sm:text-sm font-semibold text-green-600 dark:text-green-400">TZS 85K</td>
                                <td class="py-3 px-2 sm:px-4 text-xs sm:text-sm">
                                    <span class="px-2 py-1 rounded-full text-xs order-status-completed">Delivered</span>
                                </td>
                                <td class="py-3 px-2 sm:px-4 text-xs sm:text-sm text-gray-600 dark:text-gray-400">12 Jan 2024</td>
                                <td class="py-3 px-2 sm:px-4 text-xs sm:text-sm">
                                    <button class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 mr-2">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="flex flex-col sm:flex-row justify-between items-center mt-6 space-y-3 sm:space-y-0">
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Showing 1-10 of 156 orders</p>
                    <div class="flex space-x-2">
                        <button class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 px-3 py-1 rounded text-sm">Previous</button>
                        <button class="bg-green-600 text-white px-3 py-1 rounded text-sm">1</button>
                        <button class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 px-3 py-1 rounded text-sm">2</button>
                        <button class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 px-3 py-1 rounded text-sm">3</button>
                        <button class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 px-3 py-1 rounded text-sm">Next</button>
                    </div>
                </div>
            </div>

            <!-- Tab Content: Messages -->
            <div id="messages-tab" class="tab-content p-4 sm:p-6 hidden">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-6">Customer Messages</h2>
                
                <div class="space-y-4">
                    <!-- Message 1 -->
                    <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors bg-white dark:bg-gray-800">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-2 space-y-2 sm:space-y-0">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-bold">SJ</div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 dark:text-gray-100">Sarah Johnson</h4>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">Regarding: iPhone 13 Pro</p>
                                </div>
                            </div>
                            <span class="text-gray-500 dark:text-gray-400 text-sm">2 hours ago</span>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 mb-3">Hello, I'm interested in the iPhone 13 Pro. Is it still available and do you offer delivery to Arusha?</p>
                        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-medium transition-colors">
                                <i class="fas fa-reply mr-1"></i> Reply
                            </button>
                            <button class="bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 px-4 py-2 rounded text-sm font-medium transition-colors">
                                Mark as Read
                            </button>
                        </div>
                    </div>

                    <!-- Message 2 -->
                    <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors bg-white dark:bg-gray-800">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-2 space-y-2 sm:space-y-0">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">MB</div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 dark:text-gray-100">Michael Brown</h4>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">Regarding: Running Shoes</p>
                                </div>
                            </div>
                            <span class="text-gray-500 dark:text-gray-400 text-sm">5 hours ago</span>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 mb-3">Hi, I received the running shoes but they are a bit small. Do you have size 42 available for exchange?</p>
                        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-medium transition-colors">
                                <i class="fas fa-reply mr-1"></i> Reply
                            </button>
                            <button class="bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 px-4 py-2 rounded text-sm font-medium transition-colors">
                                Mark as Read
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                <button onclick="confirmDelete()" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-3 rounded-lg font-semibold transition-colors">
                    Delete Product
                </button>
            </div>
        </div>
    </div>

    <script>
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

        // === TAB FUNCTIONALITY - IMPROVED ===
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button, .mobile-tab');
            const tabContents = document.querySelectorAll('.tab-content');
            
            // Store current tab in sessionStorage
            let currentTab = sessionStorage.getItem('currentTab') || 'products-tab';
            
            function switchTab(tabName) {
                // Hide all tab contents
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });
                
                // Remove active state from all tabs
                tabButtons.forEach(button => {
                    if (button.classList.contains('tab-button')) {
                        button.classList.remove('border-green-600', 'text-green-600');
                        button.classList.add('text-gray-600', 'dark:text-gray-400', 'border-transparent');
                    } else if (button.classList.contains('mobile-tab')) {
                        button.classList.remove('active');
                    }
                });
                
                // Show selected tab content
                document.getElementById(tabName).classList.remove('hidden');
                
                // Store current tab
                sessionStorage.setItem('currentTab', tabName);
            }
            
            // Add event listeners to tabs
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const tabName = this.getAttribute('data-tab');
                    switchTab(tabName);
                    
                    // Update active state for desktop tabs
                    if (this.classList.contains('tab-button')) {
                        tabButtons.forEach(btn => {
                            if (btn.classList.contains('tab-button')) {
                                btn.classList.remove('border-green-600', 'text-green-600');
                                btn.classList.add('text-gray-600', 'dark:text-gray-400', 'border-transparent');
                            }
                        });
                        this.classList.remove('text-gray-600', 'dark:text-gray-400', 'border-transparent');
                        this.classList.add('border-green-600', 'text-green-600');
                    }
                    
                    // Update active state for mobile tabs
                    if (this.classList.contains('mobile-tab')) {
                        tabButtons.forEach(btn => {
                            if (btn.classList.contains('mobile-tab')) {
                                btn.classList.remove('active');
                            }
                        });
                        this.classList.add('active');
                    }
                });
            });
            
            // Initialize with stored tab
            if (document.getElementById(currentTab)) {
                switchTab(currentTab);
                // Update active buttons
                tabButtons.forEach(button => {
                    const tabName = button.getAttribute('data-tab');
                    if (tabName === currentTab) {
                        if (button.classList.contains('tab-button')) {
                            button.classList.remove('text-gray-600', 'dark:text-gray-400', 'border-transparent');
                            button.classList.add('border-green-600', 'text-green-600');
                        } else if (button.classList.contains('mobile-tab')) {
                            button.classList.add('active');
                        }
                    }
                });
            }
        });

        // === PRODUCT FORM SUBMISSION ===
        document.getElementById('add-product-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const productData = {
                name: document.getElementById('product-name').value,
                category: document.getElementById('product-category').value,
                price: document.getElementById('product-price').value,
                stock: document.getElementById('product-stock').value,
                location: document.getElementById('product-location').value,
                description: document.getElementById('product-description').value,
                tags: document.getElementById('product-tags').value
            };
            
            // Validate required fields
            if (!productData.name || !productData.category || !productData.price) {
                alert('Please fill in all required fields: Name, Category, and Price');
                return;
            }
            
            // Simulate API call to post product
            console.log('Posting product:', productData);
            
            // Show success message
            alert('Product posted successfully!');
            
            // Reset form
            this.reset();
            
            // Switch to products tab to see the new product
            switchTab('products-tab');
        });

        // === MODAL FUNCTIONS ===
        function openDeleteModal() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function confirmDelete() {
            alert('Product deleted successfully!');
            closeDeleteModal();
        }

        function openEditModal() {
            // This would open a separate edit product page
            alert('Redirecting to edit product page...');
            // window.location.href = 'edit-product.html';
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.id === 'deleteModal') {
                closeDeleteModal();
            }
        });

        // Helper function to switch tabs
        function switchTab(tabName) {
            const tabButtons = document.querySelectorAll('.tab-button, .mobile-tab');
            const tabContents = document.querySelectorAll('.tab-content');
            
            // Hide all tab contents
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active state from all tabs
            tabButtons.forEach(button => {
                if (button.classList.contains('tab-button')) {
                    button.classList.remove('border-green-600', 'text-green-600');
                    button.classList.add('text-gray-600', 'dark:text-gray-400', 'border-transparent');
                } else if (button.classList.contains('mobile-tab')) {
                    button.classList.remove('active');
                }
            });
            
            // Show selected tab content
            document.getElementById(tabName).classList.remove('hidden');
            
            // Update active buttons
            tabButtons.forEach(button => {
                const buttonTabName = button.getAttribute('data-tab');
                if (buttonTabName === tabName) {
                    if (button.classList.contains('tab-button')) {
                        button.classList.remove('text-gray-600', 'dark:text-gray-400', 'border-transparent');
                        button.classList.add('border-green-600', 'text-green-600');
                    } else if (button.classList.contains('mobile-tab')) {
                        button.classList.add('active');
                    }
                }
            });
            
            // Store current tab
            sessionStorage.setItem('currentTab', tabName);
        }
    </script>
</body>
</html>