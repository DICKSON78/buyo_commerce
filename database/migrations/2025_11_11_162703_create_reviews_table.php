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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $table->tinyInteger('rating')->unsigned()->default(1); // 1-5
            $table->text('comment')->nullable();
            $table->string('reviewer_name')->nullable();
            $table->string('reviewer_email')->nullable();
            $table->boolean('is_approved')->default(true);
            $table->timestamps();

            // Ensure a user can only review a product once
            $table->unique(['user_id', 'product_id']);

            // Indexes for better performance
            $table->index(['product_id', 'is_approved']);
            $table->index(['user_id', 'created_at']);
            $table->index(['rating', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};