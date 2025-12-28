<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GachaArsyaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('mystery_box_product')->truncate();
        DB::table('mystery_box')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Data dari Arsya
        DB::table('mystery_box')->insert([
            [
                'id_mystery_box' => 1,
                'name_box' => 'Normal',
                'description' => 'Mystery Box Normal'
            ],
            [
                'id_mystery_box' => 2,
                'name_box' => 'Premium',
                'description' => 'Mystery Box Premium'
            ]
        ]);

        // Data Produk Gacha dari Arsya
        DB::table('mystery_box_product')->insert([
            [
                'id_mystery_box' => 1,
                'id_product' => 1, 
                'price' => 50000,
                'point_gacha' => 10,
                'history_gacha' => 'First Spin',
                'type_gacha' => 'Normal',
                'drop_rate' => 0.25,
                'cashback' => 5000
            ],
            [
                'id_mystery_box' => 2,
                'id_product' => 8, 
                'price' => 50000,
                'point_gacha' => 10,
                'history_gacha' => null,
                'type_gacha' => null,
                'drop_rate' => 0.25,
                'cashback' => 5000
            ]
        ]);
        
        
        DB::table('wallet')->where('id_user', 6)->update([
            'saldo_coin' => 500000, 
            'point_gacha' => 100
        ]);
    }
}