<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard - Buyo</title>
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
        .nav-green {
            background: #008000;
        }
        .dark .nav-green {
            background: #0a5c0a;
        }
        .product-green { background: #008000; color: white; }
        .dark .product-green { background: #0a5c0a; }
        .product-green-light { background: #e6f4ea; }
        .dark .product-green-light { background: #1a3a2a; }
        .product-green-border { border-color: #008000; }
        .dark .product-green-border { border-color: #0a5c0a; }
        .product-green-text { color: #008000; }
        .dark .product-green-text { color: #4CAF50; }

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

        /* Dashboard Styles */
        .stat-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .order-status-pending {
            background: #fef3c7;
            color: #d97706;
        }
        .order-status-completed {
            background: #d1fae5;
            color: #065f46;
        }
        .order-status-shipped {
            background: #dbeafe;
            color: #1e40af;
        }
        .order-status-cancelled {
            background: #fee2e2;
            color: #dc2626;
        }
        .nav-tab {
            transition: all 0.3s ease;
        }
        .nav-tab.active {
            background: #008000;
            color: white;
            border-bottom: 3px solid #FFD700;
        }

        /* Mobile Tabs */
        .mobile-tab {
            flex: 1;
            min-width: 0;
            padding: 12px 8px;
            font-size: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .mobile-tab.active {
            color: #008000;
            border-bottom: 2px solid #008000;
        }
        .mobile-tab i {
            margin-bottom: 4px;
            font-size: 16px;
        }

        /* Scrollbar hiding */
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        /* Bottom Navigation Styles */
        .fixed.bottom-0 {
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }
        .dark .fixed.bottom-0 {
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.3);
        }
        /* Ensure content doesn't get hidden behind bottom nav */
        @media (max-width: 1024px) {
            body {
                padding-bottom: 4rem;
            }
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-300">
    @yield('contents')
</body>
</html>