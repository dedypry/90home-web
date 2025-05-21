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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->json('product')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('agent_coordinator')->nullable();
            $table->string('customer')->nullable();
            $table->string('promo')->nullable();
            $table->string('status')->nullable();
            $table->decimal('price', 18,2)->nullable()->default(0);
            $table->decimal('commission', 18,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
