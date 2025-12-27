<?php
//Created by Lailatul Fitaliqoh (5026231229)
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
        Schema::table('chat', function (Blueprint $table) {
            if (!Schema::hasColumn('chat', 'sender_role')) {
                $table->enum('sender_role', ['user', 'store'])
                      ->default('user')
                      ->after('message'); 
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat', function (Blueprint $table) {
            if (Schema::hasColumn('chat', 'sender_role')) {
                $table->dropColumn('sender_role');
            }
        });
    }
};