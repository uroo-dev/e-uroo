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
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('order_number');
            $table->enum('status', ['Chekout', 'Cart']);
            $table->decimal('subtotal', 12, 2);
            $table->decimal('shoping_cost', 12, 2);
            $table->decimal('discount_amount');
            $table->decimal('grand_total');
            $table->string('payment_method');
            $table->enum('payment_status', ['Success', 'Pending', 'Failed'])->default('Pending');
            $table->string('recipient_name');
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
