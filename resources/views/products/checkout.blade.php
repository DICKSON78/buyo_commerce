<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Buyo</title>
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

        /* Progress Steps */
        .progress-step {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .step-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
        }
        .step-number.active {
            background: #008000;
            color: white;
        }
        .step-number.completed {
            background: #008000;
            color: white;
        }
        .step-content {
            flex: 1;
        }

        /* Instructions */
        .instruction-card {
            background: #f8fafc;
            border-left: 4px solid #008000;
            padding: 16px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .dark .instruction-card {
            background: #1e293b;
            border-left-color: #4CAF50;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-300">
    @php
        // Fallback calculations ikiwa variables hazipo
        $cartItems = $cartItems ?? [];
        $subtotal = $subtotal ?? 0;
        $shippingFee = $shippingFee ?? 15000;
        $taxAmount = $taxAmount ?? 0;
        $totalAmount = $totalAmount ?? 0;
        
        // Recalculate ikiwa subtotal haipo
        if ($subtotal == 0 && !empty($cartItems)) {
            $subtotal = collect($cartItems)->sum(function($item) {
                return ($item['price'] ?? 0) * ($item['quantity'] ?? 0);
            });
            $taxAmount = $subtotal * 0.18;
            $totalAmount = $subtotal + $shippingFee + $taxAmount;
        }
    @endphp

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
                        <span class="text-white font-bold text-xl">Buyo Checkout</span>
                    </div>
                    <div class="sm:hidden w-10 h-10 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center">
                        <i class="fas fa-store text-green-600 dark:text-green-400 text-lg"></i>
                    </div>
                </div>

                <!-- Navigation Icons -->
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <!-- Dark Mode Toggle -->
                    <button id="themeToggle" class="text-white hover:text-yellow-300 transition-colors" title="Toggle Dark Mode">
                        <i class="fas fa-moon text-lg"></i>
                    </button>

                    <!-- Cart -->
                    <button class="text-white hover:text-yellow-300 transition-colors relative" title="Cart">
                        <i class="fas fa-shopping-cart text-lg"></i>
                        <span class="absolute -top-2 -right-2 bg-yellow-500 text-gray-900 dark:text-gray-100 text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold cart-count">{{ count($cartItems) }}</span>
                    </button>

                    <!-- User Account Dropdown -->
                    <div class="dropdown" id="accountDropdown">
                        <button onclick="toggleDropdown()" class="text-white hover:text-yellow-300 transition-colors relative" title="Account">
                            <i class="fas fa-user text-lg"></i>
                            <span class="absolute -top-2 -right-2 bg-yellow-500 text-gray-900 dark:text-gray-100 text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">
                                {{ strtoupper(substr($user->first_name ?? ($user->username ?? 'U'), 0, 1)) }}{{ strtoupper(substr($user->last_name ?? '', 0, 1)) }}
                            </span>
                        </button>
                        <div class="dropdown-content">
                            <a href="{{ route('customer.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                            <a href="#"><i class="fas fa-cog"></i> Settings</a>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-red-600 dark:text-red-400">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-2 sm:px-4 pt-20 pb-20 sm:pb-0">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Checkout Process</h1>
            <p class="text-gray-600 dark:text-gray-400">Follow these steps to complete your purchase</p>
        </div>

        <!-- Progress Steps -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <div class="progress-step">
                    <div class="step-number completed">1</div>
                    <div class="step-content">
                        <p class="font-semibold text-gray-800 dark:text-gray-100">Cart Review</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ count($cartItems) }} items selected</p>
                    </div>
                </div>
                <div class="progress-step">
                    <div class="step-number active">2</div>
                    <div class="step-content">
                        <p class="font-semibold text-gray-800 dark:text-gray-100">Customer Details</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Fill your information</p>
                    </div>
                </div>
                <div class="progress-step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <p class="font-semibold text-gray-800 dark:text-gray-100">Shipping</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Delivery information</p>
                    </div>
                </div>
                <div class="progress-step">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <p class="font-semibold text-gray-800 dark:text-gray-100">Payment</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Choose payment method</p>
                    </div>
                </div>
                <div class="progress-step">
                    <div class="step-number">5</div>
                    <div class="step-content">
                        <p class="font-semibold text-gray-800 dark:text-gray-100">Confirmation</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Review and confirm</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Checkout Form -->
            <div class="lg:col-span-2">
                <!-- Mobile Tabs Navigation -->
                <div class="lg:hidden bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-4 overflow-x-auto scrollbar-hide">
                    <div class="flex">
                        <button class="mobile-tab active" data-tab="customer-tab">
                            <i class="fas fa-user"></i>
                            <span>Details</span>
                        </button>
                        <button class="mobile-tab" data-tab="shipping-tab">
                            <i class="fas fa-truck"></i>
                            <span>Shipping</span>
                        </button>
                        <button class="mobile-tab" data-tab="payment-tab">
                            <i class="fas fa-credit-card"></i>
                            <span>Payment</span>
                        </button>
                        <button class="mobile-tab" data-tab="review-tab">
                            <i class="fas fa-check-circle"></i>
                            <span>Review</span>
                        </button>
                    </div>
                </div>

                <!-- Main Tabs Content -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <!-- Desktop Tabs Header -->
                    <div class="hidden lg:block border-b border-gray-200 dark:border-gray-700">
                        <div class="flex overflow-x-auto">
                            <button class="tab-button py-4 px-6 font-medium border-b-2 border-green-600 text-green-600 flex items-center active" data-tab="customer-tab">
                                <i class="fas fa-user mr-2"></i> Customer Details
                            </button>
                            <button class="tab-button py-4 px-6 font-medium text-gray-600 dark:text-gray-400 border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 flex items-center" data-tab="shipping-tab">
                                <i class="fas fa-truck mr-2"></i> Shipping
                            </button>
                            <button class="tab-button py-4 px-6 font-medium text-gray-600 dark:text-gray-400 border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 flex items-center" data-tab="payment-tab">
                                <i class="fas fa-credit-card mr-2"></i> Payment
                            </button>
                            <button class="tab-button py-4 px-6 font-medium text-gray-600 dark:text-gray-400 border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 flex items-center" data-tab="review-tab">
                                <i class="fas fa-check-circle mr-2"></i> Review
                            </button>
                        </div>
                    </div>

                    <!-- Tab Content: Customer Details -->
                    <div id="customer-tab" class="tab-content p-4 sm:p-6">
                        <div class="instruction-card">
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-info-circle text-green-600 dark:text-green-400 mt-1"></i>
                                <div>
                                    <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-1">Step 1: Enter Your Personal Information</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Please provide your contact details so we can send order updates and receipts.</p>
                                </div>
                            </div>
                        </div>
                        
                        <form class="space-y-6" id="customer-form">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">First Name *</label>
                                    <input type="text" name="first_name" value="{{ $user->first_name ?? '' }}" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200" placeholder="Enter first name" required>
                                </div>
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Last Name *</label>
                                    <input type="text" name="last_name" value="{{ $user->last_name ?? '' }}" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200" placeholder="Enter last name" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Email Address *</label>
                                    <input type="email" name="email" value="{{ $user->email ?? '' }}" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200" placeholder="your@email.com" required>
                                </div>
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Phone Number *</label>
                                    <input type="tel" name="phone" value="{{ $user->phone ?? '' }}" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200" placeholder="+255 XXX XXX XXX" required>
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Additional Notes (Optional)</label>
                                <textarea name="additional_notes" rows="3" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200" placeholder="Any special instructions for your order..."></textarea>
                            </div>

                            <div class="flex justify-end">
                                <button type="button" onclick="validateCustomerDetails()" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center">
                                    Continue to Shipping <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Tab Content: Shipping -->
                    <div id="shipping-tab" class="tab-content p-4 sm:p-6 hidden">
                        <div class="instruction-card">
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-info-circle text-green-600 dark:text-green-400 mt-1"></i>
                                <div>
                                    <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-1">Step 2: Enter Shipping Information</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Tell us where you want your order delivered. Choose your preferred shipping method.</p>
                                </div>
                            </div>
                        </div>
                        
                        <form class="space-y-6" id="shipping-form">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Region *</label>
                                    <select name="shipping_region" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200" required>
                                        <option value="">Select Region</option>
                                        <option value="Dar es Salaam">Dar es Salaam</option>
                                        <option value="Arusha">Arusha</option>
                                        <option value="Mwanza">Mwanza</option>
                                        <option value="Dodoma">Dodoma</option>
                                        <option value="Mbeya">Mbeya</option>
                                        <option value="Morogoro">Morogoro</option>
                                        <option value="Tanga">Tanga</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">City/District *</label>
                                    <input type="text" name="shipping_city" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200" placeholder="Enter your city" required>
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Street Address *</label>
                                <input type="text" name="shipping_address" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200" placeholder="Enter your street address" required>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Shipping Method *</label>
                                    <div class="space-y-3">
                                        <label class="flex items-center space-x-3 p-3 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <input type="radio" name="shipping_method" value="standard" class="text-green-600 focus:ring-green-500" checked>
                                            <div class="flex-1">
                                                <p class="font-medium text-gray-800 dark:text-gray-100">Standard Delivery</p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">5-7 business days - TZS <span class="standard-shipping">{{ number_format($shippingFee) }}</span></p>
                                            </div>
                                        </label>
                                        <label class="flex items-center space-x-3 p-3 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <input type="radio" name="shipping_method" value="express" class="text-green-600 focus:ring-green-500">
                                            <div class="flex-1">
                                                <p class="font-medium text-gray-800 dark:text-gray-100">Express Delivery</p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">2-3 business days - TZS <span class="express-shipping">{{ number_format($shippingFee + 15000) }}</span></p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Delivery Instructions</label>
                                    <textarea name="delivery_instructions" rows="4" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200" placeholder="Any special delivery instructions..."></textarea>
                                </div>
                            </div>

                            <div class="flex justify-between">
                                <button type="button" onclick="switchTab('customer-tab')" class="border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 px-6 py-3 rounded-lg font-semibold transition-colors flex items-center">
                                    <i class="fas fa-arrow-left mr-2"></i> Back
                                </button>
                                <button type="button" onclick="validateShippingDetails()" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center">
                                    Continue to Payment <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Tab Content: Payment -->
                    <div id="payment-tab" class="tab-content p-4 sm:p-6 hidden">
                        <div class="instruction-card">
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-info-circle text-green-600 dark:text-green-400 mt-1"></i>
                                <div>
                                    <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-1">Step 3: Choose Payment Method</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Select how you want to pay for your order. All payments are secure and encrypted.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-4">Select Payment Method *</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <label class="flex items-center space-x-3 p-4 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-green-500 payment-option">
                                        <input type="radio" name="payment_method" value="mpesa" class="text-green-600 focus:ring-green-500">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <p class="font-medium text-gray-800 dark:text-gray-100">M-Pesa</p>
                                                <i class="fas fa-mobile-alt text-green-600 text-xl"></i>
                                            </div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Mobile Money Payment</p>
                                        </div>
                                    </label>

                                    <label class="flex items-center space-x-3 p-4 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-green-500 payment-option">
                                        <input type="radio" name="payment_method" value="tigopesa" class="text-green-600 focus:ring-green-500">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <p class="font-medium text-gray-800 dark:text-gray-100">Tigo Pesa</p>
                                                <i class="fas fa-bolt text-green-600 text-xl"></i>
                                            </div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Mobile Money Payment</p>
                                        </div>
                                    </label>

                                    <label class="flex items-center space-x-3 p-4 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-green-500 payment-option">
                                        <input type="radio" name="payment_method" value="airtel" class="text-green-600 focus:ring-green-500">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <p class="font-medium text-gray-800 dark:text-gray-100">Airtel Money</p>
                                                <i class="fas fa-wifi text-green-600 text-xl"></i>
                                            </div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Mobile Money Payment</p>
                                        </div>
                                    </label>

                                    <label class="flex items-center space-x-3 p-4 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-green-500 payment-option">
                                        <input type="radio" name="payment_method" value="card" class="text-green-600 focus:ring-green-500">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <p class="font-medium text-gray-800 dark:text-gray-100">Credit/Debit Card</p>
                                                <div class="flex space-x-1">
                                                    <i class="fab fa-cc-visa text-blue-600"></i>
                                                    <i class="fab fa-cc-mastercard text-red-600"></i>
                                                </div>
                                            </div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Visa, MasterCard</p>
                                        </div>
                                    </label>

                                    <label class="flex items-center space-x-3 p-4 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-green-500 payment-option">
                                        <input type="radio" name="payment_method" value="cash_on_delivery" class="text-green-600 focus:ring-green-500" checked>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <p class="font-medium text-gray-800 dark:text-gray-100">Cash on Delivery</p>
                                                <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                                            </div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Pay when you receive</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Payment Instructions -->
                            <div id="payment-instructions" class="p-4 bg-green-50 dark:bg-green-900 rounded-lg border border-green-200 dark:border-green-700">
                                <h4 class="font-semibold text-green-800 dark:text-green-200 mb-2">Cash on Delivery Instructions</h4>
                                <p class="text-green-700 dark:text-green-300 text-sm">You'll pay TZS {{ number_format($totalAmount) }} when you receive your order. Our delivery agent will collect the payment in cash.</p>
                            </div>

                            <div class="flex justify-between">
                                <button type="button" onclick="switchTab('shipping-tab')" class="border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 px-6 py-3 rounded-lg font-semibold transition-colors flex items-center">
                                    <i class="fas fa-arrow-left mr-2"></i> Back
                                </button>
                                <button type="button" onclick="validatePaymentDetails()" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center">
                                    Review Order <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Content: Review -->
                    <div id="review-tab" class="tab-content p-4 sm:p-6 hidden">
                        <div class="instruction-card">
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-info-circle text-green-600 dark:text-green-400 mt-1"></i>
                                <div>
                                    <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-1">Step 4: Review Your Order</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Please review all information carefully before completing your purchase. Once confirmed, your order will be processed immediately.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-6">
                            <!-- Order Summary -->
                            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4">Order Items ({{ count($cartItems) }})</h3>
                                <div class="space-y-3">
                                    @foreach($cartItems as $item)
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <img src="{{ ($item['image'] ?? false) ? asset('storage/' . $item['image']) : 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=60' }}" 
                                                 alt="{{ $item['name'] ?? 'Product' }}" class="w-12 h-12 object-cover rounded-lg">
                                            <div>
                                                <p class="font-medium text-gray-800 dark:text-gray-100 text-sm">{{ Str::limit($item['name'] ?? 'Product', 30) }}</p>
                                                <p class="text-gray-600 dark:text-gray-400 text-xs">Qty: {{ $item['quantity'] ?? 0 }}</p>
                                            </div>
                                        </div>
                                        <p class="text-green-600 dark:text-green-400 font-semibold">TZS {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0)) }}</p>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Order Details -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                    <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-3">Customer Information</h3>
                                    <div class="space-y-2 text-sm">
                                        <p><strong>Name:</strong> <span class="review-customer-name"></span></p>
                                        <p><strong>Email:</strong> <span class="review-customer-email"></span></p>
                                        <p><strong>Phone:</strong> <span class="review-customer-phone"></span></p>
                                    </div>
                                </div>
                                <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                    <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-3">Shipping Information</h3>
                                    <div class="space-y-2 text-sm">
                                        <p><strong>Address:</strong> <span class="review-shipping-address"></span></p>
                                        <p><strong>City:</strong> <span class="review-shipping-city"></span></p>
                                        <p><strong>Method:</strong> <span class="review-shipping-method"></span></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Price Breakdown -->
                            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-3">Price Summary</h3>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span>Subtotal:</span>
                                        <span>TZS {{ number_format($subtotal) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Shipping:</span>
                                        <span class="review-shipping-fee">TZS {{ number_format($shippingFee) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Tax (18%):</span>
                                        <span>TZS {{ number_format($taxAmount) }}</span>
                                    </div>
                                    <div class="flex justify-between border-t border-gray-200 dark:border-gray-600 pt-2 font-bold">
                                        <span>Total:</span>
                                        <span class="text-green-600 dark:text-green-400 review-total-amount">TZS {{ number_format($totalAmount) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-3">Payment Method</h3>
                                <div class="space-y-2 text-sm">
                                    <p><strong>Selected Method:</strong> <span class="review-payment-method">Cash on Delivery</span></p>
                                </div>
                            </div>

                            <!-- Terms Agreement -->
                            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                <label class="flex items-start space-x-3">
                                    <input type="checkbox" id="terms-agreement" class="mt-1 text-green-600 focus:ring-green-500" required>
                                    <div>
                                        <p class="font-medium text-gray-800 dark:text-gray-100">I agree to the Terms & Conditions</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">By checking this box, I confirm that I have read and agree to the terms of service, privacy policy, and return policy.</p>
                                    </div>
                                </label>
                            </div>

                            <div class="flex justify-between">
                                <button type="button" onclick="switchTab('payment-tab')" class="border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 px-6 py-3 rounded-lg font-semibold transition-colors flex items-center">
                                    <i class="fas fa-arrow-left mr-2"></i> Back
                                </button>
                                <button type="button" onclick="completeOrder()" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center">
                                    <i class="fas fa-lock mr-2"></i> Complete Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Order Summary -->
            <div class="space-y-6">
                <!-- Order Summary Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Order Summary</h2>
                    
                    <div class="space-y-3 mb-4 max-h-60 overflow-y-auto">
                        @foreach($cartItems as $item)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <img src="{{ ($item['image'] ?? false) ? asset('storage/' . $item['image']) : 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=60' }}" 
                                     alt="{{ $item['name'] ?? 'Product' }}" class="w-12 h-12 object-cover rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-800 dark:text-gray-100 text-sm">{{ Str::limit($item['name'] ?? 'Product', 30) }}</p>
                                    <p class="text-gray-600 dark:text-gray-400 text-xs">Qty: {{ $item['quantity'] ?? 0 }}</p>
                                </div>
                            </div>
                            <p class="text-green-600 dark:text-green-400 font-semibold">TZS {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0)) }}</p>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Items ({{ count($cartItems) }}):</span>
                            <span>TZS {{ number_format($subtotal) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Shipping:</span>
                            <span class="summary-shipping-fee">TZS {{ number_format($shippingFee) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Tax (18%):</span>
                            <span>TZS {{ number_format($taxAmount) }}</span>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 dark:border-gray-600 pt-3">
                        <div class="flex justify-between items-center font-bold">
                            <span class="text-gray-800 dark:text-gray-100">Total:</span>
                            <span class="text-green-600 dark:text-green-400 text-lg summary-total-amount">TZS {{ number_format($totalAmount) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Support Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-headset text-white text-xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-2">Need Help?</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">Our support team is here to assist you</p>
                        <div class="space-y-2">
                            <a href="tel:+255700123456" class="block text-green-600 hover:text-green-700 text-sm">
                                <i class="fas fa-phone mr-2"></i>+255 700 123 456
                            </a>
                            <a href="mailto:support@buyo.co.tz" class="block text-green-600 hover:text-green-700 text-sm">
                                <i class="fas fa-envelope mr-2"></i>support@buyo.co.tz
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Security Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-shield-alt text-gray-900 text-xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-2">Secure Checkout</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Your payment information is securely encrypted</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // === GLOBAL VARIABLES ===
        const subtotal = {{ $subtotal }};
        const baseShippingFee = {{ $shippingFee }};
        const taxAmount = {{ $taxAmount }};
        let currentShippingFee = baseShippingFee;
        let currentTotalAmount = {{ $totalAmount }};

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

        // === DYNAMIC SHIPPING CALCULATION ===
        function updateShippingFee(shippingMethod) {
            currentShippingFee = baseShippingFee;
            
            if (shippingMethod === 'express') {
                currentShippingFee += 15000;
            }
            
            const newTaxAmount = subtotal * 0.18;
            currentTotalAmount = subtotal + currentShippingFee + newTaxAmount;
            
            // Update shipping fee displays
            document.querySelectorAll('.summary-shipping-fee').forEach(el => {
                el.textContent = `TZS ${currentShippingFee.toLocaleString()}`;
            });
            
            document.querySelectorAll('.review-shipping-fee').forEach(el => {
                el.textContent = `TZS ${currentShippingFee.toLocaleString()}`;
            });
            
            // Update total amount displays
            document.querySelectorAll('.summary-total-amount').forEach(el => {
                el.textContent = `TZS ${Math.round(currentTotalAmount).toLocaleString()}`;
            });
            
            document.querySelectorAll('.review-total-amount').forEach(el => {
                el.textContent = `TZS ${Math.round(currentTotalAmount).toLocaleString()}`;
            });
            
            return { shippingFee: currentShippingFee, totalAmount: currentTotalAmount };
        }

        // === TAB FUNCTIONALITY ===
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button, .mobile-tab');
            const tabContents = document.querySelectorAll('.tab-content');
            
            let currentTab = sessionStorage.getItem('currentTab') || 'customer-tab';
            
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

            // Payment method selection
            const paymentOptions = document.querySelectorAll('.payment-option');
            const paymentInstructions = document.getElementById('payment-instructions');
            
            paymentOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove selection from all options
                    paymentOptions.forEach(opt => {
                        opt.classList.remove('border-green-500', 'bg-green-50', 'dark:bg-green-900');
                    });

                    // Add selection to clicked option
                    this.classList.add('border-green-500', 'bg-green-50', 'dark:bg-green-900');

                    // Update payment instructions
                    const paymentMethod = this.querySelector('input').value;
                    updatePaymentInstructions(paymentMethod);
                });
            });

            // Shipping method selection
            const shippingOptions = document.querySelectorAll('input[name="shipping_method"]');
            shippingOptions.forEach(option => {
                option.addEventListener('change', function() {
                    updateShippingFee(this.value);
                });
            });

            // Auto-select first payment option
            paymentOptions[4].click(); // Select Cash on Delivery by default

            // Initialize shipping fee
            updateShippingFee('standard');
        });

        function updatePaymentInstructions(method) {
            const instructions = document.getElementById('payment-instructions');
            let title = '';
            let message = '';

            switch(method) {
                case 'mpesa':
                    title = 'M-Pesa Instructions';
                    message = 'You will receive an M-Pesa prompt on your phone. Enter your PIN to complete the payment of TZS ' + currentTotalAmount.toLocaleString() + '.';
                    break;
                case 'tigopesa':
                    title = 'Tigo Pesa Instructions';
                    message = 'You will receive a Tigo Pesa prompt on your phone. Enter your PIN to complete the payment of TZS ' + currentTotalAmount.toLocaleString() + '.';
                    break;
                case 'airtel':
                    title = 'Airtel Money Instructions';
                    message = 'You will receive an Airtel Money prompt on your phone. Enter your PIN to complete the payment of TZS ' + currentTotalAmount.toLocaleString() + '.';
                    break;
                case 'card':
                    title = 'Card Payment Instructions';
                    message = 'You will be redirected to our secure payment gateway to enter your card details.';
                    break;
                case 'cash_on_delivery':
                    title = 'Cash on Delivery Instructions';
                    message = 'You will pay TZS ' + currentTotalAmount.toLocaleString() + ' when you receive your order. Our delivery agent will collect the payment in cash.';
                    break;
            }

            instructions.innerHTML = `
                <h4 class="font-semibold text-green-800 dark:text-green-200 mb-2">${title}</h4>
                <p class="text-green-700 dark:text-green-300 text-sm">${message}</p>
            `;
        }

        // Validation functions
        function validateCustomerDetails() {
            const firstName = document.querySelector('input[name="first_name"]');
            const lastName = document.querySelector('input[name="last_name"]');
            const email = document.querySelector('input[name="email"]');
            const phone = document.querySelector('input[name="phone"]');

            if (!firstName.value || !lastName.value || !email.value || !phone.value) {
                showAlert('Tafadhali jaza sehemu zote zilizo na alama ya nyota (*) kabla ya kuendelea.', 'error');
                return;
            }

            if (!email.value.includes('@')) {
                showAlert('Tafadhali weka anwani halali ya barua pepe.', 'error');
                return;
            }

            // Validate phone number format (Tanzanian)
            const phoneRegex = /^(\+255|255|0)[0-9]{9}$/;
            if (!phoneRegex.test(phone.value.replace(/\s/g, ''))) {
                showAlert('Tafadhali weka namba halali ya simu ya Tanzania.', 'error');
                return;
            }

            switchTab('shipping-tab');
        }

        function validateShippingDetails() {
            const region = document.querySelector('select[name="shipping_region"]');
            const city = document.querySelector('input[name="shipping_city"]');
            const address = document.querySelector('input[name="shipping_address"]');
            const shippingMethod = document.querySelector('input[name="shipping_method"]:checked');

            if (!region.value || !city.value || !address.value || !shippingMethod) {
                showAlert('Tafadhali jaza taarifa zote za usafirishaji kabla ya kuendelea.', 'error');
                return;
            }

            switchTab('payment-tab');
        }

        function validatePaymentDetails() {
            const paymentSelected = document.querySelector('input[name="payment_method"]:checked');
            
            if (!paymentSelected) {
                showAlert('Tafadhali chagua njia ya malipo kabla ya kuendelea.', 'error');
                return;
            }

            // Update order summary with final amounts
            updateOrderSummary();

            switchTab('review-tab');
        }

        // Update order summary in review tab
        function updateOrderSummary() {
            const shippingMethod = document.querySelector('input[name="shipping_method"]:checked');
            const { totalAmount } = updateShippingFee(shippingMethod ? shippingMethod.value : 'standard');
            
            // Update customer info in review
            const firstName = document.querySelector('input[name="first_name"]').value;
            const lastName = document.querySelector('input[name="last_name"]').value;
            const email = document.querySelector('input[name="email"]').value;
            const phone = document.querySelector('input[name="phone"]').value;
            
            document.querySelectorAll('.review-customer-name').forEach(el => {
                el.textContent = firstName + ' ' + lastName;
            });
            document.querySelectorAll('.review-customer-email').forEach(el => {
                el.textContent = email;
            });
            document.querySelectorAll('.review-customer-phone').forEach(el => {
                el.textContent = phone;
            });

            // Update shipping info in review
            const region = document.querySelector('select[name="shipping_region"]').value;
            const city = document.querySelector('input[name="shipping_city"]').value;
            const address = document.querySelector('input[name="shipping_address"]').value;
            const shippingMethodText = shippingMethod ? (shippingMethod.value === 'express' ? 'Express Delivery' : 'Standard Delivery') : 'Standard Delivery';
            
            document.querySelectorAll('.review-shipping-address').forEach(el => {
                el.textContent = address;
            });
            document.querySelectorAll('.review-shipping-city').forEach(el => {
                el.textContent = city + ', ' + region;
            });
            document.querySelectorAll('.review-shipping-method').forEach(el => {
                el.textContent = shippingMethodText;
            });

            // Update payment method in review
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
            let paymentMethodText = 'Cash on Delivery';
            if (paymentMethod) {
                switch(paymentMethod.value) {
                    case 'mpesa': paymentMethodText = 'M-Pesa'; break;
                    case 'tigopesa': paymentMethodText = 'Tigo Pesa'; break;
                    case 'airtel': paymentMethodText = 'Airtel Money'; break;
                    case 'card': paymentMethodText = 'Credit/Debit Card'; break;
                    case 'cash_on_delivery': paymentMethodText = 'Cash on Delivery'; break;
                }
            }
            document.querySelectorAll('.review-payment-method').forEach(el => {
                el.textContent = paymentMethodText;
            });
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

        // Show custom alert
        function showAlert(message, type = 'info') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `fixed top-20 right-4 z-50 p-4 rounded-lg shadow-lg ${
                type === 'error' ? 'bg-red-500 text-white' :
                type === 'success' ? 'bg-green-500 text-white' :
                'bg-blue-500 text-white'
            }`;
            alertDiv.textContent = message;
            document.body.appendChild(alertDiv);

            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }

        // Complete order function
        function completeOrder() {
            const completeBtn = document.querySelector('#review-tab button[onclick="completeOrder()"]');
            const termsCheckbox = document.getElementById('terms-agreement');
            
            if (!termsCheckbox.checked) {
                showAlert('Tafadhali kubali Masharti na Sheria kabla ya kukamilisha agizo lako.', 'error');
                return;
            }

            const originalText = completeBtn.innerHTML;
            
            // Show processing state
            completeBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Inachakata...';
            completeBtn.disabled = true;

            // Collect all form data
            const formData = new FormData();
            
            // Customer details
            formData.append('first_name', document.querySelector('input[name="first_name"]').value);
            formData.append('last_name', document.querySelector('input[name="last_name"]').value);
            formData.append('email', document.querySelector('input[name="email"]').value);
            formData.append('phone', document.querySelector('input[name="phone"]').value);
            
            // Shipping details
            formData.append('shipping_region', document.querySelector('select[name="shipping_region"]').value);
            formData.append('shipping_city', document.querySelector('input[name="shipping_city"]').value);
            formData.append('shipping_address', document.querySelector('input[name="shipping_address"]').value);
            formData.append('shipping_method', document.querySelector('input[name="shipping_method"]:checked').value);
            
            // Payment details
            formData.append('payment_method', document.querySelector('input[name="payment_method"]:checked').value);
            formData.append('additional_notes', document.querySelector('textarea[name="additional_notes"]').value);
            formData.append('delivery_instructions', document.querySelector('textarea[name="delivery_instructions"]').value);
            
            // Add CSRF token
            formData.append('_token', '{{ csrf_token() }}');

            // Submit the form via AJAX
            fetch('{{ route("checkout.process") }}', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showAlert('Agizo limefanikiwa kuwekwa! ' + data.message, 'success');
                    // Redirect to confirmation page
                    setTimeout(() => {
                        window.location.href = data.redirect_url || '{{ route("customer.orders") }}';
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Hitilafu imetokea. Tafadhali jaribu tena.');
                }
            })
            .catch(error => {
                showAlert(error.message, 'error');
                completeBtn.innerHTML = originalText;
                completeBtn.disabled = false;
            });
        }

        // Real-time form validation
        function setupRealTimeValidation() {
            const inputs = document.querySelectorAll('input[required], select[required]');
            
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });
            });
        }

        function validateField(field) {
            const value = field.value.trim();
            const fieldName = field.getAttribute('name');
            
            if (!value) {
                field.classList.add('border-red-500');
                return false;
            }
            
            field.classList.remove('border-red-500');
            
            // Specific validations
            switch(fieldName) {
                case 'email':
                    if (!value.includes('@')) {
                        field.classList.add('border-red-500');
                        return false;
                    }
                    break;
                case 'phone':
                    const phoneRegex = /^(\+255|255|0)[0-9]{9}$/;
                    if (!phoneRegex.test(value.replace(/\s/g, ''))) {
                        field.classList.add('border-red-500');
                        return false;
                    }
                    break;
            }
            
            return true;
        }

        // Initialize real-time validation
        setupRealTimeValidation();
    </script>
</body>
</html>