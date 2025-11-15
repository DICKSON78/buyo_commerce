<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - Buyo</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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

        /* Messages Dropdown */
        .messages-dropdown {
            min-width: 320px;
            max-height: 400px;
            overflow-y: auto;
        }
        .message-item {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            cursor: pointer;
            transition: background 0.2s;
        }
        .dark .message-item {
            border-bottom-color: #4b5563;
        }
        .message-item:hover {
            background-color: #f8fafc;
        }
        .dark .message-item:hover {
            background-color: #374151;
        }
        .message-item.unread {
            background-color: #f0f9ff;
        }
        .dark .message-item.unread {
            background-color: #1e3a8a;
        }
        .message-sender {
            font-weight: 600;
            color: #1f2937;
        }
        .dark .message-sender {
            color: #f9fafb;
        }
        .message-preview {
            color: #6b7280;
            font-size: 0.875rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .dark .message-preview {
            color: #d1d5db;
        }
        .message-time {
            color: #9ca3af;
            font-size: 0.75rem;
        }

        /* Order Status Colors */
        .order-status-pending {
            background: #fef3c7;
            color: #d97706;
        }
        .order-status-processing {
            background: #dbeafe;
            color: #1e40af;
        }
        .order-status-shipped {
            background: #d1fae5;
            color: #065f46;
        }
        .order-status-delivered {
            background: #dcfce7;
            color: #166534;
        }
        .order-status-cancelled {
            background: #fee2e2;
            color: #dc2626;
        }
        .order-status-refunded {
            background: #f3e8ff;
            color: #7c3aed;
        }

        /* Payment Status */
        .payment-pending {
            background: #fef3c7;
            color: #d97706;
        }
        .payment-completed {
            background: #d1fae5;
            color: #065f46;
        }
        .payment-failed {
            background: #fee2e2;
            color: #dc2626;
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

        /* Progress Bar */
        .progress-bar {
            height: 6px;
            background: #e5e7eb;
            border-radius: 3px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background: #008000;
            transition: width 0.3s ease;
        }

        /* Receipt Styles */
        .receipt-container {
            background: white;
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 24px;
            max-width: 400px;
            margin: 0 auto;
        }
        .dark .receipt-container {
            background: #1f2937;
            border-color: #4b5563;
            color: #f9fafb;
        }
        .receipt-header {
            text-align: center;
            border-bottom: 2px solid #008000;
            padding-bottom: 16px;
            margin-bottom: 16px;
        }
        .receipt-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .dark .receipt-item {
            border-bottom-color: #4b5563;
        }
        .receipt-total {
            border-top: 2px solid #008000;
            font-weight: bold;
            font-size: 1.1em;
        }
        .dark .receipt-total {
            border-top-color: #4CAF50;
        }

        /* Chat Styles */
        .chat-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
        .chat-window {
            width: 380px;
            height: 500px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .dark .chat-window {
            background: #1f2937;
            color: #f9fafb;
        }
        .chat-header {
            background: #008000;
            color: white;
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .chat-messages {
            flex: 1;
            padding: 16px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .message {
            max-width: 80%;
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 8px;
        }
        .message.sent {
            background: #008000;
            color: white;
            align-self: flex-end;
            border-bottom-right-radius: 4px;
        }
        .message.received {
            background: #f3f4f6;
            color: #374151;
            align-self: flex-start;
            border-bottom-left-radius: 4px;
        }
        .dark .message.received {
            background: #374151;
            color: #f9fafb;
        }
        .chat-input {
            padding: 16px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            gap: 8px;
        }
        .dark .chat-input {
            border-top-color: #4b5563;
        }
        .chat-toggle {
            background: #008000;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        /* QR Code Container */
        .qr-container {
            text-align: center;
            padding: 16px;
            border-top: 1px solid #e5e7eb;
            margin-top: 16px;
        }
        .dark .qr-container {
            border-top-color: #4b5563;
        }
        .qr-code {
            width: 120px;
            height: 120px;
            background: #f3f4f6;
            margin: 0 auto 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }
        .dark .qr-code {
            background: #374151;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 20px;
        }
        .modal-content {
            background: white;
            border-radius: 12px;
            max-width: 500px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .dark .modal-content {
            background: #1f2937;
            color: #f9fafb;
        }
        .modal-header {
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: between;
            align-items: center;
        }
        .dark .modal-header {
            border-bottom-color: #4b5563;
        }
        .modal-body {
            padding: 20px;
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