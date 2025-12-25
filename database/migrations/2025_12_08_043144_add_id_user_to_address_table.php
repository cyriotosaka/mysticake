<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('address', function (Blueprint $table) {
            // Add id_user column (matching user.id_user type: int(11))
            $table->integer('id_user')->nullable()->after('id_address');
            
            // Add index for performance
            $table->index('id_user');
            
            // Add foreign key constraint
            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
        });

        // Migrate existing data: populate id_user from user.id_address relationship
        DB::statement('UPDATE address a 
                      INNER JOIN user u ON u.id_address = a.id_address 
                      SET a.id_user = u.id_user');
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
