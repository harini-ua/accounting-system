<?php

/** @var Factory $factory */

use App\Models\Address;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Address::class, static function (Faker $faker) {
    return [
        'country' => $faker->country,
        'state' => $faker->state,
        'city' => $faker->city,
        'address' => $faker->address,
        'postal_code' => $faker->postcode,
        'is_primary' => $faker->boolean,
        'is_billing' => 1,
    ];
});
