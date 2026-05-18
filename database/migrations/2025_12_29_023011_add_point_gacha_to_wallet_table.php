<?php

// Created by Lailatul Fitaliqoh (5026231229)
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('wallet', function (Blueprint $table) {
            if (! Schema::hasColumn('wallet', 'point_gacha')) {
                $table->integer('point_gacha')->default(0)->after('saldo_coin');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallet', function (Blueprint $table) {
            if (Schema::hasColumn('wallet', 'point_gacha')) {
                $table->dropColumn('point_gacha');
            }
        });
    }
};
