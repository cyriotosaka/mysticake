<?php

use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Eloquent\Relations\HasMany;

it('uses the correct table and primary key', function () {
    $store = new Store();

    expect($store->getTable())->toBe('store');
    expect($store->getKeyName())->toBe('id_store');
});

it('does not use timestamps', function () {
    $store = new Store();

    expect($store->timestamps)->toBeFalse();
});

it('allows mass assignment for fillable attributes', function () {
    $store = new Store([
        'name_store' => 'Mystic Bakery',
        'rating_store' => 4.8,
        'store_picture' => 'store.jpg',
    ]);

    expect($store->name_store)->toBe('Mystic Bakery');
    expect($store->rating_store)->toBe(4.8);
    expect($store->store_picture)->toBe('store.jpg');
});

it('products() returns a HasMany relation with the correct keys', function () {
    $store = new Store(['id_store' => 5]);
    $relation = $store->products();

    expect($relation)->toBeInstanceOf(HasMany::class);
    expect($relation->getForeignKeyName())->toBe('id_store');
    expect($relation->getLocalKeyName())->toBe('id_store');
    expect(get_class($relation->getRelated()))->toBe(Product::class);
});

it('returns related products when relation is set without database access', function () {
    $product = new Product(['name_product' => 'Chocolate Cake', 'price' => 75000]);
    $store = new Store(['id_store' => 5]);
    $store->setRelation('products', collect([$product]));

    expect($store->products)->toHaveCount(1);
    expect($store->products->first()->name_product)->toBe('Chocolate Cake');
});
