<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Testing-only migration that creates the full application schema
 * in the in-memory SQLite database used during test runs.
 *
 * The real production schema was created manually on MySQL; only
 * ALTER-style patch migrations exist in the normal migrations folder.
 * This file fills that gap so RefreshDatabase works cleanly.
 */
return new class() extends Migration
{
    public function up(): void
    {
        // ── Core auth table (matches App\Models\User) ────────────────────────
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('username', 255)->unique();
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->string('phone_number', 20)->nullable();
            $table->string('role', 50)->default('buyer');
            $table->unsignedInteger('id_address')->nullable();
            $table->string('profile_picture', 500)->nullable();
            // No timestamps (model has $timestamps = false)
        });

        Schema::create('product', function (Blueprint $table) {
            $table->increments('id_product'); // Sesuai primary key di HomeTest kamu!
            $table->string('name_product', 255);
            $table->integer('price');
            $table->integer('stock')->default(0)->nullable();
            $table->text('description')->nullable();
            $table->string('image', 500)->nullable();
            $table->timestamps();
        });

        Schema::create('cart_item', function (Blueprint $table) {
            $table->increments('id_cart_item'); // Primary key
            $table->unsignedInteger('id_cart');   // Berelasi ke tabel carts
            $table->unsignedInteger('id_product'); // Berelasi ke tabel product
            $table->integer('quantity');
            $table->integer('price')->nullable();
            $table->timestamps();
        });

        // ── Stub tables required by ALTER migrations ──────────────────────────
        Schema::create('address', function (Blueprint $table) {
            $table->increments('id_address');

            $table->unsignedInteger('id_user')->nullable();

            $table->text('full_address');
            $table->string('map_point')->nullable();
            $table->string('address_contact_number', 20);

            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('user')
                  ->onDelete('cascade');
    });

        Schema::create('review_product', function (Blueprint $table) {
            $table->increments('id_review');
            $table->unsignedInteger('id_product')->nullable();
            $table->unsignedInteger('id_user')->nullable();
            $table->text('review')->nullable();
            $table->tinyInteger('rating')->nullable();
            $table->string('photo', 500)->nullable();
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('chat', function (Blueprint $table) {
            $table->increments('id_chat');
            $table->unsignedInteger('id_user')->nullable();
            $table->unsignedInteger('id_store')->nullable();
            $table->text('message')->nullable();
            $table->string('sender_role', 50)->nullable();
            $table->timestamps();
        });

        Schema::create('wallet', function (Blueprint $table) {
            $table->increments('id_wallet');
            $table->unsignedInteger('id_user')->nullable();
            $table->decimal('saldo_coin', 15, 2)->default(0);
            $table->decimal('point_gacha', 15, 2)->nullable()->default(0);
        });

        Schema::create('mystery_box_history', function (Blueprint $table) {
            $table->increments('id_history');
            $table->unsignedInteger('id_user')->nullable();
            $table->unsignedInteger('id_mystery_box')->nullable();
            $table->string('result', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('product', function (Blueprint $table) {
            $table->increments('id_product');

            $table->unsignedInteger('id_store');

            $table->string('name_product');
            $table->text('description')->nullable();

            $table->decimal('price', 15, 2);

            $table->integer('stock')->default(0);

            $table->string('product_picture')->nullable();
        });

        Schema::create('cart', function (Blueprint $table) {
            $table->increments('id_cart');

            $table->unsignedInteger('id_user');

            $table->timestamp('created_at')->nullable();

            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('user')
                  ->onDelete('cascade');
        });

        Schema::create('cart_item', function (Blueprint $table) {
            $table->increments('id_cart_item');

            $table->unsignedInteger('id_cart');

            $table->unsignedInteger('id_product');

            $table->integer('quantity')->default(1);

            $table->foreign('id_cart')
                  ->references('id_cart')
                  ->on('cart')
                  ->onDelete('cascade');

            $table->foreign('id_product')
                  ->references('id_product')
                  ->on('product')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_item');
        Schema::dropIfExists('cart');
        Schema::dropIfExists('product');
        
        Schema::dropIfExists('mystery_box_history');
        Schema::dropIfExists('wallet');
        Schema::dropIfExists('chat');
        Schema::dropIfExists('review_product');
        Schema::dropIfExists('address');
        Schema::dropIfExists('user');
        Schema::dropIfExists('product');
        Schema::dropIfExists('cart_item');
    }
};
