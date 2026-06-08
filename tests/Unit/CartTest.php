<?php

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

afterEach(fn () => Mockery::close());

// CartItem tests

it('calculates subtotal correctly', function () {
    $product = new Product();
    $product->price = 50000;

    $item = new CartItem(['quantity' => 2]);
    $item->setRelation('product', $product);

    expect($item->getSubtotal())->toEqual(100000);
});

it('calculates subtotal with quantity of one', function () {
    $product = new Product();
    $product->price = 75000;

    $item = new CartItem(['quantity' => 1]);
    $item->setRelation('product', $product);

    expect($item->getSubtotal())->toEqual(75000);
});

it('calculates subtotal as zero when quantity is zero', function () {
    $product = new Product();
    $product->price = 50000;

    $item = new CartItem(['quantity' => 0]);
    $item->setRelation('product', $product);

    expect($item->getSubtotal())->toEqual(0);
});

// Cart tests

it('calculates total amount for selected items', function () {
    $product1 = new Product();
    $product1->price = 50000;

    $product2 = new Product();
    $product2->price = 30000;

    $item1 = new CartItem(['quantity' => 2]);
    $item1->setRelation('product', $product1);

    $item2 = new CartItem(['quantity' => 1]);
    $item2->setRelation('product', $product2);

    /** @var Cart $cart */
    $cart = Mockery::mock(Cart::class)->makePartial();
    $cart->shouldReceive('getSelectedItems')
        ->with([1, 2])
        ->andReturn(collect([$item1, $item2]));

    expect($cart->getTotalAmount([1, 2]))->toEqual(130000);
});

it('returns zero total when no items match selected ids', function () {
    /** @var Cart $cart */
    $cart = Mockery::mock(Cart::class)->makePartial();
    $cart->shouldReceive('getSelectedItems')
        ->with([99])
        ->andReturn(collect([]));

    expect($cart->getTotalAmount([99]))->toEqual(0);
});
