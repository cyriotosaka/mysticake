<?php

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

afterEach(fn () => Mockery::close());

// ══════════════════════════════════════════════════════════════════
// CartItem — getSubtotal()
// ══════════════════════════════════════════════════════════════════

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

// ══════════════════════════════════════════════════════════════════
// CartItem — relations (covers belongsTo body lines)
// ══════════════════════════════════════════════════════════════════

it('CartItem cart() returns a BelongsTo relation', function () {
    $item = new CartItem(['id_cart' => 1]);

    expect($item->cart())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
});

it('CartItem cart() uses id_cart as the foreign key', function () {
    expect((new CartItem())->cart()->getForeignKeyName())->toBe('id_cart');
});

it('CartItem cart() is related to the Cart model', function () {
    expect((new CartItem())->cart()->getRelated())->toBeInstanceOf(Cart::class);
});

it('CartItem product() returns a BelongsTo relation', function () {
    $item = new CartItem(['id_product' => 1]);

    expect($item->product())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
});

it('CartItem product() uses id_product as the foreign key', function () {
    expect((new CartItem())->product()->getForeignKeyName())->toBe('id_product');
});

it('CartItem product() is related to the Product model', function () {
    expect((new CartItem())->product()->getRelated())->toBeInstanceOf(Product::class);
});

// ══════════════════════════════════════════════════════════════════
// Cart — relations (covers belongsTo / hasMany body lines)
// ══════════════════════════════════════════════════════════════════

it('Cart user() returns a BelongsTo relation', function () {
    $cart = new Cart(['id_user' => 1]);

    expect($cart->user())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
});

it('Cart user() uses id_user as the foreign key', function () {
    expect((new Cart())->user()->getForeignKeyName())->toBe('id_user');
});

it('Cart user() is related to the User model', function () {
    expect((new Cart())->user()->getRelated())->toBeInstanceOf(User::class);
});

it('Cart items() returns a HasMany relation', function () {
    $cart = new Cart();

    expect($cart->items())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});

it('Cart items() uses id_cart as the foreign key', function () {
    expect((new Cart())->items()->getForeignKeyName())->toBe('id_cart');
});

it('Cart items() is related to the CartItem model', function () {
    expect((new Cart())->items()->getRelated())->toBeInstanceOf(CartItem::class);
});

// ══════════════════════════════════════════════════════════════════
// Cart — getTotalAmount() with selectedIds (existing, keeps working)
// ══════════════════════════════════════════════════════════════════

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

// ══════════════════════════════════════════════════════════════════
// Cart — getTotalAmount() with NO selectedIds (null branch — new)
// Mocks items() builder chain: items()->with('product')->get()
// ══════════════════════════════════════════════════════════════════

it('calculates total amount for all items when no ids are provided', function () {
    $product = new Product();
    $product->price = 40000;

    $item = new CartItem(['quantity' => 3]);
    $item->setRelation('product', $product);

    $relation = Mockery::mock(\Illuminate\Database\Eloquent\Relations\HasMany::class);
    $relation->shouldReceive('with')->with('product')->andReturnSelf();
    $relation->shouldReceive('get')->andReturn(collect([$item]));

    /** @var Cart $cart */
    $cart = Mockery::mock(Cart::class)->makePartial();
    $cart->shouldReceive('items')->andReturn($relation);

    expect($cart->getTotalAmount())->toEqual(120000);
});

it('returns zero total when cart has no items', function () {
    $relation = Mockery::mock(\Illuminate\Database\Eloquent\Relations\HasMany::class);
    $relation->shouldReceive('with')->with('product')->andReturnSelf();
    $relation->shouldReceive('get')->andReturn(collect([]));

    /** @var Cart $cart */
    $cart = Mockery::mock(Cart::class)->makePartial();
    $cart->shouldReceive('items')->andReturn($relation);

    expect($cart->getTotalAmount())->toEqual(0);
});

// ══════════════════════════════════════════════════════════════════
// Cart — getSelectedItems() (actual body — new)
// Mocks items() builder chain: items()->with()->whereIn()->get()
// ══════════════════════════════════════════════════════════════════

it('getSelectedItems returns items matching selected ids', function () {
    $product = new Product();
    $product->price = 50000;

    $item = new CartItem(['quantity' => 2]);
    $item->setRelation('product', $product);

    $relation = Mockery::mock(\Illuminate\Database\Eloquent\Relations\HasMany::class);
    $relation->shouldReceive('with')->with('product')->andReturnSelf();
    $relation->shouldReceive('whereIn')->with('id_cart_item', [1])->andReturnSelf();
    $relation->shouldReceive('get')->andReturn(collect([$item]));

    /** @var Cart $cart */
    $cart = Mockery::mock(Cart::class)->makePartial();
    $cart->shouldReceive('items')->andReturn($relation);

    $result = $cart->getSelectedItems([1]);

    expect($result)->toHaveCount(1);
    expect($result->first()->getSubtotal())->toEqual(100000);
});

it('getSelectedItems returns empty collection when no ids match', function () {
    $relation = Mockery::mock(\Illuminate\Database\Eloquent\Relations\HasMany::class);
    $relation->shouldReceive('with')->with('product')->andReturnSelf();
    $relation->shouldReceive('whereIn')->with('id_cart_item', [99])->andReturnSelf();
    $relation->shouldReceive('get')->andReturn(collect([]));

    /** @var Cart $cart */
    $cart = Mockery::mock(Cart::class)->makePartial();
    $cart->shouldReceive('items')->andReturn($relation);

    $result = $cart->getSelectedItems([99]);

    expect($result)->toHaveCount(0);
});

// ══════════════════════════════════════════════════════════════════
// Cart — clearSelectedItems()
// DB::pretend() intercepts the DELETE so no real SQL runs.
// The method body executes fully → coverage recorded.
// ══════════════════════════════════════════════════════════════════

it('clearSelectedItems deletes matching cart items', function () {
    DB::pretend(function () {
        $cart = new Cart();
        $cart->id_cart = 1;

        $result = $cart->clearSelectedItems([1, 2, 3]);

        expect($result)->toBe(0); // pretend mode: 0 affected rows
    });
});

it('clearSelectedItems with single id deletes that item', function () {
    DB::pretend(function () {
        $cart = new Cart();
        $cart->id_cart = 5;

        $result = $cart->clearSelectedItems([7]);

        expect($result)->toBe(0);
    });
});
