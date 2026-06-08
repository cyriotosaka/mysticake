<?php

use App\Models\ReviewProduct;
use Carbon\Carbon;

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
    $proxy = new class extends ReviewProduct {
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
    $proxy = new class extends ReviewProduct {
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
    $proxy = new class extends ReviewProduct {
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

    $proxy = new class($builder) extends ReviewProduct {
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

    $proxy = new class($builder) extends ReviewProduct {
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
