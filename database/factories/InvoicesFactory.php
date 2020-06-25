<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(\App\Modules\Invoice::class, static function (Faker $faker) {
    $planDate = Carbon::now()->sub(rand(1, 30) . ' days');
    return [
        'number' => $faker->bankAccountNumber,
        'name' => $faker->word,
        'plan_income_date' => $planDate,
        'pay_date' => $planDate,
    ];
});
