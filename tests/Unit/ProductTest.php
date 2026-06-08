<?php

use App\Models\CartItem;
use App\Models\MysteryBox;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ReviewProduct;
use App\Models\Store;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

afterEach(fn () => Mockery::close());

it('uses the correct table and primary key', function () {
    $product = new Product();

    expect($product->getTable())->toBe('product');
    expect($product->getKeyName())->toBe('id_product');
});

it('does not use timestamps', function () {
    $product = new Product();

    expect($product->timestamps)->toBeFalse();
});

it('allows mass assignment for fillable attributes', function () {
    $product = new Product([
        'id_store' => 1,
        'name_product' => 'Brownies',
        'description' => 'Soft chocolate brownies',
        'price' => 45000,
        'stock' => 10,
        'product_picture' => 'uploads/brownies.png',
    ]);

    expect($product->id_store)->toBe(1);
    expect($product->name_product)->toBe('Brownies');
    expect($product->description)->toBe('Soft chocolate brownies');
    expect($product->price)->toBe(45000);
    expect($product->stock)->toBe(10);
    expect($product->product_picture)->toBe('uploads/brownies.png');
});

it('store() returns a BelongsTo relation with correct keys', function () {
    $product = new Product();
    $relation = $product->store();

    expect($relation)->toBeInstanceOf(BelongsTo::class);
    expect($relation->getForeignKeyName())->toBe('id_store');
    expect($relation->getOwnerKeyName())->toBe('id_store');
    expect(get_class($relation->getRelated()))->toBe(Store::class);
});

it('cartItems() returns a HasMany relation with correct keys', function () {
    $product = new Product();
    $relation = $product->cartItems();

    expect($relation)->toBeInstanceOf(HasMany::class);
    expect($relation->getForeignKeyName())->toBe('id_product');
    expect($relation->getLocalKeyName())->toBe('id_product');
    expect(get_class($relation->getRelated()))->toBe(CartItem::class);
});

it('orderItems() returns a HasMany relation with correct keys', function () {
    $product = new Product();
    $relation = $product->orderItems();

    expect($relation)->toBeInstanceOf(HasMany::class);
    expect($relation->getForeignKeyName())->toBe('id_product');
    expect($relation->getLocalKeyName())->toBe('id_product');
    expect(get_class($relation->getRelated()))->toBe(OrderItem::class);
});

it('reviews() returns a HasMany relation with correct keys', function () {
    $product = new Product();
    $relation = $product->reviews();

    expect($relation)->toBeInstanceOf(HasMany::class);
    expect($relation->getForeignKeyName())->toBe('id_product');
    expect($relation->getLocalKeyName())->toBe('id_product');
    expect(get_class($relation->getRelated()))->toBe(ReviewProduct::class);
});

it('mysteryBoxes() returns a BelongsToMany relation', function () {
    $product = new Product();
    $relation = $product->mysteryBoxes();

    expect($relation)->toBeInstanceOf(BelongsToMany::class);
    expect(get_class($relation->getRelated()))->toBe(MysteryBox::class);
});

it('returns product picture URL when picture is set', function () {
    $product = new Product(['product_picture' => 'uploads/product.png']);

    expect($product->product_picture_url)->toContain('uploads/product.png');
});

it('returns default product picture URL when none is set', function () {
    $product = new Product();

    expect($product->product_picture_url)->toContain('images/default-product.png');
});

it('is out of stock when stock is zero or negative', function () {
    expect((new Product(['stock' => 0]))->isOutOfStock())->toBeTrue();
    expect((new Product(['stock' => -1]))->isOutOfStock())->toBeTrue();
});

it('is not out of stock when stock is positive', function () {
    expect((new Product(['stock' => 5]))->isOutOfStock())->toBeFalse();
});

it('reduces stock and saves the product when there is enough stock', function () {
    /** @var Product $product */
    $product = Mockery::mock(Product::class)->makePartial();
    $product->stock = 6;
    $product->shouldReceive('save')->once()->andReturnTrue();

    $product->reduceStock(2);

    expect($product->stock)->toBe(4);
});

it('does not reduce stock when requested amount exceeds stock', function () {
    /** @var Product $product */
    $product = Mockery::mock(Product::class)->makePartial();
    $product->stock = 3;
    $product->shouldReceive('save')->never();

    $product->reduceStock(5);

    expect($product->stock)->toBe(3);
});

it('adds stock and saves the product', function () {
    /** @var Product $product */
    $product = Mockery::mock(Product::class)->makePartial();
    $product->stock = 2;
    $product->shouldReceive('save')->once()->andReturnTrue();

    $product->addStock(4);

    expect($product->stock)->toBe(6);
});

it('scopeSearch returns same builder when keyword is empty', function () {
    $builder = new class {
        public array $calls = [];

        public function where($column, $operator = null, $value = null)
        {
            $this->calls[] = func_get_args();
            return $this;
        }
    };

    $product = new Product();

    $result = $product->scopeSearch($builder, null);

    expect($result)->toBe($builder);
    expect($builder->calls)->toBeEmpty();
});

it('scopeSearch applies search conditions when keyword is provided', function () {
    $builder = new class {
        public array $calls = [];

        public function where($column, $operator = null, $value = null)
        {
            if ($column instanceof Closure) {
                $this->calls[] = ['method' => 'where', 'args' => ['closure']];
                $column($this);
                return $this;
            }

            $this->calls[] = ['method' => 'where', 'args' => func_get_args()];
            return $this;
        }

        public function orWhere($column, $operator = null, $value = null)
        {
            $this->calls[] = ['method' => 'orWhere', 'args' => func_get_args()];
            return $this;
        }
    };

    $product = new Product();
    $result = $product->scopeSearch($builder, 'cake');

    expect($result)->toBe($builder);
    expect($builder->calls[0])->toMatchArray([
        'method' => 'where',
        'args' => ['closure'],
    ]);
    expect($builder->calls[1])->toMatchArray([
        'method' => 'where',
        'args' => ['name_product', 'LIKE', '%cake%'],
    ]);
    expect($builder->calls[2])->toMatchArray([
        'method' => 'orWhere',
        'args' => ['description', 'LIKE', '%cake%'],
    ]);
});

it('scopeHighestRated applies the correct query chain without database access', function () {
    $builder = new class {
        public array $calls = [];

        public function withAvg($relation, $column)
        {
            $this->calls[] = ['method' => 'withAvg', 'args' => [$relation, $column]];
            return $this;
        }

        public function withCount($relation)
        {
            $this->calls[] = ['method' => 'withCount', 'args' => [$relation]];
            return $this;
        }

        public function orderByDesc($column)
        {
            $this->calls[] = ['method' => 'orderByDesc', 'args' => [$column]];
            return $this;
        }

        public function take($limit)
        {
            $this->calls[] = ['method' => 'take', 'args' => [$limit]];
            return $this;
        }
    };

    $product = new Product();
    $result = $product->scopeHighestRated($builder, 3);

    expect($result)->toBe($builder);
    expect($builder->calls)->toEqual([
        ['method' => 'withAvg', 'args' => ['reviews', 'rating']],
        ['method' => 'withCount', 'args' => ['reviews']],
        ['method' => 'orderByDesc', 'args' => ['reviews_avg_rating']],
        ['method' => 'take', 'args' => [3]],
    ]);
});
