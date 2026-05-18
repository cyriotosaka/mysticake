<?php

/**
 * Created by Abdul Ghoni (5026231109)
 * Migration untuk menambahkan kolom created_at ke tabel review_product
 * Untuk menampilkan tanggal review dibuat
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
        if (! Schema::hasColumn('review_product', 'created_at')) {
            Schema::table('review_product', function (Blueprint $table) {
                $table->timestamp('created_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('review_product', function (Blueprint $table) {
            $table->dropColumn('created_at');
        });
    }
};
