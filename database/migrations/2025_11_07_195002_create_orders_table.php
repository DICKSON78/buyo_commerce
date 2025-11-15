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
        Schema::create('orders', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();

            // Rejea kwa mtumiaji anayeagiza (mnunuzi)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('restrict');

            $table->string('order_number')->unique();
            $table->string('status')->default('pending'); // pending, processing, completed, cancelled

            $table->decimal('total_amount', 10, 2);
            $table->decimal('shipping_fee', 8, 2)->default(0.00);
            $table->decimal('tax_amount', 8, 2)->default(0.00);

            // Anwani ya Usafirishaji
            $table->string('shipping_address_line1');
            $table->string('shipping_address_line2')->nullable();
            $table->string('shipping_city');
            $table->string('shipping_country');
            $table->string('shipping_zip_code');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
