<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    public function run()
    {
        $regions = [
            ['name' => 'Arusha', 'capital' => 'Arusha', 'population' => 2000000, 'area' => 36720],
            ['name' => 'Dar es Salaam', 'capital' => 'Dar es Salaam', 'population' => 6000000, 'area' => 1393],
            ['name' => 'Dodoma', 'capital' => 'Dodoma', 'population' => 3000000, 'area' => 41311],
            ['name' => 'Geita', 'capital' => 'Geita', 'population' => 2000000, 'area' => 20054],
            ['name' => 'Iringa', 'capital' => 'Iringa', 'population' => 1000000, 'area' => 35865],
            ['name' => 'Kagera', 'capital' => 'Bukoba', 'population' => 3000000, 'area' => 39566],
            ['name' => 'Katavi', 'capital' => 'Mpanda', 'population' => 600000, 'area' => 45843],
            ['name' => 'Kigoma', 'capital' => 'Kigoma', 'population' => 2500000, 'area' => 45066],
            ['name' => 'Kilimanjaro', 'capital' => 'Moshi', 'population' => 2000000, 'area' => 13309],
            ['name' => 'Lindi', 'capital' => 'Lindi', 'population' => 1000000, 'area' => 67000],
            ['name' => 'Manyara', 'capital' => 'Babati', 'population' => 1500000, 'area' => 47913],
            ['name' => 'Mara', 'capital' => 'Musoma', 'population' => 2000000, 'area' => 30782],
            ['name' => 'Mbeya', 'capital' => 'Mbeya', 'population' => 3000000, 'area' => 62000],
            ['name' => 'Morogoro', 'capital' => 'Morogoro', 'population' => 3000000, 'area' => 70799],
            ['name' => 'Mtwara', 'capital' => 'Mtwara', 'population' => 1500000, 'area' => 16707],
            ['name' => 'Mwanza', 'capital' => 'Mwanza', 'population' => 3500000, 'area' => 35000],
            ['name' => 'Njombe', 'capital' => 'Njombe', 'population' => 800000, 'area' => 21347],
            ['name' => 'Pemba North', 'capital' => 'Wete', 'population' => 250000, 'area' => 574],
            ['name' => 'Pemba South', 'capital' => 'Chake Chake', 'population' => 200000, 'area' => 332],
            ['name' => 'Pwani', 'capital' => 'Kibaha', 'population' => 1200000, 'area' => 32407],
            ['name' => 'Rukwa', 'capital' => 'Sumbawanga', 'population' => 1500000, 'area' => 75400],
            ['name' => 'Ruvuma', 'capital' => 'Songea', 'population' => 1600000, 'area' => 63498],
            ['name' => 'Shinyanga', 'capital' => 'Shinyanga', 'population' => 2000000, 'area' => 50781],
            ['name' => 'Simiyu', 'capital' => 'Bariadi', 'population' => 2000000, 'area' => 25812],
            ['name' => 'Singida', 'capital' => 'Singida', 'population' => 1500000, 'area' => 49341],
            ['name' => 'Songwe', 'capital' => 'Vwawa', 'population' => 1000000, 'area' => 27656],
            ['name' => 'Tabora', 'capital' => 'Tabora', 'population' => 3000000, 'area' => 76151],
            ['name' => 'Tanga', 'capital' => 'Tanga', 'population' => 2500000, 'area' => 26808],
            ['name' => 'Zanzibar North', 'capital' => 'Mkokotoni', 'population' => 250000, 'area' => 470],
            ['name' => 'Zanzibar South', 'capital' => 'Koani', 'population' => 150000, 'area' => 854],
            ['name' => 'Zanzibar West', 'capital' => 'Zanzibar City', 'population' => 700000, 'area' => 230],
        ];

        foreach ($regions as $region) {
            DB::table('regions')->insert([
                'name' => $region['name'],
                'capital' => $region['capital'],
                'population' => $region['population'],
                'area' => $region['area'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
