<?php

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;

// Role checks

it('returns true when user role is seller', function () {
    $user = new User(['role' => 'seller']);

    expect($user->isSeller())->toBeTrue();
});

it('returns false for isSeller when user role is buyer', function () {
    $user = new User(['role' => 'buyer']);

    expect($user->isSeller())->toBeFalse();
});

it('returns true when user role is buyer', function () {
    $user = new User(['role' => 'buyer']);

    expect($user->isBuyer())->toBeTrue();
});

it('returns false for isBuyer when user role is seller', function () {
    $user = new User(['role' => 'seller']);

    expect($user->isBuyer())->toBeFalse();
});

// Default role assigned on register

it('assigns buyer as default role on register', function () {
    $user = new User(['role' => 'buyer']);

    expect($user->isBuyer())->toBeTrue();
    expect($user->isSeller())->toBeFalse();
});

// Profile picture URL accessor

it('returns profile picture url when picture is set', function () {
    $user = new User(['profile_picture' => 'images/profile/avatar.jpg']);

    expect($user->profile_picture_url)->toContain('images/profile/avatar.jpg');
});

it('returns default avatar url when profile picture is null', function () {
    $user = new User(['profile_picture' => null]);

    expect($user->profile_picture_url)->toContain('images/default-avatar.png');
});

// Balance accessor

it('returns saldo_coin from wallet as balance', function () {
    $wallet = new Wallet(['saldo_coin' => 150]);
    $user   = new User();
    $user->setRelation('wallet', $wallet);

    expect($user->balance)->toBe(150);
});

it('returns zero balance when user has no wallet', function () {
    $user = new User();
    $user->setRelation('wallet', null);

    expect($user->balance)->toBe(0);
});

// Password hashing (register logic)

it('hashes password so plain text is not stored', function () {
    $password = 'secret123';
    $hash     = Hash::make($password);

    expect($hash)->not->toBe($password);
    expect(Hash::check($password, $hash))->toBeTrue();
});

it('rejects wrong password against stored hash', function () {
    $hash = Hash::make('correct_password');

    expect(Hash::check('wrong_password', $hash))->toBeFalse();
});
