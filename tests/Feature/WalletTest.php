<?php

use App\Models\Wallet;

it('adds saldo correctly', function () {
    $wallet = Wallet::create(['id_user' => 101, 'saldo_coin' => 100]);

    $wallet->addSaldo(50);

    $wallet->refresh();

    expect((float) $wallet->saldo_coin)->toBe(150.0);
});

it('reduces saldo when enough', function () {
    $wallet = Wallet::create(['id_user' => 102, 'saldo_coin' => 200]);

    $result = $wallet->reduceSaldo(75);

    $wallet->refresh();

    expect($result)->toBeTrue();
    expect((float) $wallet->saldo_coin)->toBe(125.0);
});

it('does not reduce saldo when insufficient', function () {
    $wallet = Wallet::create(['id_user' => 103, 'saldo_coin' => 30]);

    $result = $wallet->reduceSaldo(100);

    $wallet->refresh();

    expect($result)->toBeFalse();
    expect((float) $wallet->saldo_coin)->toBe(30.0);
});

it('hasEnoughSaldo returns correct boolean', function () {
    $wallet = Wallet::create(['id_user' => 104, 'saldo_coin' => 50]);

    expect($wallet->hasEnoughSaldo(50))->toBeTrue();
    expect($wallet->hasEnoughSaldo(51))->toBeFalse();
});
