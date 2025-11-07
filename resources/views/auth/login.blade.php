<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BidhaaHub</title>
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

        .login-container {
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

        .modal {
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .modal-content {
            transform: translateY(-20px);
            transition: transform 0.3s ease;
        }

        .modal.active {
            opacity: 1;
            visibility: visible;
        }

        .modal.active .modal-content {
            transform: translateY(0);
        }

        .social-btn {
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem;
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
        }

        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .google-btn {
            background-color: white;
            color: #3c4043;
            border: 1px solid #dadce0;
            font-weight: 500;
        }

        .google-btn:hover {
            background-color: #f8f9fa;
            border-color: #dadce0;
            box-shadow: 0 2px 6px rgba(60, 64, 67, 0.15);
        }

        .instagram-btn {
            background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
            color: white;
            border: none;
        }

        .instagram-btn:hover {
            background: linear-gradient(45deg, #e0852e, #dc5f34, #d5223d, #c4205e, #b0167a);
            box-shadow: 0 4px 12px rgba(220, 39, 67, 0.3);
        }

        .social-icon {
            margin-right: 0.75rem;
            font-size: 1.25rem;
        }

        .google-icon {
            color: #f83939;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Login Form Only - No Card Design -->
    <div class="login-container px-4">
        <!-- Logo and Title -->
        <div class="text-center mb-8">
            <div class="flex justify-center items-center mb-4">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-store text-green-600 text-2xl"></i>
                </div>
            </div>
            <span class="text-2xl font-bold text-green-600 ml-3 my-2">Buyo</span>
            <h1 class="text-2xl font-bold text-gray-800">Welcome Back</h1>
            <p class="text-gray-600 mt-2">Sign in to your BidhaaHub account</p>
        </div>

        <!-- Login Form -->
        <form class="space-y-4" action="{{ route('login') }}" method="POST">
            @csrf
            <div>
                <label for="login" class="block text-sm font-medium text-gray-700 mb-1">Email or Phone</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <input id="login" name="login" type="text" required
                           class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition"
                           placeholder="your@email.com or +255712345678">
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center mb-1">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <a href="#" onclick="openModal('forgot-password-modal')" class="text-sm text-green-600 hover:text-green-700 focus:outline-none">
                        Forgot password?
                    </a>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input id="password" name="password" type="password" required
                           class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition"
                           placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox"
                           class="h-4 w-4 text-green-600 focus:ring-green-600 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-900">Remember me</label>
                </div>
            </div>

            <button type="submit" class="btn-primary w-full text-white py-3 rounded-lg font-medium mt-4">
                <i class="fas fa-sign-in-alt mr-2"></i> Sign In
            </button>

            <div class="flex items-center my-6">
                <div class="flex-1 border-t border-gray-200"></div>
                <span class="px-3 text-gray-500 text-sm">OR</span>
                <div class="flex-1 border-t border-gray-200"></div>
            </div>

            <div class="space-y-3">
                <a href="#" class="social-btn google-btn">
                    <i class="fab fa-google social-icon google-icon"></i>
                    <span>Continue with Google</span>
                </a>
                <a href="#" class="social-btn instagram-btn">
                    <i class="fab fa-instagram social-icon"></i>
                    <span>Continue with Instagram</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Forgot Password Modal -->
    <div id="forgot-password-modal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 opacity-0 invisible">
        <div class="modal-content bg-white rounded-xl max-w-md w-full p-6 relative">
            <button onclick="closeModal('forgot-password-modal')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-key text-green-600 text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Reset Password</h2>
                <p class="text-gray-600 mt-2">Enter your email to receive a password reset link</p>
            </div>
            <form class="space-y-4" action="" method="POST">
                @csrf
                <div>
                    <label for="reset-email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" id="reset-email" name="email"
                           class="input-focus w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none transition"
                           placeholder="your@email.com" required>
                </div>
                <button type="submit" class="btn-primary w-full text-white py-3 rounded-lg font-medium">
                    <i class="fas fa-paper-plane mr-2"></i> Send Reset Link
                </button>
            </form>
            <div class="mt-4 text-center text-sm text-gray-500">
                Remember your password?
                <a href="#" class="text-green-600 hover:text-green-700 focus:outline-none">
                    Sign in
                </a>
            </div>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        window.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                closeModal(event.target.id);
            }
        });
    </script>
</body>
</html>