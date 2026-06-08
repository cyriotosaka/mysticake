<?php

use App\Models\Product;
use App\Models\Store;
use Illuminate\Testing\Fluent\AssertableJson;

it('returns drop rates for normal type', function () {
    $store = Store::create(['name_store' => 'Test Store']);

    Product::factory()->create(['id_store' => $store->id_store, 'price' => 10000, 'stock' => 10, 'name_product' => 'Prod A']);
    Product::factory()->create(['id_store' => $store->id_store, 'price' => 20000, 'stock' => 30, 'name_product' => 'Prod B']);
    Product::factory()->create(['id_store' => $store->id_store, 'price' => 40000, 'stock' => 60, 'name_product' => 'Prod C']);

    $response = $this->withoutMiddleware()->getJson(route('gacha.droprates', ['type' => 'normal']));

    $response->assertStatus(200)
        ->assertJsonPath('type', 'normal')
        ->assertJson(fn (AssertableJson $json) => $json->where('total_products', 3)
            ->where('total_stock', 100)
            ->has('rewards', 3)
            ->etc()
        );
});

it('returns drop rates for premium type', function () {
    $store = Store::create(['name_store' => 'Test Store']);

    Product::factory()->create(['id_store' => $store->id_store, 'price' => 50000, 'stock' => 5, 'name_product' => 'Prod P1']);
    Product::factory()->create(['id_store' => $store->id_store, 'price' => 75000, 'stock' => 15, 'name_product' => 'Prod P2']);

    $response = $this->withoutMiddleware()->getJson(route('gacha.droprates', ['type' => 'premium']));

    $response->assertStatus(200)
        ->assertJsonPath('type', 'premium')
        ->assertJson(fn (AssertableJson $json) => $json->where('total_products', 2)
            ->where('total_stock', 20)
            ->has('rewards', 2)
            ->etc()
        );
});
