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
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'processing', 'delivered', 'cancelled']);
            $table->enum('payment_method', ['COD', 'Transfer', 'QRIS']);
            $table->decimal('total_price', 10, 2)->nullable()->default(0);
            // $table->text('delivery_address');
            // $table->decimal('latitude', 10, 8)->nullable(); // Add latitude column
            // $table->decimal('longitude', 11, 8)->nullable(); // Add longitude column
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
