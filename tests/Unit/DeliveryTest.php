<?php

use App\Models\Delivery;
use App\Models\Orders;
use Illuminate\Support\Facades\DB;

// Fillable attribute tests

it('stores type and delivery_charges correctly', function () {
    $delivery = new Delivery(['type' => 'regular', 'delivery_charges' => 15000]);

    expect($delivery->type)->toBe('regular');
    expect($delivery->delivery_charges)->toBe(15000);
});

it('stores express type correctly', function () {
    $delivery = new Delivery(['type' => 'express', 'delivery_charges' => 30000]);

    expect($delivery->type)->toBe('express');
    expect($delivery->delivery_charges)->toBe(30000);
});

it('stores same_day type correctly', function () {
    $delivery = new Delivery(['type' => 'same_day', 'delivery_charges' => 50000]);

    expect($delivery->type)->toBe('same_day');
    expect($delivery->delivery_charges)->toBe(50000);
});

it('stores zero delivery_charges for free delivery', function () {
    $delivery = new Delivery(['type' => 'free', 'delivery_charges' => 0]);

    expect($delivery->delivery_charges)->toBe(0);
});

// Formatted price accessor (pure string logic — no DB)

it('formats 15000 as Rp 15.000', function () {
    $delivery = new Delivery(['delivery_charges' => 15000]);

    expect($delivery->formatted_price)->toBe('Rp 15.000');
});

it('formats 30000 as Rp 30.000', function () {
    $delivery = new Delivery(['delivery_charges' => 30000]);

    expect($delivery->formatted_price)->toBe('Rp 30.000');
});

it('formats 50000 as Rp 50.000', function () {
    $delivery = new Delivery(['delivery_charges' => 50000]);

    expect($delivery->formatted_price)->toBe('Rp 50.000');
});

it('formats 250000 as Rp 250.000', function () {
    $delivery = new Delivery(['delivery_charges' => 250000]);

    expect($delivery->formatted_price)->toBe('Rp 250.000');
});

it('formats 1500000 as Rp 1.500.000', function () {
    $delivery = new Delivery(['delivery_charges' => 1500000]);

    expect($delivery->formatted_price)->toBe('Rp 1.500.000');
});

it('formats zero delivery_charges as Rp 0', function () {
    $delivery = new Delivery(['delivery_charges' => 0]);

    expect($delivery->formatted_price)->toBe('Rp 0');
});

// Relationship method — type, foreign key, and related model (no DB)

it('orders() returns a HasMany relation', function () {
    $delivery = new Delivery(['type' => 'regular']);

    expect($delivery->orders())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});

it('orders() uses id_delivery as the foreign key on orders table', function () {
    $delivery = new Delivery();
    $relation = $delivery->orders();

    expect($relation->getForeignKeyName())->toBe('id_delivery');
});

it('orders() is related to the Orders model', function () {
    $delivery = new Delivery();
    $relation = $delivery->orders();

    expect($relation->getRelated())->toBeInstanceOf(Orders::class);
});

// Relation data access via setRelation (no DB)

it('accesses orders relation data correctly', function () {
    $order1 = new Orders(['status_order' => 'Pending', 'total_payment' => 50000]);
    $order2 = new Orders(['status_order' => 'completed', 'total_payment' => 80000]);

    $delivery = new Delivery(['type' => 'regular', 'delivery_charges' => 15000]);
    $delivery->setRelation('orders', collect([$order1, $order2]));

    $orders = collect($delivery->orders);
    expect($orders)->toHaveCount(2);
    expect($orders->first()->status_order)->toBe('Pending');
    expect($orders->last()->total_payment)->toBe(80000);
});

it('accesses empty orders relation correctly', function () {
    $delivery = new Delivery(['type' => 'free', 'delivery_charges' => 0]);
    $delivery->setRelation('orders', collect([]));

    $orders = collect($delivery->orders);
    expect($orders)->toHaveCount(0);
    expect($orders->isEmpty())->toBeTrue();
});

// getAllOptions() — DB::pretend() intercepts self::all() so no real query runs.
// The return line executes → coverage recorded.

it('getAllOptions returns a collection of delivery options', function () {
    DB::pretend(function () {
        $result = Delivery::getAllOptions();

        expect($result)->toBeInstanceOf(\Illuminate\Database\Eloquent\Collection::class);
    });
});
