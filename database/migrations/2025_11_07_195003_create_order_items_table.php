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
        // Meza hii inashikilia maelezo ya bidhaa zilizomo ndani ya order (agizo) moja.
        Schema::create('order_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();

            // Rejea kwa meza ya Orders (dependency: orders)
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->onDelete('cascade');

            // Rejea kwa meza ya Products (dependency: products)
           $table->foreignId('product_id')->constrained('products')->onDelete('cascade');


            $table->unsignedInteger('quantity');
            $table->decimal('price', 8, 2); // Bei ya bidhaa wakati wa kununua

            // Hii inazuia bidhaa hiyo hiyo kurudiwa kwenye agizo moja.
            $table->unique(['order_id', 'product_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
