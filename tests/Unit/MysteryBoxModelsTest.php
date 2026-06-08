<?php

use App\Models\MysteryBox;
use App\Models\MysteryBoxHistory;
use App\Models\MysteryBoxProduct;
use App\Models\Product;

// ══════════════════════════════════════════════════════════════════
// MysteryBox
// ══════════════════════════════════════════════════════════════════

// Fillable attribute tests

it('MysteryBox stores name_box and description correctly', function () {
    $box = new MysteryBox(['name_box' => 'Surprise Box', 'description' => 'A mystery cake box']);

    expect($box->name_box)->toBe('Surprise Box');
    expect($box->description)->toBe('A mystery cake box');
});

it('MysteryBox stores name_box with null description', function () {
    $box = new MysteryBox(['name_box' => 'Premium Box', 'description' => null]);

    expect($box->name_box)->toBe('Premium Box');
    expect($box->description)->toBeNull();
});

// items() relation — type, FK, related model (no DB)

it('MysteryBox items() returns a HasMany relation', function () {
    $box = new MysteryBox(['name_box' => 'Surprise Box']);

    expect($box->items())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});

it('MysteryBox items() uses id_mystery_box as the foreign key', function () {
    $box = new MysteryBox();

    expect($box->items()->getForeignKeyName())->toBe('id_mystery_box');
});

it('MysteryBox items() is related to MysteryBoxProduct', function () {
    $box = new MysteryBox();

    expect($box->items()->getRelated())->toBeInstanceOf(MysteryBoxProduct::class);
});

// products() relation — type, pivot table, related model (no DB)

it('MysteryBox products() returns a BelongsToMany relation', function () {
    $box = new MysteryBox(['name_box' => 'Surprise Box']);

    expect($box->products())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class);
});

it('MysteryBox products() uses mystery_box_product as the pivot table', function () {
    $box = new MysteryBox();

    expect($box->products()->getTable())->toBe('mystery_box_product');
});

it('MysteryBox products() is related to Product', function () {
    $box = new MysteryBox();

    expect($box->products()->getRelated())->toBeInstanceOf(Product::class);
});

// Relation data access via setRelation (no DB)

it('MysteryBox accesses items relation data correctly', function () {
    $item1 = new MysteryBoxProduct(['type_gacha' => 'normal',  'drop_rate' => 0.6]);
    $item2 = new MysteryBoxProduct(['type_gacha' => 'premium', 'drop_rate' => 0.4]);

    $box = new MysteryBox(['name_box' => 'Surprise Box']);
    $box->setRelation('items', collect([$item1, $item2]));

    $items = collect($box->items);
    expect($items)->toHaveCount(2);
    expect($items->first()->type_gacha)->toBe('normal');
    expect($items->last()->type_gacha)->toBe('premium');
});

it('MysteryBox accesses empty items relation correctly', function () {
    $box = new MysteryBox(['name_box' => 'Empty Box']);
    $box->setRelation('items', collect([]));

    expect(collect($box->items)->isEmpty())->toBeTrue();
});

// ══════════════════════════════════════════════════════════════════
// MysteryBoxHistory
// ══════════════════════════════════════════════════════════════════

// Fillable attribute tests

it('MysteryBoxHistory stores id_user and id_product correctly', function () {
    $history = new MysteryBoxHistory(['id_user' => 1, 'id_product' => 5]);

    expect($history->id_user)->toBe(1);
    expect($history->id_product)->toBe(5);
});

it('MysteryBoxHistory stores different user and product ids', function () {
    $history = new MysteryBoxHistory(['id_user' => 42, 'id_product' => 99]);

    expect($history->id_user)->toBe(42);
    expect($history->id_product)->toBe(99);
});

// product() relation — type, FK, related model (no DB)

it('MysteryBoxHistory product() returns a BelongsTo relation', function () {
    $history = new MysteryBoxHistory(['id_product' => 5]);

    expect($history->product())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
});

it('MysteryBoxHistory product() uses id_product as the foreign key', function () {
    $history = new MysteryBoxHistory();

    expect($history->product()->getForeignKeyName())->toBe('id_product');
});

it('MysteryBoxHistory product() is related to Product', function () {
    $history = new MysteryBoxHistory();

    expect($history->product()->getRelated())->toBeInstanceOf(Product::class);
});

// Relation data access via setRelation (no DB)

it('MysteryBoxHistory accesses product relation data correctly', function () {
    $product = new Product(['name_product' => 'Chocolate Cake', 'price' => 75000]);

    $history = new MysteryBoxHistory(['id_user' => 1, 'id_product' => 5]);
    $history->setRelation('product', $product);

    expect($history->product->name_product)->toBe('Chocolate Cake');
    expect($history->product->price)->toBe(75000);
});

it('MysteryBoxHistory returns null when product relation is not set', function () {
    $history = new MysteryBoxHistory(['id_user' => 1, 'id_product' => null]);
    $history->setRelation('product', null);

    expect($history->product)->toBeNull();
});

// ══════════════════════════════════════════════════════════════════
// MysteryBoxProduct (relations only — casts covered in MysteryBoxTest.php)
// ══════════════════════════════════════════════════════════════════

// Fillable attribute tests

it('MysteryBoxProduct stores all fillable fields correctly', function () {
    $item = new MysteryBoxProduct([
        'id_mystery_box' => 1,
        'id_product'     => 3,
        'price'          => 25000,
        'point_gacha'    => 10,
        'history_gacha'  => 0,
        'type_gacha'     => 'premium',
        'drop_rate'      => 0.3,
        'cashback'       => 500,
    ]);

    expect($item->id_mystery_box)->toBe(1);
    expect($item->id_product)->toBe(3);
    expect($item->type_gacha)->toBe('premium');
    expect($item->drop_rate)->toBe(0.3);
    expect($item->price)->toBe(25000);
    expect($item->cashback)->toBe(500);
});

// mysteryBox() relation — type, FK, related model (no DB)

it('MysteryBoxProduct mysteryBox() returns a BelongsTo relation', function () {
    $item = new MysteryBoxProduct(['id_mystery_box' => 1]);

    expect($item->mysteryBox())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
});

it('MysteryBoxProduct mysteryBox() uses id_mystery_box as the foreign key', function () {
    $item = new MysteryBoxProduct();

    expect($item->mysteryBox()->getForeignKeyName())->toBe('id_mystery_box');
});

it('MysteryBoxProduct mysteryBox() is related to MysteryBox', function () {
    $item = new MysteryBoxProduct();

    expect($item->mysteryBox()->getRelated())->toBeInstanceOf(MysteryBox::class);
});

// product() relation — type, FK, related model (no DB)

it('MysteryBoxProduct product() returns a BelongsTo relation', function () {
    $item = new MysteryBoxProduct(['id_product' => 3]);

    expect($item->product())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
});

it('MysteryBoxProduct product() uses id_product as the foreign key', function () {
    $item = new MysteryBoxProduct();

    expect($item->product()->getForeignKeyName())->toBe('id_product');
});

it('MysteryBoxProduct product() is related to Product', function () {
    $item = new MysteryBoxProduct();

    expect($item->product()->getRelated())->toBeInstanceOf(Product::class);
});

// Relation data access via setRelation (no DB)

it('MysteryBoxProduct accesses mysteryBox relation data correctly', function () {
    $box = new MysteryBox(['name_box' => 'Premium Box', 'description' => 'Top tier cakes']);

    $item = new MysteryBoxProduct(['id_mystery_box' => 1, 'type_gacha' => 'premium']);
    $item->setRelation('mysteryBox', $box);

    expect($item->mysteryBox->name_box)->toBe('Premium Box');
    expect($item->mysteryBox->description)->toBe('Top tier cakes');
});

it('MysteryBoxProduct accesses product relation data correctly', function () {
    $product = new Product(['name_product' => 'Red Velvet', 'price' => 60000]);

    $item = new MysteryBoxProduct(['id_product' => 3, 'drop_rate' => 0.5]);
    $item->setRelation('product', $product);

    expect($item->product->name_product)->toBe('Red Velvet');
    expect($item->product->price)->toBe(60000);
});
