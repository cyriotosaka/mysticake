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
        Schema::create('orders', function (Blueprint $table) {
            $table->integer('id_order')->autoIncrement()->primary();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->integer('id_delivery')->nullable();
            $table->integer('id_address')->nullable();
            $table->integer('id_payment_method')->nullable();
            $table->timestamp('order_date')->useCurrent();
            $table->double('extra_charges')->nullable();
            $table->double('total_payment')->nullable();
            $table->string('status_order', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
