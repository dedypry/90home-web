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
        Schema::table('sales', function (Blueprint $table) {
            $table->boolean('is_payment_sales')->nullable()->default(false);
            $table->decimal('commission_sales', 18, 2)->nullable()->default(0);
            $table->decimal('commission_brand', 18, 2)->nullable()->default(0);
            $table->integer('ppn')->nullable()->default(0);
        });

        Schema::dropIfExists('invoice_agent');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn([
                'is_payment_sales',
                'commission_sales',
                'commission_brand',
                'ppn',
            ]);
        });
    }
};
