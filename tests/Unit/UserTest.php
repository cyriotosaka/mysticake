<?php

use App\Models\Address;
use App\Models\Cart;
use App\Models\Store;
use App\Models\TopUp;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

afterEach(fn () => Mockery::close());

it('uses the correct table and primary key', function () {
    $user = new User();

    expect($user->getTable())->toBe('user');
    expect($user->getKeyName())->toBe('id_user');
});

it('does not use timestamps', function () {
    $user = new User();

    expect($user->timestamps)->toBeFalse();
});

it('allows mass assignment for fillable attributes', function () {
    $user = new User([
        'email' => 'jane@example.com',
        'username' => 'jane',
        'phone_number' => '08123456789',
        'role' => 'buyer',
        'id_address' => 5,
        'profile_picture' => 'uploads/avatar.png',
    ]);

    expect($user->email)->toBe('jane@example.com');
    expect($user->username)->toBe('jane');
    expect($user->phone_number)->toBe('08123456789');
    expect($user->role)->toBe('buyer');
    expect($user->id_address)->toBe(5);
    expect($user->profile_picture)->toBe('uploads/avatar.png');
});

it('hides the password attribute when converting to array', function () {
    $user = new User(['password' => 'secret']);

    expect($user->getHidden())->toContain('password');
    expect($user->toArray())->not->toHaveKey('password');
});

it('address() returns a BelongsTo relation with correct keys', function () {
    $user = new User();
    $relation = $user->address();

    expect($relation)->toBeInstanceOf(BelongsTo::class);
    expect($relation->getForeignKeyName())->toBe('id_address');
    expect($relation->getOwnerKeyName())->toBe('id_address');
    expect(get_class($relation->getRelated()))->toBe(Address::class);
});

it('addresses() returns a HasMany relation with correct keys', function () {
    $user = new User();
    $relation = $user->addresses();

    expect($relation)->toBeInstanceOf(HasMany::class);
    expect($relation->getForeignKeyName())->toBe('id_user');
    expect($relation->getLocalKeyName())->toBe('id_user');
    expect(get_class($relation->getRelated()))->toBe(Address::class);
});

it('wallet() returns a HasOne relation with correct keys', function () {
    $user = new User();
    $relation = $user->wallet();

    expect($relation)->toBeInstanceOf(HasOne::class);
    expect($relation->getForeignKeyName())->toBe('id_user');
    expect($relation->getLocalKeyName())->toBe('id_user');
    expect(get_class($relation->getRelated()))->toBe(Wallet::class);
});

it('reviewProducts() returns a HasMany relation with correct keys', function () {
    $user = new User();
    $relation = $user->reviewProducts();

    expect($relation)->toBeInstanceOf(HasMany::class);
    expect($relation->getForeignKeyName())->toBe('id_user');
    expect($relation->getLocalKeyName())->toBe('id_user');
});

it('orders() returns a HasMany relation with correct keys', function () {
    $user = new User();
    $relation = $user->orders();

    expect($relation)->toBeInstanceOf(HasMany::class);
    expect($relation->getForeignKeyName())->toBe('id_user');
    expect($relation->getLocalKeyName())->toBe('id_user');
});

it('carts() returns a HasMany relation with correct keys', function () {
    $user = new User();
    $relation = $user->carts();

    expect($relation)->toBeInstanceOf(HasMany::class);
    expect($relation->getForeignKeyName())->toBe('id_user');
    expect($relation->getLocalKeyName())->toBe('id_user');
    expect(get_class($relation->getRelated()))->toBe(Cart::class);
});

it('store() returns a HasOne relation with correct keys', function () {
    $user = new User();
    $relation = $user->store();

    expect($relation)->toBeInstanceOf(HasOne::class);
    expect($relation->getForeignKeyName())->toBe('id_user');
    expect($relation->getLocalKeyName())->toBe('id_user');
    expect(get_class($relation->getRelated()))->toBe(Store::class);
});

it('topUps() returns a HasMany relation with correct keys', function () {
    $user = new User();
    $relation = $user->topUps();

    expect($relation)->toBeInstanceOf(HasMany::class);
    expect($relation->getForeignKeyName())->toBe('id_user');
    expect($relation->getLocalKeyName())->toBe('id_user');
    expect(get_class($relation->getRelated()))->toBe(TopUp::class);
});

it('returns zero balance when wallet relation is missing', function () {
    $user = new User();

    expect($user->balance)->toBe(0);
});

it('returns wallet balance when wallet relation is set', function () {
    $user = new User();
    $wallet = new Wallet(['saldo_coin' => 150]);
    $user->setRelation('wallet', $wallet);

    expect($user->balance)->toBe(150);
});

it('identifies seller users correctly', function () {
    $user = new User(['role' => 'seller']);

    expect($user->isSeller())->toBeTrue();
    expect($user->isBuyer())->toBeFalse();
});

it('identifies buyer users correctly', function () {
    $user = new User(['role' => 'buyer']);

    expect($user->isBuyer())->toBeTrue();
    expect($user->isSeller())->toBeFalse();
});

it('returns default profile picture URL when none is set', function () {
    $user = new User();

    expect($user->profile_picture_url)->toContain('images/default-avatar.png');
});

it('returns custom profile picture URL when profile_picture is set', function () {
    $user = new User(['profile_picture' => 'uploads/avatar.png']);

    expect($user->profile_picture_url)->toContain('uploads/avatar.png');
});
