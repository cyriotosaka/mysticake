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
        // users table is created by the primary users migration (0001...); skip here

        // product table will be created below (after store) to include foreign key

        // cart_item will be created later with proper foreign keys

        // ── Stub tables required by ALTER migrations ──────────────────────────
        if (! Schema::hasTable('address')) {
            Schema::create('address', function (Blueprint $table) {
            $table->increments('id_address');

            $table->unsignedInteger('id_user')->nullable();

            $table->text('full_address');
            $table->string('map_point')->nullable();
            $table->string('address_contact_number', 20);

            $table->foreign('id_user')
                ->references('id_user')
                ->on('users')
                  ->onDelete('cascade');
            });
        }

        if (! Schema::hasTable('review_product')) {
            Schema::create('review_product', function (Blueprint $table) {
            $table->increments('id_review');
            $table->unsignedInteger('id_product')->nullable();
            $table->unsignedInteger('id_user')->nullable();
            $table->text('review')->nullable();
            $table->tinyInteger('rating')->nullable();
            $table->string('photo', 500)->nullable();
            $table->timestamp('created_at')->nullable();
            });
        }

        if (! Schema::hasTable('wallet')) {
            Schema::create('wallet', function (Blueprint $table) {
            $table->increments('id_wallet');
            $table->unsignedInteger('id_user')->nullable();
            $table->decimal('saldo_coin', 15, 2)->default(0);
            $table->decimal('point_gacha', 15, 2)->nullable()->default(0);
            });
        }

        if (! Schema::hasTable('mystery_box_history')) {
            Schema::create('mystery_box_history', function (Blueprint $table) {
            $table->increments('id_history');
            $table->unsignedInteger('id_user')->nullable();
            $table->unsignedInteger('id_mystery_box')->nullable();
            $table->string('result', 255)->nullable();
            $table->timestamps();
            });
        }

        if (! Schema::hasTable('store')) {
            Schema::create('store', function (Blueprint $table) {
            $table->increments('id_store');
            $table->string('name_store');
            $table->decimal('rating_store', 3, 2)->nullable();
            $table->string('store_picture')->nullable();
            });
        }

        if (! Schema::hasTable('product')) {
            Schema::create('product', function (Blueprint $table) {
            $table->increments('id_product');

            $table->unsignedInteger('id_store');

            $table->string('name_product');
            $table->text('description')->nullable();

            $table->decimal('price', 15, 2);
            $table->integer('stock')->default(0);

            $table->string('product_picture')->nullable();

            $table->foreign('id_store')
                  ->references('id_store')
                  ->on('store')
                  ->onDelete('cascade');
            });
        }

        if (! Schema::hasTable('cart')) {
            Schema::create('cart', function (Blueprint $table) {
            $table->increments('id_cart');

            $table->unsignedInteger('id_user');

            $table->timestamp('created_at')->nullable();

            $table->foreign('id_user')
                ->references('id_user')
                ->on('users')
                  ->onDelete('cascade');
            });
        }

        if (! Schema::hasTable('cart_item')) {
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

        if (! Schema::hasTable('chat')) {
            Schema::create('chat', function (Blueprint $table) {
            $table->increments('id_chat');

            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_store');

            $table->unsignedInteger('id_product')->nullable();
            $table->unsignedInteger('id_order')->nullable();

            $table->date('date');
            $table->time('time');

            $table->text('message')->nullable();

            $table->string('sender_role')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_item');
        Schema::dropIfExists('cart');

        Schema::dropIfExists('chat');

        Schema::dropIfExists('product');
        Schema::dropIfExists('store');

        Schema::dropIfExists('mystery_box_history');
        Schema::dropIfExists('wallet');
        Schema::dropIfExists('review_product');
        Schema::dropIfExists('address');
        Schema::dropIfExists('users');
    }
};
