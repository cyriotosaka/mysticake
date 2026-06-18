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
        Schema::create('cart_item', function (Blueprint $table) {
            $table->integer('id_cart_item')->autoIncrement()->primary();
            $table->integer('id_cart')->nullable();
            $table->integer('id_product')->nullable();
            $table->integer('quantity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_item');
    }
};
