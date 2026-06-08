<?php

use App\Models\Address;
use App\Models\Orders;
use App\Models\User;
use Illuminate\Support\Facades\DB;

afterEach(fn () => Mockery::close());

// ── Accessor: latitude ─────────────────────────────────────────────────────

it('parses latitude from map_point', function () {
    $address = new Address(['map_point' => '-6.200,106.816']);

    expect($address->latitude)->toBe(-6.2);
});

it('returns null latitude when map_point is null', function () {
    $address = new Address(['map_point' => null]);

    expect($address->latitude)->toBeNull();
});

// ── Accessor: longitude ────────────────────────────────────────────────────

it('parses longitude from map_point', function () {
    $address = new Address(['map_point' => '-6.200,106.816']);

    expect($address->longitude)->toBe(106.816);
});

it('returns null longitude when map_point is null', function () {
    $address = new Address(['map_point' => null]);

    expect($address->longitude)->toBeNull();
});

// ── Accessor: map_url ──────────────────────────────────────────────────────

it('generates correct google maps url', function () {
    $address = new Address(['map_point' => '-6.200,106.816']);

    expect($address->map_url)->toBe('https://www.google.com/maps?q=-6.2,106.816');
});

it('returns null map_url when map_point is null', function () {
    $address = new Address(['map_point' => null]);

    expect($address->map_url)->toBeNull();
});

// ── Fillable attributes ────────────────────────────────────────────────────

it('stores all fillable fields correctly', function () {
    $address = new Address([
        'id_user'                => 1,
        'full_address'           => '123 Cake Street, Jakarta',
        'map_point'              => '-6.200,106.816',
        'address_contact_number' => '081234567890',
    ]);

    expect($address->id_user)->toBe(1);
    expect($address->full_address)->toBe('123 Cake Street, Jakarta');
    expect($address->address_contact_number)->toBe('081234567890');
});

it('stores null map_point when address has no coordinates', function () {
    $address = new Address([
        'id_user'      => 2,
        'full_address' => 'No coordinates address',
        'map_point'    => null,
    ]);

    expect($address->map_point)->toBeNull();
    expect($address->latitude)->toBeNull();
    expect($address->longitude)->toBeNull();
});

// ── user() relation ────────────────────────────────────────────────────────

it('user() returns a BelongsTo relation', function () {
    $address = new Address(['id_user' => 1]);

    expect($address->user())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
});

it('user() uses id_user as the foreign key', function () {
    expect((new Address())->user()->getForeignKeyName())->toBe('id_user');
});

it('user() is related to the User model', function () {
    expect((new Address())->user()->getRelated())->toBeInstanceOf(User::class);
});

// ── orders() relation ──────────────────────────────────────────────────────

it('orders() returns a HasMany relation', function () {
    $address = new Address(['id_user' => 1]);

    expect($address->orders())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});

it('orders() uses id_address as the foreign key', function () {
    expect((new Address())->orders()->getForeignKeyName())->toBe('id_address');
});

it('orders() is related to the Orders model', function () {
    expect((new Address())->orders()->getRelated())->toBeInstanceOf(Orders::class);
});

// ── scopeForUser — mocked Builder, no DB ──────────────────────────────────

it('scopeForUser adds a where clause for id_user', function () {
    $query = Mockery::mock(\Illuminate\Database\Eloquent\Builder::class);
    $query->shouldReceive('where')->with('id_user', 5)->once()->andReturnSelf();

    $result = (new Address())->scopeForUser($query, 5);

    expect($result)->toBe($query);
});

it('scopeForUser passes the correct user id to where', function () {
    $query = Mockery::mock(\Illuminate\Database\Eloquent\Builder::class);
    $query->shouldReceive('where')->with('id_user', 99)->once()->andReturnSelf();

    (new Address())->scopeForUser($query, 99);
});

// ── Static methods — DB::pretend() intercepts SQL, no real query runs ──────
//
// DB::pretend() sets the connection to "pretending" mode inside the closure:
// SELECT returns [], count() returns 0, get() returns an empty Collection.
// The method bodies execute fully so coverage is recorded, but no SQL hits SQLite.

it('getUserAddresses returns a collection for a user', function () {
    DB::pretend(function () {
        $result = Address::getUserAddresses(1);

        expect($result)->toBeInstanceOf(\Illuminate\Database\Eloquent\Collection::class);
    });
});

it('canAddAddress returns true when user has no addresses', function () {
    DB::pretend(function () {
        // pretend mode: count() → 0, so 0 < 3 → true
        $result = Address::canAddAddress(1);

        expect($result)->toBeTrue();
    });
});

it('getAddressCount returns zero when no addresses exist', function () {
    DB::pretend(function () {
        // pretend mode: count() → 0
        $result = Address::getAddressCount(1);

        expect($result)->toBe(0);
    });
});

// ── setRelation: user ──────────────────────────────────────────────────────

it('accesses user relation data correctly', function () {
    $user = new User(['username' => 'johndoe', 'email' => 'john@example.com']);

    $address = new Address(['id_user' => 1, 'full_address' => '123 Cake Street']);
    $address->setRelation('user', $user);

    expect($address->user->username)->toBe('johndoe');
    expect($address->user->email)->toBe('john@example.com');
});

it('returns null when user relation is not set', function () {
    $address = new Address(['id_user' => null]);
    $address->setRelation('user', null);

    expect($address->user)->toBeNull();
});

// ── setRelation: orders ────────────────────────────────────────────────────

it('accesses orders relation data correctly', function () {
    $order1 = new Orders(['status_order' => 'Pending',   'total_payment' => 50000]);
    $order2 = new Orders(['status_order' => 'completed', 'total_payment' => 80000]);

    $address = new Address(['id_user' => 1]);
    $address->setRelation('orders', collect([$order1, $order2]));

    $orders = collect($address->orders);
    expect($orders)->toHaveCount(2);
    expect($orders->first()->status_order)->toBe('Pending');
    expect($orders->last()->total_payment)->toBe(80000);
});

it('accesses empty orders relation correctly', function () {
    $address = new Address(['id_user' => 1]);
    $address->setRelation('orders', collect([]));

    expect(collect($address->orders)->isEmpty())->toBeTrue();
});
