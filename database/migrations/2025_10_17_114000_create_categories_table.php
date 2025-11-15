<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        // Hili ndilo jedwali la kategoria za bidhaa.
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->string('color')->default('#008000');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('product_count')->default(0);

            // Foreign key ya kujirejea yenyewe kwa kategoria mama (nested categories)
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('categories') // Inajirejea kwenye jedwali hili hili
                  ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('categories');
    }
};
