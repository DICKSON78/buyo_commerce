<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 50)->unique()->nullable(false);
            $table->unsignedBigInteger('buyer_id')->nullable(false);
            $table->unsignedBigInteger('seller_id')->nullable(false);
            $table->unsignedBigInteger('product_id')->nullable(false);
            $table->integer('quantity')->nullable(false);
            $table->decimal('unit_price', 10, 2)->nullable(false);
            $table->decimal('total_price', 10, 2)->nullable(false);
            $table->enum('status', ['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->text('buyer_note')->nullable();
            $table->text('seller_note')->nullable();
            $table->enum('cancelled_by', ['buyer', 'seller', 'admin'])->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();
            $table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
