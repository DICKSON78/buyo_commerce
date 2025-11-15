<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyo | Buy & Sell Made Easy</title>
    <link rel="icon" type="image/x-icon" href="assets/img/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary: #008000;
            --secondary: #FFD700;
            --dark: #1a1a1a;
            --light: #f8f9fa;
        }

        body { 
            font-family: 'Poppins', sans-serif; 
            scroll-behavior: smooth;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Dark Mode Styles */
        .dark body {
            background-color: #1a1a1a;
            color: #e5e7eb;
        }

        .dark .bg-white {
            background-color: #1f2937;
        }

        .dark .text-gray-800 {
            color: #f9fafb;
        }

        .dark .text-gray-600 {
            color: #d1d5db;
        }

        .dark .bg-gray-50 {
            background-color: #111827;
        }

        .dark .border-gray-200 {
            border-color: #374151;
        }

        /* Navigation Styles */
        nav {
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .nav-scrolled {
            background: rgba(0, 128, 0, 0.65) !important;
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.1);
        }

        .nav-green {
            background: #008000;
        }

        .dark .nav-green {
            background: #0a5c0a;
        }

        .nav-scrolled.dark {
            background: rgba(10, 92, 10, 0.95) !important;
        }

        .gradient-bg { background: linear-gradient(135deg, #008000 0%, #006400 100%); }
        .text-gradient { background: linear-gradient(90deg, #FFD700 0%, #FFEB3B 100%); -webkit-background-clip: text; background-clip: text; color: transparent; }
        
        .hover-scale { transition: transform 0.3s ease; }
        .hover-scale:hover { transform: scale(1.03); }
        
        .nav-link { position: relative; }
        .nav-link:after { content: ''; position: absolute; width: 0; height: 2px; bottom: -2px; left: 0; background-color: #FFD700; transition: width 0.3s ease; }
        .nav-link:hover:after { width: 100%; }
        
        /* UNIFIED CARD STYLES - All cards now match product cards */
        .product-card { 
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: white;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        .dark .product-card {
            background: #1f2937;
            border-color: #374151;
        }

        .product-card:hover { 
            transform: translateY(-8px); 
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .dark .product-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
        }

        /* Testimonial Cards - Now matching product cards */
        .testimonial-card { 
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: white;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            padding: 1.5rem;
        }

        .dark .testimonial-card {
            background: #1f2937;
            border-color: #374151;
        }

        .testimonial-card:hover { 
            transform: translateY(-8px); 
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .dark .testimonial-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
        }

        /* Feature Cards - Now matching product cards */
        .feature-card { 
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: white;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            padding: 1.5rem;
            text-align: center;
            height: 100%;
        }

        .dark .feature-card {
            background: #1f2937;
            border-color: #374151;
        }

        .feature-card:hover { 
            transform: translateY(-8px); 
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .dark .feature-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
        }

        /* Quick Action Cards - Now matching product cards */
        .quick-action-card { 
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: white;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            padding: 2rem;
            text-align: center;
            height: 100%;
        }

        .dark .quick-action-card {
            background: #1f2937;
            border-color: #374151;
        }

        .quick-action-card:hover { 
            transform: translateY(-8px); 
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .dark .quick-action-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
        }

        .floating { animation: floating 3s ease-in-out infinite; }
        @keyframes floating { 0% { transform: translateY(0px); } 50% { transform: translateY(-15px); } 100% { transform: translateY(0px); } }
        
        .whatsapp-btn { box-shadow: 0 10px 15px -3px rgba(25, 175, 80, 0.3); transition: all 0.3s ease; }
        .whatsapp-btn:hover { transform: scale(1.1); box-shadow: 0 20px 25px -5px rgba(25, 175, 80, 0.4); }
        
        .hero-pattern { background-image: radial-gradient(rgba(0, 128, 0, 0.2) 1px, transparent 1px); background-size: 20px 20px; }
        
        /* Mobile Menu */
        .mobile-menu { display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; padding: 1rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); z-index: 50; }
        .dark .mobile-menu {
            background: #1f2937;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
        }
        .mobile-menu.active { display: block; }
        .mobile-menu a { display: block; padding: 0.75rem 1rem; color: #1a1a1a; border-bottom: 1px solid #f3f4f6; }
        .dark .mobile-menu a {
            color: #e5e7eb;
            border-bottom-color: #374151;
        }
        .mobile-menu a:hover { color: #008000; background-color: #f9fafb; }
        .dark .mobile-menu a:hover {
            background-color: #374151;
        }
        .mobile-menu a:last-child { border-bottom: none; }
        .mobile-menu-button { transition: all 0.3s ease; }
        .mobile-menu-button:hover { color: #008000; transform: scale(1.1); }
        
        /* Hero Background */
        .hero-section {
            background-image: linear-gradient(rgba(0, 0, 0, 0.797), rgba(0, 0, 0, 0.749)), url('https://images.unsplash.com/photo-1607082350899-7e105aa886ae?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80');
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        /* Badges and Status */
        .badge { 
            position: absolute; 
            top: 10px; 
            right: 10px; 
            background: #FFD700; 
            color: #1a1a1a; 
            padding: 4px 8px; 
            border-radius: 4px; 
            font-size: 0.75rem; 
            font-weight: 600; 
        }

        .seller-badge { 
            background: #008000; 
            color: white; 
            padding: 2px 8px; 
            border-radius: 4px; 
            font-size: 0.75rem; 
        }

        .dark .seller-badge {
            background: #0a5c0a;
        }

        .feature-icon { 
            width: 60px; 
            height: 60px; 
            border-radius: 50%; 
            background: rgba(0, 128, 0, 0.1); 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin: 0 auto 1rem; 
        }
        
        .section-title { position: relative; display: inline-block; }
        .section-title:after { content: ''; position: absolute; bottom: -8px; left: 0; width: 60%; height: 3px; background: linear-gradient(90deg, #FFD700 0%, #FFEB3B 100%); }
        
        .stats-counter { font-size: 2.5rem; font-weight: 700; background: linear-gradient(90deg, #008000 0%, #006400 100%); -webkit-background-clip: text; background-clip: text; color: transparent; }
        
        /* Quick Action Button Styles */
        .action-icon { 
            width: 80px; 
            height: 80px; 
            border-radius: 50%; 
            background: #008000; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin: 0 auto 1rem; 
            color: white;
            font-size: 1.5rem;
        }

        /* Footer Dark Mode */
        .dark footer {
            background: #111827;
        }

        .dark footer .text-gray-400 {
            color: #9ca3af;
        }

        /* Order Status Colors (from dashboard) */
        .order-status-pending {
            background: #fef3c7;
            color: #d97706;
        }
        .dark .order-status-pending {
            background: #451a03;
            color: #fbbf24;
        }

        .order-status-processing {
            background: #dbeafe;
            color: #1e40af;
        }
        .dark .order-status-processing {
            background: #1e3a8a;
            color: #60a5fa;
        }

        .payment-completed {
            background: #d1fae5;
            color: #065f46;
        }
        .dark .payment-completed {
            background: #064e3b;
            color: #34d399;
        }

        /* Scrollbar hiding */
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    </style>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#008000',
                        secondary: '#FFD700',
                        dark: '#1a1a1a',
                        light: '#f8f9fa'
                    },
                    animation: {
                        'float-slow': 'floating 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s ease-in-out infinite'
                    }
                }
            }
        };
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-300">
    <!-- WhatsApp Float Button -->
    <a href="https://wa.me/+255XXXXXXXXX" target="_blank" class="fixed bottom-8 right-8 z-50 whatsapp-btn bg-[#25D366] text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl shadow-lg animate-bounce">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Navigation -->
    <nav id="mainNav" class="fixed w-full nav-green shadow-md z-40 transition-all duration-300">
        <div class="container mx-auto px-6 py-4 flex flex-wrap items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center">
                    <i class="fas fa-store text-green-600 dark:text-green-400 text-lg"></i>
                </div>
                <div class="text-xl font-bold text-white">Buyo</div>
            </a>
            
            <!-- Search Bar -->
            <div class="flex-1 mx-4 hidden md:block max-w-xl">
                <form action="{{ route('products.search') }}" method="GET">
                    <div class="relative">
                        <input type="text" name="q" placeholder="Search products, categories, or location..." 
                               class="w-full px-4 py-2 rounded-full border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400">
                        <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="hidden lg:flex items-center space-x-6">
                <!-- Dark Mode Toggle -->
                <button id="themeToggle" class="text-white hover:text-yellow-300 transition-colors" title="Toggle Dark Mode">
                    <i class="fas fa-moon text-lg"></i>
                </button>

                <a href="{{ route('products.index') }}" class="nav-link text-white hover:text-yellow-300">Products</a>
                <a href="{{ route('register.seller') }}" class="nav-link text-white hover:text-yellow-300">Sell</a>
                
                <!-- Dynamic Navigation Based on Auth Status -->
                @auth
                    @if(Auth::user()->user_type === 'seller')
                        <a href="{{ route('seller.dashboard') }}" class="nav-link text-white hover:text-yellow-300">Seller Dashboard</a>
                    @else
                        <a href="{{ route('customer.dashboard') }}" class="nav-link text-white hover:text-yellow-300">My Account</a>
                    @endif
                    
                    <a href="{{ route('customer.cart') }}" class="text-white hover:text-yellow-300 relative">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span class="absolute top-0 right-0 bg-secondary text-dark text-xs rounded-full px-1 min-w-[18px] text-center cart-count">0</span>
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="nav-link text-white hover:text-yellow-300 bg-transparent border-none cursor-pointer">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('register.seller') }}" class="nav-link text-white hover:text-yellow-300">Login | Register</a>
                    <a href="{{ route('customer.cart') }}" class="text-white hover:text-yellow-300 relative">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span class="absolute top-0 right-0 bg-secondary text-dark text-xs rounded-full px-1 min-w-[18px] text-center cart-count">0</span>
                    </a>
                @endauth

                <span class="lang-toggle text-white hover:text-yellow-300 flex items-center" onclick="toggleLanguage()">
                    <i class="fas fa-globe mr-1"></i> EN / SW
                </span>
            </div>
            <div class="lg:hidden flex items-center space-x-4">
                <!-- Dark Mode Toggle for Mobile -->
                <button id="themeToggleMobile" class="text-white hover:text-yellow-300 transition-colors">
                    <i class="fas fa-moon text-lg"></i>
                </button>
                <button class="mobile-menu-button text-white focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div class="mobile-menu lg:hidden">
            <div class="relative mb-4">
                <form action="{{ route('products.search') }}" method="GET">
                    <input type="text" name="q" placeholder="Search..." 
                           class="w-full px-4 py-2 rounded-full border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-primary bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                    <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            <a href="{{ route('home') }}" class="nav-link">Home</a>
            <a href="{{ route('products.index') }}" class="nav-link">Products</a>
            <a href="{{ route('register.seller') }}" class="nav-link">Sell</a>
            
            @auth
                @if(Auth::user()->user_type === 'seller')
                    <a href="{{ route('seller.dashboard') }}" class="nav-link">Seller Dashboard</a>
                @else
                    <a href="{{ route('customer.dashboard') }}" class="nav-link">My Account</a>
                @endif
                <a href="{{ route('customer.cart') }}" class="nav-link flex items-center justify-between">
                    <span>Cart</span>
                    <span class="bg-secondary text-dark text-xs rounded-full px-1 min-w-[18px] text-center cart-count">0</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="nav-link text-left w-full bg-transparent border-none cursor-pointer">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('register.seller') }}" class="nav-link">Login | Register</a>
                <a href="{{ route('customer.cart') }}" class="nav-link flex items-center justify-between">
                    <span>Cart</span>
                    <span class="bg-secondary text-dark text-xs rounded-full px-1 min-w-[18px] text-center cart-count">0</span>
                </a>
            @endauth
            
            <span class="block px-4 py-2 lang-toggle flex items-center" onclick="toggleLanguage()">
                <i class="fas fa-globe mr-2"></i> EN / SW
            </span>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section pt-32 pb-20 md:pt-40 md:pb-28 relative overflow-hidden">
        <div class="container mx-auto px-6 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight animate__animated animate__fadeInDown">Buy & Sell <span class="text-gradient">Made Easy</span></h1>
            <p class="text-xl text-gray-200 mb-8 max-w-2xl mx-auto animate__animated animate__fadeIn animate__delay-1s">Connect with local sellers and buyers in Tanzania. List your products or find great deals today!</p>
            <div class="flex flex-wrap justify-center gap-4 animate__animated animate__fadeInUp animate__delay-2s">
                <a href="{{ route('products.index') }}" class="bg-secondary hover:bg-yellow-400 text-dark px-8 py-3 rounded-full text-lg font-semibold transition-all shadow-lg hover:shadow-xl flex items-center">
                    <i class="fas fa-search mr-2"></i> Browse Products
                </a>
                <a href="{{ route('register.seller') }}" class="border-2 border-white text-white hover:bg-white hover:text-primary px-8 py-3 rounded-full text-lg font-semibold transition-all flex items-center">
                    <i class="fas fa-store mr-2"></i> Become a Seller
                </a>
            </div>
        </div>
    </section>

    <!-- Quick Stats Section -->
    <section class="py-12 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="p-4">
                    <div class="stats-counter">10K+</div>
                    <p class="text-gray-600 dark:text-gray-400">Active Users</p>
                </div>
                <div class="p-4">
                    <div class="stats-counter">5K+</div>
                    <p class="text-gray-600 dark:text-gray-400">Products Listed</p>
                </div>
                <div class="p-4">
                    <div class="stats-counter">500+</div>
                    <p class="text-gray-600 dark:text-gray-400">Verified Sellers</p>
                </div>
                <div class="p-4">
                    <div class="stats-counter">95%</div>
                    <p class="text-gray-600 dark:text-gray-400">Satisfied Customers</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section - Now with unified card design -->
    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-gray-100 mb-4 section-title">Why Choose Buyo?</h2>
            <p class="text-center text-gray-600 dark:text-gray-400 mb-12 max-w-lg mx-auto">We make buying and selling simple, secure, and convenient</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature Card 1 -->
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt text-2xl text-primary"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800 dark:text-gray-100">Secure Transactions</h3>
                    <p class="text-gray-600 dark:text-gray-400">Your payments and personal information are protected with advanced security measures.</p>
                </div>
                
                <!-- Feature Card 2 -->
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shipping-fast text-2xl text-primary"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800 dark:text-gray-100">Fast Delivery</h3>
                    <p class="text-gray-600 dark:text-gray-400">Get your products delivered quickly with our trusted delivery partners across Tanzania.</p>
                </div>
                
                <!-- Feature Card 3 -->
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset text-2xl text-primary"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800 dark:text-gray-100">24/7 Support</h3>
                    <p class="text-gray-600 dark:text-gray-400">Our customer support team is always ready to help with any questions or issues.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="py-16 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 section-title">Featured Products</h2>
                <div class="flex space-x-2">
                    <button class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 p-2 rounded-full text-gray-600 dark:text-gray-400 prev-products">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 p-2 rounded-full text-gray-600 dark:text-gray-400 next-products">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
            <p class="text-gray-600 dark:text-gray-400 mb-12 max-w-lg">Handpicked quality products from trusted sellers</p>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6" id="featured-products">
                <!-- Products will be loaded dynamically via JavaScript -->
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('products.index') }}" class="bg-primary hover:bg-green-700 text-white px-8 py-3 rounded-full font-semibold transition-colors inline-flex items-center">
                    See All Products <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section - Now with unified card design -->
    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-gray-100 mb-4 section-title">What Our Customers Say</h2>
            <p class="text-center text-gray-600 dark:text-gray-400 mb-12 max-w-lg mx-auto">Real experiences from our community of buyers and sellers</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial Card 1 -->
                <div class="testimonial-card">
                    <div class="flex items-center mb-4">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" alt="Customer" class="w-12 h-12 rounded-full object-cover mr-4">
                        <div>
                            <h4 class="font-bold text-gray-800 dark:text-gray-100">Sarah J.</h4>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400">"I found the perfect dining table on Buyo. The seller was professional and the delivery was faster than expected. Highly recommended!"</p>
                </div>
                
                <!-- Testimonial Card 2 -->
                <div class="testimonial-card">
                    <div class="flex items-center mb-4">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Customer" class="w-12 h-12 rounded-full object-cover mr-4">
                        <div>
                            <h4 class="font-bold text-gray-800 dark:text-gray-100">Michael T.</h4>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400">"As a small business owner, Buyo has helped me reach more customers. The platform is easy to use and the support team is very helpful."</p>
                </div>
                
                <!-- Testimonial Card 3 -->
                <div class="testimonial-card">
                    <div class="flex items-center mb-4">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Customer" class="w-12 h-12 rounded-full object-cover mr-4">
                        <div>
                            <h4 class="font-bold text-gray-800 dark:text-gray-100">Grace L.</h4>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400">"I was hesitant to buy electronics online, but Buyo's verification system gave me confidence. The smartphone I bought works perfectly!"</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Actions Section - Now with unified card design -->
    <section class="py-16 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-gray-100 mb-12 section-title">Get Started Today</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Quick Action Card 1 -->
                <div class="quick-action-card">
                    <div class="action-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800 dark:text-gray-100">Find Products</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Browse thousands of products from trusted sellers across Tanzania</p>
                    <a href="{{ route('products.index') }}" class="text-primary font-semibold hover:text-secondary inline-flex items-center">
                        Start Shopping <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                
                <!-- Quick Action Card 2 -->
                <div class="quick-action-card">
                    <div class="action-icon">
                        <i class="fas fa-store"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800 dark:text-gray-100">Become a Seller</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">List your products and reach customers across Tanzania with our platform</p>
                    <a href="{{ route('register.seller') }}" class="text-primary font-semibold hover:text-secondary inline-flex items-center">
                        Start Selling <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                
                <!-- Quick Action Card 3 -->
                <div class="quick-action-card">
                    <div class="action-icon">
                        <i class="fas fa-download"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800 dark:text-gray-100">Get the App</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Shop on the go with our mobile application available on all platforms</p>
                    <a href="#" class="text-primary font-semibold hover:text-secondary inline-flex items-center">
                        Download Now <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-16 bg-primary">
        <div class="container mx-auto px-6">
            <div class="max-w-2xl mx-auto text-center">
                <h2 class="text-3xl font-bold text-white mb-4">Stay Updated</h2>
                <p class="text-gray-200 mb-8">Subscribe to our newsletter for the latest products and exclusive deals</p>
                <form class="flex flex-col sm:flex-row max-w-md mx-auto">
                    <input type="email" placeholder="Your email address" 
                           class="rounded-l-full px-4 py-3 flex-grow focus:outline-none bg-white text-gray-800">
                    <button type="submit" class="rounded-r-full bg-secondary text-dark px-6 py-3 font-semibold hover:bg-yellow-400 transition-colors">Subscribe</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-16 pb-8">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                            <i class="fas fa-store text-green-600 text-lg"></i>
                        </div>
                        <div class="text-xl font-bold">Buyo</div>
                    </div>
                    <p class="text-gray-400 mb-4">Local marketplace for Tanzanian buyers and sellers.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-6">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white">Home</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-gray-400 hover:text-white">Products</a></li>
                        <li><a href="{{ route('register.seller') }}" class="text-gray-400 hover:text-white">Sell on Buyo</a></li>
                        <li><a href="{{ route('choose') }}" class="text-gray-400 hover:text-white">Login/Register</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-6">Support</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Shipping & Returns</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Terms of Service</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-6">Contact Info</h3>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-start"><i class="fas fa-map-marker-alt mt-1 mr-3 text-primary"></i> Dar es Salaam, Tanzania</li>
                        <li class="flex items-start"><i class="fas fa-phone-alt mt-1 mr-3 text-primary"></i> +255 XXX XXX XXX</li>
                        <li class="flex items-start"><i class="fas fa-envelope mt-1 mr-3 text-primary"></i> info@Buyo.com</li>
                        <li class="flex items-start"><i class="fas fa-clock mt-1 mr-3 text-primary"></i> Mon - Fri: 8:00 - 17:00</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                © 2025 Buyo. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        // === DARK MODE TOGGLE ===
        const themeToggle = document.getElementById('themeToggle');
        const themeToggleMobile = document.getElementById('themeToggleMobile');
        const html = document.documentElement;

        function toggleDarkMode() {
            html.classList.toggle('dark');
            if (html.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
                themeToggle.innerHTML = '<i class="fas fa-sun text-lg"></i>';
                themeToggleMobile.innerHTML = '<i class="fas fa-sun text-lg"></i>';
            } else {
                localStorage.setItem('theme', 'light');
                themeToggle.innerHTML = '<i class="fas fa-moon text-lg"></i>';
                themeToggleMobile.innerHTML = '<i class="fas fa-moon text-lg"></i>';
            }
        }

        // Initialize theme
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
            themeToggle.innerHTML = '<i class="fas fa-sun text-lg"></i>';
            themeToggleMobile.innerHTML = '<i class="fas fa-sun text-lg"></i>';
        } else {
            themeToggle.innerHTML = '<i class="fas fa-moon text-lg"></i>';
            themeToggleMobile.innerHTML = '<i class="fas fa-moon text-lg"></i>';
        }

        themeToggle.addEventListener('click', toggleDarkMode);
        themeToggleMobile.addEventListener('click', toggleDarkMode);

        // === NAVIGATION SCROLL EFFECT ===
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('mainNav');
            if (window.scrollY > 100) {
                nav.classList.add('nav-scrolled');
            } else {
                nav.classList.remove('nav-scrolled');
            }
        });

        // === MOBILE MENU TOGGLE ===
        const mobileMenuButton = document.querySelector('.mobile-menu-button');
        const mobileMenu = document.querySelector('.mobile-menu');
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
            const icon = mobileMenuButton.querySelector('i');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        });
        
        document.querySelectorAll('.mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
                mobileMenuButton.querySelector('i').classList.add('fa-bars');
                mobileMenuButton.querySelector('i').classList.remove('fa-times');
            });
        });

        // Language Toggle (Mock - change text)
        function toggleLanguage() {
            alert('Switching language... (Implement with backend)');
        }

        // Load Featured Products
        function loadFeaturedProducts() {
            fetch('/api/featured-products')
                .then(response => response.json())
                .then(products => {
                    const container = document.getElementById('featured-products');
                    container.innerHTML = '';
                    
                    products.forEach(product => {
                        const productCard = `
                            <div class="product-card">
                                ${product.badge ? `<span class="badge">${product.badge}</span>` : ''}
                                <img src="${product.image}" alt="${product.name}" class="w-full h-48 object-cover">
                                <div class="p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100">${product.name}</h3>
                                        <span class="seller-badge">Verified</span>
                                    </div>
                                    <p class="text-green-600 dark:text-green-400 font-semibold text-lg">TZS ${product.price.toLocaleString()}</p>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">${product.location}</p>
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center text-yellow-400">
                                            <i class="fas fa-star"></i>
                                            <span class="text-gray-600 dark:text-gray-400 ml-1">${product.rating} (${product.reviews})</span>
                                        </div>
                                        <a href="/products/${product.slug}" class="bg-primary hover:bg-green-700 text-white px-4 py-2 rounded-full text-sm font-medium transition-colors">View Details</a>
                                    </div>
                                </div>
                            </div>
                        `;
                        container.innerHTML += productCard;
                    });
                })
                .catch(error => {
                    console.error('Error loading featured products:', error);
                });
        }

        // Update cart count
        function updateCartCount() {
            // This would typically come from your backend
            const cartCount = 0; // Default
            document.querySelectorAll('.cart-count').forEach(el => {
                el.textContent = cartCount;
            });
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadFeaturedProducts();
            updateCartCount();
            
            // Scroll animations
            const animateOnScroll = () => {
                document.querySelectorAll('.product-card, .testimonial-card, .feature-card, .quick-action-card').forEach(el => {
                    if (el.getBoundingClientRect().top < window.innerHeight - 100) {
                        el.classList.add('animate__animated', 'animate__fadeInUp');
                    }
                });
            };
            window.addEventListener('scroll', animateOnScroll);
            window.addEventListener('load', animateOnScroll);
        });
    </script>
</body>
</html>