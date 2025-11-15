<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Mikoa ya Tanzania Bara na Visiwani
        DB::table('regions')->insert([
            // Tanzania Bara
            ['name' => 'Arusha', 'capital' => 'Arusha', 'population' => 2000000, 'area' => 36720.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dar es Salaam', 'capital' => 'Dar es Salaam', 'population' => 6000000, 'area' => 1393.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dodoma', 'capital' => 'Dodoma', 'population' => 3000000, 'area' => 41311.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Geita', 'capital' => 'Geita', 'population' => 2000000, 'area' => 20054.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Iringa', 'capital' => 'Iringa', 'population' => 1000000, 'area' => 35865.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kagera', 'capital' => 'Bukoba', 'population' => 3000000, 'area' => 39566.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Katavi', 'capital' => 'Mpanda', 'population' => 600000, 'area' => 45843.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kigoma', 'capital' => 'Kigoma', 'population' => 2500000, 'area' => 45066.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kilimanjaro', 'capital' => 'Moshi', 'population' => 2000000, 'area' => 13309.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lindi', 'capital' => 'Lindi', 'population' => 1000000, 'area' => 67000.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Manyara', 'capital' => 'Babati', 'population' => 1500000, 'area' => 47913.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mara', 'capital' => 'Musoma', 'population' => 2000000, 'area' => 30782.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mbeya', 'capital' => 'Mbeya', 'population' => 3000000, 'area' => 62000.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Morogoro', 'capital' => 'Morogoro', 'population' => 3000000, 'area' => 70799.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mtwara', 'capital' => 'Mtwara', 'population' => 1500000, 'area' => 16707.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mwanza', 'capital' => 'Mwanza', 'population' => 3500000, 'area' => 35000.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Njombe', 'capital' => 'Njombe', 'population' => 800000, 'area' => 21347.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pwani', 'capital' => 'Kibaha', 'population' => 1200000, 'area' => 32407.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Rukwa', 'capital' => 'Sumbawanga', 'population' => 1500000, 'area' => 75400.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ruvuma', 'capital' => 'Songea', 'population' => 1600000, 'area' => 63498.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Shinyanga', 'capital' => 'Shinyanga', 'population' => 2000000, 'area' => 50781.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Simiyu', 'capital' => 'Bariadi', 'population' => 2000000, 'area' => 25812.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Singida', 'capital' => 'Singida', 'population' => 1500000, 'area' => 49341.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Songwe', 'capital' => 'Vwawa', 'population' => 1000000, 'area' => 27656.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tabora', 'capital' => 'Tabora', 'population' => 3000000, 'area' => 76151.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tanga', 'capital' => 'Tanga', 'population' => 2500000, 'area' => 26808.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            
            // Visiwani
            ['name' => 'Pemba North', 'capital' => 'Wete', 'population' => 250000, 'area' => 574.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pemba South', 'capital' => 'Chake Chake', 'population' => 200000, 'area' => 332.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Zanzibar North', 'capital' => 'Mkokotoni', 'population' => 250000, 'area' => 470.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Zanzibar South', 'capital' => 'Koani', 'population' => 150000, 'area' => 854.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Zanzibar West', 'capital' => 'Zanzibar City', 'population' => 700000, 'area' => 230.00, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 2. Categories za Ecommerce na Events
        DB::table('categories')->insert([
            // Electronics
            ['name' => 'Electronics', 'slug' => 'electronics', 'icon' => '📱', 'color' => '#FF6B6B', 'description' => 'Electronic devices and accessories', 'is_active' => 1, 'product_count' => 0, 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Smartphones', 'slug' => 'smartphones', 'icon' => '📱', 'color' => '#4ECDC4', 'description' => 'Mobile phones and smartphones', 'is_active' => 1, 'product_count' => 0, 'parent_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Laptops', 'slug' => 'laptops', 'icon' => '💻', 'color' => '#45B7D1', 'description' => 'Laptops and computers', 'is_active' => 1, 'product_count' => 0, 'parent_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Accessories', 'slug' => 'electronics-accessories', 'icon' => '🎧', 'color' => '#96CEB4', 'description' => 'Electronic accessories', 'is_active' => 1, 'product_count' => 0, 'parent_id' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Fashion
            ['name' => 'Fashion', 'slug' => 'fashion', 'icon' => '👗', 'color' => '#FECA57', 'description' => 'Clothing and fashion items', 'is_active' => 1, 'product_count' => 0, 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Men's Clothing", 'slug' => 'mens-clothing', 'icon' => '👔', 'color' => '#54A0FF', 'description' => 'Clothing for men', 'is_active' => 1, 'product_count' => 0, 'parent_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['name' => "Women's Clothing", 'slug' => 'womens-clothing', 'icon' => '👗', 'color' => '#FF9FF3', 'description' => 'Clothing for women', 'is_active' => 1, 'product_count' => 0, 'parent_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Shoes', 'slug' => 'shoes', 'icon' => '👟', 'color' => '#F368E0', 'description' => 'Footwear for all occasions', 'is_active' => 1, 'product_count' => 0, 'parent_id' => 5, 'created_at' => now(), 'updated_at' => now()],

            // Home & Garden
            ['name' => 'Home & Garden', 'slug' => 'home-garden', 'icon' => '🏠', 'color' => '#00D2D3', 'description' => 'Home and garden products', 'is_active' => 1, 'product_count' => 0, 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Furniture', 'slug' => 'furniture', 'icon' => '🛋️', 'color' => '#5F27CD', 'description' => 'Home and office furniture', 'is_active' => 1, 'product_count' => 0, 'parent_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kitchenware', 'slug' => 'kitchenware', 'icon' => '🍳', 'color' => '#FF9F43', 'description' => 'Kitchen utensils and appliances', 'is_active' => 1, 'product_count' => 0, 'parent_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Garden Tools', 'slug' => 'garden-tools', 'icon' => '🌿', 'color' => '#10AC84', 'description' => 'Gardening equipment and tools', 'is_active' => 1, 'product_count' => 0, 'parent_id' => 9, 'created_at' => now(), 'updated_at' => now()],

            // Sports & Outdoors
            ['name' => 'Sports & Outdoors', 'slug' => 'sports-outdoors', 'icon' => '⚽', 'color' => '#EE5A24', 'description' => 'Sports equipment and outdoor gear', 'is_active' => 1, 'product_count' => 0, 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fitness Equipment', 'slug' => 'fitness-equipment', 'icon' => '💪', 'color' => '#C4E538', 'description' => 'Exercise and fitness equipment', 'is_active' => 1, 'product_count' => 0, 'parent_id' => 13, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Camping Gear', 'slug' => 'camping-gear', 'icon' => '⛺', 'color' => '#FDA7DF', 'description' => 'Camping and outdoor equipment', 'is_active' => 1, 'product_count' => 0, 'parent_id' => 13, 'created_at' => now(), 'updated_at' => now()],

            // Events & Tickets
            ['name' => 'Events & Tickets', 'slug' => 'events-tickets', 'icon' => '🎫', 'color' => '#9980FA', 'description' => 'Event tickets and reservations', 'is_active' => 1, 'product_count' => 0, 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Concerts', 'slug' => 'concert-tickets', 'icon' => '🎵', 'color' => '#ED4C67', 'description' => 'Music concert tickets', 'is_active' => 1, 'product_count' => 0, 'parent_id' => 16, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sports Events', 'slug' => 'sports-events', 'icon' => '🏀', 'color' => '#0652DD', 'description' => 'Sports event tickets', 'is_active' => 1, 'product_count' => 0, 'parent_id' => 16, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Conferences', 'slug' => 'conference-tickets', 'icon' => '🎤', 'color' => '#006266', 'description' => 'Conference and seminar tickets', 'is_active' => 1, 'product_count' => 0, 'parent_id' => 16, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Festivals', 'slug' => 'festival-tickets', 'icon' => '🎪', 'color' => '#EA2027', 'description' => 'Cultural festival tickets', 'is_active' => 1, 'product_count' => 0, 'parent_id' => 16, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Theater & Shows', 'slug' => 'theater-shows', 'icon' => '🎭', 'color' => '#A3CB38', 'description' => 'Theater and performance tickets', 'is_active' => 1, 'product_count' => 0, 'parent_id' => 16, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 3. Users (20 Customers + 20 Sellers)
        $users = [];
        $customers = [];
        $sellers = [];
        $sellerProfiles = [];

        // Create 20 Customers
        for ($i = 1; $i <= 20; $i++) {
            $username = "customer{$i}";
            $email = "customer{$i}@gmail.com";
            
            $users[] = [
                'username' => $username,
                'email' => $email,
                'phone' => "2557" . sprintf('%08d', $i),
                'phone_country_code' => '+255',
                'phone_number' => "2557" . sprintf('%08d', $i),
                'password' => Hash::make('password'),
                'user_type' => 'customer',
                'full_name' => "Customer User {$i}",
                'date_of_birth' => Carbon::now()->subYears(rand(18, 50))->subDays(rand(1, 365)),
                'gender' => rand(0, 1) ? 'male' : 'female',
                'location' => 'Dar es Salaam',
                'region' => 'Dar es Salaam',
                'terms_accepted' => 1,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $customers[] = [
                'full_name' => "Customer User {$i}",
                'email' => $email,
                'phone' => "2557" . sprintf('%08d', $i),
                'date_of_birth' => Carbon::now()->subYears(rand(18, 50))->subDays(rand(1, 365)),
                'gender' => rand(0, 1) ? 'male' : 'female',
                'location' => 'Dar es Salaam',
                'region' => 'Dar es Salaam',
                'address' => "Street {$i}, Dar es Salaam",
                'city' => 'Dar es Salaam',
                'country' => 'Tanzania',
                'total_orders' => rand(0, 50),
                'total_spent' => rand(10000, 500000),
                'pending_orders' => rand(0, 5),
                'completed_orders' => rand(5, 45),
                'cancelled_orders' => rand(0, 3),
                'support_tickets' => rand(0, 10),
                'preferred_payment_method' => ['M-Pesa', 'Airtel Money', 'Tigo Pesa', 'Card'][rand(0, 3)],
                'preferred_shipping_method' => ['Standard', 'Express', 'Pickup'][rand(0, 2)],
                'newsletter_subscribed' => rand(0, 1),
                'marketing_emails' => rand(0, 1),
                'sms_notifications' => 1,
                'profile_completion' => rand(50, 100),
                'last_login_at' => now()->subDays(rand(0, 30)),
                'email_verified_at' => now(),
                'profile_picture' => null,
                'bio' => "I am customer {$i} from Tanzania",
                'preferences' => json_encode(['theme' => 'light', 'language' => 'en']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Create 20 Sellers
        for ($i = 1; $i <= 20; $i++) {
            $username = "seller{$i}";
            $email = "seller{$i}@gmail.com";
            $region = ['Dar es Salaam', 'Arusha', 'Mwanza', 'Mbeya', 'Dodoma'][rand(0, 4)];
            
            $users[] = [
                'username' => $username,
                'email' => $email,
                'phone' => "2556" . sprintf('%08d', $i),
                'phone_country_code' => '+255',
                'phone_number' => "2556" . sprintf('%08d', $i),
                'password' => Hash::make('password'),
                'user_type' => 'seller',
                'full_name' => "Seller User {$i}",
                'date_of_birth' => Carbon::now()->subYears(rand(22, 55))->subDays(rand(1, 365)),
                'gender' => rand(0, 1) ? 'male' : 'female',
                'location' => $region,
                'region' => $region,
                'terms_accepted' => 1,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $sellerUserId = 20 + $i; // User IDs start after customers
            
            $sellers[] = [
                'user_id' => $sellerUserId,
                'store_name' => "Seller {$i} Store",
                'store_description' => "Quality products from Seller {$i} in {$region}",
                'business_place' => $region,
                'business_region' => $region,
                'logo' => null,
                'banner' => null,
                'is_verified' => rand(0, 1),
                'is_active' => 1,
                'rating' => rand(30, 50) / 10,
                'total_sales' => rand(100, 5000),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $sellerProfiles[] = [
                'user_id' => $sellerUserId,
                'shop_name' => "Seller {$i} Shop",
                'description' => "Professional seller with quality products. Located in {$region}",
                'contact_number' => "2556" . sprintf('%08d', $i),
                'address' => "Shop {$i}, {$region}",
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert all data
        DB::table('users')->insert($users);
        DB::table('customers')->insert($customers);
        DB::table('sellers')->insert($sellers);
        DB::table('seller_profiles')->insert($sellerProfiles);

        // 4. Products (5 per seller = 100 products total)
        $products = [];
        $productImages = [];
        $productCounter = 1;

        $productNames = [
            'Smartphone', 'Laptop', 'Headphones', 'Smart Watch', 'Tablet',
            'T-Shirt', 'Jeans', 'Dress', 'Sneakers', 'Jacket',
            'Sofa', 'Dining Table', 'Bed', 'Wardrobe', 'Chair',
            'Blender', 'Microwave', 'Toaster', 'Coffee Maker', 'Cookware',
            'Football', 'Basketball', 'Tennis Racket', 'Yoga Mat', 'Dumbbells',
            'Concert Ticket', 'Sports Event Ticket', 'Conference Pass', 'Festival Ticket', 'Theater Ticket'
        ];

        foreach ($sellers as $seller) {
            for ($j = 1; $j <= 5; $j++) {
                $categoryId = rand(1, 21);
                $productName = $productNames[array_rand($productNames)] . " " . $productCounter;
                $slug = strtolower(str_replace(' ', '-', $productName));
                $price = rand(1000, 500000);
                $comparePrice = $price * 1.2;
                
                $products[] = [
                    'seller_id' => $seller['user_id'],
                    'category_id' => $categoryId,
                    'name' => $productName,
                    'name_sw' => $productName . " (Swahili)",
                    'slug' => $slug . '-' . $productCounter,
                    'description' => "High quality {$productName}. Perfect for everyday use.",
                    'description_sw' => "Bidhaa bora ya {$productName}. Inafaa kwa matumizi ya kila siku.",
                    'price' => $price,
                    'compare_price' => $comparePrice,
                    'quantity' => rand(1, 100),
                    'sku' => 'SKU' . sprintf('%06d', $productCounter),
                    'condition' => ['new', 'used', 'refurbished'][rand(0, 2)],
                    'status' => 'active',
                    'is_featured' => rand(0, 1),
                    'is_approved' => 1,
                    'approved_by' => 1,
                    'approved_at' => now(),
                    'view_count' => rand(0, 1000),
                    'location' => $seller['business_place'],
                    'latitude' => null,
                    'longitude' => null,
                    'created_at' => now()->subDays(rand(0, 90)),
                    'updated_at' => now(),
                ];

                // Add product images
                $productImages[] = [
                    'product_id' => $productCounter,
                    'image_path' => 'products/product-' . rand(1, 10) . '.jpg',
                    'is_primary' => 1,
                    'sort_order' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $productCounter++;
            }
        }

        DB::table('products')->insert($products);
        DB::table('product_images')->insert($productImages);

        // 5. Carts (Random products in customer carts)
        $carts = [];
        for ($i = 1; $i <= 20; $i++) {
            $cartItems = rand(1, 5);
            $usedProducts = [];
            
            for ($j = 0; $j < $cartItems; $j++) {
                $productId = rand(1, 100);
                while (in_array($productId, $usedProducts)) {
                    $productId = rand(1, 100);
                }
                $usedProducts[] = $productId;
                
                $product = $products[$productId - 1];
                
                $carts[] = [
                    'user_id' => $i, // Customer user IDs are 1-20
                    'product_id' => $productId,
                    'quantity' => rand(1, 3),
                    'price' => $product['price'],
                    'created_at' => now()->subDays(rand(0, 7)),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('carts')->insert($carts);

        // 6. Favorites (Random favorites for customers)
        $favorites = [];
        for ($i = 1; $i <= 20; $i++) {
            $favoriteCount = rand(3, 10);
            $usedProducts = [];
            
            for ($j = 0; $j < $favoriteCount; $j++) {
                $productId = rand(1, 100);
                while (in_array($productId, $usedProducts)) {
                    $productId = rand(1, 100);
                }
                $usedProducts[] = $productId;
                
                $favorites[] = [
                    'user_id' => $i,
                    'product_id' => $productId,
                    'created_at' => now()->subDays(rand(0, 30)),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('favorites')->insert($favorites);

        // 7. Orders and Order Items
        $orders = [];
        $orderItems = [];
        $orderHistories = [];
        $orderCounter = 1;

        for ($i = 1; $i <= 20; $i++) { // For each customer
            $orderCount = rand(2, 8);
            
            for ($j = 0; $j < $orderCount; $j++) {
                $totalAmount = 0;
                $orderItemsTemp = [];
                $itemCount = rand(1, 4);
                $usedProducts = [];
                
                for ($k = 0; $k < $itemCount; $k++) {
                    $productId = rand(1, 100);
                    while (in_array($productId, $usedProducts)) {
                        $productId = rand(1, 100);
                    }
                    $usedProducts[] = $productId;
                    
                    $product = $products[$productId - 1];
                    $quantity = rand(1, 3);
                    $itemTotal = $product['price'] * $quantity;
                    $totalAmount += $itemTotal;
                    
                    $orderItemsTemp[] = [
                        'order_id' => $orderCounter,
                        'product_id' => $productId,
                        'quantity' => $quantity,
                        'price' => $product['price'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                
                $shippingFee = rand(500, 5000);
                $taxAmount = $totalAmount * 0.18;
                $grandTotal = $totalAmount + $shippingFee + $taxAmount;
                
                $orders[] = [
                    'id' => $orderCounter,
                    'user_id' => $i,
                    'order_number' => 'ORD' . sprintf('%06d', $orderCounter),
                    'status' => ['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'][rand(0, 4)],
                    'total_amount' => $grandTotal,
                    'shipping_fee' => $shippingFee,
                    'tax_amount' => $taxAmount,
                    'shipping_address_line1' => "Street {$i}, House {$j}",
                    'shipping_address_line2' => "Near {$region} Market",
                    'shipping_city' => $region,
                    'shipping_country' => 'Tanzania',
                    'shipping_zip_code' => '10000',
                    'created_at' => now()->subDays(rand(1, 60)),
                    'updated_at' => now(),
                ];

                $orderItems = array_merge($orderItems, $orderItemsTemp);

                // Order History
                $orderHistories[] = [
                    'order_id' => $orderCounter,
                    'status' => 'pending',
                    'note' => 'Order placed successfully',
                    'created_by' => $i,
                    'created_at' => now()->subDays(rand(1, 60)),
                    'updated_at' => now(),
                ];

                $orderCounter++;
            }
        }

        DB::table('orders')->insert($orders);
        DB::table('order_items')->insert($orderItems);
        DB::table('order_histories')->insert($orderHistories);

        // 8. Conversations and Messages
        $conversations = [];
        $messages = [];
        $conversationCounter = 1;

        for ($i = 1; $i <= 10; $i++) { // 10 conversations
            $customerId = rand(1, 20);
            $sellerId = 20 + rand(1, 20); // Seller user IDs are 21-40
            
            $conversations[] = [
                'id' => $conversationCounter,
                'user_id' => $customerId,
                'seller_user_id' => $sellerId,
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now(),
            ];

            // Add 3-8 messages per conversation
            $messageCount = rand(3, 8);
            for ($j = 0; $j < $messageCount; $j++) {
                $isCustomer = $j % 2 == 0;
                $senderId = $isCustomer ? $customerId : $sellerId;
                
                $messages[] = [
                    'conversation_id' => $conversationCounter,
                    'user_id' => $senderId,
                    'content' => $isCustomer ? 
                        "Hello, I have a question about your product" : 
                        "Hello, how can I help you with our products?",
                    'read_at' => $j > 0 ? now()->subDays(rand(0, 2)) : null,
                    'created_at' => now()->subDays(rand(0, 30))->addMinutes($j * 5),
                    'updated_at' => now(),
                ];
            }

            $conversationCounter++;
        }

        DB::table('conversations')->insert($conversations);
        DB::table('messages')->insert($messages);

        // 9. Notifications
        $notifications = [];
        for ($i = 1; $i <= 50; $i++) {
            $userId = rand(1, 40); // Both customers and sellers
            $notifications[] = [
                'user_id' => $userId,
                'title' => 'System Notification ' . $i,
                'message' => 'This is a sample notification message for user ' . $userId,
                'type' => ['info', 'success', 'warning', 'error'][rand(0, 3)],
                'related_type' => ['order', 'message', 'product', 'system'][rand(0, 3)],
                'related_id' => rand(1, 100),
                'is_read' => rand(0, 1),
                'read_at' => rand(0, 1) ? now()->subDays(rand(0, 7)) : null,
                'created_at' => now()->subDays(rand(0, 30)),
                'updated_at' => now(),
            ];
        }

        DB::table('notifications')->insert($notifications);

        $this->command->info('Database seeded successfully with:');
        $this->command->info('- 31 Regions (Tanzania Bara na Visiwani)');
        $this->command->info('- 21 Categories (including Events & Tickets)');
        $this->command->info('- 40 Users (20 Customers + 20 Sellers)');
        $this->command->info('- 100 Products');
        $this->command->info('- Sample data for all related tables');
    }
}