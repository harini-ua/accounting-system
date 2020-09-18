<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Expense;
use Illuminate\Support\Carbon;
use Faker\Generator as Faker;

$factory->define(Expense::class, function (Faker $faker) {
    $planSum = $faker->randomFloat(2, 100, 10000);
    $realSum = $planSum * $faker->randomFloat(1, 0, 1);
    $planDate = Carbon::now()->addMonth()->subDays(random_int(0, 395));
    $realDate = $realSum ? (clone $planDate)->addDays(random_int(0, 10)) : null;
    return [
        'plan_date' => $planDate,
        'real_date' => $realDate,
        'purpose' => $faker->sentence,
        'plan_sum' => $planSum,
        'real_sum' => $realSum,
    ];
});
