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
        Schema::create('review_store', function (Blueprint $table) {
            $table->integer('id_review_store')->autoIncrement()->primary();
            $table->integer('id_store')->nullable();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->text('comment')->nullable();
            $table->integer('like_review')->nullable();
            $table->integer('rating')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_store');
    }
};
