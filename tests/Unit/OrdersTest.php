<?php

use App\Models\OrderItem;
use App\Models\Orders;

afterEach(fn () => Mockery::close());

it('user() returns a BelongsTo relation with correct keys', function () {
    $relation = (new Orders())->user();

    expect($relation)->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsTo::class);
    expect($relation->getForeignKeyName())->toEqual('id_user');
    expect($relation->getOwnerKeyName())->toEqual('id_user');
});

it('paymentMethod() returns a BelongsTo relation with correct keys', function () {
    $relation = (new Orders())->paymentMethod();

    expect($relation)->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsTo::class);
    expect($relation->getForeignKeyName())->toEqual('id_payment_method');
    expect($relation->getOwnerKeyName())->toEqual('id_payment_method');
});

it('address() returns a BelongsTo relation with correct keys', function () {
    $relation = (new Orders())->address();

    expect($relation)->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsTo::class);
    expect($relation->getForeignKeyName())->toEqual('id_address');
    expect($relation->getOwnerKeyName())->toEqual('id_address');
});

it('delivery() returns a BelongsTo relation with correct keys', function () {
    $relation = (new Orders())->delivery();

    expect($relation)->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsTo::class);
    expect($relation->getForeignKeyName())->toEqual('id_delivery');
    expect($relation->getOwnerKeyName())->toEqual('id_delivery');
});

it('items() returns a HasMany relation with correct keys', function () {
    $relation = (new Orders())->items();

    expect($relation)->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\HasMany::class);
    expect($relation->getForeignKeyName())->toEqual('id_order');
    expect($relation->getLocalKeyName())->toEqual('id_order');
});

it('histories() returns a HasMany relation with correct keys', function () {
    $relation = (new Orders())->histories();

    expect($relation)->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\HasMany::class);
    expect($relation->getForeignKeyName())->toEqual('id_order');
});

it('totalItems sums quantities from items relation', function () {
    $item1 = new OrderItem(['quantity' => 2]);
    $item2 = new OrderItem(['quantity' => 3]);

    /** @var Orders $order */
    $order = Mockery::mock(Orders::class)->makePartial();
    $order->shouldReceive('items')->andReturn(collect([$item1, $item2]));

    expect($order->totalItems())->toEqual(5);
});

it('isCompleted returns true only for completed status', function () {
    $order = new Orders(['status_order' => 'completed']);
    expect($order->isCompleted())->toBeTrue();

    $order2 = new Orders(['status_order' => 'pending']);
    expect($order2->isCompleted())->toBeFalse();
});

it('getFormattedDate returns expected date string', function () {
    $order = new Orders(['order_date' => '2026-06-08 14:30:00']);
    expect($order->getFormattedDate())->toEqual('08 Jun 2026, 14:30');
});

it('getFormattedTotal returns rupiah formatted string', function () {
    $order = new Orders(['total_payment' => 150000]);
    expect($order->getFormattedTotal())->toEqual('Rp 150.000');
});

it('findByUser builds the correct query chain without database access', function () {
    $query = Mockery::mock();
    $query->shouldReceive('with')
        ->with(['items.product', 'address', 'delivery', 'paymentMethod'])
        ->andReturnSelf();
    $query->shouldReceive('orderBy')
        ->with('order_date', 'desc')
        ->andReturnSelf();
    $query->shouldReceive('get')
        ->andReturn(collect(['order-a']));

    $stub = new class($query) extends Orders
    {
        private static $query;

        public function __construct($query)
        {
            self::$query = $query;
        }

        public static function where($column, $value)
        {
            return self::$query;
        }
    };

    $result = get_class($stub)::findByUser(7);

    expect($result)->toEqual(collect(['order-a']));
});

it('createFromCart creates order and order items without database access', function () {
    $cartItem1 = (object) [
        'price' => 10000,
        'quantity' => 2,
        'id_product' => 5,
    ];
    $cartItem2 = (object) [
        'price' => 0,
        'quantity' => 1,
        'id_product' => 6,
    ];
    $cartItems = collect([$cartItem1, $cartItem2]);

    $deliveryMock = (object) ['delivery_charges' => 15000];
    $createdOrder = new Orders();
    $createdOrder->id_order = 111;
    $createdItems = [];

    $stub = new class($deliveryMock, $createdOrder, $createdItems) extends Orders
    {
        private static $delivery;

        private static $createdOrder;

        private static $createdItems;

        public function __construct($delivery, $createdOrder, &$createdItems)
        {
            self::$delivery = $delivery;
            self::$createdOrder = $createdOrder;
            self::$createdItems = &$createdItems;
        }

        protected static function resolveDelivery($deliveryId)
        {
            return self::$delivery;
        }

        public static function create(array $attributes = [])
        {
            return self::$createdOrder;
        }

        protected static function createOrderItem(array $data)
        {
            self::$createdItems[] = $data;
        }
    };

    $stubClass = get_class($stub);
    $result = $stubClass::createFromCart($cartItems, 1, 2, 3, 4, 5000);

    expect($result)->toBe($createdOrder);
    expect($createdItems)->toEqual([
        ['id_order' => 111, 'id_product' => 5, 'quantity' => 2, 'subtotal' => 20000],
        ['id_order' => 111, 'id_product' => 6, 'quantity' => 1, 'subtotal' => 0],
    ]);
});
