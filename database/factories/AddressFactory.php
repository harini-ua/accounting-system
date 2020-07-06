<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Address::class, static function (Faker $faker) {
    return [
        'country' => $faker->country,
        'state' => $faker->state,
        'city' => $faker->city,
        'address' => $faker->address,
        'postal_code' => $faker->postcode,
        'is_primary' => $faker->boolean,
        'is_billing' => $faker->boolean,
    ];
});
