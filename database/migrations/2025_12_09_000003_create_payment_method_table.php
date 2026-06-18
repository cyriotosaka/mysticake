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
        Schema::create('payment_method', function (Blueprint $table) {
            $table->integer('id_payment_method')->autoIncrement()->primary();
            $table->string('name_method', 255)->nullable();
            $table->string('payment_barcode', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_method');
    }
};
