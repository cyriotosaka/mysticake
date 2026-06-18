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
        Schema::create('mystery_box_product', function (Blueprint $table) {
            $table->integer('id_mystery_box');
            $table->integer('id_product');
            $table->double('price')->nullable();
            $table->integer('point_gacha')->nullable();
            $table->string('history_gacha', 255)->nullable();
            $table->string('type_gacha', 255)->nullable();
            $table->double('drop_rate')->nullable();
            $table->double('cashback')->nullable();
            
            $table->primary(['id_mystery_box', 'id_product']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mystery_box_product');
    }
};
