<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => '255' . $this->faker->numberBetween(700000000, 789999999),
            'phone_country_code' => '+255',
            'phone_number' => '255' . $this->faker->numberBetween(700000000, 789999999),
            'password' => Hash::make('password'),
            'user_type' => 'customer',
            'full_name' => $this->faker->name(),
            'date_of_birth' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'location' => $this->faker->city(),
            'region' => $this->faker->randomElement(['Dar es Salaam', 'Arusha', 'Mwanza', 'Dodoma', 'Mbeya', 'Morogoro', 'Tanga', 'Moshi']),
            'terms_accepted' => true,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function seller()
    {
        return $this->state(function (array $attributes) {
            return [
                'user_type' => 'seller',
            ];
        });
    }

    public function customer()
    {
        return $this->state(function (array $attributes) {
            return [
                'user_type' => 'customer',
            ];
        });
    }
}