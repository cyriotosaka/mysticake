<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wishlist', function (Blueprint $table) {
            $table->integer('id_wishlist')->autoIncrement()->primary();
            $table->integer('id_user');
            $table->integer('id_product');
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['id_user', 'id_product']);
            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
            $table->foreign('id_product')->references('id_product')->on('product')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wishlist');
    }
};
