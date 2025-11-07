<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - Buyo</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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
        .order-status-refunded {
            background: #f3e8ff;
            color: #7c3aed;
        }

        /* Payment Status */
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

        /* Progress Bar */
        .progress-bar {
            height: 6px;
            background: #e5e7eb;
            border-radius: 3px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background: #008000;
            transition: width 0.3s ease;
        }

        /* Receipt Styles */
        .receipt-container {
            background: white;
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 24px;
            max-width: 400px;
            margin: 0 auto;
        }
        .dark .receipt-container {
            background: #1f2937;
            border-color: #4b5563;
            color: #f9fafb;
        }
        .receipt-header {
            text-align: center;
            border-bottom: 2px solid #008000;
            padding-bottom: 16px;
            margin-bottom: 16px;
        }
        .receipt-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .dark .receipt-item {
            border-bottom-color: #4b5563;
        }
        .receipt-total {
            border-top: 2px solid #008000;
            font-weight: bold;
            font-size: 1.1em;
        }
        .dark .receipt-total {
            border-top-color: #4CAF50;
        }

        /* Chat Styles */
        .chat-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
        .chat-window {
            width: 350px;
            height: 500px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .dark .chat-window {
            background: #1f2937;
            color: #f9fafb;
        }
        .chat-header {
            background: #008000;
            color: white;
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .chat-messages {
            flex: 1;
            padding: 16px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .message {
            max-width: 80%;
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 8px;
        }
        .message.sent {
            background: #008000;
            color: white;
            align-self: flex-end;
            border-bottom-right-radius: 4px;
        }
        .message.received {
            background: #f3f4f6;
            color: #374151;
            align-self: flex-start;
            border-bottom-left-radius: 4px;
        }
        .dark .message.received {
            background: #374151;
            color: #f9fafb;
        }
        .chat-input {
            padding: 16px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            gap: 8px;
        }
        .dark .chat-input {
            border-top-color: #4b5563;
        }
        .chat-toggle {
            background: #008000;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        /* QR Code Container */
        .qr-container {
            text-align: center;
            padding: 16px;
            border-top: 1px solid #e5e7eb;
            margin-top: 16px;
        }
        .dark .qr-container {
            border-top-color: #4b5563;
        }
        .qr-code {
            width: 120px;
            height: 120px;
            background: #f3f4f6;
            margin: 0 auto 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }
        .dark .qr-code {
            background: #374151;
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
                        <span class="text-white font-bold text-xl">Buyo Customer</span>
                    </div>
                    <div class="sm:hidden w-10 h-10 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center">
                        <i class="fas fa-store text-green-600 dark:text-green-400 text-lg"></i>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 max-w-xl mx-2 sm:mx-4">
                    <form class="relative">
                        <input type="text" placeholder="Search orders, products..."
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
                        <span class="absolute -top-2 -right-2 bg-yellow-500 text-gray-900 dark:text-gray-100 text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">2</span>
                    </button>

                    <!-- Messages -->
                    <button class="text-white hover:text-yellow-300 transition-colors relative">
                        <i class="fas fa-comments text-lg"></i>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">3</span>
                    </button>

                    <!-- User Account Dropdown -->
                    <div class="dropdown" id="accountDropdown">
                        <button onclick="toggleDropdown()" class="text-white hover:text-yellow-300 transition-colors relative" title="Account">
                            <i class="fas fa-user text-lg"></i>
                            <span class="absolute -top-2 -right-2 bg-yellow-500 text-gray-900 dark:text-gray-100 text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">JD</span>
                        </button>
                        <div class="dropdown-content">
                            <a href="customer-dashboard.html"><i class="fas fa-tachometer-alt"></i> Customer Dashboard</a>
                            <a href="seller-dashboard.html"><i class="fas fa-store"></i> Seller Dashboard</a>
                            <a href="#"><i class="fas fa-cog"></i> Settings</a>
                            <a href="#" class="text-red-600 dark:text-red-400"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-2 sm:px-4 pt-20 pb-32 sm:pb-20">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Customer Dashboard</h1>
            <p class="text-gray-600 dark:text-gray-400">Welcome back, John Doe! Track your orders and payments.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="stat-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Total Orders</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">12</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-blue-600 dark:text-blue-400 text-xl"></i>
                    </div>
                </div>
                <p class="text-green-600 dark:text-green-400 text-sm mt-2"><i class="fas fa-arrow-up mr-1"></i> 2 new this week</p>
            </div>

            <div class="stat-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Pending Orders</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">3</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 dark:text-yellow-400 text-xl"></i>
                    </div>
                </div>
                <p class="text-yellow-600 dark:text-yellow-400 text-sm mt-2">Awaiting processing</p>
            </div>

            <div class="stat-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Support Tickets</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">2</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                        <i class="fas fa-headset text-purple-600 dark:text-purple-400 text-xl"></i>
                    </div>
                </div>
                <p class="text-blue-600 dark:text-blue-400 text-sm mt-2">1 awaiting response</p>
            </div>
        </div>

        <!-- Mobile Tabs Navigation -->
        <div class="lg:hidden bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-4 overflow-x-auto scrollbar-hide">
            <div class="flex">
                <button class="mobile-tab active" data-tab="orders-tab">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                </button>
                <button class="mobile-tab" data-tab="payments-tab">
                    <i class="fas fa-credit-card"></i>
                    <span>Payments</span>
                </button>
                <button class="mobile-tab" data-tab="tracking-tab">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Tracking</span>
                </button>
                <button class="mobile-tab" data-tab="receipts-tab">
                    <i class="fas fa-receipt"></i>
                    <span>Receipts</span>
                </button>
            </div>
        </div>

        <!-- Main Tabs Content -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Desktop Tabs Header -->
            <div class="hidden lg:block border-b border-gray-200 dark:border-gray-700">
                <div class="flex overflow-x-auto">
                    <button class="tab-button py-4 px-6 font-medium border-b-2 border-green-600 text-green-600 flex items-center active" data-tab="orders-tab">
                        <i class="fas fa-shopping-cart mr-2"></i> My Orders
                    </button>
                    <button class="tab-button py-4 px-6 font-medium text-gray-600 dark:text-gray-400 border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 flex items-center" data-tab="payments-tab">
                        <i class="fas fa-credit-card mr-2"></i> Payments
                    </button>
                    <button class="tab-button py-4 px-6 font-medium text-gray-600 dark:text-gray-400 border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 flex items-center" data-tab="tracking-tab">
                        <i class="fas fa-map-marker-alt mr-2"></i> Order Tracking
                    </button>
                    <button class="tab-button py-4 px-6 font-medium text-gray-600 dark:text-gray-400 border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 flex items-center" data-tab="receipts-tab">
                        <i class="fas fa-receipt mr-2"></i> Receipts
                    </button>
                </div>
            </div>

            <!-- Tab Content: My Orders -->
            <div id="orders-tab" class="tab-content p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 space-y-3 sm:space-y-0">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">My Orders (12)</h2>
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                        <select class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                            <option>All Status</option>
                            <option>Pending</option>
                            <option>Processing</option>
                            <option>Shipped</option>
                            <option>Delivered</option>
                        </select>
                        <input type="date" class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                    </div>
                </div>

                <!-- Orders List -->
                <div class="space-y-4">
                    <!-- Order 1 -->
                    <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:shadow-md transition-shadow bg-white dark:bg-gray-800">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-4">
                            <div class="flex items-center space-x-4 mb-3 lg:mb-0">
                                <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=100" alt="iPhone" class="w-16 h-16 object-cover rounded-lg">
                                <div>
                                    <h3 class="font-bold text-gray-800 dark:text-gray-100">iPhone 13 Pro 256GB</h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">Order #ORD-2024-001</p>
                                    <p class="text-green-600 dark:text-green-400 font-semibold">TZS 2,500,000</p>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                                <span class="px-3 py-1 rounded-full text-sm order-status-processing">Processing</span>
                                <span class="px-3 py-1 rounded-full text-sm payment-completed">Paid</span>
                            </div>
                        </div>
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-center space-x-4 mb-2 lg:mb-0">
                                <span><i class="fas fa-calendar mr-1"></i> Ordered: 15 Jan 2024</span>
                                <span><i class="fas fa-truck mr-1"></i> Estimated: 20 Jan 2024</span>
                            </div>
                            <div class="flex space-x-2">
                                <button onclick="viewOrderDetails('ORD-2024-001')" class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 px-3 py-1 border border-green-600 rounded-lg transition-colors">
                                    <i class="fas fa-eye mr-1"></i> View Details
                                </button>
                                <button onclick="trackOrder('ORD-2024-001')" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 px-3 py-1 border border-blue-600 rounded-lg transition-colors">
                                    <i class="fas fa-map-marker-alt mr-1"></i> Track
                                </button>
                                <button onclick="openSellerChat('Tech Store')" class="text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 px-3 py-1 border border-purple-600 rounded-lg transition-colors">
                                    <i class="fas fa-comment mr-1"></i> Chat Seller
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Order 2 -->
                    <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:shadow-md transition-shadow bg-white dark:bg-gray-800">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-4">
                            <div class="flex items-center space-x-4 mb-3 lg:mb-0">
                                <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=100" alt="Shoes" class="w-16 h-16 object-cover rounded-lg">
                                <div>
                                    <h3 class="font-bold text-gray-800 dark:text-gray-100">Running Shoes - Size 42</h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">Order #ORD-2024-002</p>
                                    <p class="text-green-600 dark:text-green-400 font-semibold">TZS 120,000</p>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                                <span class="px-3 py-1 rounded-full text-sm order-status-shipped">Shipped</span>
                                <span class="px-3 py-1 rounded-full text-sm payment-completed">Paid</span>
                            </div>
                        </div>
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-center space-x-4 mb-2 lg:mb-0">
                                <span><i class="fas fa-calendar mr-1"></i> Ordered: 14 Jan 2024</span>
                                <span><i class="fas fa-truck mr-1"></i> Shipped: 16 Jan 2024</span>
                            </div>
                            <div class="flex space-x-2">
                                <button onclick="viewOrderDetails('ORD-2024-002')" class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 px-3 py-1 border border-green-600 rounded-lg transition-colors">
                                    <i class="fas fa-eye mr-1"></i> View Details
                                </button>
                                <button onclick="trackOrder('ORD-2024-002')" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 px-3 py-1 border border-blue-600 rounded-lg transition-colors">
                                    <i class="fas fa-map-marker-alt mr-1"></i> Track
                                </button>
                                <button onclick="openSellerChat('Fashion Hub')" class="text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 px-3 py-1 border border-purple-600 rounded-lg transition-colors">
                                    <i class="fas fa-comment mr-1"></i> Chat Seller
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Load More -->
                <div class="text-center mt-8">
                    <button class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 px-6 py-2 rounded-lg font-medium transition-colors">
                        Load More Orders
                    </button>
                </div>
            </div>

            <!-- Tab Content: Payments -->
            <div id="payments-tab" class="tab-content p-4 sm:p-6 hidden">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-6">Payment History</h2>
                
                <div class="space-y-4">
                    <!-- Payment 1 -->
                    <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:shadow-md transition-shadow bg-white dark:bg-gray-800">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-3">
                            <div>
                                <h3 class="font-bold text-gray-800 dark:text-gray-100">Payment for Order #ORD-2024-001</h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">Transaction ID: TXN-00123456</p>
                            </div>
                            <div class="flex items-center space-x-4 mt-2 lg:mt-0">
                                <span class="text-green-600 dark:text-green-400 font-bold text-lg">TZS 2,500,000</span>
                                <span class="px-3 py-1 rounded-full text-sm payment-completed">Completed</span>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-center space-x-4">
                                <span><i class="fas fa-calendar mr-1"></i> Paid: 15 Jan 2024, 10:30 AM</span>
                                <span><i class="fas fa-credit-card mr-1"></i> Credit Card</span>
                            </div>
                            <button onclick="viewPaymentDetails('TXN-00123456')" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 mt-2 sm:mt-0">
                                <i class="fas fa-receipt mr-1"></i> View Receipt
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Content: Order Tracking -->
            <div id="tracking-tab" class="tab-content p-4 sm:p-6 hidden">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-6">Order Tracking</h2>
                
                <!-- Tracking for Order #ORD-2024-002 -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
                        <div>
                            <h3 class="font-bold text-gray-800 dark:text-gray-100 text-lg">Running Shoes - Size 42</h3>
                            <p class="text-gray-600 dark:text-gray-400">Order #ORD-2024-002</p>
                        </div>
                        <div class="flex items-center space-x-4 mt-3 lg:mt-0">
                            <span class="px-3 py-1 rounded-full text-sm order-status-shipped">Shipped</span>
                            <span class="text-green-600 dark:text-green-400 font-semibold">TZS 120,000</span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mb-6">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 75%"></div>
                        </div>
                    </div>

                    <!-- Tracking Steps -->
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white flex-shrink-0">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800 dark:text-gray-100">Order Confirmed</h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">Your order has been confirmed and is being processed</p>
                                <p class="text-gray-500 dark:text-gray-500 text-xs">14 Jan 2024, 02:15 PM</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white flex-shrink-0">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800 dark:text-gray-100">Order Processed</h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">Your item has been processed and packed for shipping</p>
                                <p class="text-gray-500 dark:text-gray-500 text-xs">15 Jan 2024, 10:30 AM</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white flex-shrink-0">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800 dark:text-gray-100">Shipped</h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">Your order has been shipped via DHL Express</p>
                                <p class="text-gray-500 dark:text-gray-500 text-xs">16 Jan 2024, 09:15 AM</p>
                                <div class="mt-2 p-3 bg-blue-50 dark:bg-blue-900 rounded-lg">
                                    <p class="text-blue-800 dark:text-blue-200 text-sm font-medium">Tracking Number: DHL-789456123</p>
                                    <p class="text-blue-700 dark:text-blue-300 text-xs">Current Location: Dar es Salaam Sorting Facility</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Content: Receipts -->
            <div id="receipts-tab" class="tab-content p-4 sm:p-6 hidden">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-6">Receipts & Invoices</h2>
                
                <!-- Receipt for Order #ORD-2024-003 -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
                        <div>
                            <h3 class="font-bold text-gray-800 dark:text-gray-100 text-lg">Wireless Headphones Pro</h3>
                            <p class="text-gray-600 dark:text-gray-400">Order #ORD-2024-003 • Completed</p>
                        </div>
                        <div class="flex space-x-3 mt-3 lg:mt-0">
                            <button onclick="downloadReceipt('ORD-2024-003')" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center">
                                <i class="fas fa-download mr-2"></i> Download PDF
                            </button>
                            <button onclick="printReceipt('ORD-2024-003')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center">
                                <i class="fas fa-print mr-2"></i> Print
                            </button>
                        </div>
                    </div>

                    <!-- Receipt Preview -->
                    <div class="receipt-container">
                        <div class="receipt-header">
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">BUYO STORE</h2>
                            <p class="text-gray-600 dark:text-gray-400">Official Receipt</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Receipt #RC-2024-003</p>
                        </div>
                        
                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600 dark:text-gray-400">Date:</span>
                                <span class="font-medium text-gray-800 dark:text-gray-100">15 Jan 2024</span>
                            </div>
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600 dark:text-gray-400">Order ID:</span>
                                <span class="font-medium text-gray-800 dark:text-gray-100">ORD-2024-003</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Customer:</span>
                                <span class="font-medium text-gray-800 dark:text-gray-100">John Doe</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-2">Items Purchased:</h3>
                            <div class="receipt-item">
                                <span class="text-gray-800 dark:text-gray-200">Wireless Headphones Pro</span>
                                <span class="text-gray-800 dark:text-gray-200">TZS 85,000</span>
                            </div>
                            <div class="receipt-item">
                                <span class="text-gray-800 dark:text-gray-200">Shipping Fee</span>
                                <span class="text-gray-800 dark:text-gray-200">TZS 10,000</span>
                            </div>
                            <div class="receipt-item">
                                <span class="text-gray-800 dark:text-gray-200">Tax (18%)</span>
                                <span class="text-gray-800 dark:text-gray-200">TZS 15,300</span>
                            </div>
                        </div>

                        <div class="receipt-item receipt-total">
                            <span class="text-gray-800 dark:text-gray-100">TOTAL</span>
                            <span class="text-gray-800 dark:text-gray-100">TZS 110,300</span>
                        </div>

                        <!-- QR Code Section -->
                        <div class="qr-container">
                            <div class="qr-code">
                                <div class="text-center text-xs text-gray-500 dark:text-gray-400">
                                    <div class="grid grid-cols-3 gap-1 w-20 h-20 mx-auto">
                                        <!-- Simple QR Code Pattern -->
                                        <div class="bg-black dark:bg-white rounded"></div>
                                        <div class="bg-black dark:bg-white rounded"></div>
                                        <div class="bg-black dark:bg-white rounded"></div>
                                        <div class="bg-black dark:bg-white rounded"></div>
                                        <div class="bg-white dark:bg-gray-800 rounded"></div>
                                        <div class="bg-black dark:bg-white rounded"></div>
                                        <div class="bg-black dark:bg-white rounded"></div>
                                        <div class="bg-white dark:bg-gray-800 rounded"></div>
                                        <div class="bg-black dark:bg-white rounded"></div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Scan QR code for order verification</p>
                        </div>

                        <div class="mt-6 text-center text-xs text-gray-500 dark:text-gray-400">
                            <p>Thank you for shopping with Buyo!</p>
                            <p>For inquiries: support@buyo.co.tz | +255 222 123 456</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat System -->
    <div class="chat-container">
        <!-- Support Chat -->
        <div id="supportChat" class="chat-window hidden">
            <div class="chat-header">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-headset"></i>
                    <span>Buyo Support</span>
                </div>
                <button onclick="toggleChat('supportChat')" class="text-white hover:text-yellow-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="chat-messages" id="supportMessages">
                <div class="message received">
                    <p>Hello! Welcome to Buyo Support. How can we help you today?</p>
                    <span class="text-xs opacity-70">10:30 AM</span>
                </div>
            </div>
            <div class="chat-input">
                <input type="text" placeholder="Type your message..." class="flex-1 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                <button onclick="sendSupportMessage()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>

        <!-- Seller Chat -->
        <div id="sellerChat" class="chat-window hidden">
            <div class="chat-header">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-store"></i>
                    <span id="sellerName">Seller</span>
                </div>
                <button onclick="toggleChat('sellerChat')" class="text-white hover:text-yellow-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="chat-messages" id="sellerMessages">
                <div class="message received">
                    <p>Hello! Thank you for your purchase. How can I assist you?</p>
                    <span class="text-xs opacity-70">10:25 AM</span>
                </div>
            </div>
            <div class="chat-input">
                <input type="text" placeholder="Type your message..." class="flex-1 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                <button onclick="sendSellerMessage()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>

        <!-- Chat Toggle Buttons -->
        <div class="flex space-x-2">
            <div class="chat-toggle" onclick="toggleChat('supportChat')" title="Support Chat">
                <i class="fas fa-headset"></i>
            </div>
            <div class="chat-toggle" onclick="toggleSupportChat()" title="Seller Chat">
                <i class="fas fa-comments"></i>
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div id="orderDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 max-w-2xl w-full max-h-96 overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">Order Details</h3>
                <button onclick="closeOrderDetails()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="orderDetailsContent">
                <!-- Order details will be loaded here -->
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

        // === TAB FUNCTIONALITY ===
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button, .mobile-tab');
            const tabContents = document.querySelectorAll('.tab-content');
            
            let currentTab = sessionStorage.getItem('currentTab') || 'orders-tab';
            
            function switchTab(tabName) {
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });
                
                tabButtons.forEach(button => {
                    if (button.classList.contains('tab-button')) {
                        button.classList.remove('border-green-600', 'text-green-600');
                        button.classList.add('text-gray-600', 'dark:text-gray-400', 'border-transparent');
                    } else if (button.classList.contains('mobile-tab')) {
                        button.classList.remove('active');
                    }
                });
                
                document.getElementById(tabName).classList.remove('hidden');
                sessionStorage.setItem('currentTab', tabName);
            }
            
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const tabName = this.getAttribute('data-tab');
                    switchTab(tabName);
                    
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
            
            if (document.getElementById(currentTab)) {
                switchTab(currentTab);
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

        // === CHAT FUNCTIONALITY ===
        function toggleChat(chatId) {
            const chatWindow = document.getElementById(chatId);
            const isVisible = !chatWindow.classList.contains('hidden');
            
            // Hide all chat windows first
            document.querySelectorAll('.chat-window').forEach(chat => {
                chat.classList.add('hidden');
            });
            
            // Toggle the clicked chat
            if (!isVisible) {
                chatWindow.classList.remove('hidden');
            }
        }

        function toggleSupportChat() {
            // This opens seller chat selection
            alert('Select a seller from your orders to start chatting');
        }

        function openSellerChat(sellerName) {
            document.getElementById('sellerName').textContent = sellerName;
            toggleChat('sellerChat');
        }

        function sendSupportMessage() {
            const input = document.querySelector('#supportChat .chat-input input');
            const message = input.value.trim();
            
            if (message) {
                const messagesContainer = document.getElementById('supportMessages');
                const messageElement = document.createElement('div');
                messageElement.className = 'message sent';
                messageElement.innerHTML = `
                    <p>${message}</p>
                    <span class="text-xs opacity-70">${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                `;
                messagesContainer.appendChild(messageElement);
                input.value = '';
                
                // Auto reply after 2 seconds
                setTimeout(() => {
                    const autoReply = document.createElement('div');
                    autoReply.className = 'message received';
                    autoReply.innerHTML = `
                        <p>Thank you for your message. Our support team will get back to you shortly.</p>
                        <span class="text-xs opacity-70">${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                    `;
                    messagesContainer.appendChild(autoReply);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }, 2000);
                
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        }

        function sendSellerMessage() {
            const input = document.querySelector('#sellerChat .chat-input input');
            const message = input.value.trim();
            
            if (message) {
                const messagesContainer = document.getElementById('sellerMessages');
                const messageElement = document.createElement('div');
                messageElement.className = 'message sent';
                messageElement.innerHTML = `
                    <p>${message}</p>
                    <span class="text-xs opacity-70">${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                `;
                messagesContainer.appendChild(messageElement);
                input.value = '';
                
                // Auto reply after 2 seconds
                setTimeout(() => {
                    const autoReply = document.createElement('div');
                    autoReply.className = 'message received';
                    autoReply.innerHTML = `
                        <p>Thanks for your message. I'll check on your order and get back to you soon.</p>
                        <span class="text-xs opacity-70">${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                    `;
                    messagesContainer.appendChild(autoReply);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }, 2000);
                
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        }

        // === ORDER MANAGEMENT FUNCTIONS ===
        function viewOrderDetails(orderId) {
            const orderDetails = {
                'ORD-2024-001': {
                    product: 'iPhone 13 Pro 256GB',
                    price: 'TZS 2,500,000',
                    status: 'Processing',
                    orderDate: '15 Jan 2024',
                    estimatedDelivery: '20 Jan 2024',
                    payment: 'Credit Card - Paid',
                    shipping: 'DHL Express - TZS 15,000'
                },
                'ORD-2024-002': {
                    product: 'Running Shoes - Size 42',
                    price: 'TZS 120,000',
                    status: 'Shipped',
                    orderDate: '14 Jan 2024',
                    estimatedDelivery: '20 Jan 2024',
                    payment: 'Mobile Money - Paid',
                    shipping: 'DHL Express - TZS 10,000'
                }
            };

            const order = orderDetails[orderId];
            if (order) {
                document.getElementById('orderDetailsContent').innerHTML = `
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="font-semibold text-gray-600 dark:text-gray-400">Product</h4>
                                <p class="text-gray-800 dark:text-gray-100">${order.product}</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-600 dark:text-gray-400">Price</h4>
                                <p class="text-green-600 dark:text-green-400 font-bold">${order.price}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="font-semibold text-gray-600 dark:text-gray-400">Order Status</h4>
                                <span class="px-2 py-1 rounded-full text-sm ${order.status === 'Processing' ? 'order-status-processing' : order.status === 'Shipped' ? 'order-status-shipped' : 'order-status-delivered'}">${order.status}</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-600 dark:text-gray-400">Order Date</h4>
                                <p>${order.orderDate}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="font-semibold text-gray-600 dark:text-gray-400">${order.status === 'Delivered' ? 'Delivery Date' : 'Estimated Delivery'}</h4>
                                <p>${order.status === 'Delivered' ? order.deliveryDate : order.estimatedDelivery}</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-600 dark:text-gray-400">Payment</h4>
                                <p>${order.payment}</p>
                            </div>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-600 dark:text-gray-400">Shipping</h4>
                            <p>${order.shipping}</p>
                        </div>
                    </div>
                `;
                document.getElementById('orderDetailsModal').classList.remove('hidden');
            }
        }

        function closeOrderDetails() {
            document.getElementById('orderDetailsModal').classList.add('hidden');
        }

        function trackOrder(orderId) {
            switchTab('tracking-tab');
            alert(`Tracking order: ${orderId}`);
        }

        function viewPaymentDetails(transactionId) {
            alert(`Viewing payment details for: ${transactionId}`);
        }

        function completePayment(transactionId) {
            if (confirm('Complete this payment now?')) {
                alert(`Payment completed for: ${transactionId}`);
            }
        }

        // === RECEIPT FUNCTIONS ===
        function downloadReceipt(orderId) {
            alert(`Downloading receipt for: ${orderId}`);
        }

        function printReceipt(orderId) {
            alert(`Printing receipt for: ${orderId}`);
        }

        // Helper function to switch tabs
        function switchTab(tabName) {
            const tabButtons = document.querySelectorAll('.tab-button, .mobile-tab');
            const tabContents = document.querySelectorAll('.tab-content');
            
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });
            
            tabButtons.forEach(button => {
                if (button.classList.contains('tab-button')) {
                    button.classList.remove('border-green-600', 'text-green-600');
                    button.classList.add('text-gray-600', 'dark:text-gray-400', 'border-transparent');
                } else if (button.classList.contains('mobile-tab')) {
                    button.classList.remove('active');
                }
            });
            
            document.getElementById(tabName).classList.remove('hidden');
            
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
            
            sessionStorage.setItem('currentTab', tabName);
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.id === 'orderDetailsModal') {
                closeOrderDetails();
            }
        });
    </script>
</body>
</html>