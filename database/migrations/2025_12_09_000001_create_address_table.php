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
        Schema::create('address', function (Blueprint $table) {
            $table->integer('id_address')->autoIncrement()->primary();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->text('full_address')->nullable();
            $table->string('map_point', 255)->nullable();
            $table->string('address_contact_number', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address');
    }
};
