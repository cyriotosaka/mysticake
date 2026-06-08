<?php

use App\Models\ReviewStore;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

it('uses the correct table and primary key', function () {
    $reviewStore = new ReviewStore();

    expect($reviewStore->getTable())->toBe('review_store');
    expect($reviewStore->getKeyName())->toBe('id_review_store');
});

it('does not use timestamps', function () {
    $reviewStore = new ReviewStore();

    expect($reviewStore->timestamps)->toBeFalse();
});

it('allows mass assignment for fillable attributes', function () {
    $reviewStore = new ReviewStore([
        'id_store' => 1,
        'id_user' => 2,
        'comment' => 'Great service',
        'like_review' => 10,
        'rating' => 5,
    ]);

    expect($reviewStore->id_store)->toBe(1);
    expect($reviewStore->id_user)->toBe(2);
    expect($reviewStore->comment)->toBe('Great service');
    expect($reviewStore->like_review)->toBe(10);
    expect($reviewStore->rating)->toBe(5);
});

it('store() returns a BelongsTo relation with the correct keys', function () {
    $reviewStore = new ReviewStore();
    $relation = $reviewStore->store();

    expect($relation)->toBeInstanceOf(BelongsTo::class);
    expect($relation->getForeignKeyName())->toBe('id_store');
    expect($relation->getOwnerKeyName())->toBe('id_store');
    expect(get_class($relation->getRelated()))->toBe(Store::class);
});

it('user() returns a BelongsTo relation with the correct keys', function () {
    $reviewStore = new ReviewStore();
    $relation = $reviewStore->user();

    expect($relation)->toBeInstanceOf(BelongsTo::class);
    expect($relation->getForeignKeyName())->toBe('id_user');
    expect($relation->getOwnerKeyName())->toBe('id_user');
    expect(get_class($relation->getRelated()))->toBe(User::class);
});
