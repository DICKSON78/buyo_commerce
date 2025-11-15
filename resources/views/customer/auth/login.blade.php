<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Buyo</title>
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

        .dark .text-gray-900 {
            color: #f9fafb;
        }

        .dark .text-gray-500 {
            color: #9ca3af;
        }

        .dark .border-gray-300 {
            border-color: #374151;
        }

        .dark .border-gray-200 {
            border-color: #374151;
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

        /* Modal Styles */
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

        .dark .modal-content {
            background: #1f2937;
        }

        .dark .text-gray-800 {
            color: #f9fafb;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-300">
    <!-- Login Form Only - No Card Design -->
    <div class="login-container px-4">
        <!-- Logo and Title -->
        <div class="text-center mb-8">
            <div class="flex justify-center items-center mb-4">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                    <i class="fas fa-store text-green-600 dark:text-green-400 text-2xl"></i>
                </div>
            </div>
            <span class="text-2xl font-bold text-green-600 dark:text-green-400 ml-3 my-2">Buyo</span>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Welcome Back</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Sign in to your Buyo account</p>
        </div>

        <!-- Display Errors -->
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

        <!-- Login Form -->
        <form class="space-y-4" action="{{ route('customer.authenticate') }}" method="POST">
            @csrf
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email, Phone or Username</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <input id="username" name="username" type="text" value="{{ old('username') }}" required
                           class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none transition bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                           placeholder="your@email.com, +255712345678, or username">
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center mb-1">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                    <a href="#" onclick="openModal('forgot-password-modal')" class="text-sm text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 focus:outline-none">
                        Forgot password?
                    </a>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input id="password" name="password" type="password" required
                           class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none transition bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                           placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox"
                           class="h-4 w-4 text-green-600 dark:text-green-400 focus:ring-green-600 dark:focus:ring-green-400 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-800">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Remember me</label>
                </div>
            </div>

            <button type="submit" class="btn-primary w-full text-white py-3 rounded-lg font-medium mt-4">
                <i class="fas fa-sign-in-alt mr-2"></i> Sign In
            </button>
        </form>

        <!-- Sign Up Link -->
        <div class="flex items-center justify-center my-6">
            <h2 class="text-gray-500 dark:text-gray-400">Don't have an account ?
                <a href="{{ route('register.customer') }}" class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 font-medium">Sign up here</a>
            </h2>
        </div>

    </div>

    <!-- Forgot Password Modal -->
    <div id="forgot-password-modal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 opacity-0 invisible">
        <div class="modal-content bg-white dark:bg-gray-800 rounded-xl max-w-md w-full p-6 relative">
            <button onclick="closeModal('forgot-password-modal')" class="absolute top-4 right-4 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                <i class="fas fa-times"></i>
            </button>
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-key text-green-600 dark:text-green-400 text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Reset Password</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Enter your email to receive a password reset link</p>
            </div>
            <form class="space-y-4" action="{{ route('customer.password.email') }}" method="POST">
                @csrf
                <div>
                    <label for="reset-email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
                    <input type="email" id="reset-email" name="email"
                           class="input-focus w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none transition bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                           placeholder="your@email.com" required>
                </div>
                <button type="submit" class="btn-primary w-full text-white py-3 rounded-lg font-medium">
                    <i class="fas fa-paper-plane mr-2"></i> Send Reset Link
                </button>
            </form>
            <div class="mt-4 text-center text-sm text-gray-500 dark:text-gray-400">
                Remember your password?
                <a href="#" onclick="closeModal('forgot-password-modal')" class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 focus:outline-none">
                    Sign in
                </a>
            </div>
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

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modals = document.querySelectorAll('.modal.active');
                modals.forEach(modal => {
                    closeModal(modal.id);
                });
            }
        });

        // Auto-focus on login input
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('login').focus();
        });
    </script>
</body>
</html>
