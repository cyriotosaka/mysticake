<?php

use App\Models\Orders;
use App\Models\PaymentMethod;

// Fillable attribute tests

it('stores name_method and payment_barcode correctly', function () {
    $method = new PaymentMethod([
        'name_method'     => 'Bank Transfer',
        'payment_barcode' => 'barcodes/bca.png',
    ]);

    expect($method->name_method)->toBe('Bank Transfer');
    expect($method->payment_barcode)->toBe('barcodes/bca.png');
});

it('stores a different payment method correctly', function () {
    $method = new PaymentMethod([
        'name_method'     => 'GoPay',
        'payment_barcode' => 'barcodes/gopay.png',
    ]);

    expect($method->name_method)->toBe('GoPay');
    expect($method->payment_barcode)->toBe('barcodes/gopay.png');
});

it('stores null payment_barcode when method has no barcode', function () {
    $method = new PaymentMethod([
        'name_method'     => 'Cash on Delivery',
        'payment_barcode' => null,
    ]);

    expect($method->name_method)->toBe('Cash on Delivery');
    expect($method->payment_barcode)->toBeNull();
});

// orders() relation — type, FK, related model (no DB)

it('orders() returns a HasMany relation', function () {
    $method = new PaymentMethod(['name_method' => 'Bank Transfer']);

    expect($method->orders())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});

it('orders() uses id_payment_method as the foreign key', function () {
    $method = new PaymentMethod();

    expect($method->orders()->getForeignKeyName())->toBe('id_payment_method');
});

it('orders() is related to the Orders model', function () {
    $method = new PaymentMethod();

    expect($method->orders()->getRelated())->toBeInstanceOf(Orders::class);
});

// Relation data access via setRelation (no DB)

it('accesses orders relation data correctly', function () {
    $order1 = new Orders(['status_order' => 'Pending',   'total_payment' => 75000]);
    $order2 = new Orders(['status_order' => 'completed', 'total_payment' => 120000]);

    $method = new PaymentMethod(['name_method' => 'Bank Transfer']);
    $method->setRelation('orders', collect([$order1, $order2]));

    $orders = collect($method->orders);
    expect($orders)->toHaveCount(2);
    expect($orders->first()->status_order)->toBe('Pending');
    expect($orders->last()->total_payment)->toBe(120000);
});

it('accesses empty orders relation correctly', function () {
    $method = new PaymentMethod(['name_method' => 'GoPay']);
    $method->setRelation('orders', collect([]));

    expect(collect($method->orders)->isEmpty())->toBeTrue();
});
