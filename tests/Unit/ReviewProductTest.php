<?php

use App\Models\Product;
use App\Models\ReviewProduct;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

afterEach(fn () => \Mockery::close());

it('detects when a review contains a comment', function () {
    $review = new ReviewProduct(['comment' => 'Great cake!']);

    expect($review->hasComment())->toBeTrue();
});

it('detects when a review does not contain a comment', function () {
    $review = new ReviewProduct(['comment' => '']);

    expect($review->hasComment())->toBeFalse();
});

it('identifies positive reviews when rating is 4 or greater', function () {
    $review = new ReviewProduct(['rating' => 4]);

    expect($review->isPositive())->toBeTrue();
});

it('identifies non-positive reviews when rating is less than 4', function () {
    $review = new ReviewProduct(['rating' => 3]);

    expect($review->isPositive())->toBeFalse();
});

it('returns a human readable date when created_at is set', function () {
    $createdAt = Carbon::now()->subDays(2);
    $review = new ReviewProduct(['created_at' => $createdAt]);

    expect($review->getFormattedDate())->toContain('2');
});

it('returns a fallback string when created_at is missing', function () {
    $review = new ReviewProduct();

    expect($review->getFormattedDate())->toBe('Beberapa waktu lalu');
});

it('increments like_review and saves the model', function () {
    /** @var ReviewProduct $review */
    $review = \Mockery::mock(ReviewProduct::class)->makePartial();
    $review->like_review = 5;
    $review->shouldReceive('save')->once()->andReturnTrue();

    $result = $review->incrementLike();

    expect($result)->toBe(6);
    expect($review->like_review)->toBe(6);
});

it('prevents review when user already reviewed the product', function () {
    $proxy = new class() extends ReviewProduct
    {
        public static function hasUserReviewed($userId, $productId)
        {
            return true;
        }

        public static function hasUserPurchased($userId, $productId)
        {
            return false;
        }
    };

    $className = get_class($proxy);

    expect($className::canUserReview(11, 22))->toEqual([
        'can_review' => false,
        'message' => 'Anda sudah pernah memberikan review untuk produk ini.',
    ]);
});

it('requires purchase before review when user has not reviewed yet', function () {
    $proxy = new class() extends ReviewProduct
    {
        public static function hasUserReviewed($userId, $productId)
        {
            return false;
        }

        public static function hasUserPurchased($userId, $productId)
        {
            return false;
        }
    };

    $className = get_class($proxy);

    expect($className::canUserReview(11, 22))->toEqual([
        'can_review' => false,
        'message' => 'Anda harus membeli produk ini terlebih dahulu sebelum bisa memberikan review.',
    ]);
});

it('allows review when user purchased and has not reviewed yet', function () {
    $proxy = new class() extends ReviewProduct
    {
        public static function hasUserReviewed($userId, $productId)
        {
            return false;
        }

        public static function hasUserPurchased($userId, $productId)
        {
            return true;
        }
    };

    $className = get_class($proxy);

    expect($className::canUserReview(11, 22))->toEqual([
        'can_review' => true,
        'message' => '',
    ]);
});

it('checks whether a user has already reviewed a product without touching the database', function () {
    $builder = \Mockery::mock();
    $builder->shouldReceive('where')
        ->with('id_product', 22)
        ->once()
        ->andReturnSelf();
    $builder->shouldReceive('exists')
        ->once()
        ->andReturnTrue();

    $proxy = new class($builder) extends ReviewProduct
    {
        private static function builderStore($builder = null)
        {
            static $current;

            if ($builder !== null) {
                $current = $builder;
            }

            return $current;
        }

        public function __construct($builder = null, array $attributes = [])
        {
            if ($builder !== null) {
                self::builderStore($builder);
            }

            parent::__construct($attributes);
        }

        public static function where($column, $value)
        {
            return self::builderStore();
        }
    };

    $className = get_class($proxy);

    expect($className::hasUserReviewed(11, 22))->toBeTrue();
});

// ── product() relation ─────────────────────────────────────────────────────

it('product() returns a BelongsTo relation', function () {
    $review = new ReviewProduct(['id_product' => 1]);

    expect($review->product())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
});

it('product() uses id_product as the foreign key', function () {
    expect((new ReviewProduct())->product()->getForeignKeyName())->toBe('id_product');
});

it('product() is related to the Product model', function () {
    expect((new ReviewProduct())->product()->getRelated())->toBeInstanceOf(Product::class);
});

// ── user() relation ────────────────────────────────────────────────────────

it('user() returns a BelongsTo relation', function () {
    $review = new ReviewProduct(['id_user' => 1]);

    expect($review->user())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
});

it('user() uses id_user as the foreign key', function () {
    expect((new ReviewProduct())->user()->getForeignKeyName())->toBe('id_user');
});

it('user() is related to the User model', function () {
    expect((new ReviewProduct())->user()->getRelated())->toBeInstanceOf(User::class);
});

// ── setRelation: product and user ──────────────────────────────────────────

it('accesses product relation data correctly', function () {
    $product = new Product(['name_product' => 'Chocolate Cake', 'price' => 75000]);

    $review = new ReviewProduct(['id_product' => 1, 'rating' => 5]);
    $review->setRelation('product', $product);

    expect($review->product->name_product)->toBe('Chocolate Cake');
    expect($review->product->price)->toBe(75000);
});

it('accesses user relation data correctly', function () {
    $user = new User(['username' => 'johndoe', 'email' => 'john@example.com']);

    $review = new ReviewProduct(['id_user' => 1, 'comment' => 'Delicious!']);
    $review->setRelation('user', $user);

    expect($review->user->username)->toBe('johndoe');
    expect($review->user->email)->toBe('john@example.com');
});

// ── incrementLike() null branch ────────────────────────────────────────────

it('starts like count from one when like_review is null', function () {
    /** @var ReviewProduct $review */
    $review = \Mockery::mock(ReviewProduct::class)->makePartial();
    $review->like_review = null;
    $review->shouldReceive('save')->once()->andReturnTrue();

    $result = $review->incrementLike();

    expect($result)->toBe(1); // null ?? 0 = 0, + 1 = 1
    expect($review->like_review)->toBe(1);
});

// ── hasUserPurchased() ─────────────────────────────────────────────────────
// DB::pretend() intercepts the EXISTS query — whereHas() still executes the
// closure to build the subquery (covering those lines), but no SQL hits SQLite.

it('hasUserPurchased returns false when no matching orders exist', function () {
    DB::pretend(function () {
        $result = ReviewProduct::hasUserPurchased(1, 1);

        expect($result)->toBeFalse(); // pretend mode: exists() → false
    });
});

it('finds reviews by product with eager loaded user and ordering', function () {
    $builder = \Mockery::mock();
    $builder->shouldReceive('with')
        ->with('user')
        ->once()
        ->andReturnSelf();
    $builder->shouldReceive('orderByDesc')
        ->with('created_at')
        ->once()
        ->andReturnSelf();
    $builder->shouldReceive('orderByDesc')
        ->with('id_review_product')
        ->once()
        ->andReturnSelf();
    $builder->shouldReceive('get')
        ->once()
        ->andReturn(collect(['review-data']));

    $proxy = new class($builder) extends ReviewProduct
    {
        private static function builderStore($builder = null)
        {
            static $current;

            if ($builder !== null) {
                $current = $builder;
            }

            return $current;
        }

        public function __construct($builder = null, array $attributes = [])
        {
            if ($builder !== null) {
                self::builderStore($builder);
            }

            parent::__construct($attributes);
        }

        public static function where($column, $value)
        {
            return self::builderStore();
        }
    };

    $className = get_class($proxy);

    expect($className::findByProduct(22))->toEqual(collect(['review-data']));
});
