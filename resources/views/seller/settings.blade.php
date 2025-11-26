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

    /* Tab Styles - Exactly like customer dashboard */
    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    /* Mobile Tabs Navigation - Exactly like customer dashboard */
    .mobile-tab {
        flex: 1;
        padding: 0.75rem 0.5rem;
        border: none;
        background-color: transparent;
        color: #6b7280;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.75rem;
        min-width: 80px;
    }

    .dark .mobile-tab {
        color: #d1d5db;
    }

    .mobile-tab:hover {
        color: #008000;
    }

    .dark .mobile-tab:hover {
        color: #10b981;
    }

    .mobile-tab.active {
        color: #008000;
        background-color: #f0f9ff;
    }

    .dark .mobile-tab.active {
        color: #10b981;
        background-color: #064e3b;
    }

    /* Desktop Tabs Header - Exactly like customer dashboard */
    .tab-button {
        border: none;
        background: none;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
        border-bottom: 2px solid transparent;
        padding: 1rem 1.5rem;
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    .tab-button.active {
        border-bottom-color: #008000;
        color: #008000;
    }

    .dark .tab-button.active {
        border-bottom-color: #10b981;
        color: #10b981;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #374151;
        font-size: 0.875rem;
    }

    .dark .form-label {
        color: #e5e7eb;
    }

    .form-input,
    .form-textarea,
    .form-select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: #ffffff;
        color: #1f2937;
    }

    .dark .form-input,
    .dark .form-textarea,
    .dark .form-select {
        background-color: #374151;
        border-color: #4b5563;
        color: #f3f4f6;
    }

    .form-input:focus,
    .form-textarea:focus,
    .form-select:focus {
        outline: none;
        border-color: #008000;
        box-shadow: 0 0 0 3px rgba(0, 128, 0, 0.1);
    }

    .dark .form-input:focus,
    .dark .form-textarea:focus,
    .dark .form-select:focus {
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    .form-textarea {
        resize: vertical;
        min-height: 120px;
    }

    /* Button Styles */
    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 0.5rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background-color: #008000;
        color: white;
    }

    .btn-primary:hover {
        background-color: #006600;
    }

    .btn-secondary {
        background-color: #e5e7eb;
        color: #374151;
    }

    .dark .btn-secondary {
        background-color: #4b5563;
        color: #f3f4f6;
    }

    .btn-secondary:hover {
        background-color: #d1d5db;
    }

    .dark .btn-secondary:hover {
        background-color: #6b7280;
    }

    /* Dropdown Styles */
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

    /* Navigation Buttons */
    .nav-buttons {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e5e7eb;
    }

    .dark .nav-buttons {
        border-top-color: #4b5563;
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
                        <i class="fas fa-cog text-green-600 dark:text-green-400 text-lg"></i>
                    </div>
                    <span class="text-white font-bold text-xl">Settings</span>
                </div>
                <div class="sm:hidden w-10 h-10 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center">
                    <i class="fas fa-cog text-green-600 dark:text-green-400 text-lg"></i>
                </div>
            </div>

            <!-- Navigation Icons -->
            <div class="flex items-center space-x-3 sm:space-x-4">
                <!-- Dark Mode Toggle -->
                <button id="themeToggle" class="text-white hover:text-yellow-300 transition-colors" title="Toggle Dark Mode">
                    <i class="fas fa-moon text-lg"></i>
                </button>

                <!-- Back to Dashboard -->
                <a href="{{ route('seller.dashboard') }}" class="text-white hover:text-yellow-300 transition-colors" title="Back to Dashboard">
                    <i class="fas fa-arrow-left text-lg"></i>
                </a>

                <!-- User Account Dropdown -->
                <div class="dropdown" id="accountDropdown">
                    <button onclick="toggleDropdown()" class="text-white hover:text-yellow-300 transition-colors relative" title="Account">
                        <i class="fas fa-user text-lg"></i>
                    </button>
                    <div class="dropdown-content">
                        <a href="{{ route('seller.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                        <a href="{{ route('seller.profile') }}"><i class="fas fa-user-circle"></i> Profile</a>
                        <a href="{{ route('seller.settings') }}"><i class="fas fa-cog"></i> Settings</a>
                        <a href="#" class="text-red-600 dark:text-red-400"><i class="fas fa-sign-out-alt"></i> Logout</a>
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
        <div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Settings</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Manage your store settings and preferences</p>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 dark:bg-green-900 dark:border-green-700 dark:text-green-200">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 dark:bg-red-900 dark:border-red-700 dark:text-red-200">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Mobile Tabs Navigation - Exactly like customer dashboard -->
    <div class="lg:hidden bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-4 overflow-x-auto scrollbar-hide">
        <div class="flex">
            <button class="mobile-tab active" data-tab="profile-tab">
                <i class="fas fa-user"></i>
                <span>Profile</span>
            </button>
            <button class="mobile-tab" data-tab="business-tab">
                <i class="fas fa-briefcase"></i>
                <span>Business</span>
            </button>
            <button class="mobile-tab" data-tab="payment-tab">
                <i class="fas fa-credit-card"></i>
                <span>Payment</span>
            </button>
            <button class="mobile-tab" data-tab="policies-tab">
                <i class="fas fa-file-contract"></i>
                <span>Policies</span>
            </button>
            <button class="mobile-tab" data-tab="security-tab">
                <i class="fas fa-lock"></i>
                <span>Security</span>
            </button>
        </div>
    </div>

    <!-- Main Tabs Content - Exactly like customer dashboard design -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <!-- Desktop Tabs Header - Exactly like customer dashboard -->
        <div class="hidden lg:block border-b border-gray-200 dark:border-gray-700">
            <div class="flex overflow-x-auto">
                <button class="tab-button py-4 px-6 font-medium border-b-2 border-green-600 text-green-600 flex items-center active" data-tab="profile-tab">
                    <i class="fas fa-user mr-2"></i> Profile
                </button>
                <button class="tab-button py-4 px-6 font-medium text-gray-600 dark:text-gray-400 border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 flex items-center" data-tab="business-tab">
                    <i class="fas fa-briefcase mr-2"></i> Business
                </button>
                <button class="tab-button py-4 px-6 font-medium text-gray-600 dark:text-gray-400 border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 flex items-center" data-tab="payment-tab">
                    <i class="fas fa-credit-card mr-2"></i> Payment
                </button>
                <button class="tab-button py-4 px-6 font-medium text-gray-600 dark:text-gray-400 border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 flex items-center" data-tab="policies-tab">
                    <i class="fas fa-file-contract mr-2"></i> Policies
                </button>
                <button class="tab-button py-4 px-6 font-medium text-gray-600 dark:text-gray-400 border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 flex items-center" data-tab="security-tab">
                    <i class="fas fa-lock mr-2"></i> Security
                </button>
            </div>
        </div>

        <!-- Tab Content: Profile -->
        <div id="profile-tab" class="tab-content active p-4 sm:p-6">
            <form id="profile-form" action="{{ route('seller.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Store Name -->
                    <div class="form-group">
                        <label class="form-label">Store Name <span class="text-red-500">*</span></label>
                        <input type="text" name="store_name" value="{{ old('store_name', $seller->store_name) }}" 
                               class="form-input @error('store_name') border-red-500 @enderror" 
                               placeholder="Enter your store name" required>
                        @error('store_name')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Store Logo -->
                    <div class="form-group">
                        <label class="form-label">Store Logo</label>
                        <input type="file" name="logo" accept="image/*" class="form-input @error('logo') border-red-500 @enderror">
                        @if($seller->logo)
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Current logo is set</p>
                        @endif
                        @error('logo')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Store Description -->
                <div class="form-group">
                    <label class="form-label">Store Description</label>
                    <textarea name="store_description" 
                              class="form-textarea @error('store_description') border-red-500 @enderror" 
                              placeholder="Tell customers about your store...">{{ old('store_description', $seller->store_description) }}</textarea>
                    @error('store_description')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Store Banner -->
                <div class="form-group">
                    <label class="form-label">Store Banner</label>
                    <input type="file" name="banner" accept="image/*" class="form-input @error('banner') border-red-500 @enderror">
                    @if($seller->banner)
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Current banner is set</p>
                    @endif
                    @error('banner')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Navigation Buttons -->
                <div class="nav-buttons">
                    <div></div> <!-- Empty div for spacing -->
                    <button type="button" class="btn btn-primary next-btn" data-next-tab="business-tab">
                        Next <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Tab Content: Business -->
        <div id="business-tab" class="tab-content p-4 sm:p-6">
            <form id="business-form" action="{{ route('seller.settings.update') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Business Place -->
                    <div class="form-group">
                        <label class="form-label">Business Location <span class="text-red-500">*</span></label>
                        <input type="text" name="business_place" value="{{ old('business_place', $seller->business_place) }}" 
                               class="form-input @error('business_place') border-red-500 @enderror" 
                               placeholder="City or area" required>
                        @error('business_place')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Business Region -->
                    <div class="form-group">
                        <label class="form-label">Region <span class="text-red-500">*</span></label>
                        <select name="business_region" class="form-select @error('business_region') border-red-500 @enderror" required>
                            <option value="">Select Region</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->name }}" {{ old('business_region', $seller->business_region) == $region->name ? 'selected' : '' }}>
                                    {{ $region->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('business_region')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Tax ID -->
                    <div class="form-group">
                        <label class="form-label">Tax ID</label>
                        <input type="text" name="tax_id" value="{{ old('tax_id', $seller->tax_id) }}" 
                               class="form-input @error('tax_id') border-red-500 @enderror" 
                               placeholder="Your tax identification number">
                        @error('tax_id')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Business License -->
                    <div class="form-group">
                        <label class="form-label">Business License</label>
                        <input type="text" name="business_license" value="{{ old('business_license', $seller->business_license) }}" 
                               class="form-input @error('business_license') border-red-500 @enderror" 
                               placeholder="Your business license number">
                        @error('business_license')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Customer Service Phone -->
                    <div class="form-group">
                        <label class="form-label">Customer Service Phone</label>
                        <input type="tel" name="customer_service_phone" value="{{ old('customer_service_phone', $seller->customer_service_phone) }}" 
                               class="form-input @error('customer_service_phone') border-red-500 @enderror" 
                               placeholder="+255 xxx xxx xxx">
                        @error('customer_service_phone')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Customer Service Email -->
                    <div class="form-group">
                        <label class="form-label">Customer Service Email</label>
                        <input type="email" name="customer_service_email" value="{{ old('customer_service_email', $seller->customer_service_email) }}" 
                               class="form-input @error('customer_service_email') border-red-500 @enderror" 
                               placeholder="support@yourstore.com">
                        @error('customer_service_email')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="nav-buttons">
                    <button type="button" class="btn btn-secondary back-btn" data-prev-tab="profile-tab">
                        <i class="fas fa-arrow-left mr-2"></i> Back
                    </button>
                    <button type="button" class="btn btn-primary next-btn" data-next-tab="payment-tab">
                        Next <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Tab Content: Payment -->
        <div id="payment-tab" class="tab-content p-4 sm:p-6">
            <form id="payment-form" action="{{ route('seller.settings.update') }}" method="POST">
                @csrf

                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Bank Account</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="form-group">
                        <label class="form-label">Bank Name</label>
                        <input type="text" name="bank_name" value="{{ old('bank_name', $seller->bank_name) }}" 
                               class="form-input @error('bank_name') border-red-500 @enderror" 
                               placeholder="e.g., NBC, CRDB, TIB">
                        @error('bank_name')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Account Number</label>
                        <input type="text" name="bank_account_number" value="{{ old('bank_account_number', $seller->bank_account_number) }}" 
                               class="form-input @error('bank_account_number') border-red-500 @enderror" 
                               placeholder="Your bank account number">
                        @error('bank_account_number')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group md:col-span-2">
                        <label class="form-label">Account Name</label>
                        <input type="text" name="bank_account_name" value="{{ old('bank_account_name', $seller->bank_account_name) }}" 
                               class="form-input @error('bank_account_name') border-red-500 @enderror" 
                               placeholder="Name on the account">
                        @error('bank_account_name')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <hr class="my-6 border-gray-200 dark:border-gray-700">

                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Mobile Money</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label class="form-label">M-Pesa / Mobile Money Number</label>
                        <input type="tel" name="momo_number" value="{{ old('momo_number', $seller->momo_number) }}" 
                               class="form-input @error('momo_number') border-red-500 @enderror" 
                               placeholder="+255 xxx xxx xxx">
                        @error('momo_number')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Account Name</label>
                        <input type="text" name="momo_name" value="{{ old('momo_name', $seller->momo_name) }}" 
                               class="form-input @error('momo_name') border-red-500 @enderror" 
                               placeholder="Name on the account">
                        @error('momo_name')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="nav-buttons">
                    <button type="button" class="btn btn-secondary back-btn" data-prev-tab="business-tab">
                        <i class="fas fa-arrow-left mr-2"></i> Back
                    </button>
                    <button type="button" class="btn btn-primary next-btn" data-next-tab="policies-tab">
                        Next <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Tab Content: Policies -->
        <div id="policies-tab" class="tab-content p-4 sm:p-6">
            <form id="policies-form" action="{{ route('seller.settings.update') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Return Policy</label>
                    <textarea name="return_policy" 
                              class="form-textarea @error('return_policy') border-red-500 @enderror" 
                              placeholder="Describe your return policy...">{{ old('return_policy', $seller->return_policy) }}</textarea>
                    @error('return_policy')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Shipping Policy</label>
                    <textarea name="shipping_policy" 
                              class="form-textarea @error('shipping_policy') border-red-500 @enderror" 
                              placeholder="Describe your shipping policy...">{{ old('shipping_policy', $seller->shipping_policy) }}</textarea>
                    @error('shipping_policy')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Navigation Buttons -->
                <div class="nav-buttons">
                    <button type="button" class="btn btn-secondary back-btn" data-prev-tab="payment-tab">
                        <i class="fas fa-arrow-left mr-2"></i> Back
                    </button>
                    <button type="button" class="btn btn-primary next-btn" data-next-tab="security-tab">
                        Next <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Tab Content: Security -->
        <div id="security-tab" class="tab-content p-4 sm:p-6">
            <form id="security-form" action="{{ route('seller.settings.update') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group md:col-span-2">
                        <label class="form-label">Current Password <span class="text-red-500">*</span></label>
                        <input type="password" name="current_password" 
                               class="form-input @error('current_password') border-red-500 @enderror" 
                               placeholder="Enter your current password">
                        @error('current_password')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">New Password <span class="text-red-500">*</span></label>
                        <input type="password" name="new_password" 
                               class="form-input @error('new_password') border-red-500 @enderror" 
                               placeholder="Enter your new password">
                        @error('new_password')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Confirm Password <span class="text-red-500">*</span></label>
                        <input type="password" name="new_password_confirmation" 
                               class="form-input @error('new_password_confirmation') border-red-500 @enderror" 
                               placeholder="Confirm your new password">
                        @error('new_password_confirmation')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="nav-buttons">
                    <button type="button" class="btn btn-secondary back-btn" data-prev-tab="policies-tab">
                        <i class="fas fa-arrow-left mr-2"></i> Back
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i> Save All Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bottom Navigation -->
@include('partials.bottom_nav')

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

    // === TAB FUNCTIONALITY - With Back/Next buttons ===
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-button, .mobile-tab');
        const tabContents = document.querySelectorAll('.tab-content');
        const nextButtons = document.querySelectorAll('.next-btn');
        const backButtons = document.querySelectorAll('.back-btn');

        // Function to switch tabs
        function switchTab(tabName) {
            // Hide all tab contents
            tabContents.forEach(content => {
                content.style.display = 'none';
                content.classList.remove('active');
            });

            // Remove active classes from all buttons
            tabButtons.forEach(button => {
                button.classList.remove('active');
                if (button.classList.contains('tab-button')) {
                    button.classList.remove('border-green-600', 'text-green-600');
                    button.classList.add('text-gray-600', 'dark:text-gray-400', 'border-transparent');
                }
            });

            // Show the selected tab content
            const activeTab = document.getElementById(tabName);
            if (activeTab) {
                activeTab.style.display = 'block';
                activeTab.classList.add('active');
            }

            // Set active state for the clicked button
            tabButtons.forEach(button => {
                if (button.getAttribute('data-tab') === tabName) {
                    button.classList.add('active');
                    if (button.classList.contains('tab-button')) {
                        button.classList.remove('text-gray-600', 'dark:text-gray-400', 'border-transparent');
                        button.classList.add('border-green-600', 'text-green-600');
                    }
                }
            });

            // Save current tab to session storage
            sessionStorage.setItem('currentTab', tabName);
        }

        // Add click event listeners to all tab buttons
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tabName = this.getAttribute('data-tab');
                switchTab(tabName);
            });
        });

        // Add click event listeners to Next buttons
        nextButtons.forEach(button => {
            button.addEventListener('click', function() {
                const nextTab = this.getAttribute('data-next-tab');
                switchTab(nextTab);
            });
        });

        // Add click event listeners to Back buttons
        backButtons.forEach(button => {
            button.addEventListener('click', function() {
                const prevTab = this.getAttribute('data-prev-tab');
                switchTab(prevTab);
            });
        });

        // Initialize with saved tab or default to profile-tab
        const savedTab = sessionStorage.getItem('currentTab') || 'profile-tab';
        switchTab(savedTab);
    });
</script>
@endsection