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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('courier_id')->nullable()->constrained('couriers')->onDelete('cascade');
            $table->decimal('delivery_fee', 10, 2);
            $table->enum('delivery_status', ['assigned', 'on_delivery', 'delivered', 'cancelled'])->nullable();
            $table->text('address')->nullable(); // Add address column
            $table->decimal('latitude', 10, 8)->nullable(); // Add latitude column
            $table->decimal('longitude', 11, 8)->nullable(); // Add longitude column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};