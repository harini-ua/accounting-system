<?php

/** @var Factory $factory */

use App\Models\Payment;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Payment::class, static function (Faker $faker) {
    $receivedSum = $faker->randomFloat(2, 100, 10000);
    return [
        'fee' => $receivedSum / 100,
        'received_sum' => $receivedSum,
        'date' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
    ];
});
