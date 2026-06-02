<?php

// Created by Lailatul Fitaliqoh (5026231229)

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
        // User::factory(10)->create();

        User::factory()->create([
            'username' => 'testuser',
            'email' => 'test@example.com',
            'phone_number' => '08123456789',
            'role' => 'buyer',
        ]);

        // Run other seeders
        $this->call([
            GachaProductSeeder::class,
            GachaArsyaSeeder::class,
        ]);
    }
}
