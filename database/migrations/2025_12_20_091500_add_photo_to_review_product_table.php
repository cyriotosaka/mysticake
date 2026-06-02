<?php

/**
 * Created by Abdul Ghoni (5026231109)
 * Migration untuk menambahkan kolom review_photo ke tabel review_product
 * Now skipped as review_photo is included in table creation
 */
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
        // review_photo is now included in the review_product table creation
        // See migration 2025_12_09_000014_create_review_product_table
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};
