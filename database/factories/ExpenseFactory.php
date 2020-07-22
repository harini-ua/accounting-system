<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Expense;
use Faker\Generator as Faker;

$factory->define(Expense::class, function (Faker $faker) {
    $planSum = $faker->randomFloat(2, 100, 10000);
    return [
        'plan_date' => $faker->dateTimeBetween('-1 year', '+ 1 month'),
        'purpose' => $faker->sentence,
        'plan_sum' => $planSum,
        'real_sum' => $planSum * $faker->randomFloat(1, 0, 1),
    ];
});
