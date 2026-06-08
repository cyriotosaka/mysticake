<?php

use App\Models\Orders;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\PaymentMethod;
use App\Models\Address;
use App\Models\Delivery;
use App\Models\History;
use Mockery;

afterEach(fn () => Mockery::close());

it('user() returns a BelongsTo relation with correct keys', function () {
    $relation = (new Orders())->user();

    expect($relation)->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsTo::class);
    expect($relation->getForeignKeyName())->toEqual('id_user');
    expect($relation->getOwnerKeyName())->toEqual('id_user');
});

it('paymentMethod() returns a BelongsTo relation with correct keys', function () {
    $relation = (new Orders())->paymentMethod();

    expect($relation)->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsTo::class);
    expect($relation->getForeignKeyName())->toEqual('id_payment_method');
    expect($relation->getOwnerKeyName())->toEqual('id_payment_method');
});

it('address() returns a BelongsTo relation with correct keys', function () {
    $relation = (new Orders())->address();

    expect($relation)->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsTo::class);
    expect($relation->getForeignKeyName())->toEqual('id_address');
    expect($relation->getOwnerKeyName())->toEqual('id_address');
});

it('delivery() returns a BelongsTo relation with correct keys', function () {
    $relation = (new Orders())->delivery();

    expect($relation)->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsTo::class);
    expect($relation->getForeignKeyName())->toEqual('id_delivery');
    expect($relation->getOwnerKeyName())->toEqual('id_delivery');
});

it('items() returns a HasMany relation with correct keys', function () {
    $relation = (new Orders())->items();

    expect($relation)->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\HasMany::class);
    expect($relation->getForeignKeyName())->toEqual('id_order');
    expect($relation->getLocalKeyName())->toEqual('id_order');
});

it('histories() returns a HasMany relation with correct keys', function () {
    $relation = (new Orders())->histories();

    expect($relation)->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\HasMany::class);
    expect($relation->getForeignKeyName())->toEqual('id_order');
});

it('totalItems sums quantities from items relation', function () {
    $item1 = new OrderItem(['quantity' => 2]);
    $item2 = new OrderItem(['quantity' => 3]);

    /** @var Orders $order */
    $order = Mockery::mock(Orders::class)->makePartial();
    $order->shouldReceive('items')->andReturn(collect([$item1, $item2]));

    expect($order->totalItems())->toEqual(5);
});

it('isCompleted returns true only for completed status', function () {
    $order = new Orders(['status_order' => 'completed']);
    expect($order->isCompleted())->toBeTrue();

    $order2 = new Orders(['status_order' => 'pending']);
    expect($order2->isCompleted())->toBeFalse();
});

it('getFormattedDate returns expected date string', function () {
    $order = new Orders(['order_date' => '2026-06-08 14:30:00']);
    expect($order->getFormattedDate())->toEqual('08 Jun 2026, 14:30');
});

it('getFormattedTotal returns rupiah formatted string', function () {
    $order = new Orders(['total_payment' => 150000]);
    expect($order->getFormattedTotal())->toEqual('Rp 150.000');
});

