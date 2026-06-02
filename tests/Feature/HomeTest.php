<?php

use App\Models\User;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase; // <-- ADD THIS

uses(RefreshDatabase::class);

it('redirects unauthenticated users to login page', function () {
    $response = $this->get('/home');

    $response->assertRedirect('/login');
});

it('allows authenticated users to view the home page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/home');

    $response->assertStatus(200);
    $response->assertViewIs('home');
});

it('passes the correct data to the home view', function () {
    $user = User::factory()->create();

    // Create a product for recommendations
    Product::factory()->count(3)->create();

    // Create a cart and some items for this user
    $cart = Cart::create(['id_user' => $user->id_user]);
    CartItem::create([
        'id_cart' => $cart->id_cart,
        'id_product' => Product::first()->id_product,
        'quantity' => 1,
        'price' => 10000
    ]);
    CartItem::create([
        'id_cart' => $cart->id_cart,
        'id_product' => Product::latest()->first()->id_product,
        'quantity' => 2,
        'price' => 20000
    ]);

    $response = $this->actingAs($user)->get('/home');

    $response->assertStatus(200);
    $response->assertViewHasAll(['user', 'cartCount', 'recommendations']);
    
    // Assert cart count is exactly 2 types of items (since we added 2 CartItems)
    expect($response->viewData('cartCount'))->toBe(2);
    
    // Assert it recommends at most 2 products (as per controller logic)
    expect($response->viewData('recommendations'))->toHaveCount(2);
});
