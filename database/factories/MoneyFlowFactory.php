<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MoneyFlow;
use Faker\Generator as Faker;

$factory->define(MoneyFlow::class, function (Faker $faker) {

    $sumFrom = $faker->randomFloat(2, 10, 10000);
    $currencyRate = rand(0, 2) ? $faker->randomFloat(2, 23, 33) : null;
    $sumTo = $currencyRate ? $sumFrom * $currencyRate : $sumFrom;
    $fee = rand(0, 2) ? $sumFrom / 100 : null;

    return [
        'date' => $faker->dateTimeThisYear,
        'account_from_id' => 1,
        'sum_from' => $sumFrom,
        'account_to_id' => 2,
        'sum_to' => $sumTo,
        'currency_rate' => $currencyRate,
        'fee' => $fee,
        'comment' => rand(0, 1) ? $faker->text : null,
    ];
});
