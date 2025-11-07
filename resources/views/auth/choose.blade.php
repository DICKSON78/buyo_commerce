<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Buyo - Choose Your Role</title>
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

        .role-option {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
        }

        .role-option:hover {
            border-color: #008000;
            transform: translateY(-2px);
        }

        .role-option.selected {
            border-color: #008000;
            background-color: #f0fdf4;
        }

        .btn-primary {
            background: #008000;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background: #006600;
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
            <h1 class="text-2xl font-bold text-gray-800">Create Your Account</h1>
            <p class="text-gray-600 mt-2">Join thousands of buyers and sellers on Buyo</p>
        </div>

        <!-- Role Selection -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">I want to:</label>
            <div class="space-y-3">
                <!-- Buyer Option -->
                <div class="role-option p-4 rounded-lg cursor-pointer" onclick="selectRole('buyer')">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-800">Buy Products</h3>
                            <p class="text-sm text-gray-500 mt-1">Browse and purchase products from various sellers</p>
                        </div>
                        <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center">
                            <div class="w-3 h-3 rounded-full bg-green-600 hidden"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Seller Option -->
                <div class="role-option p-4 rounded-lg cursor-pointer" onclick="selectRole('seller')">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-store text-green-600 text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-800">Sell Products</h3>
                            <p class="text-sm text-gray-500 mt-1">List your products and start selling to customers</p>
                        </div>
                        <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center">
                            <div class="w-3 h-3 rounded-full bg-green-600 hidden"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Continue Button -->
        <button id="continue-btn" onclick="continueToNext()" class="btn-primary w-full text-white py-3 rounded-lg font-medium opacity-50 cursor-not-allowed" disabled>
            Continue
        </button>



        <!-- Back to home link -->
        <div class="mt-6 text-center">
            <a href="{{ route('home') }}" class="text-green-600 hover:text-green-700 flex items-center justify-center text-sm">
                <i class="fas fa-arrow-left mr-2"></i> Back to home
            </a>
        </div>
    </div>

    <script>
        let selectedRole = null;

        function selectRole(role) {
            selectedRole = role;
            
            // Update visual selection
            document.querySelectorAll('.role-option').forEach(option => {
                option.classList.remove('selected');
                const checkmark = option.querySelector('.bg-green-600');
                checkmark.classList.add('hidden');
                option.querySelector('.border-gray-300').classList.remove('border-green-600');
            });
            
            const selectedOption = event.currentTarget;
            selectedOption.classList.add('selected');
            const checkmark = selectedOption.querySelector('.bg-green-600');
            checkmark.classList.remove('hidden');
            selectedOption.querySelector('.border-gray-300').classList.add('border-green-600');
            
            // Enable continue button
            const continueBtn = document.getElementById('continue-btn');
            continueBtn.disabled = false;
            continueBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            continueBtn.classList.add('cursor-pointer');
        }

        function continueToNext() {
            if (!selectedRole) return;
            
            if (selectedRole === 'buyer') {
                // Redirect to login page for buyers
                window.location.href = "{{ route('login') }}";
            } else {
                // Redirect to seller registration page
                window.location.href = "{{ route('register') }}";
            }
        }
    </script>
</body>
</html>