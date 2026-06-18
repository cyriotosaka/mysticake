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
        Schema::create('chat', function (Blueprint $table) {
            $table->integer('id_chat')->autoIncrement()->primary();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->integer('id_store')->nullable();
            $table->integer('id_order')->nullable();
            $table->integer('id_product')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->text('message')->nullable();
            $table->enum('sender_role', ['user', 'store'])->default('user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat');
    }
};
