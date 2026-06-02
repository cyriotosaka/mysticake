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
        Schema::create('product', function (Blueprint $table) {
            $table->integer('id_product')->autoIncrement()->primary();
            $table->integer('id_store')->nullable();
            $table->double('price')->nullable();
            $table->integer('stock')->default(0);
            $table->string('name_product', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('product_picture', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
