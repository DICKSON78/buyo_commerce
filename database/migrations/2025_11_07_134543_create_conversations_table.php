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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();

            // Meza ya mazungumzo inahitaji watumiaji wawili (mfumo huu unajengwa kwa ajili ya muuzaji na mnunuzi).
            // user_id ndiye anayeanzisha mazungumzo (mnunuzi)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // seller_user_id ni mtumiaji anayewakilisha muuzaji (lazima pia awe kwenye meza ya users)
            $table->foreignId('seller_user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Hii inahakikisha kuna conversation moja tu kati ya mnunuzi na muuzaji husika.
            $table->unique(['user_id', 'seller_user_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
