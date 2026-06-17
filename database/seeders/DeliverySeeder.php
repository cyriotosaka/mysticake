<?php

// FIX: Tabel 'delivery' tidak punya data, sehingga di halaman checkout
//      tidak ada pilihan tipe pengiriman dan tombol Place Order tidak bisa diklik.
//      Seeder ini menambahkan data awal tipe pengiriman.

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliverySeeder extends Seeder
{
    public function run(): void
    {
        // Cek apakah sudah ada data
        if (DB::table('delivery')->count() > 0) {
            $this->command->info('Delivery data already exists, skipping.');
            return;
        }

        DB::table('delivery')->insert([
            [
                'type'             => 'Regular (3-5 hari)',
                'delivery_charges' => 15000,
            ],
            [
                'type'             => 'Express (1-2 hari)',
                'delivery_charges' => 25000,
            ],
            [
                'type'             => 'Same Day',
                'delivery_charges' => 40000,
            ],
        ]);

        $this->command->info('✅ Delivery options seeded.');
    }
}
