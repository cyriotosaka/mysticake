<?php

use App\Models\Address;
use App\Models\User;

// ============================================================
// AUTH GUARDS
// ============================================================

it('redirects guests from address index', function () {
    $this->get(route('address.index'))
        ->assertRedirect(route('login'));
});

it('redirects guests from address create form', function () {
    $this->get(route('address.create'))
        ->assertRedirect(route('login'));
});

it('redirects guests trying to store an address', function () {
    $this->post(route('address.store'), [])
        ->assertRedirect(route('login'));
});

it('redirects guests trying to update an address', function () {
    $this->put(route('address.update', 1), [])
        ->assertRedirect(route('login'));
});

it('redirects guests trying to delete an address', function () {
    $this->delete(route('address.destroy', 1))
        ->assertRedirect(route('login'));
});

// ============================================================
// ADDRESS INDEX
// ============================================================

it('renders address index and shows only the authenticated users addresses', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();

    Address::factory()->create(['id_user' => $user->id_user,  'full_address' => 'My Address']);
    Address::factory()->create(['id_user' => $other->id_user, 'full_address' => 'Other Address']);

    $response = $this->actingAs($user)->get(route('address.index'));

    $addresses = $response->viewData('addresses');
    expect($addresses)->toHaveCount(1)
        ->and($addresses->first()->full_address)->toBe('My Address');
});

it('passes canAddMore as true when the user has fewer than 3 addresses', function () {
    $user = User::factory()->create();
    Address::factory()->count(2)->create(['id_user' => $user->id_user]);

    $response = $this->actingAs($user)->get(route('address.index'));

    expect($response->viewData('canAddMore'))->toBeTrue();
});

it('passes canAddMore as false when the user already has 3 addresses', function () {
    $user = User::factory()->create();
    Address::factory()->count(3)->create(['id_user' => $user->id_user]);

    $response = $this->actingAs($user)->get(route('address.index'));

    expect($response->viewData('canAddMore'))->toBeFalse();
});

it('shows an empty address list for a brand-new user', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('address.index'));

    expect($response->viewData('addresses'))->toHaveCount(0)
        ->and($response->viewData('canAddMore'))->toBeTrue();
});

// ============================================================
// CREATE FORM
// ============================================================

it('renders the address creation form', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('address.create'))
        ->assertOk()
        ->assertViewIs('settings.address_form');
});

// ============================================================
// STORE – Happy Path
// ============================================================

it('stores a new address and persists it to the database', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('address.store'), [
            'full_address' => 'Jl. Raya Darmo No. 50, Surabaya',
            'map_point' => '-7.2887,112.7370',
            'address_contact_number' => '081234567890',
        ])
        ->assertRedirect(route('address.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('address', [
        'id_user' => $user->id_user,
        'full_address' => 'Jl. Raya Darmo No. 50, Surabaya',
        'map_point' => '-7.2887,112.7370',
    ]);
});

it('stores address with null map_point when not provided', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('address.store'), [
            'full_address' => 'Jl. Pemuda No. 1',
            'address_contact_number' => '089900001111',
        ])
        ->assertRedirect(route('address.index'));

    $this->assertDatabaseHas('address', [
        'id_user' => $user->id_user,
        'full_address' => 'Jl. Pemuda No. 1',
        'map_point' => null,
    ]);
});

it('allows storing up to 3 addresses in sequence', function () {
    $user = User::factory()->create();

    foreach (['First Street', 'Second Street', 'Third Street'] as $street) {
        $this->actingAs($user)
            ->post(route('address.store'), [
                'full_address' => $street,
                'address_contact_number' => '081234567890',
            ]);
    }

    expect(Address::where('id_user', $user->id_user)->count())->toBe(3);
});

// ============================================================
// STORE – Validation
// ============================================================

it('rejects store when full_address is absent', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('address.store'), [
            'address_contact_number' => '081234567890',
        ])
        ->assertSessionHasErrors('full_address');
});

it('rejects store when address_contact_number is absent', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('address.store'), [
            'full_address' => 'Jl. Test No. 1',
        ])
        ->assertSessionHasErrors('address_contact_number');
});

it('rejects store when all required fields are absent', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('address.store'), [])
        ->assertSessionHasErrors(['full_address', 'address_contact_number']);
});

// ============================================================
// STORE – Business Rule: Max 3 Addresses
// ============================================================

it('enforces three-address limit and flashes an error session', function () {
    $user = User::factory()->create();
    Address::factory()->count(3)->create(['id_user' => $user->id_user]);

    $this->actingAs($user)
        ->post(route('address.store'), [
            'full_address' => 'Fourth Address Attempt',
            'address_contact_number' => '081234567890',
        ])
        ->assertRedirect(route('address.index'))
        ->assertSessionHas('error');

    expect(Address::where('id_user', $user->id_user)->count())->toBe(3);
});

it('does not affect the address count of other users when limit is reached', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();

    Address::factory()->count(3)->create(['id_user' => $user->id_user]);
    Address::factory()->count(2)->create(['id_user' => $other->id_user]);

    $this->actingAs($user)
        ->post(route('address.store'), [
            'full_address' => 'Overflow Address',
            'address_contact_number' => '081234567890',
        ]);

    expect(Address::where('id_user', $other->id_user)->count())->toBe(2);
});

// ============================================================
// EDIT FORM
// ============================================================

it('renders the edit form for an address belonging to the authenticated user', function () {
    $user = User::factory()->create();
    $address = Address::factory()->create(['id_user' => $user->id_user]);

    $this->actingAs($user)
        ->get(route('address.edit', $address->id_address))
        ->assertOk()
        ->assertViewIs('settings.address_form')
        ->assertViewHas('address', $address);
});

it('returns 404 when editing another users address', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();
    $address = Address::factory()->create(['id_user' => $other->id_user]);

    $this->actingAs($user)
        ->get(route('address.edit', $address->id_address))
        ->assertNotFound();
});

it('returns 404 when editing a non-existent address id', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('address.edit', 99999))
        ->assertNotFound();
});

// ============================================================
// UPDATE – Happy Path
// ============================================================

it('updates address fields and persists changes to the database', function () {
    $user = User::factory()->create();
    $address = Address::factory()->create(['id_user' => $user->id_user]);

    $this->actingAs($user)
        ->put(route('address.update', $address->id_address), [
            'full_address' => 'Updated Street No. 99',
            'address_contact_number' => '089999999999',
        ])
        ->assertRedirect(route('address.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('address', [
        'id_address' => $address->id_address,
        'full_address' => 'Updated Street No. 99',
        'address_contact_number' => '089999999999',
    ]);
});

it('updates map_point when supplied on update', function () {
    $user = User::factory()->create();
    $address = Address::factory()->create(['id_user' => $user->id_user]);

    $this->actingAs($user)
        ->put(route('address.update', $address->id_address), [
            'full_address' => 'Somewhere New',
            'address_contact_number' => '081234567890',
            'map_point' => '-6.2000,106.8166',
        ]);

    $this->assertDatabaseHas('address', [
        'id_address' => $address->id_address,
        'map_point' => '-6.2000,106.8166',
    ]);
});

// ============================================================
// UPDATE – Authorization
// ============================================================

it('returns 404 when updating another users address', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();
    $address = Address::factory()->create([
        'id_user' => $other->id_user,
        'full_address' => 'Original Address',
    ]);

    $this->actingAs($user)
        ->put(route('address.update', $address->id_address), [
            'full_address' => 'Hacked Address',
            'address_contact_number' => '081234567890',
        ])
        ->assertNotFound();

    $this->assertDatabaseMissing('address', [
        'id_address' => $address->id_address,
        'full_address' => 'Hacked Address',
    ]);
});

// ============================================================
// UPDATE – Validation
// ============================================================

it('rejects update when full_address is absent', function () {
    $user = User::factory()->create();
    $address = Address::factory()->create(['id_user' => $user->id_user]);

    $this->actingAs($user)
        ->put(route('address.update', $address->id_address), [
            'address_contact_number' => '081234567890',
        ])
        ->assertSessionHasErrors('full_address');
});

it('rejects update when address_contact_number is absent', function () {
    $user = User::factory()->create();
    $address = Address::factory()->create(['id_user' => $user->id_user]);

    $this->actingAs($user)
        ->put(route('address.update', $address->id_address), [
            'full_address' => 'Jl. Test No. 1',
        ])
        ->assertSessionHasErrors('address_contact_number');
});

// ============================================================
// DESTROY – Happy Path
// ============================================================

it('deletes an address belonging to the authenticated user', function () {
    $user = User::factory()->create();
    $address = Address::factory()->create(['id_user' => $user->id_user]);

    $this->actingAs($user)
        ->delete(route('address.destroy', $address->id_address))
        ->assertRedirect(route('address.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('address', ['id_address' => $address->id_address]);
});

it('decrements the users address count by one after deletion', function () {
    $user = User::factory()->create();
    Address::factory()->count(2)->create(['id_user' => $user->id_user]);
    $last = Address::factory()->create(['id_user' => $user->id_user]);

    $this->actingAs($user)
        ->delete(route('address.destroy', $last->id_address));

    expect(Address::where('id_user', $user->id_user)->count())->toBe(2);
});

// ============================================================
// DESTROY – Authorization
// ============================================================

it('returns 404 when deleting another users address', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();
    $address = Address::factory()->create(['id_user' => $other->id_user]);

    $this->actingAs($user)
        ->delete(route('address.destroy', $address->id_address))
        ->assertNotFound();

    $this->assertDatabaseHas('address', ['id_address' => $address->id_address]);
});

it('does not remove the authenticated users own addresses when targeting another users record', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();

    $ownAddress = Address::factory()->create(['id_user' => $user->id_user]);
    $otherAddress = Address::factory()->create(['id_user' => $other->id_user]);

    $this->actingAs($user)
        ->delete(route('address.destroy', $otherAddress->id_address));

    $this->assertDatabaseHas('address', ['id_address' => $ownAddress->id_address]);
});

it('returns 404 when deleting a non-existent address id', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->delete(route('address.destroy', 99999))
        ->assertNotFound();
});

// ============================================================
// DATA ISOLATION
// ============================================================

it('two users addresses never interfere with each other', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    $addrA = Address::factory()->create(['id_user' => $userA->id_user, 'full_address' => 'Address A']);
    $addrB = Address::factory()->create(['id_user' => $userB->id_user, 'full_address' => 'Address B']);

    // User A updates their own address
    $this->actingAs($userA)
        ->put(route('address.update', $addrA->id_address), [
            'full_address' => 'Address A Updated',
            'address_contact_number' => '081111111111',
        ]);

    // User B's address must remain unchanged
    $this->assertDatabaseHas('address', [
        'id_address' => $addrB->id_address,
        'full_address' => 'Address B',
    ]);
});
