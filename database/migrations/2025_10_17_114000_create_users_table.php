<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable(false);
            $table->string('email', 255)->unique()->nullable();
            $table->string('phone', 20)->unique()->nullable();
            $table->string('password', 255)->nullable(false);
            $table->enum('role', ['buyer', 'seller', 'admin'])->default('buyer');
            $table->string('avatar', 500)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->enum('language', ['en', 'sw'])->default('en');
            $table->timestamps(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
