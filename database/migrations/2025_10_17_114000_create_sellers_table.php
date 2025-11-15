<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('store_name');
            $table->text('store_description')->nullable();
            $table->string('business_place');
            $table->string('business_region');
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_active')->default(true);
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('total_sales')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('sellers');
    }
};