<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('address', 'id_user')) {
            Schema::table('address', function (Blueprint $table) {
                $table->integer('id_user')->nullable()->after('id_address');
                $table->index('id_user');
                $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('address', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
            $table->dropIndex(['id_user']);
            $table->dropColumn('id_user');
        });
    }
};
