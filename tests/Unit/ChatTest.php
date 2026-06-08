<?php

use App\Models\Chat;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;

// Fillable attribute tests

it('stores message and sender_role correctly', function () {
    $chat = new Chat([
        'id_user' => 1,
        'id_store' => 2,
        'message' => 'Hello, is this available?',
        'date' => '2026-06-08',
        'time' => '14:30:00',
        'sender_role' => 'user',
    ]);

    expect($chat->message)->toBe('Hello, is this available?');
    expect($chat->sender_role)->toBe('user');
});

it('stores store sender_role correctly', function () {
    $chat = new Chat([
        'id_user' => 1,
        'id_store' => 2,
        'message' => 'Yes, still available!',
        'sender_role' => 'store',
    ]);

    expect($chat->sender_role)->toBe('store');
});

it('allows null message for product inquiry chats', function () {
    $chat = new Chat([
        'id_user' => 1,
        'id_store' => 2,
        'id_product' => 5,
        'message' => null,
        'sender_role' => 'user',
    ]);

    expect($chat->message)->toBeNull();
    expect($chat->id_product)->toBe(5);
});

it('allows null id_order when chat is not related to an order', function () {
    $chat = new Chat([
        'id_user' => 1,
        'id_store' => 2,
        'id_order' => null,
        'message' => 'Just browsing!',
    ]);

    expect($chat->id_order)->toBeNull();
});

it('allows null id_product when chat is not related to a product', function () {
    $chat = new Chat([
        'id_user' => 1,
        'id_store' => 2,
        'id_product' => null,
        'message' => 'General inquiry.',
    ]);

    expect($chat->id_product)->toBeNull();
});

// Relationship access via setRelation (no DB)

it('accesses user relation data correctly', function () {
    $user = new User(['username' => 'johndoe', 'email' => 'john@example.com']);

    $chat = new Chat(['id_user' => 1, 'message' => 'Hi!']);
    $chat->setRelation('user', $user);

    expect($chat->user->username)->toBe('johndoe');
    expect($chat->user->email)->toBe('john@example.com');
});

it('accesses store relation data correctly', function () {
    $store = new Store(['name_store' => 'MystiCake Store', 'rating_store' => 5]);

    $chat = new Chat(['id_store' => 2, 'message' => 'Is this available?']);
    $chat->setRelation('store', $store);

    expect($chat->store->name_store)->toBe('MystiCake Store');
    expect($chat->store->rating_store)->toBe(5);
});

it('accesses product relation data correctly', function () {
    $product = new Product(['name_product' => 'Chocolate Cake', 'price' => 75000]);

    $chat = new Chat(['id_product' => 5, 'message' => null]);
    $chat->setRelation('product', $product);

    expect($chat->product->name_product)->toBe('Chocolate Cake');
    expect($chat->product->price)->toBe(75000);
});

it('returns null when product relation is not set', function () {
    $chat = new Chat(['id_product' => null, 'message' => 'General question.']);
    $chat->setRelation('product', null);

    expect($chat->product)->toBeNull();
});

// Relationship method return types (covers belongsTo() lines without hitting DB)

it('user() returns a BelongsTo relation', function () {
    $chat = new Chat(['id_user' => 1]);

    expect($chat->user())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
});

it('store() returns a BelongsTo relation', function () {
    $chat = new Chat(['id_store' => 1]);

    expect($chat->store())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
});

it('orders() returns a BelongsTo relation', function () {
    $chat = new Chat(['id_order' => 1]);

    expect($chat->orders())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
});

it('product() returns a BelongsTo relation', function () {
    $chat = new Chat(['id_product' => 1]);

    expect($chat->product())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
});
