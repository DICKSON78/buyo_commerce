<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seller_profiles', function (Blueprint $table) {
            $table->id();

            // Hii inahitajika kuwa unique ili meza nyingine (kama products)
            // iweze kurejelea hii user_id badala ya profile 'id'.
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade')
                  ->unique(); // FIX KUU YA ERRNO 150

            $table->string('shop_name');
            $table->text('description')->nullable();
            $table->string('contact_number')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_profiles');
    }
};
