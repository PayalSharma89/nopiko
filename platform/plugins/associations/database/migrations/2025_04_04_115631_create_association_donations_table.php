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
        Schema::create('association_donations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('association_id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->decimal('donation_amount', 10, 2);
            $table->timestamps();
        
            $table->foreign('association_id')->references('id')->on('associations')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('ec_products')->onDelete('set null');
            $table->foreign('order_id')->references('id')->on('ec_orders')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('association_donations');
    }
};
