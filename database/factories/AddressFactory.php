<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_user' => User::factory(),
            'full_address' => fake()->address(),
            'map_point' => '-7.2575,112.7521',
            'address_contact_number' => '08123456789',
        ];
    }
}