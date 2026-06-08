<?php

use App\Models\Address;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('authenticated user can view address page', function () {
    $response = $this->actingAs($this->user)
        ->get(route('address.index'));

    $response->assertStatus(200);
});

test('user can create address', function () {

    $response = $this->actingAs($this->user)
        ->post(route('address.store'), [
            'full_address' => 'Jl. Surabaya No 1',
            'map_point' => '-7.2575,112.7521',
            'address_contact_number' => '08123456789',
        ]);

    $response->assertRedirect(route('address.index'));

    $this->assertDatabaseHas('address', [
        'full_address' => 'Jl. Surabaya No 1',
    ]);
});

test('user cannot create more than 3 addresses', function () {

    Address::factory()->count(3)->create([
        'id_user' => $this->user->id_user,
    ]);

    $response = $this->actingAs($this->user)
        ->post(route('address.store'), [
            'full_address' => 'Alamat keempat',
            'address_contact_number' => '08123456789',
        ]);

    $response->assertSessionHas('error');
});

test('user can update address', function () {

    $address = Address::factory()->create([
        'id_user' => $this->user->id_user,
    ]);

    $response = $this->actingAs($this->user)
        ->put(route('address.update', $address->id_address), [
            'full_address' => 'Alamat Baru',
            'map_point' => 'test',
            'address_contact_number' => '0811111111',
        ]);

    $response->assertRedirect(route('address.index'));

    $this->assertDatabaseHas('address', [
        'full_address' => 'Alamat Baru',
    ]);
});

test('user can delete address', function () {

    $address = Address::factory()->create([
        'id_user' => $this->user->id_user,
    ]);

    $response = $this->actingAs($this->user)
        ->delete(route('address.destroy', $address->id_address));

    $response->assertRedirect(route('address.index'));

    $this->assertDatabaseMissing('address', [
        'id_address' => $address->id_address,
    ]);
});
