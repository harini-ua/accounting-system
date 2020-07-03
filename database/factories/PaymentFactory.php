<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Payment::class, static function (Faker $faker) {
    $receivedSum = $faker->randomFloat(2, 100, 10000);
    return [
        'fee' => $receivedSum / 100,
        'received_sum' => $receivedSum,
        'date' => \Carbon\Carbon::now()->addWeeks(random_int(1, 52))->format('Y-m-d')
    ];
});
