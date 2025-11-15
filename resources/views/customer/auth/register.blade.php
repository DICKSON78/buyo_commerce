<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Buyo</title>
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

        .dark .text-gray-500 {
            color: #9ca3af;
        }

        .dark .border-gray-300 {
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
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-300">
    <div class="register-container px-4">
        <!-- Logo and Title -->
        <div class="text-center mb-8">
            <div class="flex justify-center items-center mb-4">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                    <i class="fas fa-store text-green-600 dark:text-green-400 text-2xl"></i>
                </div>
            </div>
            <span class="text-2xl font-bold text-green-600 dark:text-green-400 ml-3 my-2">Buyo</span>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Join Buyo</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Start shopping today</p>
        </div>

        <!-- Account Form -->
        <div>
        <form class="space-y-4" action="{{ route('register.customer') }}" method="POST">
            @csrf
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Username</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <input type="text" id="username" name="username" required
                        class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none transition bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                        placeholder="Your username" value="{{ old('username') }}">
                </div>
            </div>
            <div>
                <label for="customer-password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input type="password" id="customer-password" name="password" required
                        class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none transition bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                        placeholder="••••••••">
                </div>
            </div>
            <div>
                <label for="confirmPassword" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input type="password" id="confirmPassword" name="password_confirmation" required
                        class="pl-10 input-focus w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none transition bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200"
                        placeholder="••••••••">
                </div>
            </div>
            <div class="flex items-center justify-center">
                <div class="flex items-center h-5">
                    <input id="terms" name="terms" type="checkbox" required
                        class="focus:ring-green-600 dark:focus:ring-green-400 h-4 w-4 text-green-600 dark:text-green-400 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-800">
                </div>
                <div class="ml-3 text-sm">
                    <label for="terms" class="text-gray-700 dark:text-gray-300">
                        I agree to the <a href="#" class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300">Terms</a> and <a href="#" class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300">Privacy</a>
                    </label>
                </div>
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

            <div class="mt-6">
                <button type="submit" class="btn-primary text-white w-full px-6 py-3 rounded-lg font-medium">
                    <i class="fas fa-user-plus mr-2"></i> Get Started
                </button>
            </div>
        </form>
        </div>

            <div class="flex items-center justify-center my-6">
              <h2 class="text-gray-500 dark:text-gray-400">Already have account ? <a href="{{ route('login.customer') }}"><span class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300">SignIn here </span></a></h2>
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

        function registerAsCustomer() {
            // Validate all customer form fields
            const requiredFields = [
                'username', 'customer-password', 'confirmPassword'
            ];

            for (let field of requiredFields) {
                if (!document.getElementById(field).value) {
                    alert('Please fill in all fields');
                    return;
                }
            }

            if (!document.getElementById('terms').checked) {
                alert('Please agree to the Terms and Privacy Policy');
                return;
            }

            // Simulate registration
            alert('Welcome to Buyo! Account created successfully');
            window.location.href = '{{ route("login.customer") }}';
        }
    </script>
</body>
</html>