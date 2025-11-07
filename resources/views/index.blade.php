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
        body { font-family: 'Poppins', sans-serif; scroll-behavior: smooth; }
        .gradient-bg { background: linear-gradient(135deg, #008000 0%, #006400 100%); }
        .text-gradient { background: linear-gradient(90deg, #FFD700 0%, #FFEB3B 100%); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .hover-scale { transition: transform 0.3s ease; }
        .hover-scale:hover { transform: scale(1.03); }
        .nav-link { position: relative; }
        .nav-link:after { content: ''; position: absolute; width: 0; height: 2px; bottom: -2px; left: 0; background-color: #FFD700; transition: width 0.3s ease; }
        .nav-link:hover:after { width: 100%; }
        .product-card { transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .product-card:hover { transform: translateY(-10px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
        .floating { animation: floating 3s ease-in-out infinite; }
        @keyframes floating { 0% { transform: translateY(0px); } 50% { transform: translateY(-15px); } 100% { transform: translateY(0px); } }
        .whatsapp-btn { box-shadow: 0 10px 15px -3px rgba(25, 175, 80, 0.3); transition: all 0.3s ease; }
        .whatsapp-btn:hover { transform: scale(1.1); box-shadow: 0 20px 25px -5px rgba(25, 175, 80, 0.4); }
        .hero-pattern { background-image: radial-gradient(rgba(0, 128, 0, 0.2) 1px, transparent 1px); background-size: 20px 20px; }
        nav { z-index: 1000; }
        /* Mobile Menu */
        .mobile-menu { display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; padding: 1rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); z-index: 50; }
        .mobile-menu.active { display: block; }
        .mobile-menu a { display: block; padding: 0.75rem 1rem; color: #1a1a1a; border-bottom: 1px solid #f3f4f6; }
        .mobile-menu a:hover { color: #008000; background-color: #f9fafb; }
        .mobile-menu a:last-child { border-bottom: none; }
        .mobile-menu-button { transition: all 0.3s ease; }
        .mobile-menu-button:hover { color: #008000; transform: scale(1.1); }
        /* Language Toggle */
        .lang-toggle { cursor: pointer; }
        /* Hero Background */
        .hero-section {
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1607082350899-7e105aa886ae?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80');
            background-size: cover;
            background-position: center;
            position: relative;
        }
        /* New Styles */
        .category-icon { transition: all 0.3s ease; }
        .category-icon:hover { transform: scale(1.1) rotate(5deg); }
        .badge { position: absolute; top: 10px; right: 10px; background: #FFD700; color: #1a1a1a; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600; }
        .price-tag { background: linear-gradient(90deg, #FFD700 0%, #FFEB3B 100%); color: #1a1a1a; padding: 4px 8px; border-radius: 4px; font-weight: 600; }
        .testimonial-card { background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05); padding: 1.5rem; }
        .seller-badge { background: #008000; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; }
        .feature-icon { width: 60px; height: 60px; border-radius: 50%; background: rgba(0, 128, 0, 0.1); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; }
        .newsletter-input { border-radius: 50px 0 0 50px; }
        .newsletter-btn { border-radius: 0 50px 50px 0; }
        .section-title { position: relative; display: inline-block; }
        .section-title:after { content: ''; position: absolute; bottom: -8px; left: 0; width: 60%; height: 3px; background: linear-gradient(90deg, #FFD700 0%, #FFEB3B 100%); }
        .stats-counter { font-size: 2.5rem; font-weight: 700; background: linear-gradient(90deg, #008000 0%, #006400 100%); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .quick-action-btn { transition: all 0.3s ease; }
        .quick-action-btn:hover { transform: translateY(-5px); }

        /* Shopify-inspired improvements */
        .hero-gradient { background: linear-gradient(135deg, #008000 0%, #006400 100%); }
        .card-gradient { background: linear-gradient(135deg, rgba(0, 128, 0, 0.1) 0%, rgba(0, 100, 0, 0.1) 100%); }
        .hover-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); }
        .tab-active { background: #008000; color: white; }
        .tab-inactive { background: #f3f4f6; color: #4b5563; }
        .tab-inactive:hover { background: #e5e7eb; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .glow-effect { box-shadow: 0 0 20px rgba(0, 128, 0, 0.3); }
        .animated-gradient { background: linear-gradient(-45deg, #008000, #006400, #004d00, #003300); background-size: 400% 400%; animation: gradient 15s ease infinite; }
        @keyframes gradient { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
    </style>
    <script>
        tailwind.config = {
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
<body class="bg-gray-50">
    <!-- WhatsApp Float Button -->
    <a href="https://wa.me/+255XXXXXXXXX" target="_blank" class="fixed bottom-8 right-8 z-50 whatsapp-btn bg-[#25D366] text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl shadow-lg animate-bounce">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Navigation (Enhanced with Search, Cart, Login) -->
    <nav class="fixed w-full bg-primary shadow-md z-40 transition-all duration-300">
        <div class="container mx-auto px-6 py-4 flex flex-wrap items-center justify-between">
            <a href="index.html" class="flex items-center space-x-2">
                <img src="assets/img/logo.png" alt="Buyo Logo" class="h-10">
                <div class="text-xl font-bold text-white">Buyo</div>
            </a>
            <!-- Search Bar -->
            <div class="flex-1 mx-4 hidden md:block max-w-xl">
                <div class="relative">
                    <input type="text" placeholder="Search products, categories, or location..." class="w-full px-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <button class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="hidden lg:flex items-center space-x-6">
                <a href="products.html" class="nav-link text-white hover:text-dark">Categories</a>
                <a href="sell.html" class="nav-link text-white hover:text-dark">Sell</a>
                <a href="{{route('choose')}}" class="nav-link text-white hover:text-dark">Login | Register</a>
                <a href="#" class="text-white hover:text-dark relative">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    <span class="absolute top-0 right-0 bg-secondary text-dark text-xs rounded-full px-1 min-w-[18px] text-center">0</span>
                </a>
                <a href="#" class="text-white hover:text-dark relative">
                    <i class="far fa-bell text-xl"></i>
                    <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full px-1 min-w-[18px] text-center">3</span>
                </a>
                <span class="lang-toggle text-white hover:text-primary flex items-center" onclick="toggleLanguage()">
                    <i class="fas fa-globe mr-1"></i> EN / SW
                </span>
            </div>
            <div class="lg:hidden">
                <button class="mobile-menu-button text-dark focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div class="mobile-menu lg:hidden">
            <div class="relative mb-4">
                <input type="text" placeholder="Search..." class="w-full px-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary">
                <button class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <a href="index.html" class="nav-link">Home</a>
            <a href="about.html" class="nav-link">About</a>
            <a href="products.html" class="nav-link">Products</a>
            <a href="sell.html" class="nav-link">Sell</a>
            <a href="testimonials.html" class="nav-link">Testimonials</a>
            <a href="contact.html" class="nav-link">Contact</a>
            <a href="{{ route('choose') }}" class="nav-link">Login | Register</a>
            <a href="#" class="nav-link flex items-center justify-between">
                <span>Cart</span>
                <span class="bg-secondary text-dark text-xs rounded-full px-1 min-w-[18px] text-center">0</span>
            </a>
            <a href="#" class="nav-link flex items-center justify-between">
                <span>Notifications</span>
                <span class="bg-red-500 text-white text-xs rounded-full px-1 min-w-[18px] text-center">3</span>
            </a>
            <span class="block px-4 py-2 lang-toggle flex items-center" onclick="toggleLanguage()">
                <i class="fas fa-globe mr-2"></i> EN / SW
            </span>
        </div>
    </nav>

    <!-- Hero Section with Background Image -->
    <section class="hero-section pt-32 pb-20 md:pt-40 md:pb-28 relative overflow-hidden">
        <div class="container mx-auto px-6 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight animate__animated animate__fadeInDown">Buy & Sell <span class="text-gradient">Made Easy</span></h1>
            <p class="text-xl text-gray-200 mb-8 max-w-2xl mx-auto animate__animated animate__fadeIn animate__delay-1s">Connect with local sellers and buyers in Tanzania. List your products or find great deals today!</p>
            <div class="flex flex-wrap justify-center gap-4 animate__animated animate__fadeInUp animate__delay-2s">
                <a href="{{ route('choose') }}" class="bg-secondary hover:bg-yellow-400 text-dark px-8 py-3 rounded-full text-lg font-semibold transition-all shadow-lg hover:shadow-xl flex items-center">
                    <i class="fas fa-search mr-2"></i> Browse Products
                </a>
                <a href="{{route('choose')}}" class="border-2 border-white text-white hover:bg-white hover:text-primary px-8 py-3 rounded-full text-lg font-semibold transition-all flex items-center">
                    <i class="fas fa-store mr-2"></i> Become a Seller
                </a>
            </div>
        </div>
    </section>

    <!-- Quick Stats Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="p-4">
                    <div class="stats-counter">10K+</div>
                    <p class="text-gray-600">Active Users</p>
                </div>
                <div class="p-4">
                    <div class="stats-counter">5K+</div>
                    <p class="text-gray-600">Products Listed</p>
                </div>
                <div class="p-4">
                    <div class="stats-counter">500+</div>
                    <p class="text-gray-600">Verified Sellers</p>
                </div>
                <div class="p-4">
                    <div class="stats-counter">95%</div>
                    <p class="text-gray-600">Satisfied Customers</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-dark mb-4 section-title">Why Choose Buyo?</h2>
            <p class="text-center text-gray-600 mb-12 max-w-lg mx-auto">We make buying and selling simple, secure, and convenient</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt text-2xl text-primary"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Secure Transactions</h3>
                    <p class="text-gray-600">Your payments and personal information are protected with advanced security measures.</p>
                </div>
                <div class="text-center p-6">
                    <div class="feature-icon">
                        <i class="fas fa-shipping-fast text-2xl text-primary"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Fast Delivery</h3>
                    <p class="text-gray-600">Get your products delivered quickly with our trusted delivery partners across Tanzania.</p>
                </div>
                <div class="text-center p-6">
                    <div class="feature-icon">
                        <i class="fas fa-headset text-2xl text-primary"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">24/7 Support</h3>
                    <p class="text-gray-600">Our customer support team is always ready to help with any questions or issues.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section (12 Products with Images) -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-dark section-title">Featured Products</h2>
                <div class="flex space-x-2">
                    <button class="bg-gray-200 hover:bg-gray-300 p-2 rounded-full">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="bg-gray-200 hover:bg-gray-300 p-2 rounded-full">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
            <p class="text-gray-600 mb-12 max-w-lg">Handpicked quality products from trusted sellers</p>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <div class="product-card bg-white rounded-lg shadow-md overflow-hidden relative">
                    <span class="badge">New</span>
                    <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1099&q=80" alt="Smart Watch" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-bold text-lg">Smart Watch Series 5</h3>
                            <span class="seller-badge">Verified</span>
                        </div>
                        <p class="text-secondary font-semibold text-lg">TZS 350,000</p>
                        <p class="text-gray-600 text-sm mb-3">Dar es Salaam</p>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center text-yellow-400">
                                <i class="fas fa-star"></i>
                                <span class="text-gray-600 ml-1">4.8 (24)</span>
                            </div>
                            <a href="product-details.html" class="bg-primary text-white px-4 py-2 rounded-full text-sm font-medium hover:bg-green-700 transition-colors">View Details</a>
                        </div>
                    </div>
                </div>
                <div class="product-card bg-white rounded-lg shadow-md overflow-hidden relative">
                    <span class="badge">Trending</span>
                    <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Sports Shoes" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-bold text-lg">Running Shoes</h3>
                            <span class="seller-badge">Verified</span>
                        </div>
                        <p class="text-secondary font-semibold text-lg">TZS 85,000</p>
                        <p class="text-gray-600 text-sm mb-3">Arusha</p>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center text-yellow-400">
                                <i class="fas fa-star"></i>
                                <span class="text-gray-600 ml-1">4.5 (18)</span>
                            </div>
                            <a href="product-details.html" class="bg-primary text-white px-4 py-2 rounded-full text-sm font-medium hover:bg-green-700 transition-colors">View Details</a>
                        </div>
                    </div>
                </div>
                <div class="product-card bg-white rounded-lg shadow-md overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Headphones" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-bold text-lg">Wireless Headphones</h3>
                            <span class="seller-badge">Verified</span>
                        </div>
                        <p class="text-secondary font-semibold text-lg">TZS 120,000</p>
                        <p class="text-gray-600 text-sm mb-3">Dodoma</p>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center text-yellow-400">
                                <i class="fas fa-star"></i>
                                <span class="text-gray-600 ml-1">4.7 (32)</span>
                            </div>
                            <a href="product-details.html" class="bg-primary text-white px-4 py-2 rounded-full text-sm font-medium hover:bg-green-700 transition-colors">View Details</a>
                        </div>
                    </div>
                </div>
                <div class="product-card bg-white rounded-lg shadow-md overflow-hidden relative">
                    <span class="badge">Sale</span>
                    <img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Camera" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-bold text-lg">Digital Camera</h3>
                            <span class="seller-badge">Verified</span>
                        </div>
                        <div class="flex items-center space-x-2 mb-2">
                            <p class="text-secondary font-semibold text-lg">TZS 450,000</p>
                            <p class="text-gray-500 text-sm line-through">TZS 520,000</p>
                        </div>
                        <p class="text-gray-600 text-sm mb-3">Mwanza</p>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center text-yellow-400">
                                <i class="fas fa-star"></i>
                                <span class="text-gray-600 ml-1">4.9 (41)</span>
                            </div>
                            <a href="product-details.html" class="bg-primary text-white px-4 py-2 rounded-full text-sm font-medium hover:bg-green-700 transition-colors">View Details</a>
                        </div>
                    </div>
                </div>
                <!-- Additional product cards would continue here -->
            </div>
            <div class="text-center mt-12">
                <a href="products.html" class="bg-primary text-white px-8 py-3 rounded-full font-semibold hover:bg-green-700 transition-colors inline-flex items-center">
                    See All Products <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-dark mb-4 section-title">What Our Customers Say</h2>
            <p class="text-center text-gray-600 mb-12 max-w-lg mx-auto">Real experiences from our community of buyers and sellers</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="testimonial-card">
                    <div class="flex items-center mb-4">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" alt="Customer" class="w-12 h-12 rounded-full object-cover mr-4">
                        <div>
                            <h4 class="font-bold">Sarah J.</h4>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">"I found the perfect dining table on Buyo. The seller was professional and the delivery was faster than expected. Highly recommended!"</p>
                </div>
                <div class="testimonial-card">
                    <div class="flex items-center mb-4">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Customer" class="w-12 h-12 rounded-full object-cover mr-4">
                        <div>
                            <h4 class="font-bold">Michael T.</h4>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">"As a small business owner, Buyo has helped me reach more customers. The platform is easy to use and the support team is very helpful."</p>
                </div>
                <div class="testimonial-card">
                    <div class="flex items-center mb-4">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Customer" class="w-12 h-12 rounded-full object-cover mr-4">
                        <div>
                            <h4 class="font-bold">Grace L.</h4>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">"I was hesitant to buy electronics online, but Buyo's verification system gave me confidence. The smartphone I bought works perfectly!"</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Actions Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-dark mb-12 section-title">Get Started Today</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="quick-action-btn bg-light rounded-xl p-8 text-center">
                    <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Find Products</h3>
                    <p class="text-gray-600 mb-4">Browse thousands of products from trusted sellers</p>
                    <a href="products.html" class="text-primary font-semibold hover:text-secondary">Start Shopping →</a>
                </div>
                <div class="quick-action-btn bg-light rounded-xl p-8 text-center">
                    <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fas fa-store"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Become a Seller</h3>
                    <p class="text-gray-600 mb-4">List your products and reach customers across Tanzania</p>
                    <a href="{{ route('choose') }}" class="text-primary font-semibold hover:text-secondary">Start Selling →</a>
                </div>
                <div class="quick-action-btn bg-light rounded-xl p-8 text-center">
                    <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fas fa-download"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Get the App</h3>
                    <p class="text-gray-600 mb-4">Shop on the go with our mobile application</p>
                    <a href="#" class="text-primary font-semibold hover:text-secondary">Download Now →</a>
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
                <div class="flex flex-col sm:flex-row max-w-md mx-auto">
                    <input type="email" placeholder="Your email address" class="newsletter-input px-4 py-3 flex-grow focus:outline-none">
                    <button class="newsletter-btn bg-secondary text-dark px-6 py-3 font-semibold hover:bg-yellow-400 transition-colors">Subscribe</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white pt-16 pb-8">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <img src="assets/img/logo.png" alt="Buyo Logo" class="h-10">
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
                        <li><a href="index.html" class="text-gray-400 hover:text-white">Home</a></li>
                        <li><a href="about.html" class="text-gray-400 hover:text-white">About</a></li>
                        <li><a href="products.html" class="text-gray-400 hover:text-white">Products</a></li>
                        <li><a href="sell.html" class="text-gray-400 hover:text-white">Sell on Buyo</a></li>
                        <li><a href="testimonials.html" class="text-gray-400 hover:text-white">Testimonials</a></li>
                        <li><a href="contact.html" class="text-gray-400 hover:text-white">Contact</a></li>
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
        // Mobile menu toggle
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
        // Scroll animations
        const animateOnScroll = () => {
            document.querySelectorAll('.product-card, .hover-scale, .quick-action-btn').forEach(el => {
                if (el.getBoundingClientRect().top < window.innerHeight - 100) {
                    el.classList.add('animate__animated', 'animate__fadeInUp');
                }
            });
        };
        window.addEventListener('scroll', animateOnScroll);
        window.addEventListener('load', animateOnScroll);
    </script>
</body>
</html>
