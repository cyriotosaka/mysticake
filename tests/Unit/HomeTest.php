<?php

use App\Models\Product;

afterEach(fn () => Mockery::close());

// Product stock logic (used in home page recommendations)

it('returns true when product stock is zero', function () {
    $product = new Product(['stock' => 0]);

    expect($product->isOutOfStock())->toBeTrue();
});

it('returns true when product stock is negative', function () {
    $product = new Product(['stock' => -1]);

    expect($product->isOutOfStock())->toBeTrue();
});

it('returns false when product has stock available', function () {
    $product = new Product(['stock' => 10]);

    expect($product->isOutOfStock())->toBeFalse();
});

// Product picture URL accessor

it('returns product picture url when picture is set', function () {
    $product = new Product(['product_picture' => 'images/products/cake.jpg']);

    expect($product->product_picture_url)->toContain('images/products/cake.jpg');
});

it('returns default image url when product picture is null', function () {
    $product = new Product(['product_picture' => null]);

    expect($product->product_picture_url)->toContain('images/default-product.png');
});

// Stock mutation methods

it('reduces stock by the given quantity', function () {
    /** @var Product $product */
    $product = Mockery::mock(Product::class)->makePartial();
    $product->stock = 10;
    $product->shouldReceive('save')->once()->andReturn(true);

    $product->reduceStock(3);

    expect($product->stock)->toBe(7);
});

it('does not reduce stock when quantity exceeds available stock', function () {
    /** @var Product $product */
    $product = Mockery::mock(Product::class)->makePartial();
    $product->stock = 2;
    $product->shouldReceive('save')->never();

    $product->reduceStock(5);

    expect($product->stock)->toBe(2);
});

it('adds stock by the given quantity', function () {
    /** @var Product $product */
    $product = Mockery::mock(Product::class)->makePartial();
    $product->stock = 5;
    $product->shouldReceive('save')->once()->andReturn(true);

    $product->addStock(10);

    expect($product->stock)->toBe(15);
});
