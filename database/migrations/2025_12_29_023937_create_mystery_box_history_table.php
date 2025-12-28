<?php
//Created by Lailatul Fitaliqoh (5026231229)
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
        Schema::create('mystery_box_history', function (Blueprint $table) {
            $table->integer('id_gacha_history')->autoIncrement(); 

            $table->integer('id_user');
            $table->integer('id_product');

            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
            $table->foreign('id_product')->references('id_product')->on('product')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mystery_box_history');
    }
};