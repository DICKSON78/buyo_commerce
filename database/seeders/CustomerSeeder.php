<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'username' => 'john_doe',
                'email' => 'john@example.com',
                'phone' => '255712345001',
                'full_name' => 'John Doe',
                'location' => 'Dar es Salaam',
                'region' => 'Dar es Salaam',
            ],
            [
                'username' => 'mary_smith',
                'email' => 'mary@example.com',
                'phone' => '255712345002',
                'full_name' => 'Mary Smith',
                'location' => 'Arusha',
                'region' => 'Arusha',
            ],
            [
                'username' => 'david_wilson',
                'email' => 'david@example.com',
                'phone' => '255712345003',
                'full_name' => 'David Wilson',
                'location' => 'Mwanza',
                'region' => 'Mwanza',
            ],
            [
                'username' => 'sarah_johnson',
                'email' => 'sarah@example.com',
                'phone' => '255712345004',
                'full_name' => 'Sarah Johnson',
                'location' => 'Dodoma',
                'region' => 'Dodoma',
            ],
            [
                'username' => 'michael_brown',
                'email' => 'michael@example.com',
                'phone' => '255712345005',
                'full_name' => 'Michael Brown',
                'location' => 'Mbeya',
                'region' => 'Mbeya',
            ],
            [
                'username' => 'lisa_davis',
                'email' => 'lisa@example.com',
                'phone' => '255712345006',
                'full_name' => 'Lisa Davis',
                'location' => 'Morogoro',
                'region' => 'Morogoro',
            ],
            [
                'username' => 'robert_miller',
                'email' => 'robert@example.com',
                'phone' => '255712345007',
                'full_name' => 'Robert Miller',
                'location' => 'Tanga',
                'region' => 'Tanga',
            ],
            [
                'username' => 'emma_wilson',
                'email' => 'emma@example.com',
                'phone' => '255712345008',
                'full_name' => 'Emma Wilson',
                'location' => 'Moshi',
                'region' => 'Kilimanjaro',
            ],
            [
                'username' => 'james_taylor',
                'email' => 'james@example.com',
                'phone' => '255712345009',
                'full_name' => 'James Taylor',
                'location' => 'Iringa',
                'region' => 'Iringa',
            ],
            [
                'username' => 'sophia_anderson',
                'email' => 'sophia@example.com',
                'phone' => '255712345010',
                'full_name' => 'Sophia Anderson',
                'location' => 'Songea',
                'region' => 'Ruvuma',
            ],
            [
                'username' => 'daniel_thomas',
                'email' => 'daniel@example.com',
                'phone' => '255712345011',
                'full_name' => 'Daniel Thomas',
                'location' => 'Shinyanga',
                'region' => 'Shinyanga',
            ],
            [
                'username' => 'olivia_martin',
                'email' => 'olivia@example.com',
                'phone' => '255712345012',
                'full_name' => 'Olivia Martin',
                'location' => 'Tabora',
                'region' => 'Tabora',
            ],
            [
                'username' => 'william_white',
                'email' => 'william@example.com',
                'phone' => '255712345013',
                'full_name' => 'William White',
                'location' => 'Kigoma',
                'region' => 'Kigoma',
            ],
            [
                'username' => 'ava_harris',
                'email' => 'ava@example.com',
                'phone' => '255712345014',
                'full_name' => 'Ava Harris',
                'location' => 'Lindi',
                'region' => 'Lindi',
            ],
            [
                'username' => 'benjamin_clark',
                'email' => 'benjamin@example.com',
                'phone' => '255712345015',
                'full_name' => 'Benjamin Clark',
                'location' => 'Mtwara',
                'region' => 'Mtwara',
            ],
            [
                'username' => 'charlotte_lewis',
                'email' => 'charlotte@example.com',
                'phone' => '255712345016',
                'full_name' => 'Charlotte Lewis',
                'location' => 'Bukoba',
                'region' => 'Kagera',
            ],
            [
                'username' => 'henry_walker',
                'email' => 'henry@example.com',
                'phone' => '255712345017',
                'full_name' => 'Henry Walker',
                'location' => 'Sumbawanga',
                'region' => 'Rukwa',
            ],
            [
                'username' => 'amelia_young',
                'email' => 'amelia@example.com',
                'phone' => '255712345018',
                'full_name' => 'Amelia Young',
                'location' => 'Singida',
                'region' => 'Singida',
            ],
            [
                'username' => 'alexander_king',
                'email' => 'alexander@example.com',
                'phone' => '255712345019',
                'full_name' => 'Alexander King',
                'location' => 'Musoma',
                'region' => 'Mara',
            ],
            [
                'username' => 'mia_scott',
                'email' => 'mia@example.com',
                'phone' => '255712345020',
                'full_name' => 'Mia Scott',
                'location' => 'Babati',
                'region' => 'Manyara',
            ]
        ];

        foreach ($customers as $customerData) {
            $user = User::create([
                'username' => $customerData['username'],
                'email' => $customerData['email'],
                'phone' => $customerData['phone'],
                'phone_country_code' => '+255',
                'phone_number' => $customerData['phone'],
                'password' => Hash::make('password'),
                'user_type' => 'customer',
                'full_name' => $customerData['full_name'],
                'location' => $customerData['location'],
                'region' => $customerData['region'],
                'terms_accepted' => true,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Customer::create([
                'id' => $user->id,
                'full_name' => $customerData['full_name'],
                'email' => $customerData['email'],
                'phone' => $customerData['phone'],
                'location' => $customerData['location'],
                'region' => $customerData['region'],
                'country' => 'Tanzania',
                'total_orders' => rand(0, 50),
                'total_spent' => rand(0, 5000000),
                'pending_orders' => rand(0, 5),
                'completed_orders' => rand(0, 30),
                'cancelled_orders' => rand(0, 5),
                'support_tickets' => rand(0, 10),
                'profile_completion' => rand(50, 100),
                'last_login_at' => now(),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('20 customers created successfully!');
    }
}