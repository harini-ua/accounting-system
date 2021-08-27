<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Payment::class, static function (Faker $faker) {
    $receivedSum = $faker->randomFloat(2, 100, 10000);
    return [
        'fee' => $receivedSum / 100,
        'received_sum' => $receivedSum,
        'date' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
    ];
});
