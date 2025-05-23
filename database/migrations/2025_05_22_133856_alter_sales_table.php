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
            $table->boolean('is_payment_agent')->default(false);
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('commission_company')->nullable()->default(0);
            $table->decimal('commission_agent')->nullable()->default(0);
            $table->decimal('commission_fee')->nullable()->default(0);
            $table->integer('agent_id')->nullable();
            $table->boolean('is_payment')->default(false);
        });

        Schema::create('invoice_agent', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('invoice_id');
            $table->decimal('commission_fee');
            $table->integer('ppn')->nullable()->default(0);
            $table->integer('pph')->nullable()->default(0);
            $table->boolean('is_payment')->default(false);
             $table->timestamps();
        });
        Schema::create('invoice_principal', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('invoice_id');
            $table->decimal('commission_fee');
            $table->integer('ppn')->nullable()->default(0);
            $table->integer('pph')->nullable()->default(0);
            $table->boolean('is_payment')->default(false);
             $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('type_ads')->nullable();
            $table->integer('bedroom')->nullable()->default(0);
            $table->integer('bathroom')->nullable()->default(0);
            $table->integer('number_of_floors')->nullable()->default(0);
            $table->decimal('surface_area', 8, 2)->nullable()->default(0);
            $table->decimal('building_area', 8, 2)->nullable()->default(0);
            $table->string('certificate')->nullable();
            $table->string('furniture')->nullable();
            $table->string('listing_title')->nullable();
            $table->text('public_facilities')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['is_payment_agent']);
        });
    }
};
