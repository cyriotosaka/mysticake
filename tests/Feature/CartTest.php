<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    private function createUser()
    {
        return User::factory()->create();
    }

    private function createProduct()
    {
        return Product::create([
            'id_store' => 1,
            'name_product' => 'Brownies',
            'description' => 'Test Product',
            'price' => 10000,
            'stock' => 10,
            'product_picture' => 'test.jpg',
        ]);
    }

    public function test_user_can_view_cart()
    {
        $user = $this->createUser();

        $response = $this
            ->actingAs($user)
            ->get(route('cart.index'));

        $response->assertStatus(200);
    }

    public function test_user_can_add_product_to_cart()
    {
        $user = $this->createUser();

        $product = $this->createProduct();

        $this->actingAs($user)
            ->post(route('cart.add', $product->id_product));

        $this->assertDatabaseCount('cart_item', 1);
    }

    public function test_existing_product_quantity_increases()
    {
        $user = $this->createUser();

        $product = $this->createProduct();

        $cart = Cart::create([
            'id_user' => $user->id_user,
        ]);

        CartItem::create([
            'id_cart' => $cart->id_cart,
            'id_product' => $product->id_product,
            'quantity' => 1,
        ]);

        $this->actingAs($user)
            ->post(route('cart.add', $product->id_product));

        $this->assertDatabaseHas('cart_item', [
            'id_product' => $product->id_product,
            'quantity' => 2,
        ]);
    }

    public function test_user_can_update_quantity()
    {
        $user = $this->createUser();

        $product = $this->createProduct();

        $cart = Cart::create([
            'id_user' => $user->id_user,
        ]);

        $item = CartItem::create([
            'id_cart' => $cart->id_cart,
            'id_product' => $product->id_product,
            'quantity' => 1,
        ]);

        $this->actingAs($user)
            ->post(route('cart.update', $item->id_cart_item), [
                'quantity' => 3,
            ]);

        $this->assertDatabaseHas('cart_item', [
            'id_cart_item' => $item->id_cart_item,
            'quantity' => 3,
        ]);
    }

    public function test_user_can_delete_item()
    {
        $user = $this->createUser();

        $product = $this->createProduct();

        $cart = Cart::create([
            'id_user' => $user->id_user,
        ]);

        $item = CartItem::create([
            'id_cart' => $cart->id_cart,
            'id_product' => $product->id_product,
            'quantity' => 1,
        ]);

        $this->actingAs($user)
            ->delete(route('cart.delete', $item->id_cart_item));

        $this->assertDatabaseMissing('cart_item', [
            'id_cart_item' => $item->id_cart_item,
        ]);
    }

    public function test_checkout_stores_selected_items_in_session()
    {
        $user = $this->createUser();

        $product = $this->createProduct();

        $cart = Cart::create([
            'id_user' => $user->id_user,
        ]);

        $item = CartItem::create([
            'id_cart' => $cart->id_cart,
            'id_product' => $product->id_product,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($user)
            ->post(route('cart.checkout'), [
                'selected_items' => [$item->id_cart_item],
            ]);

        $response->assertSessionHas('selected_cart_items');
    }

    public function test_gacha_item_cannot_be_updated()
    {
        $user = $this->createUser();

        $product = $this->createProduct();

        $cart = Cart::create([
            'id_user' => $user->id_user,
        ]);

        $item = CartItem::create([
            'id_cart' => $cart->id_cart,
            'id_product' => $product->id_product,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($user)
            ->withSession([
                'gacha_item_ids' => [$item->id_cart_item],
            ])
            ->post(route('cart.update', $item->id_cart_item), [
                'quantity' => 5,
            ]);

        $response->assertSessionHas('error');
    }
}