<?php

use App\Models\History;
use App\Models\Orders;

// Fillable attribute tests

it('stores id_order, date, and time correctly', function () {
    $history = new History([
        'id_order' => 10,
        'date'     => '2026-06-08',
        'time'     => '14:30:00',
    ]);

    expect($history->id_order)->toBe(10);
    expect($history->date)->toBe('2026-06-08');
    expect($history->time)->toBe('14:30:00');
});

it('stores different date and time values correctly', function () {
    $history = new History([
        'id_order' => 5,
        'date'     => '2025-12-25',
        'time'     => '08:00:00',
    ]);

    expect($history->id_order)->toBe(5);
    expect($history->date)->toBe('2025-12-25');
    expect($history->time)->toBe('08:00:00');
});

it('allows null date and time when not provided', function () {
    $history = new History(['id_order' => 3]);

    expect($history->date)->toBeNull();
    expect($history->time)->toBeNull();
});

// Relationship method — type, foreign key, and related model (no DB)

it('orders() returns a BelongsTo relation', function () {
    $history = new History(['id_order' => 1]);

    expect($history->orders())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
});

it('orders() uses id_order as the foreign key', function () {
    $history = new History();
    $relation = $history->orders();

    expect($relation->getForeignKeyName())->toBe('id_order');
});

it('orders() is related to the Orders model', function () {
    $history = new History();
    $relation = $history->orders();

    expect($relation->getRelated())->toBeInstanceOf(Orders::class);
});

// Relation data access via setRelation (no DB)

it('accesses order data through orders relation', function () {
    $order = new Orders([
        'status_order'  => 'completed',
        'total_payment' => 120000,
        'order_date'    => '2026-06-08',
    ]);

    $history = new History(['id_order' => 10, 'date' => '2026-06-08']);
    $history->setRelation('orders', $order);

    expect($history->orders->status_order)->toBe('completed');
    expect($history->orders->total_payment)->toBe(120000);
});

it('accesses pending order data through orders relation', function () {
    $order = new Orders([
        'status_order'  => 'Pending',
        'total_payment' => 50000,
    ]);

    $history = new History(['id_order' => 7]);
    $history->setRelation('orders', $order);

    expect($history->orders->status_order)->toBe('Pending');
});

it('returns null when orders relation is not set', function () {
    $history = new History(['id_order' => null]);
    $history->setRelation('orders', null);

    expect($history->orders)->toBeNull();
});
