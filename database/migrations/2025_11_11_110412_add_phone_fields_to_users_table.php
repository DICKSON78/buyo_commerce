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
        Schema::table('users', function (Blueprint $table) {
            // Add phone fields
            $table->string('phone_country_code')->default('+255')->after('phone');
            $table->string('phone_number')->nullable()->after('phone_country_code');
            
            // Make phone field nullable since we'll use phone_number
            $table->string('phone')->nullable()->change();
            
            // Index for better performance
            $table->index('phone_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone_country_code', 'phone_number']);
            $table->string('phone')->nullable(false)->change();
        });
    }
};