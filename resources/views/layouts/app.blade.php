<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BidhaaHub | Buy & Sell Made Easy')</title>
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
        
        /* New Enhanced Styles */
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

        /* Instagram Stories Style */
        .stories-container { display: flex; overflow-x: auto; padding: 1rem 0; gap: 1rem; scrollbar-width: none; }
        .stories-container::-webkit-scrollbar { display: none; }
        .story-item { flex: 0 0 auto; text-align: center; cursor: pointer; }
        .story-circle { width: 80px; height: 80px; border-radius: 50%; padding: 3px; background: linear-gradient(45deg, #008000 0%, #006400 100%); display: flex; align-items: center; justify-content: center; }
        .story-inner { width: 100%; height: 100%; border-radius: 50%; background: white; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .story-inner img { width: 100%; height: 100%; object-fit: cover; }

        /* Enhanced Navigation */
        .nav-container { background: linear-gradient(135deg, #008000 0%, #006400 100%); }
        .cart-badge { position: absolute; top: -8px; right: -8px; background: #FFD700; color: #1a1a1a; border-radius: 50%; width: 18px; height: 18px; font-size: 0.7rem; display: flex; align-items: center; justify-content: center; }

        /* Modern Improvements */
        .hover-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); }
        .glow-effect { box-shadow: 0 0 20px rgba(0, 128, 0, 0.3); }
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

    <!-- Enhanced Navigation -->
    <nav class="fixed w-full nav-container shadow-md z-40 transition-all duration-300">
        <div class="container mx-auto px-6 py-4 flex flex-wrap items-center justify-between">
            <a href="/" class="flex items-center space-x-2">
                <div class="h-10 w-10 bg-white rounded-full flex items-center justify-center text-primary font-bold text-lg">BH</div>
                <div class="text-xl font-bold text-white">BIDHAAHUB</div>
            </a>

            <!-- Search Bar -->
            <div class="flex-1 mx-4 hidden md:block max-w-xl">
                <div class="relative">
                    <input type="text" placeholder="Search products, categories, or location..." 
                           class="w-full px-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent">
                    <button class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <div class="hidden lg:flex items-center space-x-6">
                <a href="/products" class="nav-link text-white hover:text-secondary">Categories</a>
                <a href="/sell" class="nav-link text-white hover:text-secondary">Sell</a>
                <a href="/login" class="nav-link text-white hover:text-secondary">Login / Register</a>
                
                <a href="/cart" class="text-white hover:text-secondary relative">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    <span class="cart-badge">0</span>
                </a>
                
                <a href="#" class="text-white hover:text-secondary relative">
                    <i class="far fa-bell text-xl"></i>
                    <span class="cart-badge bg-red-500 text-white">3</span>
                </a>
                
                <span class="lang-toggle text-white hover:text-secondary flex items-center" onclick="toggleLanguage()">
                    <i class="fas fa-globe mr-1"></i> EN / SW
                </span>
            </div>

            <div class="lg:hidden">
                <button class="mobile-menu-button text-white focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="mobile-menu lg:hidden">
            <div class="relative mb-4">
                <input type="text" placeholder="Search..." 
                       class="w-full px-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary">
                <button class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <a href="/" class="nav-link">Home</a>
            <a href="/about" class="nav-link">About</a>
            <a href="/products" class="nav-link">Products</a>
            <a href="/sell" class="nav-link">Sell</a>
            <a href="/testimonials" class="nav-link">Testimonials</a>
            <a href="/contact" class="nav-link">Contact</a>
            <a href="/login" class="nav-link">Login / Register</a>
            <a href="/cart" class="nav-link flex items-center justify-between">
                <span>Cart</span>
                <span class="cart-badge">0</span>
            </a>
            <a href="#" class="nav-link flex items-center justify-between">
                <span>Notifications</span>
                <span class="cart-badge bg-red-500 text-white">3</span>
            </a>
            <span class="block px-4 py-2 lang-toggle flex items-center" onclick="toggleLanguage()">
                <i class="fas fa-globe mr-2"></i> EN / SW
            </span>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-20">
        @yield('content')
    </main>

    <!-- Enhanced Footer -->
    <footer class="bg-dark text-white pt-16 pb-8">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="h-10 w-10 bg-primary rounded-full flex items-center justify-center text-white font-bold">BH</div>
                        <div class="text-xl font-bold">BIDHAAHUB</div>
                    </div>
                    <p class="text-gray-400 mb-4">Local marketplace for Tanzanian buyers and sellers.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-6">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="/" class="text-gray-400 hover:text-white transition-colors">Home</a></li>
                        <li><a href="/about" class="text-gray-400 hover:text-white transition-colors">About</a></li>
                        <li><a href="/products" class="text-gray-400 hover:text-white transition-colors">Products</a></li>
                        <li><a href="/sell" class="text-gray-400 hover:text-white transition-colors">Sell on BidhaaHub</a></li>
                        <li><a href="/testimonials" class="text-gray-400 hover:text-white transition-colors">Testimonials</a></li>
                        <li><a href="/contact" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-6">Support</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Shipping & Returns</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-6">Contact Info</h3>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-primary"></i> 
                            Dar es Salaam, Tanzania
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 mr-3 text-primary"></i> 
                            +255 XXX XXX XXX
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-3 text-primary"></i> 
                            info@bidhaahub.com
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-clock mt-1 mr-3 text-primary"></i> 
                            Mon - Fri: 8:00 - 17:00
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                © 2025 BidhaaHub. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.querySelector('.mobile-menu-button');
        const mobileMenu = document.querySelector('.mobile-menu');
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('active');
                const icon = mobileMenuButton.querySelector('i');
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-times');
            });

            document.querySelectorAll('.mobile-menu a').forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.remove('active');
                    const icon = mobileMenuButton.querySelector('i');
                    icon.classList.add('fa-bars');
                    icon.classList.remove('fa-times');
                });
            });
        }

        // Language Toggle
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

    @yield('scripts')
</body>
</html>