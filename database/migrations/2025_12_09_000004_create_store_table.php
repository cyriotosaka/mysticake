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
        Schema::create('store', function (Blueprint $table) {
            $table->integer('id_store')->autoIncrement()->primary();
            $table->string('name_store', 255)->nullable();
            $table->double('rating_store')->nullable();
            $table->string('store_picture', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store');
    }
};
