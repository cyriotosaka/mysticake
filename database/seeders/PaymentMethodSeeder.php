<?php

// FIX: Tabel 'payment_method' perlu punya data agar halaman checkout
//      bisa menampilkan pilihan metode pembayaran.

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('payment_method')->count() > 0) {
            $this->command->info('Payment method data already exists, skipping.');
            return;
        }

        DB::table('payment_method')->insert([
            ['id_payment_method' => 1, 'name_method' => 'Debit Card'],
            ['id_payment_method' => 2, 'name_method' => 'Bank Transfer'],
            ['id_payment_method' => 3, 'name_method' => 'E-Wallet'],
            ['id_payment_method' => 4, 'name_method' => 'Indomaret'],
            ['id_payment_method' => 5, 'name_method' => 'Alfamart'],
            ['id_payment_method' => 6, 'name_method' => 'Cash'],
        ]);

        $this->command->info('✅ Payment methods seeded.');
    }
}
