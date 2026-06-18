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
        // point_gacha is now included in the wallet table creation
        // See migration 2025_12_09_000017_create_wallet_table
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};
