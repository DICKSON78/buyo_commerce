<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('seller_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained()->onDelete('cascade');
            $table->date('stat_date');
            $table->integer('orders_count')->default(0);
            $table->decimal('revenue', 12, 2)->default(0);
            $table->integer('products_added')->default(0);
            $table->integer('page_views')->default(0);
            $table->timestamps();

            $table->unique(['seller_id', 'stat_date']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('seller_stats');
    }
};
