<?php

use App\Models\Wallet;

afterEach(fn () => Mockery::close());

// Pure attribute logic — no save() needed

it('returns true when saldo is exactly enough', function () {
    $wallet = new Wallet(['saldo_coin' => 50]);

    expect($wallet->hasEnoughSaldo(50))->toBeTrue();
});

it('returns false when saldo is insufficient', function () {
    $wallet = new Wallet(['saldo_coin' => 50]);

    expect($wallet->hasEnoughSaldo(51))->toBeFalse();
});

it('returns true when saldo exceeds the required amount', function () {
    $wallet = new Wallet(['saldo_coin' => 100]);

    expect($wallet->hasEnoughSaldo(50))->toBeTrue();
});

// Methods that call save() — use Mockery to avoid DB

it('adds saldo correctly', function () {
    /** @var Wallet $wallet */
    $wallet = Mockery::mock(Wallet::class)->makePartial();
    $wallet->saldo_coin = 100;
    $wallet->shouldReceive('save')->once()->andReturn(true);

    $wallet->addSaldo(50);

    expect((float) $wallet->saldo_coin)->toBe(150.0);
});

it('reduces saldo when balance is sufficient', function () {
    /** @var Wallet $wallet */
    $wallet = Mockery::mock(Wallet::class)->makePartial();
    $wallet->saldo_coin = 200;
    $wallet->shouldReceive('save')->once()->andReturn(true);

    $result = $wallet->reduceSaldo(75);

    expect($result)->toBeTrue();
    expect((float) $wallet->saldo_coin)->toBe(125.0);
});

it('does not reduce saldo and returns false when balance is insufficient', function () {
    /** @var Wallet $wallet */
    $wallet = Mockery::mock(Wallet::class)->makePartial();
    $wallet->saldo_coin = 30;
    $wallet->shouldReceive('save')->never();

    $result = $wallet->reduceSaldo(100);

    expect($result)->toBeFalse();
    expect((float) $wallet->saldo_coin)->toBe(30.0);
});
