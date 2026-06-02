<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Chat;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChatTest extends TestCase
{
    use RefreshDatabase;

    private function createUser()
    {
        return User::factory()->create();
    }

    private function createStore()
    {
        return Store::create([
            'name_store' => 'MystiCake Store',
            'rating_store' => 5,
            'store_picture' => 'store.jpg',
        ]);
    }

    private function createProduct($store)
    {
        return Product::create([
            'id_store' => $store->id_store,
            'name_product' => 'Brownies',
            'description' => 'Test Product',
            'price' => 10000,
            'stock' => 10,
            'product_picture' => 'brownies.jpg',
        ]);
    }

    public function test_user_can_view_chat_list()
    {
        $user = $this->createUser();

        $response = $this
            ->actingAs($user)
            ->get(route('chat.index'));

        $response->assertStatus(200);
    }

    public function test_user_can_open_chat_room()
    {
        $user = $this->createUser();
        $store = $this->createStore();

        $response = $this
            ->actingAs($user)
            ->get(route('chat.show', $store->id_store));

        $response->assertStatus(200);
    }

    public function test_user_can_send_message()
    {
        $user = $this->createUser();
        $store = $this->createStore();

        $this->actingAs($user)
            ->post(route('chat.send', $store->id_store), [
                'message' => 'Halo toko',
            ]);

        $this->assertDatabaseHas('chat', [
            'id_user' => $user->id_user,
            'id_store' => $store->id_store,
            'message' => 'Halo toko',
        ]);
    }

    public function test_message_is_required()
    {
        $user = $this->createUser();
        $store = $this->createStore();

        $response = $this
            ->actingAs($user)
            ->post(route('chat.send', $store->id_store), [
                'message' => '',
            ]);

        $response->assertSessionHasErrors('message');
    }

    public function test_user_can_start_chat_from_product()
    {
        $user = $this->createUser();

        $store = $this->createStore();

        $product = $this->createProduct($store);

        $this->actingAs($user)
            ->get(route('chat.product', $product->id_product));

        $this->assertDatabaseHas('chat', [
            'id_user' => $user->id_user,
            'id_store' => $store->id_store,
            'id_product' => $product->id_product,
            'sender_role' => 'user',
        ]);
    }

    public function test_duplicate_product_chat_is_not_created()
    {
        $user = $this->createUser();

        $store = $this->createStore();

        $product = $this->createProduct($store);

        Chat::create([
            'id_user' => $user->id_user,
            'id_store' => $store->id_store,
            'id_product' => $product->id_product,
            'message' => null,
            'date' => now()->format('Y-m-d'),
            'time' => now()->format('H:i:s'),
            'sender_role' => 'user',
        ]);

        $this->actingAs($user)
            ->get(route('chat.product', $product->id_product));

        $this->assertDatabaseCount('chat', 1);
    }
}