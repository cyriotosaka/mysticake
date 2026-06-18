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
        // sender_role is now included in the chat table creation
        // See migration 2025_12_09_000013_create_chat_table
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};
