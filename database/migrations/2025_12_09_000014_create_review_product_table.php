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
        Schema::create('review_product', function (Blueprint $table) {
            $table->integer('id_review_product')->autoIncrement()->primary();
            $table->integer('id_product')->nullable();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->text('comment')->nullable();
            $table->string('review_photo', 255)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->integer('like_review')->nullable();
            $table->integer('rating')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_product');
    }
};
