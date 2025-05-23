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
        Schema::create('principal_sale', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('sale_id');
            $table->decimal('commission_fee');
            $table->integer('ppn')->nullable()->default(0);
            $table->integer('pph')->nullable()->default(0);
            $table->boolean('is_payment')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('principal_sale');
    }
};
