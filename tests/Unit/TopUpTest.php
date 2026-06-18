<?php

use App\Models\PaymentMethod;
use App\Models\TopUp;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

afterEach(fn () => \Mockery::close());

it('uses the correct table and primary key', function () {
    $topUp = new TopUp();

    expect($topUp->getTable())->toBe('top_up');
    expect($topUp->getKeyName())->toBe('id_top_up');
});

it('does not use timestamps', function () {
    $topUp = new TopUp();

    expect($topUp->timestamps)->toBeFalse();
});

it('allows mass assignment for fillable attributes', function () {
    $topUp = new TopUp([
        'id_payment_method' => 2,
        'id_user' => 3,
        'total_top_up' => 50000,
        'date' => '2026-06-01',
        'time' => '12:00:00',
        'admin_fee' => 1500,
    ]);

    expect($topUp->id_payment_method)->toBe(2);
    expect($topUp->id_user)->toBe(3);
    expect($topUp->total_top_up)->toBe(50000.0);
    expect($topUp->date->format('Y-m-d'))->toBe('2026-06-01');
    expect($topUp->time)->toBe('12:00:00');
    expect($topUp->admin_fee)->toBe(1500.0);
});

it('user() returns a BelongsTo relation with correct keys', function () {
    $topUp = new TopUp();
    $relation = $topUp->user();

    expect($relation)->toBeInstanceOf(BelongsTo::class);
    expect($relation->getForeignKeyName())->toBe('id_user');
    expect($relation->getOwnerKeyName())->toBe('id_user');
    expect(get_class($relation->getRelated()))->toBe(User::class);
});

it('paymentMethod() returns a BelongsTo relation with correct keys', function () {
    $topUp = new TopUp();
    $relation = $topUp->paymentMethod();

    expect($relation)->toBeInstanceOf(BelongsTo::class);
    expect($relation->getForeignKeyName())->toBe('id_payment_method');
    expect($relation->getOwnerKeyName())->toBe('id_payment_method');
    expect(get_class($relation->getRelated()))->toBe(PaymentMethod::class);
});

it('computes total_including_fee correctly', function () {
    $topUp = new TopUp(['total_top_up' => 75000, 'admin_fee' => 2500]);

    expect($topUp->total_including_fee)->toBe(77500.0);
});

it('formats amount, admin fee, and total as currency strings', function () {
    $topUp = new TopUp(['total_top_up' => 82000, 'admin_fee' => 1800]);

    expect($topUp->formatted_amount)->toBe('Rp 82.000');
    expect($topUp->formatted_admin_fee)->toBe('Rp 1.800');
    expect($topUp->formatted_total)->toBe('Rp 83.800');
});

it('formats datetime when date and time are present', function () {
    $topUp = new TopUp(['date' => '2026-06-08', 'time' => '14:45:00']);

    expect($topUp->formatted_datetime)->toBe('08 Jun 2026 14:45:00');
});

it('returns dash when formatted_datetime is missing date or time', function () {
    $topUp = new TopUp(['date' => null, 'time' => null]);

    expect($topUp->formatted_datetime)->toBe('-');
});

it('scopes for a specific user without database access', function () {
    $builder = new class()
    {
        public array $calls = [];

        public function where($column, $value)
        {
            $this->calls[] = ['column' => $column, 'value' => $value];

            return $this;
        }
    };

    $topUp = new TopUp();

    $topUp->scopeForUser($builder, 7);

    expect($builder->calls)->toEqual([['column' => 'id_user', 'value' => 7]]);
});

it('scopes by payment method without database access', function () {
    $builder = new class()
    {
        public array $calls = [];

        public function where($column, $value)
        {
            $this->calls[] = ['column' => $column, 'value' => $value];

            return $this;
        }
    };

    $topUp = new TopUp();

    $topUp->scopeByPaymentMethod($builder, 4);

    expect($builder->calls)->toEqual([['column' => 'id_payment_method', 'value' => 4]]);
});

it('scopes between dates without database access', function () {
    $builder = new class()
    {
        public array $calls = [];

        public function whereBetween($column, array $values)
        {
            $this->calls[] = ['column' => $column, 'values' => $values];

            return $this;
        }
    };

    $topUp = new TopUp();

    $topUp->scopeBetweenDates($builder, '2026-06-01', '2026-06-30');

    expect($builder->calls)->toEqual([['column' => 'date', 'values' => ['2026-06-01', '2026-06-30']]]);
});

it('scopes recent ordering without database access', function () {
    $builder = new class()
    {
        public array $calls = [];

        public function orderBy($column, $direction)
        {
            $this->calls[] = ['column' => $column, 'direction' => $direction];

            return $this;
        }
    };

    $topUp = new TopUp();

    $topUp->scopeRecent($builder);

    expect($builder->calls)->toEqual([
        ['column' => 'date', 'direction' => 'desc'],
        ['column' => 'time', 'direction' => 'desc'],
    ]);
});
