<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seller_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->string('store_name', 255)->nullable(false);
            $table->string('store_slug', 255)->unique()->nullable(false);
            $table->string('store_logo', 500)->nullable();
            $table->text('bio')->nullable();
            $table->string('contact_phone', 20)->nullable();
            $table->string('contact_email', 255)->nullable();
            $table->string('location', 255)->nullable();
            $table->text('address')->nullable();
            $table->enum('verified_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->integer('total_sales')->default(0);
            $table->timestamps(false);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seller_profiles');
    }
};
