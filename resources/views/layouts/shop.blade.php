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
            min-width: 200px;
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

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        /* Desktop Modal */
        .desktop-modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.9);
            background: white;
            border-radius: 12px;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            max-width: 90%;
            width: 400px;
        }
        .dark .desktop-modal {
            background: #1f2937;
        }
        .desktop-modal.active {
            opacity: 1;
            visibility: visible;
            transform: translate(-50%, -50%) scale(1);
        }

        /* Mobile Bottom Sheet */
        .bottom-sheet {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-radius: 20px 20px 0 0;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.15);
            transform: translateY(100%);
            transition: transform 0.3s ease-out;
            z-index: 1000;
            max-height: 80vh;
            overflow-y: auto;
        }
        .dark .bottom-sheet {
            background: #1f2937;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.3);
        }
        .bottom-sheet.active {
            transform: translateY(0);
        }
        .bottom-sheet-handle {
            width: 40px;
            height: 4px;
            background: #d1d5db;
            border-radius: 2px;
            margin: 12px auto;
        }
        .dark .bottom-sheet-handle {
            background: #4b5563;
        }

        /* Contact Seller Modal */
        .contact-modal {
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        .contact-modal.active {
            opacity: 1;
            visibility: visible;
        }
        .contact-modal-content {
            transform: translateY(-20px);
            transition: transform 0.3s ease;
        }
        .contact-modal.active .contact-modal-content {
            transform: translateY(0);
        }
        
        /* Flag Icons */
        .flag-icon {
            width: 24px;
            height: 16px;
            display: inline-block;
            background-size: cover;
            border-radius: 2px;
            margin-right: 8px;
        }

        /* Theme Auto Detection Indicator */
        .theme-auto-indicator {
            position: relative;
        }
        .theme-auto-indicator::after {
            content: 'AUTO';
            position: absolute;
            top: -8px;
            right: -8px;
            background: #008000;
            color: white;
            font-size: 8px;
            padding: 2px 4px;
            border-radius: 4px;
            font-weight: bold;
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-300">
    @yield('contents')
</body>
</html>