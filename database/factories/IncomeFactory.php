<?php

/** @var Factory $factory */

use App\Models\Income;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Income::class, function (Faker $faker) {
    return [
        'plan_sum' => $faker->randomFloat(2, 100, 10000),
        'plan_date' => $faker->dateTimeBetween('-1 year', '+ 1 year'),
    ];
});
