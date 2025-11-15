<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Registration - Buyo</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <style>
        :root {
            --primary: #008000;
            --secondary: #FFD700;
            --dark: #1a1a1a;
            --light: #f8f9fa;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Dark Mode Styles */
        .dark body {
            background-color: #1a1a1a;
            color: #e5e7eb;
        }

        .dark .bg-gray-50 {
            background-color: #111827;
        }

        .dark .text-gray-800 {
            color: #f9fafb;
        }

        .dark .text-gray-700 {
            color: #e5e7eb;
        }

        .dark .text-gray-600 {
            color: #d1d5db;
        }

        .dark .border-gray-300 {
            border-color: #374151;
        }

        .dark .bg-gray-200 {
            background-color: #374151;
        }

        .dark .bg-green-100 {
            background-color: #064e3b;
        }

        .dark .bg-red-100 {
            background-color: #7f1d1d;
        }

        .dark .text-red-700 {
            color: #fca5a5;
        }

        .dark .border-red-400 {
            border-color: #f87171;
        }

        .dark .text-green-700 {
            color: #6ee7b7;
        }

        .dark .border-green-400 {
            border-color: #34d399;
        }

        .dark .hover\:bg-gray-50:hover {
            background-color: #374151;
        }

        .btn-primary {
            background: #008000;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background: #006600;
        }

        .dark .btn-primary {
            background: #0a5c0a;
        }

        .dark .btn-primary:hover {
            background: #064e06;
        }

        .input-focus:focus {
            border-color: #008000;
            box-shadow: 0 0 0 3px rgba(0, 128, 0, 0.2);
        }

        .dark .input-focus:focus {
            border-color: #0a5c0a;
            box-shadow: 0 0 0 3px rgba(10, 92, 10, 0.3);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Progress bar dark mode */
        .dark .bg-green-600 {
            background-color: #0a5c0a;
        }

        /* Custom Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-container {
            background: white;
            border-radius: 12px;
            padding: 0;
            max-width: 400px;
            width: 90%;
            transform: scale(0.9);
            transition: transform 0.3s ease;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .dark .modal-container {
            background: #1f2937;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
        }

        .modal-overlay.active .modal-container {
            transform: scale(1);
        }

        .modal-header {
            padding: 1.5rem 1.5rem 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .dark .modal-header {
            border-bottom-color: #374151;
        }

        .modal-body {
            padding: 1rem 1.5rem;
        }

        .modal-footer {
            padding: 1rem 1.5rem 1.5rem;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
        }

        .dark .modal-footer {
            border-top-color: #374151;
        }

        .modal-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
        }

        .modal-icon.warning {
            background: #fef3c7;
            color: #d97706;
        }

        .dark .modal-icon.warning {
            background: #451a03;
            color: #fbbf24;
        }

        .modal-icon.error {
            background: #fee2e2;
            color: #dc2626;
        }

        .dark .modal-icon.error {
            background: #7f1d1d;
            color: #f87171;
        }

        .modal-icon.success {
            background: #d1fae5;
            color: #059669;
        }

        .dark .modal-icon.success {
            background: #064e3b;
            color: #34d399;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 0.5rem;
            color: #1f2937;
        }

        .dark .modal-title {
            color: #f9fafb;
        }

        .modal-message {
            text-align: center;
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        .dark .modal-message {
            color: #d1d5db;
        }

        .btn-modal {
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
            outline: none;
        }

        .btn-modal-primary {
            background: #008000;
            color: white;
        }

        .btn-modal-primary:hover {
            background: #006600;
        }

        .dark .btn-modal-primary {
            background: #0a5c0a;
        }

        .dark .btn-modal-primary:hover {
            background: #064e06;
        }

        .btn-modal-secondary {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .btn-modal-secondary:hover {
            background: #e5e7eb;
        }

        .dark .btn-modal-secondary {
            background: #374151;
            color: #d1d5db;
            border-color: #4b5563;
        }

        .dark .btn-modal-secondary:hover {
            background: #4b5563;
        }

        /* Country Code Dropdown Styles */
        .country-code-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        .dark .country-code-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%239ca3af' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        }

        /* Readonly input styles */
        .readonly-input {
            background-color: #f9fafb;
            color: #6b7280;
            cursor: not-allowed;
        }

        .dark .readonly-input {
            background-color: #374151;
            color: #9ca3af;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-300">
    <!-- Custom Modal -->
    <div id="customModal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <div id="modalIcon" class="modal-icon warning">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h3 id="modalTitle" class="modal-title">Attention Required</h3>
            </div>
            <div class="modal-body">
                <p id="modalMessage" class="modal-message">Please fill in all required fields before proceeding.</p>
            </div>
            <div class="modal-footer">
                <button id="modalCancel" class="btn-modal btn-modal-secondary" style="display: none;">Cancel</button>
                <button id="modalConfirm" class="btn-modal btn-modal-primary">OK</button>
            </div>
        </div>
    </div>

    <div class="register-container px-4 w-full max-w-2xl">
        <!-- Logo and Title -->
        <div class="text-center mb-8">
            <div class="flex justify-center items-center mb-4">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                    <i class="fas fa-store text-green-600 dark:text-green-400 text-2xl"></i>
                </div>
            </div>
            <span class="text-2xl font-bold text-green-600 dark:text-green-400 ml-3 my-2">Buyo</span>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Seller Registration</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Set up your business account in 3 simple steps</p>
            
            @php
                $user = Auth::user();
                $isExistingCustomer = Auth::check() && $user->user_type === 'customer';
            @endphp
            
            @if($isExistingCustomer)
            <div class="mt-4 bg-blue-100 dark:bg-blue-900 border border-blue-400 dark:border-blue-700 text-blue-700 dark:text-blue-200 px-4 py-3 rounded">
                <i class="fas fa-info-circle mr-2"></i>
                You're registering as a seller using your existing customer account: <strong>{{ $user->username }}</strong>
            </div>
            @endif
        </div>

        @if ($errors->any())
            <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Progress Bar -->
        <div class="mb-6">
            <div class="flex justify-between mb-2">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Step <span id="current-step">1</span> of 3</span>
                <span class="text-sm text-gray-500 dark:text-gray-400"><span id="progress-percentage">33</span>% complete</span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                <div class="bg-green-600 dark:bg-green-700 h-2 rounded-full transition-all duration-300" style="width: 33%"></div>
            </div>
        </div>

        <form action="{{ route('seller.register') }}" method="POST" id="seller-registration-form">
            @csrf

            <!-- Tab 1: Business Information -->
            <div id="tab-1" class="tab-content active">
                <h2 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">Business Information</h2>
                <div class="space-y-4">
                    <div>
                        <label for="store_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Business Name *</label>
                        <input type="text" id="store_name" name="store_name" value="{{ old('store_name') }}" required
                               class="input-focus w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none transition bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                               placeholder="e.g. Mwanaidi General Shop">
                    </div>
                    
                    @if(!$isExistingCustomer)
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Username *</label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" required
                               class="input-focus w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none transition bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                               placeholder="Choose a username">
                    </div>
                    @endif
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Business Owner Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $isExistingCustomer ? $user->username : '') }}" required
                               class="input-focus w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none transition bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                               placeholder="Full name of owner">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gender *</label>
                        <div class="flex space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }}
                                       class="h-4 w-4 text-green-600 dark:text-green-400 focus:ring-green-500 border-gray-300 dark:border-gray-600" required>
                                <span class="ml-2 text-gray-700 dark:text-gray-300">Male</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}
                                       class="h-4 w-4 text-green-600 dark:text-green-400 focus:ring-green-500 border-gray-300 dark:border-gray-600">
                                <span class="ml-2 text-gray-700 dark:text-gray-300">Female</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label for="dob" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date of Birth *</label>
                        <input type="date" id="dob" name="dob" value="{{ old('dob') }}" required
                               class="input-focus w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none transition bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200">
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="button" onclick="nextTab('tab-2')" class="btn-primary text-white px-6 py-3 rounded-lg font-medium">
                        Next <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </div>

            <!-- Tab 2: Location & Contact -->
            <div id="tab-2" class="tab-content">
                <h2 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">Location & Contact</h2>
                <div class="space-y-4">
                    <div>
                        <label for="business_place" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Place of Business *</label>
                        <input type="text" id="business_place" name="business_place" value="{{ old('business_place') }}" required
                               class="input-focus w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none transition bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                               placeholder="e.g. Kariakoo Market">
                    </div>
                    <div>
                        <label for="region_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Region *</label>
                        <select id="region_id" name="region_id" required
                                class="input-focus country-code-select w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none transition bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200">
                            <option value="" disabled {{ old('region_id') ? '' : 'selected' }}>Select your region</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                    {{ $region->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    @if(!$isExistingCustomer)
                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-1">
                            <label for="phone_country_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Country Code *</label>
                            <select id="phone_country_code" name="phone_country_code" required
                                    class="country-code-select w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 text-sm">
                                <option value="+255" selected>+255 Tanzania</option>
                                <option value="+254">+254 Kenya</option>
                                <option value="+256">+256 Uganda</option>
                                <option value="+257">+257 Burundi</option>
                                <option value="+250">+250 Rwanda</option>
                                <option value="+258">+258 Mozambique</option>
                                <option value="+260">+260 Zambia</option>
                                <option value="+263">+263 Zimbabwe</option>
                                <option value="+264">+264 Namibia</option>
                                <option value="+267">+267 Botswana</option>
                                <option value="+268">+268 Swaziland</option>
                                <option value="+269">+269 Comoros</option>
                                <option value="+27">+27 South Africa</option>
                                <option value="+211">+211 South Sudan</option>
                                <option value="+249">+249 Sudan</option>
                                <option value="+251">+251 Ethiopia</option>
                                <option value="+252">+252 Somalia</option>
                                <option value="+253">+253 Djibouti</option>
                                <option value="+261">+261 Madagascar</option>
                                <option value="+262">+262 Réunion</option>
                                <option value="+265">+265 Malawi</option>
                                <option value="+266">+266 Lesotho</option>
                                <option value="+290">+290 St. Helena</option>
                                <option value="+291">+291 Eritrea</option>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label for="phone_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone Number *</label>
                            <input type="tel" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required
                                   class="input-focus w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none transition bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                                   placeholder="712345678" pattern="[0-9]{9}">
                        </div>
                    </div>
                    @else
                    <!-- For existing customers - Phone number is optional and pre-filled -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-1">
                            <label for="phone_country_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Country Code</label>
                            <select id="phone_country_code" name="phone_country_code"
                                    class="country-code-select w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 text-sm">
                                <option value="+255" selected>+255 Tanzania</option>
                                <option value="+254">+254 Kenya</option>
                                <option value="+256">+256 Uganda</option>
                                <option value="+257">+257 Burundi</option>
                                <option value="+250">+250 Rwanda</option>
                                <option value="+258">+258 Mozambique</option>
                                <option value="+260">+260 Zambia</option>
                                <option value="+263">+263 Zimbabwe</option>
                                <option value="+264">+264 Namibia</option>
                                <option value="+267">+267 Botswana</option>
                                <option value="+268">+268 Swaziland</option>
                                <option value="+269">+269 Comoros</option>
                                <option value="+27">+27 South Africa</option>
                                <option value="+211">+211 South Sudan</option>
                                <option value="+249">+249 Sudan</option>
                                <option value="+251">+251 Ethiopia</option>
                                <option value="+252">+252 Somalia</option>
                                <option value="+253">+253 Djibouti</option>
                                <option value="+261">+261 Madagascar</option>
                                <option value="+262">+262 Réunion</option>
                                <option value="+265">+265 Malawi</option>
                                <option value="+266">+266 Lesotho</option>
                                <option value="+290">+290 St. Helena</option>
                                <option value="+291">+291 Eritrea</option>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label for="phone_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone Number (Optional)</label>
                            <input type="tel" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number ?? '') }}"
                                   class="input-focus w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none transition bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                                   placeholder="712345678" pattern="[0-9]{9}">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Leave empty to keep your current phone number: <strong>{{ $user->phone ?? 'Not set' }}</strong></p>
                        </div>
                    </div>
                    @endif
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address @if(!$isExistingCustomer)*@endif</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            @if($isExistingCustomer)
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                                   class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none transition bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                                   placeholder="your@email.com">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Leave empty to keep your current email: <strong>{{ $user->email ?? 'Not set' }}</strong></p>
                            @else
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                   class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none transition bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                                   placeholder="your@email.com">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-between">
                    <button type="button" onclick="prevTab('tab-1')" class="border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 px-6 py-3 rounded-lg font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <i class="fas fa-arrow-left mr-2"></i> Back
                    </button>
                    <button type="button" onclick="nextTab('tab-3')" class="btn-primary text-white px-6 py-3 rounded-lg font-medium">
                        Next <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </div>

            <!-- Tab 3: Account Credentials -->
            <div id="tab-3" class="tab-content">
                <h2 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">Account Credentials</h2>
                <div class="space-y-4">
                    @if(!$isExistingCustomer)
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="password" name="password" required
                                   class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none transition bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                                   placeholder="••••••••">
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Password must be at least 6 characters long</p>
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm Password *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                   class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none transition bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                                   placeholder="••••••••">
                        </div>
                    </div>
                    @else
                    <div class="bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-800 p-4 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-key text-green-600 dark:text-green-400 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-semibold text-green-800 dark:text-green-300">Your Account Credentials</h4>
                                <p class="text-sm text-green-700 dark:text-green-400 mt-1">
                                    You'll continue using your existing customer account credentials:
                                </p>
                                <div class="mt-2 space-y-1 text-sm">
                                    <div><strong>Username:</strong> {{ $user->username }}</div>
                                    <div><strong>Password:</strong> Your current password</div>
                                </div>
                                <p class="text-xs text-green-600 dark:text-green-500 mt-2">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Your login details remain the same. You can now access both customer and seller features.
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="terms" name="terms" type="checkbox" required
                                   class="focus:ring-green-600 dark:focus:ring-green-400 h-4 w-4 text-green-600 dark:text-green-400 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-800">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="terms" class="text-gray-700 dark:text-gray-300">
                                I agree to the <a href="#" class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300">Terms of Service</a> and <a href="#" class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300">Privacy Policy</a>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-between">
                    <button type="button" onclick="prevTab('tab-2')" class="border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 px-6 py-3 rounded-lg font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <i class="fas fa-arrow-left mr-2"></i> Back
                    </button>
                    <button type="submit" class="btn-primary text-white px-6 py-3 rounded-lg font-medium">
                        @if($isExistingCustomer)
                        <i class="fas fa-store mr-2"></i> Become Seller
                        @else
                        <i class="fas fa-user-plus mr-2"></i> Create Account
                        @endif
                    </button>
                </div>
            </div>
        </form>

        <!-- Back link -->
        <div class="mt-8 text-center">
            <a href="{{ route('choose') }}" class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 flex items-center justify-center text-sm">
                <i class="fas fa-arrow-left mr-2"></i> Back to role selection
            </a>
        </div>
    </div>

    <script>
        // === DARK MODE DETECTION ===
        const html = document.documentElement;

        // Initialize theme based on device preference
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }

        // Listen for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
            if (!localStorage.getItem('theme')) {
                if (event.matches) {
                    html.classList.add('dark');
                } else {
                    html.classList.remove('dark');
                }
            }
        });

        // === CUSTOM MODAL SYSTEM ===
        const modal = document.getElementById('customModal');
        const modalIcon = document.getElementById('modalIcon');
        const modalTitle = document.getElementById('modalTitle');
        const modalMessage = document.getElementById('modalMessage');
        const modalConfirm = document.getElementById('modalConfirm');
        const modalCancel = document.getElementById('modalCancel');

        function showModal(type, title, message, confirmCallback = null, cancelCallback = null) {
            // Reset modal classes
            modalIcon.className = 'modal-icon';
            
            // Set modal type and content
            switch(type) {
                case 'warning':
                    modalIcon.classList.add('warning');
                    modalIcon.innerHTML = '<i class="fas fa-exclamation-triangle"></i>';
                    break;
                case 'error':
                    modalIcon.classList.add('error');
                    modalIcon.innerHTML = '<i class="fas fa-times-circle"></i>';
                    break;
                case 'success':
                    modalIcon.classList.add('success');
                    modalIcon.innerHTML = '<i class="fas fa-check-circle"></i>';
                    break;
                default:
                    modalIcon.classList.add('warning');
                    modalIcon.innerHTML = '<i class="fas fa-info-circle"></i>';
            }

            modalTitle.textContent = title;
            modalMessage.textContent = message;

            // Show/hide cancel button
            if (cancelCallback) {
                modalCancel.style.display = 'block';
                modalCancel.onclick = function() {
                    hideModal();
                    if (cancelCallback) cancelCallback();
                };
            } else {
                modalCancel.style.display = 'none';
            }

            // Set confirm button action
            modalConfirm.onclick = function() {
                hideModal();
                if (confirmCallback) confirmCallback();
            };

            // Show modal
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function hideModal() {
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                hideModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                hideModal();
            }
        });

        let currentTab = 'tab-1';
        let currentStep = 1;
        const totalSteps = 3;

        function updateProgress() {
            const progressPercentage = Math.round((currentStep / totalSteps) * 100);
            document.querySelector('.bg-green-600').style.width = `${progressPercentage}%`;
            document.getElementById('progress-percentage').textContent = progressPercentage;
            document.getElementById('current-step').textContent = currentStep;
        }

        function switchTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(tab => {
                if (tab.id.startsWith('tab-')) {
                    tab.classList.remove('active');
                }
            });
            document.getElementById(tabId).classList.add('active');
            currentTab = tabId;
            currentStep = parseInt(tabId.split('-')[1]);
            updateProgress();
        }

        function nextTab(nextTabId) {
            if (validateCurrentTab()) {
                if (currentTab === 'tab-1') currentStep = 2;
                else if (currentTab === 'tab-2') currentStep = 3;
                switchTab(nextTabId);
            }
        }

        function prevTab(prevTabId) {
            if (currentTab === 'tab-3') currentStep = 2;
            else if (currentTab === 'tab-2') currentStep = 1;
            switchTab(prevTabId);
        }

        function validateCurrentTab() {
            const currentTabElement = document.getElementById(currentTab);
            const inputs = currentTabElement.querySelectorAll('input[required], select[required]');
            let emptyField = null;

            for (let input of inputs) {
                if (!input.value) {
                    emptyField = input;
                    break;
                }

                // Email validation for tab 2 (only for new users)
                if (input.type === 'email' && input.value && input.hasAttribute('required')) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(input.value)) {
                        showModal('error', 'Invalid Email', 'Please enter a valid email address.', function() {
                            input.focus();
                        });
                        return false;
                    }
                }

                // Phone validation for tab 2 (only for new users)
                if (input.id === 'phone_number' && input.value && input.hasAttribute('required')) {
                    const phoneRegex = /^[0-9]{9}$/;
                    if (!phoneRegex.test(input.value)) {
                        showModal('error', 'Invalid Phone Number', 'Please enter a valid phone number (9 digits).', function() {
                            input.focus();
                        });
                        return false;
                    }
                }
            }

            if (emptyField) {
                showModal('warning', 'Required Field', 'Please fill in all required fields before proceeding.', function() {
                    emptyField.focus();
                });
                return false;
            }

            return true;
        }

        // Form submission validation
        document.getElementById('seller-registration-form').addEventListener('submit', function(e) {
            if (!document.getElementById('terms').checked) {
                e.preventDefault();
                showModal('warning', 'Terms Required', 'Please agree to the Terms of Service and Privacy Policy');
                return false;
            }

            // Password confirmation validation (only for new users)
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirmation');
            
            if (password && confirmPassword && password.hasAttribute('required')) {
                if (password.value !== confirmPassword.value) {
                    e.preventDefault();
                    showModal('error', 'Password Mismatch', 'Passwords do not match. Please make sure both passwords are the same.', function() {
                        password.focus();
                    });
                    return false;
                }

                if (password.value.length < 6) {
                    e.preventDefault();
                    showModal('error', 'Weak Password', 'Password must be at least 6 characters long.', function() {
                        password.focus();
                    });
                    return false;
                }
            }
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            updateProgress();
            
            // Auto-focus first field
            const firstInput = document.querySelector('input[required]');
            if (firstInput) {
                firstInput.focus();
            }

            // Auto-populate phone fields for existing customers
            @if($isExistingCustomer)
            const userPhone = '{{ $user->phone ?? "" }}';
            if (userPhone) {
                // Extract country code and phone number from stored phone
                const countryCode = userPhone.substring(0, 4); // +255
                const phoneNumber = userPhone.substring(4); // rest of the number
                
                const countryCodeSelect = document.getElementById('phone_country_code');
                const phoneNumberInput = document.getElementById('phone_number');
                
                if (countryCodeSelect && phoneNumberInput) {
                    // Set country code if it exists in options
                    for (let option of countryCodeSelect.options) {
                        if (option.value === countryCode) {
                            countryCodeSelect.value = countryCode;
                            break;
                        }
                    }
                    
                    // Set phone number
                    if (!phoneNumberInput.value) {
                        phoneNumberInput.value = phoneNumber;
                    }
                }
            }
            @endif
        });

        // Country code selection with flag emojis
        const countryCodes = {
            '+255': '🇹🇿 Tanzania',
            '+254': '🇰🇪 Kenya', 
            '+256': '🇺🇬 Uganda',
            '+257': '🇧🇮 Burundi',
            '+250': '🇷🇼 Rwanda',
            '+258': '🇲🇿 Mozambique',
            '+260': '🇿🇲 Zambia',
            '+263': '🇿🇼 Zimbabwe',
            '+264': '🇳🇦 Namibia',
            '+267': '🇧🇼 Botswana',
            '+268': '🇸🇿 Swaziland',
            '+269': '🇰🇲 Comoros',
            '+27': '🇿🇦 South Africa',
            '+211': '🇸🇸 South Sudan',
            '+249': '🇸🇩 Sudan',
            '+251': '🇪🇹 Ethiopia',
            '+252': '🇸🇴 Somalia',
            '+253': '🇩🇯 Djibouti',
            '+261': '🇲🇬 Madagascar',
            '+262': '🇷🇪 Réunion',
            '+265': '🇲🇼 Malawi',
            '+266': '🇱🇸 Lesotho',
            '+290': '🇸🇭 St. Helena',
            '+291': '🇪🇷 Eritrea'
        };

        // Enhance country dropdown with flags
        function enhanceCountryDropdown() {
            const select = document.getElementById('phone_country_code');
            if (select) {
                // Clear existing options
                select.innerHTML = '';
                
                // Add options with flags
                Object.entries(countryCodes).forEach(([code, name]) => {
                    const option = document.createElement('option');
                    option.value = code;
                    option.textContent = `${code} ${name}`;
                    if (code === '+255') {
                        option.selected = true;
                    }
                    select.appendChild(option);
                });
            }
        }

        // Uncomment the line below if you want to use flags in the dropdown
        // document.addEventListener('DOMContentLoaded', enhanceCountryDropdown);
    </script>
</body>
</html>