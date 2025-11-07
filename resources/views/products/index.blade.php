<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyo - Shop Local</title>
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
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .snap-x {
            scroll-snap-type: x mandatory;
        }
        .snap-center {
            scroll-snap-align: center;
        }
        .carousel-container {
            scroll-behavior: smooth;
        }
        .nav-green {
            background: #008000;
        }
        .dark .nav-green {
            background: #0a5c0a;
        }

        /* Product Green */
        .product-green { background: #008000; color: white; }
        .dark .product-green { background: #0a5c0a; }
        .product-green-light { background: #e6f4ea; }
        .dark .product-green-light { background: #1a3a2a; }
        .product-green-border { border-color: #008000; }
        .dark .product-green-border { border-color: #0a5c0a; }
        .product-green-text { color: #008000; }
        .dark .product-green-text { color: #4CAF50; }

        /* Categories Colors */
        .tech-color { background: #008000; color: white; }
        .dark .tech-color { background: #0a5c0a; }
        .fashion-color { background: #8B008B; color: white; }
        .dark .fashion-color { background: #6a006a; }
        .book-color { background: #FFD700; color: #1a1a1a; }
        .dark .book-color { background: #d4af37; }
        .car-color { background: #DC143C; color: white; }
        .dark .car-color { background: #b01030; }
        .home-color { background: #FF8C00; color: white; }
        .dark .home-color { background: #cc7000; }
        .ticket-color { background: #4B0082; color: white; }
        .dark .ticket-color { background: #3a0064; }
        .cake-color { background: #FF69B4; color: white; }
        .dark .cake-color { background: #d4589a; }
        .electronics-color { background: #1E90FF; color: white; }
        .dark .electronics-color { background: #1870cc; }

        .tech-light { background: #e6f4ea; }
        .dark .tech-light { background: #1a3a2a; }
        .fashion-light { background: #f3e6f5; }
        .dark .fashion-light { background: #2a1a3a; }
        .book-light { background: #fff9e6; }
        .dark .book-light { background: #3a2a1a; }
        .car-light { background: #ffe6e6; }
        .dark .car-light { background: #3a1a1a; }
        .home-light { background: #fff0e6; }
        .dark .home-light { background: #3a2a1a; }
        .ticket-light { background: #e6e6fa; }
        .dark .ticket-light { background: #2a1a3a; }
        .cake-light { background: #ffe6f2; }
        .dark .cake-light { background: #3a1a2a; }
        .electronics-light { background: #e6f2ff; }
        .dark .electronics-light { background: #1a2a3a; }

        .tech-border { border-color: #008000; }
        .dark .tech-border { border-color: #0a5c0a; }
        .fashion-border { border-color: #8B008B; }
        .dark .fashion-border { border-color: #6a006a; }
        .book-border { border-color: #FFD700; }
        .dark .book-border { border-color: #d4af37; }
        .car-border { border-color: #DC143C; }
        .dark .car-border { border-color: #b01030; }
        .home-border { border-color: #FF8C00; }
        .dark .home-border { border-color: #cc7000; }
        .ticket-border { border-color: #4B0082; }
        .dark .ticket-border { border-color: #3a0064; }
        .cake-border { border-color: #FF69B4; }
        .dark .cake-border { border-color: #d4589a; }
        .electronics-border { border-color: #1E90FF; }
        .dark .electronics-border { border-color: #1870cc; }

        .tech-text { color: #008000; }
        .dark .tech-text { color: #4CAF50; }
        .fashion-text { color: #8B008B; }
        .dark .fashion-text { color: #b366b3; }
        .book-text { color: #FFD700; }
        .dark .book-text { color: #ffeb3b; }
        .car-text { color: #DC143C; }
        .dark .car-text { color: #ff5252; }
        .home-text { color: #FF8C00; }
        .dark .home-text { color: #ffa726; }
        .ticket-text { color: #4B0082; }
        .dark .ticket-text { color: #7c43bd; }
        .cake-text { color: #FF69B4; }
        .dark .cake-text { color: #ff85c0; }
        .electronics-text { color: #1E90FF; }
        .dark .electronics-text { color: #64b5f6; }

        /* Sidebar Width */
        .sidebar-wide {
            width: 20rem;
        }

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
                        <span class="text-white font-bold text-xl">Buyo</span>
                    </div>
                    <div class="sm:hidden w-10 h-10 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center">
                        <i class="fas fa-store text-green-600 dark:text-green-400 text-lg"></i>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 max-w-xl mx-2 sm:mx-4">
                    <form class="relative">
                        <input type="text" placeholder="Search products..."
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

                    <!-- Language -->
                    <button onclick="openLanguageModal()" class="text-white hover:text-yellow-300 transition-colors" title="Language">
                        <i class="fas fa-globe text-lg"></i>
                    </button>

                    <!-- User Account Dropdown -->
                    <div class="dropdown" id="accountDropdown">
                        <button onclick="toggleDropdown()" class="text-white hover:text-yellow-300 transition-colors relative" title="Account">
                            <i class="fas fa-user text-lg"></i>
                            <span class="absolute -top-2 -right-2 bg-yellow-500 text-gray-900 dark:text-gray-100 text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">J</span>
                        </button>
                        <div class="dropdown-content">
                            <a href="#"><i class="fas fa-user-circle"></i> View Profile</a>
                            <a href="#"><i class="fas fa-cog"></i> Settings</a>
                            <a href="#" class="text-red-600 dark:text-red-400"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </div>

                    <!-- Cart -->
                    <button onclick="openCartModal()" class="text-white hover:text-yellow-300 transition-colors relative" title="Cart">
                        <i class="fas fa-shopping-cart text-lg"></i>
                        <span class="absolute -top-2 -right-2 bg-yellow-500 text-gray-900 dark:text-gray-100 text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">3</span>
                    </button>

                    <!-- Sell -->
                    <a href="sell.html" class="bg-yellow-500 dark:bg-yellow-600 text-gray-900 dark:text-gray-100 p-2 sm:px-4 sm:py-2 rounded-lg font-semibold hover:bg-yellow-400 dark:hover:bg-yellow-500 transition-colors flex items-center space-x-1 sm:space-x-2">
                        <i class="fas fa-plus text-sm sm:text-base"></i>
                        <span class="hidden sm:block">Sell</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Language Modal -->
    <div id="languageModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 max-w-sm w-full mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100">Select Language</h3>
                <button onclick="closeLanguageModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="space-y-3">
                <button class="w-full bg-green-600 dark:bg-green-700 text-white py-3 rounded-lg font-semibold transition-colors flex items-center justify-center space-x-2">
                    <i class="fas fa-check"></i>
                    <span>English</span>
                </button>
                <button class="w-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 py-3 rounded-lg font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors flex items-center justify-center space-x-2">
                    <span>Kiswahili</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Cart Modal -->
    <div id="cartModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 max-w-md w-full mx-4 max-h-96 overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100">Your Cart (3 items)</h3>
                <button onclick="closeCartModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="space-y-4 mb-4">
                <div class="flex items-center space-x-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=100" alt="iPhone" class="w-12 h-12 object-cover rounded-lg">
                    <div class="flex-1">
                        <p class="font-medium text-gray-800 dark:text-gray-100 text-sm">iPhone 13 Pro 256GB</p>
                        <p class="text-green-600 dark:text-green-400 font-semibold">TZS 2,500,000</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button class="w-6 h-6 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-minus text-xs"></i>
                        </button>
                        <span class="text-sm font-medium">1</span>
                        <button class="w-6 h-6 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-plus text-xs"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center space-x-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=100" alt="Shoes" class="w-12 h-12 object-cover rounded-lg">
                    <div class="flex-1">
                        <p class="font-medium text-gray-800 dark:text-gray-100 text-sm">Running Shoes</p>
                        <p class="text-green-600 dark:text-green-400 font-semibold">TZS 120,000</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button class="w-6 h-6 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-minus text-xs"></i>
                        </button>
                        <span class="text-sm font-medium">1</span>
                        <button class="w-6 h-6 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-plus text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mb-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                    <span class="font-semibold">TZS 2,620,000</span>
                </div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-600 dark:text-gray-400">Shipping:</span>
                    <span class="font-semibold">TZS 15,000</span>
                </div>
                <div class="flex justify-between items-center text-lg font-bold">
                    <span>Total:</span>
                    <span class="text-green-600 dark:text-green-400">TZS 2,635,000</span>
                </div>
            </div>

            <button onclick="proceedToCheckout()" class="w-full bg-green-600 dark:bg-green-700 hover:bg-green-700 dark:hover:bg-green-800 text-white py-3 rounded-lg font-semibold transition-colors duration-300 flex items-center justify-center space-x-2">
                <i class="fas fa-lock"></i>
                <span>Proceed to Checkout</span>
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-2 sm:px-4 pt-20">
        <!-- Mobile Categories Bar -->
        <div class="lg:hidden bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-3 mb-4">
            <div class="flex space-x-4 overflow-x-auto pb-1 scrollbar-hide">
                <div class="flex flex-col items-center cursor-pointer group flex-shrink-0">
                    <div class="relative">
                        <div class="w-14 h-14 rounded-full p-0.5 tech-color">
                            <div class="w-full h-full bg-white dark:bg-gray-800 rounded-full flex items-center justify-center p-1">
                                <div class="w-full h-full tech-light rounded-full flex items-center justify-center">
                                    <i class="fas fa-mobile-alt tech-text text-sm"></i>
                                </div>
                            </div>
                        </div>
                        <div class="absolute -top-1 -right-1 bg-yellow-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-bold border-2 border-white dark:border-gray-800 shadow-sm">
                            5
                        </div>
                    </div>
                    <span class="text-xs font-medium text-gray-700 dark:text-gray-300 mt-1 truncate max-w-14 text-center">
                        Tech Store
                    </span>
                </div>
                <div class="flex flex-col items-center cursor-pointer group flex-shrink-0">
                    <div class="relative">
                        <div class="w-14 h-14 rounded-full p-0.5 fashion-color">
                            <div class="w-full h-full bg-white dark:bg-gray-800 rounded-full flex items-center justify-center p-1">
                                <div class="w-full h-full fashion-light rounded-full flex items-center justify-center">
                                    <i class="fas fa-tshirt fashion-text text-sm"></i>
                                </div>
                            </div>
                        </div>
                        <div class="absolute -top-1 -right-1 bg-yellow-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-bold border-2 border-white dark:border-gray-800 shadow-sm">
                            8
                        </div>
                    </div>
                    <span class="text-xs font-medium text-gray-700 dark:text-gray-300 mt-1 truncate max-w-14 text-center">
                        Fashion Hub
                    </span>
                </div>
                <div class="flex flex-col items-center cursor-pointer group flex-shrink-0">
                    <div class="relative">
                        <div class="w-14 h-14 rounded-full p-0.5 book-color">
                            <div class="w-full h-full bg-white dark:bg-gray-800 rounded-full flex items-center justify-center p-1">
                                <div class="w-full h-full book-light rounded-full flex items-center justify-center">
                                    <i class="fas fa-book book-text text-sm"></i>
                                </div>
                            </div>
                        </div>
                        <div class="absolute -top-1 -right-1 bg-yellow-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-bold border-2 border-white dark:border-gray-800 shadow-sm">
                            12
                        </div>
                    </div>
                    <span class="text-xs font-medium text-gray-700 dark:text-gray-300 mt-1 truncate max-w-14 text-center">
                        Book Store
                    </span>
                </div>
                <div class="flex flex-col items-center cursor-pointer group flex-shrink-0">
                    <div class="relative">
                        <div class="w-14 h-14 rounded-full p-0.5 car-color">
                            <div class="w-full h-full bg-white dark:bg-gray-800 rounded-full flex items-center justify-center p-1">
                                <div class="w-full h-full car-light rounded-full flex items-center justify-center">
                                    <i class="fas fa-car car-text text-sm"></i>
                                </div>
                            </div>
                        </div>
                        <div class="absolute -top-1 -right-1 bg-yellow-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-bold border-2 border-white dark:border-gray-800 shadow-sm">
                            2
                        </div>
                    </div>
                    <span class="text-xs font-medium text-gray-700 dark:text-gray-300 mt-1 truncate max-w-14 text-center">
                        Auto Deals
                    </span>
                </div>
                <div class="flex flex-col items-center cursor-pointer group flex-shrink-0">
                    <div class="relative">
                        <div class="w-14 h-14 rounded-full p-0.5 cake-color">
                            <div class="w-full h-full bg-white dark:bg-gray-800 rounded-full flex items-center justify-center p-1">
                                <div class="w-full h-full cake-light rounded-full flex items-center justify-center">
                                    <i class="fas fa-birthday-cake cake-text text-sm"></i>
                                </div>
                            </div>
                        </div>
                        <div class="absolute -top-1 -right-1 bg-yellow-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-bold border-2 border-white dark:border-gray-800 shadow-sm">
                            7
                        </div>
                    </div>
                    <span class="text-xs font-medium text-gray-700 dark:text-gray-300 mt-1 truncate max-w-14 text-center">
                        Cake Shop
                    </span>
                </div>
            </div>
        </div>

        <div class="flex gap-6 lg:gap-8">
            <!-- Left Sidebar -->
            <div class="sidebar-wide hidden lg:block bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 h-fit sticky top-28">
                <div class="mb-6">
                    <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100 mb-3">Categories</h3>
                    <div class="space-y-1">
                        <div class="flex items-center justify-between p-2 rounded-lg hover:bg-green-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-mobile-alt tech-text text-sm w-4"></i>
                                <span class="text-gray-700 dark:text-gray-300 text-sm">Phones & Tablets</span>
                            </div>
                            <span class="tech-light tech-text text-xs px-1.5 py-0.5 rounded-full">156</span>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-lg hover:bg-green-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-laptop electronics-text text-sm w-4"></i>
                                <span class="text-gray-700 dark:text-gray-300 text-sm">Electronics</span>
                            </div>
                            <span class="electronics-light electronics-text text-xs px-1.5 py-0.5 rounded-full">89</span>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-lg hover:bg-green-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-tshirt fashion-text text-sm w-4"></i>
                                <span class="text-gray-700 dark:text-gray-300 text-sm">Fashion</span>
                            </div>
                            <span class="fashion-light fashion-text text-xs px-1.5 py-0.5 rounded-full">234</span>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-lg hover:bg-green-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-home home-text text-sm w-4"></i>
                                <span class="text-gray-700 dark:text-gray-300 text-sm">Home & Garden</span>
                            </div>
                            <span class="home-light home-text text-xs px-1.5 py-0.5 rounded-full">167</span>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-lg hover:bg-green-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-car car-text text-sm w-4"></i>
                                <span class="text-gray-700 dark:text-gray-300 text-sm">Vehicles</span>
                            </div>
                            <span class="car-light car-text text-xs px-1.5 py-0.5 rounded-full">45</span>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-lg hover:bg-green-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-ticket-alt ticket-text text-sm w-4"></i>
                                <span class="text-gray-700 dark:text-gray-300 text-sm">Event Tickets</span>
                            </div>
                            <span class="ticket-light ticket-text text-xs px-1.5 py-0.5 rounded-full">23</span>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-lg hover:bg-green-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-book book-text text-sm w-4"></i>
                                <span class="text-gray-700 dark:text-gray-300 text-sm">Books & PDFs</span>
                            </div>
                            <span class="book-light book-text text-xs px-1.5 py-0.5 rounded-full">67</span>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded-lg hover:bg-green-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-birthday-cake cake-text text-sm w-4"></i>
                                <span class="text-gray-700 dark:text-gray-300 text-sm">Cakes & Pastries</span>
                            </div>
                            <span class="cake-light cake-text text-xs px-1.5 py-0.5 rounded-full">34</span>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100 mb-3">Recent Sellers</h3>
                    <div class="space-y-2">
                        <div class="flex items-center space-x-2 p-2 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-green-50 dark:hover:bg-gray-600 cursor-pointer transition-colors">
                            <div class="w-8 h-8 tech-color rounded-full flex items-center justify-center text-white font-bold text-xs">TS</div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-800 dark:text-gray-100 text-sm truncate">Tech Store</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Active now</p>
                            </div>
                            <span class="bg-yellow-500 text-white text-xs px-1.5 py-0.5 rounded-full">5</span>
                        </div>
                        <div class="flex items-center space-x-2 p-2 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-green-50 dark:hover:bg-gray-600 cursor-pointer transition-colors">
                            <div class="w-8 h-8 fashion-color rounded-full flex items-center justify-center text-white font-bold text-xs">FH</div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-800 dark:text-gray-100 text-sm truncate">Fashion Hub</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">2 min ago</p>
                            </div>
                            <span class="bg-yellow-500 text-white text-xs px-1.5 py-0.5 rounded-full">8</span>
                        </div>
                        <div class="flex items-center space-x-2 p-2 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-green-50 dark:hover:bg-gray-600 cursor-pointer transition-colors">
                            <div class="w-8 h-8 book-color rounded-full flex items-center justify-center text-gray-900 dark:text-gray-100 font-bold text-xs">BS</div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-800 dark:text-gray-100 text-sm truncate">Book Store</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">5 min ago</p>
                            </div>
                            <span class="bg-yellow-500 text-white text-xs px-1.5 py-0.5 rounded-full">12</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Product Feed -->
            <div class="flex-1 min-w-0">
                <div class="space-y-4 pb-8">
                    <!-- Product 1 -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between p-3 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 product-green rounded-full flex items-center justify-center text-white font-bold text-sm">TS</div>
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-gray-100 text-sm">Tech Store</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Dar es Salaam</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button class="text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="fas fa-shopping-cart text-sm"></i></button>
                                <button class="text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="fas fa-globe text-sm"></i></button>
                                <button class="text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="fas fa-ellipsis-h text-sm"></i></button>
                            </div>
                        </div>

                        <div class="relative">
                            <div class="carousel-container flex overflow-x-auto snap-x snap-mandatory scrollbar-hide" style="height: 400px;">
                                <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=500" alt="iPhone Front" class="w-full h-full object-cover snap-center flex-shrink-0">
                                <img src="https://images.unsplash.com/photo-1565849904461-04a58ad377e0?w=500" alt="iPhone Back" class="w-full h-full object-cover snap-center flex-shrink-0">
                                <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=500" alt="iPhone Box" class="w-full h-full object-cover snap-center flex-shrink-0">
                            </div>
                            <div class="absolute bottom-3 left-1/2 transform -translate-x-1/2 flex space-x-1.5">
                                <div class="w-1.5 h-1.5 bg-white rounded-full opacity-100 indicator"></div>
                                <div class="w-1.5 h-1.5 bg-white rounded-full opacity-50 indicator"></div>
                                <div class="w-1.5 h-1.5 bg-white rounded-full opacity-50 indicator"></div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-3 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center space-x-3">
                                <button class="text-xl text-gray-600 dark:text-gray-400 hover:text-red-500 like-btn"><i class="far fa-heart"></i></button>
                                <button class="text-xl text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="far fa-comment"></i></button>
                                <button class="text-xl text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="far fa-share-square"></i></button>
                            </div>
                            <button class="text-xl text-gray-600 dark:text-gray-400 hover:text-yellow-500"><i class="far fa-bookmark"></i></button>
                        </div>

                        <div class="p-3">
                            <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100 mb-2">iPhone 13 Pro 256GB</h3>
                            <span class="product-green text-white px-3 py-1 rounded-full text-sm font-semibold shadow-sm">TZS 2,500,000</span>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-3 mb-3">Brand new iPhone 13 Pro with 256GB storage. Never used, still in original packaging. Includes warranty and all accessories.</p>
                            <button onclick="addToCart('iPhone 13 Pro 256GB', 2500000)" class="w-full product-green hover:bg-green-700 dark:hover:bg-green-800 text-white py-2.5 rounded-lg font-semibold transition-colors duration-300 flex items-center justify-center space-x-2 text-sm">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Add to Cart</span>
                            </button>
                            <div class="mt-3 space-y-2">
                                <div class="flex items-start space-x-2">
                                    <div class="w-6 h-6 product-green-light rounded-full flex-shrink-0 mt-0.5 flex items-center justify-center">
                                        <span class="product-green-text text-xs font-bold">J</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs"><span class="font-semibold product-green-text">john_doe</span> This looks amazing! Is it still available?</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">1h ago</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2 mt-2">
                                    <input type="text" placeholder="Add a comment..." class="flex-1 border product-green-border rounded-full px-3 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-green-500 product-green-light dark:bg-gray-700">
                                    <button class="product-green-text font-semibold text-xs">Post</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product 2 -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between p-3 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 product-green rounded-full flex items-center justify-center text-white font-bold text-sm">BS</div>
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-gray-100 text-sm">Book Store</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Online</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button class="text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="fas fa-shopping-cart text-sm"></i></button>
                                <button class="text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="fas fa-globe text-sm"></i></button>
                                <button class="text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="fas fa-ellipsis-h text-sm"></i></button>
                            </div>
                        </div>

                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=500" alt="Business Book" class="w-full h-80 object-cover">
                            <div class="absolute top-3 right-3 product-green text-white px-2 py-1 rounded-lg text-xs font-semibold">PDF Download</div>
                        </div>

                        <div class="flex items-center justify-between p-3 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center space-x-3">
                                <button class="text-xl text-gray-600 dark:text-gray-400 hover:text-red-500 like-btn"><i class="far fa-heart"></i></button>
                                <button class="text-xl text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="far fa-comment"></i></button>
                                <button class="text-xl text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="far fa-share-square"></i></button>
                            </div>
                            <button class="text-xl text-gray-600 dark:text-gray-400 hover:text-yellow-500"><i class="far fa-bookmark"></i></button>
                        </div>

                        <div class="p-3">
                            <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100 mb-2">Business Strategy Guide - PDF</h3>
                            <span class="product-green text-white px-3 py-1 rounded-full text-sm font-semibold shadow-sm">TZS 15,000</span>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-3 mb-3">Complete guide to business strategy and entrepreneurship. 200+ pages of valuable insights, case studies, and practical advice.</p>
                            <button onclick="addToCart('Business Strategy Guide - PDF', 15000)" class="w-full product-green hover:bg-green-700 dark:hover:bg-green-800 text-white py-2.5 rounded-lg font-semibold transition-colors duration-300 flex items-center justify-center space-x-2 text-sm">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Add to Cart</span>
                            </button>
                            <div class="mt-3 space-y-2">
                                <div class="flex items-start space-x-2">
                                    <div class="w-6 h-6 product-green-light rounded-full flex-shrink-0 mt-0.5 flex items-center justify-center">
                                        <span class="product-green-text text-xs font-bold">E</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs"><span class="font-semibold product-green-text">entrepreneur_tz</span> This book changed my business perspective!</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">3h ago</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2 mt-2">
                                    <input type="text" placeholder="Add a comment..." class="flex-1 border product-green-border rounded-full px-3 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-green-500 product-green-light dark:bg-gray-700">
                                    <button class="product-green-text font-semibold text-xs">Post</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product 3 -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between p-3 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 product-green rounded-full flex items-center justify-center text-white font-bold text-sm">FH</div>
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-gray-100 text-sm">Fashion Hub</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Arusha</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button class="text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="fas fa-shopping-cart text-sm"></i></button>
                                <button class="text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="fas fa-globe text-sm"></i></button>
                                <button class="text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="fas fa-ellipsis-h text-sm"></i></button>
                            </div>
                        </div>

                        <div class="relative">
                            <div class="carousel-container flex overflow-x-auto snap-x snap-mandatory scrollbar-hide" style="height: 400px;">
                                <img src="https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=500" alt="Dress Front" class="w-full h-full object-cover snap-center flex-shrink-0">
                                <img src="https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?w=500" alt="Dress Back" class="w-full h-full object-cover snap-center flex-shrink-0">
                            </div>
                            <div class="absolute bottom-3 left-1/2 transform -translate-x-1/2 flex space-x-1.5">
                                <div class="w-1.5 h-1.5 bg-white rounded-full opacity-100 indicator"></div>
                                <div class="w-1.5 h-1.5 bg-white rounded-full opacity-50 indicator"></div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-3 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center space-x-3">
                                <button class="text-xl text-gray-600 dark:text-gray-400 hover:text-red-500 like-btn"><i class="far fa-heart"></i></button>
                                <button class="text-xl text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="far fa-comment"></i></button>
                                <button class="text-xl text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="far fa-share-square"></i></button>
                            </div>
                            <button class="text-xl text-gray-600 dark:text-gray-400 hover:text-yellow-500"><i class="far fa-bookmark"></i></button>
                        </div>

                        <div class="p-3">
                            <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100 mb-2">African Print Dress - Size M</h3>
                            <span class="product-green text-white px-3 py-1 rounded-full text-sm font-semibold shadow-sm">TZS 85,000</span>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-3 mb-3">Beautiful African print dress made from high-quality fabric. Perfect for special occasions.</p>
                            <button onclick="addToCart('African Print Dress - Size M', 85000)" class="w-full product-green hover:bg-green-700 dark:hover:bg-green-800 text-white py-2.5 rounded-lg font-semibold transition-colors duration-300 flex items-center justify-center space-x-2 text-sm">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Add to Cart</span>
                            </button>
                            <div class="mt-3 space-y-2">
                                <div class="flex items-start space-x-2">
                                    <div class="w-6 h-6 product-green-light rounded-full flex-shrink-0 mt-0.5 flex items-center justify-center">
                                        <span class="product-green-text text-xs font-bold">F</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs"><span class="font-semibold product-green-text">fashion_guru</span> Love the pattern!</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">30m ago</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2 mt-2">
                                    <input type="text" placeholder="Add a comment..." class="flex-1 border product-green-border rounded-full px-3 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-green-500 product-green-light dark:bg-gray-700">
                                    <button class="product-green-text font-semibold text-xs">Post</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product 4 -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between p-3 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 product-green rounded-full flex items-center justify-center text-white font-bold text-sm">AD</div>
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-gray-100 text-sm">Auto Deals</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Dar es Salaam</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button class="text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="fas fa-shopping-cart text-sm"></i></button>
                                <button class="text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="fas fa-globe text-sm"></i></button>
                                <button class="text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="fas fa-ellipsis-h text-sm"></i></button>
                            </div>
                        </div>

                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=500" alt="Toyota RAV4" class="w-full h-80 object-cover">
                            <div class="absolute top-3 right-3 product-green text-white px-2 py-1 rounded-lg text-xs font-semibold">2023 Model</div>
                        </div>

                        <div class="flex items-center justify-between p-3 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center space-x-3">
                                <button class="text-xl text-gray-600 dark:text-gray-400 hover:text-red-500 like-btn"><i class="far fa-heart"></i></button>
                                <button class="text-xl text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="far fa-comment"></i></button>
                                <button class="text-xl text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="far fa-share-square"></i></button>
                            </div>
                            <button class="text-xl text-gray-600 dark:text-gray-400 hover:text-yellow-500"><i class="far fa-bookmark"></i></button>
                        </div>

                        <div class="p-3">
                            <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100 mb-2">Toyota RAV4 2023</h3>
                            <span class="product-green text-white px-3 py-1 rounded-full text-sm font-semibold shadow-sm">TZS 45,000,000</span>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-3 mb-3">Brand new Toyota RAV4 2023 model. 1500cc engine, automatic transmission.</p>
                            <button onclick="addToCart('Toyota RAV4 2023', 45000000)" class="w-full product-green hover:bg-green-700 dark:hover:bg-green-800 text-white py-2.5 rounded-lg font-semibold transition-colors duration-300 flex items-center justify-center space-x-2 text-sm">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Add to Cart</span>
                            </button>
                            <div class="mt-3 space-y-2">
                                <div class="flex items-start space-x-2">
                                    <div class="w-6 h-6 product-green-light rounded-full flex-shrink-0 mt-0.5 flex items-center justify-center">
                                        <span class="product-green-text text-xs font-bold">C</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs"><span class="font-semibold product-green-text">car_lover</span> Is financing available?</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">2h ago</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2 mt-2">
                                    <input type="text" placeholder="Add a comment..." class="flex-1 border product-green-border rounded-full px-3 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-green-500 product-green-light dark:bg-gray-700">
                                    <button class="product-green-text font-semibold text-xs">Post</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product 5 -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between p-3 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 product-green rounded-full flex items-center justify-center text-white font-bold text-sm">CS</div>
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-gray-100 text-sm">Cake Shop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Mwanza</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button class="text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="fas fa-shopping-cart text-sm"></i></button>
                                <button class="text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="fas fa-globe text-sm"></i></button>
                                <button class="text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="fas fa-ellipsis-h text-sm"></i></button>
                            </div>
                        </div>

                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=500" alt="Birthday Cake" class="w-full h-80 object-cover">
                            <div class="absolute top-3 right-3 product-green text-white px-2 py-1 rounded-lg text-xs font-semibold">Custom Order</div>
                        </div>

                        <div class="flex items-center justify-between p-3 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center space-x-3">
                                <button class="text-xl text-gray-600 dark:text-gray-400 hover:text-red-500 like-btn"><i class="far fa-heart"></i></button>
                                <button class="text-xl text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="far fa-comment"></i></button>
                                <button class="text-xl text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="far fa-share-square"></i></button>
                            </div>
                            <button class="text-xl text-gray-600 dark:text-gray-400 hover:text-yellow-500"><i class="far fa-bookmark"></i></button>
                        </div>

                        <div class="p-3">
                            <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100 mb-2">Custom Birthday Cake - 2kg</h3>
                            <span class="product-green text-white px-3 py-1 rounded-full text-sm font-semibold shadow-sm">TZS 45,000</span>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-3 mb-3">Beautiful custom birthday cake with buttercream frosting. 2kg size.</p>
                            <button onclick="addToCart('Custom Birthday Cake - 2kg', 45000)" class="w-full product-green hover:bg-green-700 dark:hover:bg-green-800 text-white py-2.5 rounded-lg font-semibold transition-colors duration-300 flex items-center justify-center space-x-2 text-sm">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Add to Cart</span>
                            </button>
                            <div class="mt-3 space-y-2">
                                <div class="flex items-start space-x-2">
                                    <div class="w-6 h-6 product-green-light rounded-full flex-shrink-0 mt-0.5 flex items-center justify-center">
                                        <span class="product-green-text text-xs font-bold">B</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs"><span class="font-semibold product-green-text">birthday_planner</span> Can I customize the message?</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">1h ago</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2 mt-2">
                                    <input type="text" placeholder="Add a comment..." class="flex-1 border product-green-border rounded-full px-3 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-green-500 product-green-light dark:bg-gray-700">
                                    <button class="product-green-text font-semibold text-xs">Post</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product 6 -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between p-3 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 product-green rounded-full flex items-center justify-center text-white font-bold text-sm">ES</div>
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-gray-100 text-sm">Electro Store</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Dodoma</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button class="text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="fas fa-shopping-cart text-sm"></i></button>
                                <button class="text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="fas fa-globe text-sm"></i></button>
                                <button class="text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="fas fa-ellipsis-h text-sm"></i></button>
                            </div>
                        </div>

                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500" alt="Headphones" class="w-full h-80 object-cover">
                            <div class="absolute top-3 right-3 product-green text-white px-2 py-1 rounded-lg text-xs font-semibold">Noise Cancelling</div>
                        </div>

                        <div class="flex items-center justify-between p-3 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center space-x-3">
                                <button class="text-xl text-gray-600 dark:text-gray-400 hover:text-red-500 like-btn"><i class="far fa-heart"></i></button>
                                <button class="text-xl text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="far fa-comment"></i></button>
                                <button class="text-xl text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400"><i class="far fa-share-square"></i></button>
                            </div>
                            <button class="text-xl text-gray-600 dark:text-gray-400 hover:text-yellow-500"><i class="far fa-bookmark"></i></button>
                        </div>

                        <div class="p-3">
                            <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100 mb-2">Wireless Headphones Pro</h3>
                            <span class="product-green text-white px-3 py-1 rounded-full text-sm font-semibold shadow-sm">TZS 120,000</span>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-3 mb-3">Premium wireless headphones with active noise cancellation. 30-hour battery life.</p>
                            <button onclick="addToCart('Wireless Headphones Pro', 120000)" class="w-full product-green hover:bg-green-700 dark:hover:bg-green-800 text-white py-2.5 rounded-lg font-semibold transition-colors duration-300 flex items-center justify-center space-x-2 text-sm">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Add to Cart</span>
                            </button>
                            <div class="mt-3 space-y-2">
                                <div class="flex items-start space-x-2">
                                    <div class="w-6 h-6 product-green-light rounded-full flex-shrink-0 mt-0.5 flex items-center justify-center">
                                        <span class="product-green-text text-xs font-bold">M</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs"><span class="font-semibold product-green-text">music_lover</span> How's the sound quality?</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">45m ago</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2 mt-2">
                                    <input type="text" placeholder="Add a comment..." class="flex-1 border product-green-border rounded-full px-3 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-green-500 product-green-light dark:bg-gray-700">
                                    <button class="product-green-text font-semibold text-xs">Post</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="sidebar-wide hidden lg:block bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 h-fit sticky top-28">
                <div class="mb-6">
                    <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100 mb-3">Trending Now</h3>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3 p-2 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-green-50 dark:hover:bg-gray-600 cursor-pointer transition-colors">
                            <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=100" alt="Headphones" class="w-12 h-12 object-cover rounded-lg">
                            <div class="flex-1">
                                <p class="font-medium text-gray-800 dark:text-gray-100 text-sm">Wireless Headphones Pro</p>
                                <p class="text-green-600 dark:text-green-400 font-semibold text-xs">TZS 120,000</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 p-2 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-green-50 dark:hover:bg-gray-600 cursor-pointer transition-colors">
                            <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=100" alt="Book" class="w-12 h-12 object-cover rounded-lg">
                            <div class="flex-1">
                                <p class="font-medium text-gray-800 dark:text-gray-100 text-sm">Business Strategy Guide</p>
                                <p class="text-green-600 dark:text-green-400 font-semibold text-xs">TZS 15,000</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 p-2 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-green-50 dark:hover:bg-gray-600 cursor-pointer transition-colors">
                            <img src="https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=100" alt="Dress" class="w-12 h-12 object-cover rounded-lg">
                            <div class="flex-1">
                                <p class="font-medium text-gray-800 dark:text-gray-100 text-sm">African Print Dress</p>
                                <p class="text-green-600 dark:text-green-400 font-semibold text-xs">TZS 85,000</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 p-2 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-green-50 dark:hover:bg-gray-600 cursor-pointer transition-colors">
                            <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=100" alt="Car" class="w-12 h-12 object-cover rounded-lg">
                            <div class="flex-1">
                                <p class="font-medium text-gray-800 dark:text-gray-100 text-sm">Toyota RAV4 2023</p>
                                <p class="text-green-600 dark:text-green-400 font-semibold text-xs">TZS 45M</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 p-2 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-green-50 dark:hover:bg-gray-600 cursor-pointer transition-colors">
                            <img src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=100" alt="Cake" class="w-12 h-12 object-cover rounded-lg">
                            <div class="flex-1">
                                <p class="font-medium text-gray-800 dark:text-gray-100 text-sm">Custom Birthday Cake</p>
                                <p class="text-green-600 dark:text-green-400 font-semibold text-xs">TZS 45,000</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white p-5 rounded-xl text-center shadow-md mb-6">
                    <h4 class="font-bold text-lg mb-2">Special Offer!</h4>
                    <p class="text-sm mb-3">Get 20% OFF on all Electronics this week!</p>
                    <button class="bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold text-sm hover:bg-gray-100 transition">
                        Shop Now
                    </button>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100">Your Cart</h3>
                        <span class="bg-green-600 text-white text-xs px-2 py-1 rounded-full cart-count">3 items</span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-3 cart-total">Total: TZS 2,635,000</p>
                    <button onclick="openCartModal()" class="w-full bg-green-600 dark:bg-green-700 hover:bg-green-700 dark:hover:bg-green-800 text-white py-2.5 rounded-lg font-semibold transition-colors duration-300 text-sm">
                        View Cart
                    </button>
                </div>
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

        // === CART ===
        let cartItems = [
            { name: 'iPhone 13 Pro 256GB', price: 2500000, quantity: 1 },
            { name: 'Running Shoes', price: 120000, quantity: 1 }
        ];

        function updateCartDisplay() {
            const totalItems = cartItems.reduce((sum, item) => sum + item.quantity, 0);
            const totalAmount = cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0) + 15000;
            document.querySelectorAll('.cart-count').forEach(el => el.textContent = `${totalItems} items`);
            document.querySelector('.cart-total').textContent = `Total: TZS ${totalAmount.toLocaleString()}`;
        }

        function addToCart(name, price) {
            const item = cartItems.find(i => i.name === name);
            if (item) item.quantity++;
            else cartItems.push({ name, price, quantity: 1 });
            updateCartDisplay();
            openCartModal();
            alert(`${name} added to cart!`);
        }

        // === MODALS ===
        function openLanguageModal() { document.getElementById('languageModal').classList.remove('hidden'); }
        function closeLanguageModal() { document.getElementById('languageModal').classList.add('hidden'); }
        function openCartModal() { document.getElementById('cartModal').classList.remove('hidden'); }
        function closeCartModal() { document.getElementById('cartModal').classList.add('hidden'); }
        function proceedToCheckout() { alert('Redirecting to checkout...'); }

        // === CAROUSEL & LIKE ===
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.carousel-container').forEach(carousel => {
                const images = carousel.querySelectorAll('img');
                const indicators = carousel.parentElement.querySelectorAll('.indicator');
                if (images.length <= 1) return;
                let currentIndex = 0;
                const updateIndicators = () => {
                    indicators.forEach((ind, i) => {
                        ind.classList.toggle('opacity-100', i === currentIndex);
                        ind.classList.toggle('opacity-50', i !== currentIndex);
                    });
                };
                let startX = 0;
                const handleEnd = (endX) => {
                    const diff = startX - endX;
                    if (Math.abs(diff) > 50) {
                        if (diff > 0 && currentIndex < images.length - 1) currentIndex++;
                        else if (diff < 0 && currentIndex > 0) currentIndex--;
                        images[currentIndex].scrollIntoView({ behavior: 'smooth', inline: 'center' });
                        updateIndicators();
                    }
                };
                carousel.addEventListener('mousedown', e => { startX = e.clientX; });
                carousel.addEventListener('touchstart', e => { startX = e.touches[0].clientX; });
                carousel.addEventListener('mouseup', e => handleEnd(e.clientX));
                carousel.addEventListener('touchend', e => handleEnd(e.changedTouches[0].clientX));
                indicators.forEach((ind, i) => {
                    ind.addEventListener('click', () => {
                        currentIndex = i;
                        images[i].scrollIntoView({ behavior: 'smooth', inline: 'center' });
                        updateIndicators();
                    });
                });
                updateIndicators();
            });

            document.querySelectorAll('.like-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.classList.toggle('far');
                    this.classList.toggle('fas');
                    this.classList.toggle('text-red-500');
                });
            });

            document.addEventListener('click', (e) => {
                ['languageModal', 'cartModal'].forEach(id => {
                    const modal = document.getElementById(id);
                    if (modal && !modal.classList.contains('hidden') && e.target === modal) {
                        modal.classList.add('hidden');
                    }
                });
            });

            updateCartDisplay();
        });
    </script>
</body>
</html>