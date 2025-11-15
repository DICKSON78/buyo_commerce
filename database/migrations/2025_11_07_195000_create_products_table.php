<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('seller_id')->nullable(false);
            $table->unsignedBigInteger('category_id')->nullable(false);
            $table->string('name', 255)->nullable(false);
            $table->string('name_sw', 255)->nullable();
            $table->string('slug', 255)->unique()->nullable(false);
            $table->text('description')->nullable();
            $table->text('description_sw')->nullable();
            $table->decimal('price', 10, 2)->nullable(false);
            $table->decimal('compare_price', 10, 2)->nullable();
            $table->integer('quantity')->default(1);
            $table->string('sku', 100)->nullable();
            $table->enum('condition', ['new', 'used', 'refurbished'])->default('new');
            $table->enum('status', ['draft', 'active', 'inactive', 'sold'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_approved')->default(false);
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->integer('view_count')->default(0);
            $table->string('location', 255)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
            $table->foreign('seller_id')->references('user_id')->on('seller_profiles')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('restrict');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
