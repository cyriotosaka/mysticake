<?php

use App\Models\Address;

it('parses latitude from map_point', function () {
    $address = new Address(['map_point' => '-6.200,106.816']);

    expect($address->latitude)->toBe(-6.2);
});

it('parses longitude from map_point', function () {
    $address = new Address(['map_point' => '-6.200,106.816']);

    expect($address->longitude)->toBe(106.816);
});

it('returns null latitude when map_point is null', function () {
    $address = new Address(['map_point' => null]);

    expect($address->latitude)->toBeNull();
});

it('returns null longitude when map_point is null', function () {
    $address = new Address(['map_point' => null]);

    expect($address->longitude)->toBeNull();
});

it('generates correct google maps url', function () {
    $address = new Address(['map_point' => '-6.200,106.816']);

    expect($address->map_url)->toBe('https://www.google.com/maps?q=-6.2,106.816');
});

it('returns null map_url when map_point is null', function () {
    $address = new Address(['map_point' => null]);

    expect($address->map_url)->toBeNull();
});
