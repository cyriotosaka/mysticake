<?php

use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Orders;
use Mockery;

afterEach(fn () => Mockery::close());

it('orders() returns a BelongsTo relation with correct keys', function () {
    $relation = (new OrderItem())->orders();

    expect($relation)->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsTo::class);
    expect($relation->getForeignKeyName())->toEqual('id_order');
    expect($relation->getOwnerKeyName())->toEqual('id_order');
});

it('product() returns a BelongsTo relation with correct keys', function () {
    $relation = (new OrderItem())->product();

    expect($relation)->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsTo::class);
    expect($relation->getForeignKeyName())->toEqual('id_product');
    expect($relation->getOwnerKeyName())->toEqual('id_product');
});

it('calculateSubtotal sets subtotal based on related product price and quantity', function () {
    $product = new Product(['price' => 120000]);

    /** @var OrderItem $orderItem */
    $orderItem = Mockery::mock(OrderItem::class)->makePartial();
    $orderItem->quantity = 3;
    $orderItem->setRelation('product', $product);

    // prevent actual DB save
    $orderItem->shouldReceive('save')->once()->andReturnTrue();

    $orderItem->calculateSubtotal();

    expect($orderItem->subtotal)->toEqual(360000);
});

it('calculateSubtotal does nothing when product relation is missing', function () {
    /** @var OrderItem $orderItem */
    $orderItem = Mockery::mock(OrderItem::class)->makePartial();
    $orderItem->quantity = 2;
    $orderItem->setRelation('product', null);

    // ensure save is not called
    $orderItem->shouldReceive('save')->never();

    $orderItem->calculateSubtotal();

    expect($orderItem->subtotal)->toBeNull();
});
