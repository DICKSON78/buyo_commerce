<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics', 'icon' => 'mobile-alt', 'color' => '#008000'],
            ['name' => 'Fashion', 'slug' => 'fashion', 'icon' => 'tshirt', 'color' => '#FF6B6B'],
            ['name' => 'Home & Garden', 'slug' => 'home-garden', 'icon' => 'home', 'color' => '#4ECDC4'],
            ['name' => 'Vehicles', 'slug' => 'vehicles', 'icon' => 'car', 'color' => '#45B7D1'],
            ['name' => 'Real Estate', 'slug' => 'real-estate', 'icon' => 'building', 'color' => '#FFA500'],
            ['name' => 'Jobs & Services', 'slug' => 'jobs-services', 'icon' => 'briefcase', 'color' => '#9B59B6'],
            ['name' => 'Agriculture', 'slug' => 'agriculture', 'icon' => 'tractor', 'color' => '#27AE60'],
            ['name' => 'Beauty & Health', 'slug' => 'beauty-health', 'icon' => 'spa', 'color' => '#E74C3C'],
            ['name' => 'Sports & Entertainment', 'slug' => 'sports-entertainment', 'icon' => 'futbol', 'color' => '#3498DB'],
            ['name' => 'Education', 'slug' => 'education', 'icon' => 'graduation-cap', 'color' => '#8E44AD'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'icon' => $category['icon'],
                'color' => $category['color'],
                'description' => $category['name'] . ' products and services',
                'is_active' => true,
                'product_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Categories created successfully!');
    }
}