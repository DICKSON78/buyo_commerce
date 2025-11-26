@extends('layouts.dashboards.customer')
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
                <!-- Messages Dropdown -->
                <div class="dropdown" id="messagesDropdown">
                    <button onclick="toggleMessagesDropdown()" class="text-white hover:text-yellow-300 transition-colors relative" title="Messages">
                        <i class="fas fa-comments text-lg"></i>
                        <span id="messageCount" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">0</span>
                    </button>
                    <div class="dropdown-content messages-dropdown">
                        <div class="p-3 border-b border-gray-200 dark:border-gray-600">
                            <h3 class="font-semibold text-gray-800 dark:text-gray-100">Messages</h3>
                        </div>
                        <div id="messagesList">
                            <!-- Messages will be loaded here -->
                        </div>
                        <div class="p-3 text-center border-t border-gray-200 dark:border-gray-600">
                            <a href="#" class="text-green-600 dark:text-green-400 text-sm font-medium">View All Messages</a>
                        </div>
                    </div>
                </div>

                <!-- User Account Dropdown -->
                <div class="dropdown" id="accountDropdown">
                    <button onclick="toggleDropdown()" class="text-white hover:text-yellow-300 transition-colors relative" title="Account">
                        <i class="fas fa-user text-lg"></i>
                        <span class="absolute -top-2 -right-2 bg-yellow-500 text-gray-900 dark:text-gray-100 text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">
                            {{-- {{ substr($user->username, 0, 2) }} --}}
                        </span>
                    </button>
                    <div class="dropdown-content">
                        <a href="{{ route('customer.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                        <a href="{{ route('customer.profile') }}"><i class="fas fa-user"></i> Profile</a>
                        <a href="{{ route('customer.orders') }}"><i class="fas fa-shopping-cart"></i> Orders</a>
                        <a href="{{ route('customer.shop') }}"><i class="fas fa-store"></i> Shop</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900 px-4 py-2">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-2 sm:px-4 pt-20 pb-20">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div class="flex items-center space-x-4 mb-4 sm:mb-0">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Customer Dashboard</h1>
                <p class="text-gray-600 dark:text-gray-400">Welcome back, Track your orders and payments.</p>
            </div>
        </div>
        <a href="{{ route('products.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center space-x-2 w-fit">
            <i class="fas fa-shopping-bag"></i>
            <span>Continue Shopping</span>
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="stat-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100" id="totalOrders">{{ $stats['total_orders'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
            </div>
            <p class="text-green-600 dark:text-green-400 text-sm mt-2" id="ordersTrend">
                <i class="fas fa-arrow-up mr-1"></i>
                <span id="newOrdersCount">{{ $stats['pending_orders'] ?? 0 }}</span> pending orders
            </p>
        </div>

        <div class="stat-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Total Spent</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">TZS {{ number_format($stats['total_spent'] ?? 0, 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-green-600 dark:text-green-400 text-xl"></i>
                </div>
            </div>
            <p class="text-green-600 dark:text-green-400 text-sm mt-2">{{ $stats['completed_orders'] ?? 0 }} completed orders</p>
        </div>

        <div class="stat-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Support Tickets</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100" id="supportTickets">{{ $supportTicketsCount ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                    <i class="fas fa-headset text-purple-600 dark:text-purple-400 text-xl"></i>
                </div>
            </div>
            <p class="text-blue-600 dark:text-blue-400 text-sm mt-2" id="ticketsStatus">{{ $supportTicketsCount ?? 0 }} awaiting response</p>
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
                   <span class="ml-2 bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full" id="ordersCount">
                    {{ is_array($allOrders) ? count($allOrders) : ($allOrders->total() ?? 0) }}
                </span>
                </button>
                <button class="tab-button py-4 px-6 font-medium text-gray-600 dark:text-gray-400 border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 flex items-center" data-tab="payments-tab">
                    <i class="fas fa-credit-card mr-2"></i> Payments
                   <span class="ml-2 bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full" id="paymentsCount">
                    {{ is_countable($payments) ? count($payments) : 0 }}
                </span>
                </button>
                <button class="tab-button py-4 px-6 font-medium text-gray-600 dark:text-gray-400 border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 flex items-center" data-tab="tracking-tab">
                    <i class="fas fa-map-marker-alt mr-2"></i> Order Tracking
                    <span class="ml-2 bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full" id="trackingCount">{{is_countable($trackingOrders) ? count($trackingOrders) : 0}}</span>
                </button>
                <button class="tab-button py-4 px-6 font-medium text-gray-600 dark:text-gray-400 border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 flex items-center" data-tab="receipts-tab">
                    <i class="fas fa-receipt mr-2"></i> Receipts
                    <span class="ml-2 bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full" id="receiptsCount">{{ is_array($receipts) ? count($receipts) : 0 }}</span>
                </button>
            </div>
        </div>

        <!-- Tab Content: My Orders -->
        <div id="orders-tab" class="tab-content p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 space-y-3 sm:space-y-0">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">My Orders (<span id="ordersTotal"> {{ is_array($allOrders) ? count($allOrders) : ($allOrders->total() ?? 0) }}</span>)</h2>
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                    <select id="statusFilter" class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <input type="date" id="dateFilter" class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                </div>
            </div>

            <!-- Orders List -->
            <div class="space-y-4" id="ordersList">
                @forelse($allOrders as $order)
                <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:shadow-md transition-shadow bg-white dark:bg-gray-800">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-4">
                        <div class="flex items-center space-x-4 mb-3 lg:mb-0">
                            @if($order->items->first() && $order->items->first()->product)
                                <img src="{{ $order->items->first()->product->image_path ?? 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=100' }}"
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
                            <button onclick="trackOrder({{ $order->id }})" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 px-3 py-1 border border-blue-600 rounded-lg transition-colors">
                                <i class="fas fa-map-marker-alt mr-1"></i> Track
                            </button>
                            @if($order->items->first() && $order->items->first()->product && $order->items->first()->product->seller)
                            <button onclick="openSellerChat({{ $order->id }}, '{{ $order->items->first()->product->seller->store_name ?? 'Seller' }}')" class="text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 px-3 py-1 border border-purple-600 rounded-lg transition-colors">
                                <i class="fas fa-comment mr-1"></i> Chat Seller
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <i class="fas fa-shopping-cart text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-600 dark:text-gray-400">No orders found</p>
                    <a href="{{ route('customer.shop') }}" class="text-green-600 dark:text-green-400 hover:underline mt-2 inline-block">Start Shopping</a>
                </div>
                @endforelse
            </div>

            <!-- Load More -->
            @if($allOrders->hasMorePages())
            <div class="text-center mt-8">
                <button onclick="loadMoreOrders()" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 px-6 py-2 rounded-lg font-medium transition-colors">
                    Load More Orders
                </button>
            </div>
            @endif
        </div>

        <!-- Tab Content: Payments -->
        <div id="payments-tab" class="tab-content p-4 sm:p-6 hidden">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-6">Payment History</h2>

            <div class="space-y-4" id="paymentsList">
                @forelse($payments as $payment)
                <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:shadow-md transition-shadow bg-white dark:bg-gray-800">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-3">
                        <div>
                            <h3 class="font-bold text-gray-800 dark:text-gray-100">Payment for Order #{{ $payment['order_number'] }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Transaction ID: TXN-{{ str_pad($payment['id'], 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div class="flex items-center space-x-4 mt-2 lg:mt-0">
                            <span class="text-green-600 dark:text-green-400 font-bold text-lg">TZS {{ number_format($payment['amount'], 2) }}</span>
                            <span class="px-3 py-1 rounded-full text-sm {{ $payment['status'] === 'completed' ? 'payment-completed' : 'payment-pending' }}">{{ ucfirst($payment['status']) }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-sm text-gray-600 dark:text-gray-400">
                        <div class="flex items-center space-x-4">
                            <span><i class="fas fa-calendar mr-1"></i> Paid: {{ $payment['date']->format('d M Y, h:i A') }}</span>
                            <span><i class="fas fa-credit-card mr-1"></i> Credit Card</span>
                        </div>
                        <button onclick="viewPaymentDetails({{ $payment['id'] }})" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 mt-2 sm:mt-0">
                            <i class="fas fa-receipt mr-1"></i> View Receipt
                        </button>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <i class="fas fa-credit-card text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-600 dark:text-gray-400">No payment history found</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Tab Content: Order Tracking -->
        <div id="tracking-tab" class="tab-content p-4 sm:p-6 hidden">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-6">Order Tracking</h2>

            <div id="trackingList">
                @forelse($trackingOrders as $order)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
                        <div>
                            <h3 class="font-bold text-gray-800 dark:text-gray-100 text-lg">
                                @if($order->items->first() && $order->items->first()->product)
                                    {{ $order->items->first()->product->name }}
                                @else
                                    Order #{{ $order->order_number }}
                                @endif
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400">Order #{{ $order->order_number }}</p>
                        </div>
                        <div class="flex items-center space-x-4 mt-3 lg:mt-0">
                            <span class="px-3 py-1 rounded-full text-sm {{ $order->getStatusBadgeClass() }}">{{ ucfirst($order->status) }}</span>
                            <span class="text-green-600 dark:text-green-400 font-semibold">TZS {{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mb-6">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $order->getProgressPercentage() }}%"></div>
                        </div>
                    </div>

                    <!-- Tracking Steps -->
                    <div class="space-y-6" id="trackingSteps-{{ $order->id }}">
                        <!-- Tracking steps will be loaded via AJAX -->
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <i class="fas fa-map-marker-alt text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-600 dark:text-gray-400">No orders to track</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Tab Content: Receipts -->
        <div id="receipts-tab" class="tab-content p-4 sm:p-6 hidden">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-6">Receipts & Invoices</h2>

            <div id="receiptsList">
                @forelse($receipts as $order)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
                        <div>
                            <h3 class="font-bold text-gray-800 dark:text-gray-100 text-lg">
                                @if($order->items->first() && $order->items->first()->product)
                                    {{ $order->items->first()->product->name }}
                                @else
                                    Order #{{ $order->order_number }}
                                @endif
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400">Order #{{ $order->order_number }} • {{ ucfirst($order->status) }}</p>
                        </div>
                        <div class="flex space-x-3 mt-3 lg:mt-0">
                            <button onclick="downloadReceipt({{ $order->id }})" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center">
                                <i class="fas fa-download mr-2"></i> Download PDF
                            </button>
                            <button onclick="printReceipt({{ $order->id }})" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center">
                                <i class="fas fa-print mr-2"></i> Print
                            </button>
                        </div>
                    </div>

                    <!-- Receipt Preview -->
                    <div class="receipt-container">
                        <div class="receipt-header">
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">BUYO STORE</h2>
                            <p class="text-gray-600 dark:text-gray-400">Official Receipt</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Receipt #RC-{{ $order->id }}</p>
                        </div>

                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600 dark:text-gray-400">Date:</span>
                                <span class="font-medium text-gray-800 dark:text-gray-100">{{ $order->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600 dark:text-gray-400">Order ID:</span>
                                <span class="font-medium text-gray-800 dark:text-gray-100">{{ $order->order_number }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Customer:</span>
                                <span class="font-medium text-gray-800 dark:text-gray-100"></span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-2">Items Purchased:</h3>
                            @foreach($order->items as $item)
                            <div class="receipt-item">
                                <span class="text-gray-800 dark:text-gray-200">{{ $item->product->name ?? 'Product' }}</span>
                                <span class="text-gray-800 dark:text-gray-200">TZS {{ number_format($item->price, 2) }} x {{ $item->quantity }}</span>
                            </div>
                            @endforeach
                            <div class="receipt-item">
                                <span class="text-gray-800 dark:text-gray-200">Shipping Fee</span>
                                <span class="text-gray-800 dark:text-gray-200">TZS {{ number_format($order->shipping_fee, 2) }}</span>
                            </div>
                            <div class="receipt-item">
                                <span class="text-gray-800 dark:text-gray-200">Tax</span>
                                <span class="text-gray-800 dark:text-gray-200">TZS {{ number_format($order->tax_amount, 2) }}</span>
                            </div>
                        </div>

                        <div class="receipt-item receipt-total">
                            <span class="text-gray-800 dark:text-gray-100">TOTAL</span>
                            <span class="text-gray-800 dark:text-gray-100">TZS {{ number_format($order->total_amount, 2) }}</span>
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
                @empty
                <div class="text-center py-8">
                    <i class="fas fa-receipt text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-600 dark:text-gray-400">No receipts available</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Bottom Navigation - For ALL devices (Mobile, Tablet, Desktop) -->
@include('partials.bottom_nav')

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

        <!-- Chat Toggle Button -->
        <div class="chat-toggle" onclick="toggleSupportChat()" title="Customer Support">
            <i class="fas fa-headset"></i>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div id="orderDetailsModal" class="modal-overlay hidden">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">Order Details</h3>
                <button onclick="closeOrderDetails()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="orderDetailsContent">
                    <!-- Order details will be loaded here -->
                </div>
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

        // === AUTO DARK MODE DETECTION ===
        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;

        // Detect system preference
        function detectSystemTheme() {
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                return 'dark';
            }
            return 'light';
        }

        // Initialize theme
        function initializeTheme() {
            const savedTheme = localStorage.getItem('theme');
            const systemTheme = detectSystemTheme();

            if (savedTheme) {
                html.classList.toggle('dark', savedTheme === 'dark');
            } else {
                html.classList.toggle('dark', systemTheme === 'dark');
                localStorage.setItem('theme', systemTheme);
            }

            updateThemeIcon();
        }

        function updateThemeIcon() {
            if (html.classList.contains('dark')) {
                themeToggle.innerHTML = '<i class="fas fa-sun text-lg"></i>';
            } else {
                themeToggle.innerHTML = '<i class="fas fa-moon text-lg"></i>';
            }
        }

        // Initialize theme on load
        document.addEventListener('DOMContentLoaded', initializeTheme);

        // Listen for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (!localStorage.getItem('theme')) {
                html.classList.toggle('dark', e.matches);
                updateThemeIcon();
            }
        });

        // === DROPDOWNS ===
        function toggleDropdown() {
            document.getElementById('accountDropdown').classList.toggle('active');
        }

        function toggleMessagesDropdown() {
            const dropdown = document.getElementById('messagesDropdown');
            dropdown.classList.toggle('active');
            if (dropdown.classList.contains('active')) {
                loadMessages();
            }
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            const accountDropdown = document.getElementById('accountDropdown');
            const messagesDropdown = document.getElementById('messagesDropdown');

            if (!accountDropdown.contains(e.target)) {
                accountDropdown.classList.remove('active');
            }
            if (!messagesDropdown.contains(e.target)) {
                messagesDropdown.classList.remove('active');
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

            // Load initial data
            loadDashboardStats();
            loadMessages();
        });

        // === MESSAGES FUNCTIONALITY ===
        async function loadMessages() {
            try {
                const response = await fetch('/customer/api/conversations');
                const data = await response.json();

                if (data.success) {
                    const messagesList = document.getElementById('messagesList');
                    const messageCount = document.getElementById('messageCount');

                    let unreadCount = 0;
                    let messagesHTML = '';

                    data.conversations.forEach(conversation => {
                        unreadCount += conversation.unread_count;

                        messagesHTML += `
                            <div class="message-item ${conversation.unread_count > 0 ? 'unread' : ''}" onclick="openChat('${conversation.id}', '${conversation.seller_name}')">
                                <div class="flex justify-between items-start mb-1">
                                    <span class="message-sender">${conversation.seller_name}</span>
                                    <span class="message-time">${formatTime(conversation.last_message_time)}</span>
                                </div>
                                <div class="message-preview">${conversation.last_message}</div>
                                ${conversation.unread_count > 0 ? `
                                    <div class="flex justify-between items-center mt-2">
                                        <span class="text-xs text-blue-600 dark:text-blue-400">${conversation.unread_count} unread</span>
                                        <span class="text-xs text-green-600 dark:text-green-400">Click to reply</span>
                                    </div>
                                ` : ''}
                            </div>
                        `;
                    });

                    messagesList.innerHTML = messagesHTML || `
                        <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                            <i class="fas fa-comments text-2xl mb-2"></i>
                            <p>No messages yet</p>
                        </div>
                    `;

                    messageCount.textContent = unreadCount;
                    messageCount.style.display = unreadCount > 0 ? 'flex' : 'none';
                }
            } catch (error) {
                console.error('Error loading messages:', error);
            }
        }

        function formatTime(timestamp) {
            const date = new Date(timestamp);
            const now = new Date();
            const diff = now - date;

            if (diff < 60000) return 'Just now';
            if (diff < 3600000) return `${Math.floor(diff / 60000)}m ago`;
            if (diff < 86400000) return `${Math.floor(diff / 3600000)}h ago`;
            return date.toLocaleDateString();
        }

        function openChat(conversationId, sellerName) {
            document.getElementById('sellerName').textContent = sellerName;
            toggleChat('sellerChat');
            document.getElementById('messagesDropdown').classList.remove('active');
        }

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
            toggleChat('supportChat');
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
        async function viewOrderDetails(orderId) {
            try {
                const response = await fetch(`/customer/api/orders/${orderId}/view`);
                const data = await response.json();

                if (data.success) {
                    const order = data.order;
                    document.getElementById('orderDetailsContent').innerHTML = `
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <h4 class="font-semibold text-gray-600 dark:text-gray-400">Product</h4>
                                    <p class="text-gray-800 dark:text-gray-100">${order.items[0]?.product_name || 'Product'}</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-600 dark:text-gray-400">Price</h4>
                                    <p class="text-green-600 dark:text-green-400 font-bold">TZS ${order.total_amount}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <h4 class="font-semibold text-gray-600 dark:text-gray-400">Order Status</h4>
                                    <span class="px-2 py-1 rounded-full text-sm ${getStatusBadgeClass(order.status)}">${order.status}</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-600 dark:text-gray-400">Order Date</h4>
                                    <p>${order.order_date}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <h4 class="font-semibold text-gray-600 dark:text-gray-400">${order.status === 'delivered' ? 'Delivery Date' : 'Estimated Delivery'}</h4>
                                    <p>${order.status === 'delivered' ? order.delivery_date : order.estimated_delivery}</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-600 dark:text-gray-400">Payment</h4>
                                    <p>${order.payment_status}</p>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-600 dark:text-gray-400">Shipping Address</h4>
                                <p>${order.shipping_address}, ${order.city}, ${order.country}</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-600 dark:text-gray-400 mb-2">Order Items:</h4>
                                ${order.items.map(item => `
                                    <div class="flex justify-between py-1 border-b border-gray-200 dark:border-gray-600">
                                        <span>${item.product_name} x ${item.quantity}</span>
                                        <span>TZS ${item.subtotal}</span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    `;
                    document.getElementById('orderDetailsModal').classList.remove('hidden');
                }
            } catch (error) {
                console.error('Error fetching order details:', error);
                alert('Error loading order details');
            }
        }

        function getStatusBadgeClass(status) {
            const statusClasses = {
                'pending': 'order-status-pending',
                'processing': 'order-status-processing',
                'shipped': 'order-status-shipped',
                'delivered': 'order-status-delivered',
                'cancelled': 'order-status-cancelled'
            };
            return statusClasses[status] || 'order-status-pending';
        }

        function closeOrderDetails() {
            document.getElementById('orderDetailsModal').classList.add('hidden');
        }

        async function trackOrder(orderId) {
            try {
                const response = await fetch(`/customer/api/orders/${orderId}/track`);
                const data = await response.json();

                if (data.success) {
                    const order = data.order;
                    const trackingContainer = document.getElementById(`trackingSteps-${orderId}`);

                    if (trackingContainer) {
                        trackingContainer.innerHTML = order.tracking_steps.map(step => `
                            <div class="flex items-start space-x-4">
                                <div class="w-8 h-8 ${step.completed ? 'bg-green-600' : 'bg-gray-300'} rounded-full flex items-center justify-center text-white flex-shrink-0">
                                    <i class="fas fa-${step.completed ? 'check' : 'clock'}"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-800 dark:text-gray-100">${step.title}</h4>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">${step.description}</p>
                                    <p class="text-gray-500 dark:text-gray-500 text-xs">${step.date}</p>
                                </div>
                            </div>
                        `).join('');
                    }

                    switchTab('tracking-tab');
                }
            } catch (error) {
                console.error('Error tracking order:', error);
                alert('Error loading tracking information');
            }
        }

        function viewPaymentDetails(transactionId) {
            alert(`Viewing payment details for: ${transactionId}`);
        }

        // === RECEIPT FUNCTIONS ===
        async function downloadReceipt(orderId) {
            try {
                const response = await fetch(`/customer/api/orders/${orderId}/download-receipt`);
                const data = await response.json();

                if (data.success) {
                    // In a real application, this would download a PDF
                    alert(`Receipt downloaded for order: ${data.receipt.order_number}`);
                }
            } catch (error) {
                console.error('Error downloading receipt:', error);
                alert('Error downloading receipt');
            }
        }

        async function printReceipt(orderId) {
            try {
                const response = await fetch(`/customer/api/orders/${orderId}/print-receipt`);
                const data = await response.json();

                if (data.success) {
                    // In a real application, this would open print dialog
                    alert(`Receipt ready for printing: ${data.order_number}`);
                }
            } catch (error) {
                console.error('Error printing receipt:', error);
                alert('Error printing receipt');
            }
        }

        // === DASHBOARD DATA LOADING ===
        async function loadDashboardStats() {
            try {
                const response = await fetch('/customer/api/dashboard/stats');
                const data = await response.json();

                if (data.success) {
                    document.getElementById('totalOrders').textContent = data.stats.total_orders;
                    document.getElementById('pendingOrders').textContent = data.stats.pending_orders;
                    document.getElementById('supportTickets').textContent = data.support_tickets;

                    // Update trends
                    const newOrders = Math.floor(data.stats.total_orders * 0.1); // Simulate 10% new orders
                    document.getElementById('newOrdersCount').textContent = newOrders;
                }
            } catch (error) {
                console.error('Error loading dashboard stats:', error);
            }
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

        // Filter orders
        document.getElementById('statusFilter').addEventListener('change', filterOrders);
        document.getElementById('dateFilter').addEventListener('change', filterOrders);

        function filterOrders() {
            const status = document.getElementById('statusFilter').value;
            const date = document.getElementById('dateFilter').value;

            // In a real application, this would make an API call to filter orders
            console.log('Filtering orders by:', { status, date });
        }

        // Load more orders
        function loadMoreOrders() {
            // In a real application, this would load the next page of orders
            alert('Loading more orders...');
        }
    </script>
@endsection
