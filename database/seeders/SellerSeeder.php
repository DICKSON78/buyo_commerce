<?php

namespace Database\Seeders;

use App\Models\Seller;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SellerSeeder extends Seeder
{
    public function run(): void
    {
        $sellers = [
            [
                'username' => 'tech_master',
                'email' => 'tech@example.com',
                'phone' => '255712345101',
                'full_name' => 'Tech Master Owner',
                'store_name' => 'Tech Master Tanzania',
                'store_description' => 'Your trusted electronics and gadgets dealer',
                'business_place' => 'Dar es Salaam',
                'business_region' => 'Dar es Salaam',
            ],
            [
                'username' => 'fashion_king',
                'email' => 'fashion@example.com',
                'phone' => '255712345102',
                'full_name' => 'Fashion King Owner',
                'store_name' => 'Fashion King Boutique',
                'store_description' => 'Latest fashion trends for men and women',
                'business_place' => 'Arusha',
                'business_region' => 'Arusha',
            ],
            [
                'username' => 'farm_expert',
                'email' => 'farm@example.com',
                'phone' => '255712345103',
                'full_name' => 'Farm Expert Owner',
                'store_name' => 'Farm Expert Supplies',
                'store_description' => 'Quality agricultural equipment and tools',
                'business_place' => 'Morogoro',
                'business_region' => 'Morogoro',
            ],
            [
                'username' => 'home_decor',
                'email' => 'home@example.com',
                'phone' => '255712345104',
                'full_name' => 'Home Decor Owner',
                'store_name' => 'Home Decor Solutions',
                'store_description' => 'Beautiful furniture and home accessories',
                'business_place' => 'Mwanza',
                'business_region' => 'Mwanza',
            ],
            [
                'username' => 'auto_parts',
                'email' => 'auto@example.com',
                'phone' => '255712345105',
                'full_name' => 'Auto Parts Owner',
                'store_name' => 'Auto Parts Hub',
                'store_description' => 'Genuine spare parts for all vehicles',
                'business_place' => 'Dar es Salaam',
                'business_region' => 'Dar es Salaam',
            ],
            [
                'username' => 'beauty_shop',
                'email' => 'beauty@example.com',
                'phone' => '255712345106',
                'full_name' => 'Beauty Shop Owner',
                'store_name' => 'Beauty Shop Tanzania',
                'store_description' => 'Premium beauty and skincare products',
                'business_place' => 'Dodoma',
                'business_region' => 'Dodoma',
            ],
            [
                'username' => 'sports_gear',
                'email' => 'sports@example.com',
                'phone' => '255712345107',
                'full_name' => 'Sports Gear Owner',
                'store_name' => 'Sports Gear Center',
                'store_description' => 'Sports equipment and fitness gear',
                'business_place' => 'Mbeya',
                'business_region' => 'Mbeya',
            ],
            [
                'username' => 'book_store',
                'email' => 'books@example.com',
                'phone' => '255712345108',
                'full_name' => 'Book Store Owner',
                'store_name' => 'Book Store Tanzania',
                'store_description' => 'Educational books and learning materials',
                'business_place' => 'Tanga',
                'business_region' => 'Tanga',
            ],
            [
                'username' => 'phone_center',
                'email' => 'phones@example.com',
                'phone' => '255712345109',
                'full_name' => 'Phone Center Owner',
                'store_name' => 'Phone Center Ltd',
                'store_description' => 'Smartphones and mobile accessories',
                'business_place' => 'Moshi',
                'business_region' => 'Kilimanjaro',
            ],
            [
                'username' => 'kitchen_world',
                'email' => 'kitchen@example.com',
                'phone' => '255712345110',
                'full_name' => 'Kitchen World Owner',
                'store_name' => 'Kitchen World Tanzania',
                'store_description' => 'Kitchen appliances and utensils',
                'business_place' => 'Iringa',
                'business_region' => 'Iringa',
            ],
            [
                'username' => 'construction_mart',
                'email' => 'construction@example.com',
                'phone' => '255712345111',
                'full_name' => 'Construction Mart Owner',
                'store_name' => 'Construction Mart',
                'store_description' => 'Building materials and tools',
                'business_place' => 'Songea',
                'business_region' => 'Ruvuma',
            ],
            [
                'username' => 'jewelry_spot',
                'email' => 'jewelry@example.com',
                'phone' => '255712345112',
                'full_name' => 'Jewelry Spot Owner',
                'store_name' => 'Jewelry Spot',
                'store_description' => 'Beautiful jewelry and accessories',
                'business_place' => 'Shinyanga',
                'business_region' => 'Shinyanga',
            ],
            [
                'username' => 'computer_tech',
                'email' => 'computer@example.com',
                'phone' => '255712345113',
                'full_name' => 'Computer Tech Owner',
                'store_name' => 'Computer Tech Solutions',
                'store_description' => 'Computers and IT equipment',
                'business_place' => 'Tabora',
                'business_region' => 'Tabora',
            ],
            [
                'username' => 'health_pharmacy',
                'email' => 'pharmacy@example.com',
                'phone' => '255712345114',
                'full_name' => 'Health Pharmacy Owner',
                'store_name' => 'Health Pharmacy',
                'store_description' => 'Medicines and healthcare products',
                'business_place' => 'Kigoma',
                'business_region' => 'Kigoma',
            ],
            [
                'username' => 'fish_market',
                'email' => 'fish@example.com',
                'phone' => '255712345115',
                'full_name' => 'Fish Market Owner',
                'store_name' => 'Fresh Fish Market',
                'store_description' => 'Fresh fish and seafood products',
                'business_place' => 'Lindi',
                'business_region' => 'Lindi',
            ],
            [
                'username' => 'furniture_house',
                'email' => 'furniture@example.com',
                'phone' => '255712345116',
                'full_name' => 'Furniture House Owner',
                'store_name' => 'Furniture House Ltd',
                'store_description' => 'Quality furniture for home and office',
                'business_place' => 'Mtwara',
                'business_region' => 'Mtwara',
            ],
            [
                'username' => 'electronic_world',
                'email' => 'electronic@example.com',
                'phone' => '255712345117',
                'full_name' => 'Electronic World Owner',
                'store_name' => 'Electronic World',
                'store_description' => 'All types of electronics and gadgets',
                'business_place' => 'Bukoba',
                'business_region' => 'Kagera',
            ],
            [
                'username' => 'fashion_queen',
                'email' => 'fashionq@example.com',
                'phone' => '255712345118',
                'full_name' => 'Fashion Queen Owner',
                'store_name' => 'Fashion Queen Boutique',
                'store_description' => 'Women fashion and accessories',
                'business_place' => 'Sumbawanga',
                'business_region' => 'Rukwa',
            ],
            [
                'username' => 'hardware_store',
                'email' => 'hardware@example.com',
                'phone' => '255712345119',
                'full_name' => 'Hardware Store Owner',
                'store_name' => 'Hardware Store Tanzania',
                'store_description' => 'Tools and hardware equipment',
                'business_place' => 'Singida',
                'business_region' => 'Singida',
            ],
            [
                'username' => 'cosmetic_shop',
                'email' => 'cosmetic@example.com',
                'phone' => '255712345120',
                'full_name' => 'Cosmetic Shop Owner',
                'store_name' => 'Cosmetic Shop',
                'store_description' => 'Beauty and cosmetic products',
                'business_place' => 'Musoma',
                'business_region' => 'Mara',
            ]
        ];

        foreach ($sellers as $sellerData) {
            $user = User::create([
                'username' => $sellerData['username'],
                'email' => $sellerData['email'],
                'phone' => $sellerData['phone'],
                'phone_country_code' => '+255',
                'phone_number' => $sellerData['phone'],
                'password' => Hash::make('password'),
                'user_type' => 'seller',
                'full_name' => $sellerData['full_name'],
                'location' => $sellerData['business_place'],
                'region' => $sellerData['business_region'],
                'terms_accepted' => true,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $seller = Seller::create([
                'user_id' => $user->id,
                'store_name' => $sellerData['store_name'],
                'store_description' => $sellerData['store_description'],
                'business_place' => $sellerData['business_place'],
                'business_region' => $sellerData['business_region'],
                'is_verified' => true,
                'is_active' => true,
                'rating' => rand(35, 50) / 10, // 3.5 to 5.0
                'total_sales' => rand(10, 300),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            SellerProfile::create([
                'user_id' => $user->id,
                'shop_name' => $sellerData['store_name'],
                'description' => $sellerData['store_description'],
                'contact_number' => $sellerData['phone'],
                'address' => $sellerData['business_place'] . ', ' . $sellerData['business_region'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('20 sellers created successfully!');
    }
}