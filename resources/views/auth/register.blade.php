<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Registration - Buyo</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .register-container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        .btn-primary {
            background: #008000;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background: #006600;
        }

        .input-focus:focus {
            border-color: #008000;
            box-shadow: 0 0 0 3px rgba(0, 128, 0, 0.2);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="register-container px-4">
        <!-- Logo and Title -->
        <div class="text-center mb-8">
            <div class="flex justify-center items-center mb-4">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-store text-green-600 text-2xl"></i>
                </div>
            </div>
            <span class="text-2xl font-bold text-green-600 ml-3 my-2">Buyo</span>
            <h1 class="text-2xl font-bold text-gray-800">Seller Registration</h1>
            <p class="text-gray-600 mt-2">Set up your business account in 3 simple steps</p>
        </div>

        <!-- Progress Bar -->
        <div class="mb-6">
            <div class="flex justify-between mb-2">
                <span class="text-sm font-medium text-gray-700">Step <span id="current-step">1</span> of 3</span>
                <span class="text-sm text-gray-500"><span id="progress-percentage">33</span>% complete</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-green-600 h-2 rounded-full transition-all duration-300" style="width: 33%"></div>
            </div>
        </div>

        <!-- Tab 1: Business Information -->
        <div id="tab-1" class="tab-content active">
            <h2 class="text-lg font-medium text-gray-800 mb-4">Business Information</h2>
            <div class="space-y-4">
                <div>
                    <label for="businessName" class="block text-sm font-medium text-gray-700 mb-1">Business Name</label>
                    <input type="text" id="businessName" name="store_name" required
                           class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition"
                           placeholder="e.g. Mwanaidi General Shop">
                </div>
                <div>
                    <label for="ownerName" class="block text-sm font-medium text-gray-700 mb-1">Business Owner Name</label>
                    <input type="text" id="ownerName" name="name" required
                           class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition"
                           placeholder="Full name of owner">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="gender" value="male"
                                   class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300" required>
                            <span class="ml-2 text-gray-700">Male</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="gender" value="female"
                                   class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                            <span class="ml-2 text-gray-700">Female</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label for="dob" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                    <input type="date" id="dob" name="dob" required
                           class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition">
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
            <h2 class="text-lg font-medium text-gray-800 mb-4">Location & Contact</h2>
            <div class="space-y-4">
                <div>
                    <label for="businessPlace" class="block text-sm font-medium text-gray-700 mb-1">Place of Business</label>
                    <input type="text" id="businessPlace" name="location" required
                           class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition"
                           placeholder="e.g. Kariakoo Market">
                </div>
                <div>
                    <label for="region" class="block text-sm font-medium text-gray-700 mb-1">Region</label>
                    <select id="region" name="region" required
                            class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition">
                        <option value="" disabled selected>Select your region</option>
                        <option value="Dar es Salaam">Dar es Salaam</option>
                        <option value="Dodoma">Dodoma</option>
                        <option value="Arusha">Arusha</option>
                        <option value="Mwanza">Mwanza</option>
                        <option value="Mbeya">Mbeya</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telephone Number</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">+255</span>
                        </div>
                        <input type="tel" id="phone" name="phone" required
                               class="pl-12 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition"
                               placeholder="712345678" pattern="[0-9]{9}">
                    </div>
                </div>
                <div>
                    <label for="seller-email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" id="seller-email" name="email" required
                               class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition"
                               placeholder="your@email.com">
                    </div>
                </div>
            </div>
            <div class="mt-6 flex justify-between">
                <button type="button" onclick="prevTab('tab-1')" class="border border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-50 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </button>
                <button type="button" onclick="nextTab('tab-3')" class="btn-primary text-white px-6 py-3 rounded-lg font-medium">
                    Next <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>

        <!-- Tab 3: Account Credentials -->
        <div id="tab-3" class="tab-content">
            <h2 class="text-lg font-medium text-gray-800 mb-4">Account Credentials</h2>
            <div class="space-y-4">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input type="text" id="username" name="username" required
                               class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition"
                               placeholder="Choose a username">
                    </div>
                </div>
                <div>
                    <label for="seller-password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" id="seller-password" name="password" required
                               class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition"
                               placeholder="••••••••">
                    </div>
                </div>
                <div>
                    <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" id="confirmPassword" name="password_confirmation" required
                               class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition"
                               placeholder="••••••••">
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox" required
                               class="focus:ring-green-600 h-4 w-4 text-green-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="text-gray-700">
                            I agree to the <a href="#" class="text-green-600 hover:text-green-700">Terms of Service</a> and <a href="#" class="text-green-600 hover:text-green-700">Privacy Policy</a>
                        </label>
                    </div>
                </div>
            </div>
            <div class="mt-6 flex justify-between">
                <button type="button" onclick="prevTab('tab-2')" class="border border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-50 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </button>
                <button type="button" onclick="registerAsSeller()" class="btn-primary text-white px-6 py-3 rounded-lg font-medium">
                    <i class="fas fa-user-plus mr-2"></i> Create Account
                </button>
            </div>
        </div>

        <!-- Back link -->
        <div class="mt-8 text-center">
            <a href="{{ route('choose') }}" class="text-green-600 hover:text-green-700 flex items-center justify-center text-sm">
                <i class="fas fa-arrow-left mr-2"></i> Back to role selection
            </a>
        </div>
    </div>

    <script>
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
            if (currentTab === 'tab-1') currentStep = 2;
            else if (currentTab === 'tab-2') currentStep = 3;
            switchTab(nextTabId);
        }

        function prevTab(prevTabId) {
            if (currentTab === 'tab-3') currentStep = 2;
            else if (currentTab === 'tab-2') currentStep = 1;
            switchTab(prevTabId);
        }

        function registerAsSeller() {
            // Validate all seller form fields
            const requiredFields = [
                'businessName', 'ownerName', 'dob', 'businessPlace', 
                'region', 'phone', 'seller-email', 'username', 
                'seller-password', 'confirmPassword'
            ];
            
            for (let field of requiredFields) {
                if (!document.getElementById(field).value) {
                    alert('Please fill in all required fields');
                    return;
                }
            }
            
            if (!document.getElementById('terms').checked) {
                alert('Please agree to the Terms of Service and Privacy Policy');
                return;
            }
            
            // Simulate registration
            alert('Seller account created successfully! Redirecting to login...');
            window.location.href = 'login.html';
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            updateProgress();
        });
    </script>
</body>
</html>