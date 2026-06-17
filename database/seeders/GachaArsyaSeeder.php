<?php

// Created by Lailatul Fitaliqoh (5026231229)
// FIXED: Seeder sebelumnya hanya memasukkan 2 produk (id_product 1 & 8) ke mystery_box_product,
//        sehingga gacha hanya menampilkan 1 produk. Sekarang di-join langsung dengan semua produk
//        yang sudah di-seed oleh GachaProductSeeder berdasarkan range harga.

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

        // Insert mystery box types
        DB::table('mystery_box')->insert([
            [
                'id_mystery_box' => 1,
                'name_box' => 'Normal',
                'description' => 'Mystery Box Normal',
            ],
            [
                'id_mystery_box' => 2,
                'name_box' => 'Premium',
                'description' => 'Mystery Box Premium',
            ],
        ]);

        // ============================================================
        // FIX: Ambil semua produk dari tabel product dan masukkan ke
        //      mystery_box_product berdasarkan range harga.
        //      Normal Box  = produk harga Rp 0 - Rp 49.999
        //      Premium Box = produk harga Rp 50.000+
        // Drop rate dihitung berdasarkan stock secara proporsional.
        // ============================================================

        // --- Normal Box (id_mystery_box = 1, harga Rp 0 - Rp 49.999) ---
        $normalProducts = DB::table('product')
            ->whereBetween('price', [0, 49999])
            ->select('id_product', 'stock')
            ->get();

        $normalTotalStock = $normalProducts->sum('stock');
        $normalInsertData = [];

        foreach ($normalProducts as $product) {
            $dropRate = $normalTotalStock > 0
                ? round($product->stock / $normalTotalStock, 4)
                : (count($normalProducts) > 0 ? round(1 / count($normalProducts), 4) : 0);

            $normalInsertData[] = [
                'id_mystery_box' => 1,
                'id_product'     => $product->id_product,
                'price'          => 15000,   // harga gacha normal
                'point_gacha'    => 10,
                'history_gacha'  => null,
                'type_gacha'     => 'Normal',
                'drop_rate'      => $dropRate,
                'cashback'       => 1000,
            ];
        }

        if (!empty($normalInsertData)) {
            DB::table('mystery_box_product')->insert($normalInsertData);
            $this->command->info('✅ Inserted ' . count($normalInsertData) . ' products to Normal Box.');
        }

        // --- Premium Box (id_mystery_box = 2, harga Rp 50.000+) ---
        $premiumProducts = DB::table('product')
            ->where('price', '>=', 50000)
            ->select('id_product', 'stock')
            ->get();

        $premiumTotalStock = $premiumProducts->sum('stock');
        $premiumInsertData = [];

        foreach ($premiumProducts as $product) {
            $dropRate = $premiumTotalStock > 0
                ? round($product->stock / $premiumTotalStock, 4)
                : (count($premiumProducts) > 0 ? round(1 / count($premiumProducts), 4) : 0);

            $premiumInsertData[] = [
                'id_mystery_box' => 2,
                'id_product'     => $product->id_product,
                'price'          => 25000,   // harga gacha premium
                'point_gacha'    => 20,
                'history_gacha'  => null,
                'type_gacha'     => 'Premium',
                'drop_rate'      => $dropRate,
                'cashback'       => 2500,
            ];
        }

        if (!empty($premiumInsertData)) {
            DB::table('mystery_box_product')->insert($premiumInsertData);
            $this->command->info('✅ Inserted ' . count($premiumInsertData) . ' products to Premium Box.');
        }

        // Update wallet user demo (id_user = 6) jika ada
        $walletExists = DB::table('wallet')->where('id_user', 6)->exists();
        if ($walletExists) {
            DB::table('wallet')->where('id_user', 6)->update([
                'saldo_coin'  => 500000,
                'point_gacha' => 100,
            ]);
        }
    }
}
