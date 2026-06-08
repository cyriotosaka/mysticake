<?php

use App\Models\MysteryBoxProduct;
use App\Models\Product;

// Drop rate calculation logic (mirrors calculateDropRates in MysteryBoxController)

it('calculates drop rate proportional to each product stock', function () {
    $products = collect([
        tap(new Product(), fn ($p) => $p->stock = 30),
        tap(new Product(), fn ($p) => $p->stock = 70),
    ]);

    $totalStock = $products->sum('stock');
    $rates = $products->map(fn ($p) => ($p->stock / $totalStock) * 100);

    expect($rates->first())->toBe(30.0);
    expect($rates->last())->toBe(70.0);
});

it('gives equal drop rate to all products when total stock is zero', function () {
    $products = collect([
        new Product(['stock' => 0]),
        new Product(['stock' => 0]),
    ]);

    $totalStock = $products->sum('stock');
    $equalRate  = ($totalStock == 0 && count($products) > 0)
        ? 100 / count($products)
        : 0;

    expect($equalRate)->toEqual(50);
});

it('returns zero rate when product list is empty', function () {
    $products  = collect([]);
    $totalStock = $products->sum('stock');
    $equalRate  = ($totalStock == 0 && count($products) > 0)
        ? 100 / count($products)
        : 0;

    expect($equalRate)->toBe(0);
});

// MysteryBoxProduct attribute casting

it('casts drop_rate to float', function () {
    $item = new MysteryBoxProduct(['drop_rate' => '0.5']);

    expect($item->drop_rate)->toBe(0.5);
});

it('casts price to integer', function () {
    $item = new MysteryBoxProduct(['price' => '50000']);

    expect($item->price)->toBe(50000);
});

// Weighted RNG selection logic (mirrors rollGacha in MysteryBoxController)

it('selects first item when random falls within its drop weight', function () {
    $item1 = new MysteryBoxProduct(['drop_rate' => 0.3]);
    $item2 = new MysteryBoxProduct(['drop_rate' => 0.7]);
    $candidates = collect([$item1, $item2]);

    $random        = 0.2; // within item1's range (0 – 0.3)
    $wonItem       = null;
    $currentWeight = 0;

    foreach ($candidates as $candidate) {
        $currentWeight += $candidate->drop_rate;
        if ($random <= $currentWeight) {
            $wonItem = $candidate;
            break;
        }
    }

    expect($wonItem)->toBe($item1);
});

it('selects second item when random exceeds first item drop weight', function () {
    $item1 = new MysteryBoxProduct(['drop_rate' => 0.3]);
    $item2 = new MysteryBoxProduct(['drop_rate' => 0.7]);
    $candidates = collect([$item1, $item2]);

    $random        = 0.5; // within item2's range (0.3 – 1.0)
    $wonItem       = null;
    $currentWeight = 0;

    foreach ($candidates as $candidate) {
        $currentWeight += $candidate->drop_rate;
        if ($random <= $currentWeight) {
            $wonItem = $candidate;
            break;
        }
    }

    expect($wonItem)->toBe($item2);
});

// Gacha cost by type

it('assigns correct gacha cost for normal type', function () {
    $type = 'normal';
    $gachaCost = match ($type) {
        'normal'  => 15000,
        'premium' => 25000,
        default   => 0,
    };

    expect($gachaCost)->toBe(15000);
});

it('assigns correct gacha cost for premium type', function () {
    $type = 'premium';
    $gachaCost = match ($type) {
        'normal'  => 15000,
        'premium' => 25000,
        default   => 0,
    };

    expect($gachaCost)->toBe(25000);
});

it('assigns zero cost for unknown gacha type', function () {
    $type = 'bonus';
    $gachaCost = match ($type) {
        'normal'  => 15000,
        'premium' => 25000,
        default   => 0,
    };

    expect($gachaCost)->toBe(0);
});
