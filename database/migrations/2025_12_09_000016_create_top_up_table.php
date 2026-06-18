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
        Schema::create('top_up', function (Blueprint $table) {
            $table->integer('id_top_up')->autoIncrement()->primary();
            $table->integer('id_payment_method')->nullable();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->double('total_top_up')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->double('admin_fee')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('top_up');
    }
};
