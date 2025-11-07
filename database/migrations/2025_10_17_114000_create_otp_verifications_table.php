<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('otp_verifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('otp_code', 10)->nullable(false);
            $table->string('token', 255)->nullable(false);
            $table->enum('type', ['phone_verification', 'email_verification', 'password_reset'])->nullable(false);
            $table->boolean('is_used')->default(false);
            $table->timestamp('expires_at')->nullable(false);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('otp_verifications');
    }
};
