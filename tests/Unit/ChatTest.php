<?php

use App\Models\Chat;
use Carbon\Carbon;

// Model attribute tests

it('can instantiate a chat with all fields', function () {
    $chat = new Chat([
        'id_user'     => 1,
        'id_store'    => 2,
        'message'     => 'Hello, is this available?',
        'date'        => '2026-06-08',
        'time'        => '14:30:00',
        'sender_role' => 'user',
    ]);

    expect($chat->message)->toBe('Hello, is this available?');
    expect($chat->sender_role)->toBe('user');
});

it('allows null message for product inquiry chats', function () {
    $chat = new Chat([
        'id_user'    => 1,
        'id_store'   => 2,
        'id_product' => 5,
        'message'    => null,
        'sender_role' => 'user',
    ]);

    expect($chat->message)->toBeNull();
    expect($chat->id_product)->toBe(5);
});

// Duplicate product chat detection logic (from ChatController::chatWithProduct)

it('should create new chat bubble when no previous chat exists', function () {
    $lastChat  = null;
    $productId = 5;

    $shouldCreate = ! $lastChat || $lastChat->id_product != $productId;

    expect($shouldCreate)->toBeTrue();
});

it('should create new chat bubble when last chat is for a different product', function () {
    $lastChat  = new Chat(['id_product' => 3]);
    $productId = 5;

    $shouldCreate = ! $lastChat || $lastChat->id_product != $productId;

    expect($shouldCreate)->toBeTrue();
});

it('should not create duplicate chat bubble for the same product', function () {
    $lastChat  = new Chat(['id_product' => 5]);
    $productId = 5;

    $shouldCreate = ! $lastChat || $lastChat->id_product != $productId;

    expect($shouldCreate)->toBeFalse();
});

// Time formatting logic (from ChatController::index)

it('formats time as H:i when chat is from today', function () {
    $chat = new Chat([
        'date' => now()->format('Y-m-d'),
        'time' => '14:30:00',
    ]);

    $formatted = Carbon::parse($chat->date)->isToday()
        ? Carbon::parse($chat->time)->format('H:i')
        : Carbon::parse($chat->date)->format('d/m');

    expect($formatted)->toBe('14:30');
});

it('formats date as d/m when chat is from a past date', function () {
    $chat = new Chat([
        'date' => '2026-01-15',
        'time' => '09:00:00',
    ]);

    $formatted = Carbon::parse($chat->date)->isToday()
        ? Carbon::parse($chat->time)->format('H:i')
        : Carbon::parse($chat->date)->format('d/m');

    expect($formatted)->toBe('15/01');
});
