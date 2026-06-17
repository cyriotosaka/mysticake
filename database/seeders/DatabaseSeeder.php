<?php

// Created by Lailatul Fitaliqoh (5026231229)
// FIXED: Tambahkan DeliverySeeder dan PaymentMethodSeeder agar
//        tabel delivery dan payment_method tidak kosong saat checkout.

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'username'     => 'testuser',
            'email'        => 'test@example.com',
            'phone_number' => '08123456789',
            'role'         => 'buyer',
        ]);

        $this->call([
            PaymentMethodSeeder::class, // FIX: isi tabel payment_method
            DeliverySeeder::class,      // FIX: isi tabel delivery
            GachaProductSeeder::class,  // insert produk-produk ke tabel product
            GachaArsyaSeeder::class,    // mapping produk ke mystery_box_product
        ]);
    }
}
