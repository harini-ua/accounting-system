<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(\App\Models\Invoice::class, static function (Faker $faker) {
    $date = Carbon::now()->subDays(random_int(1, 30));
    $planDate = Carbon::now()->addDays(random_int(1, 30));
    return [
        'number' => $faker->bankAccountNumber,
        'name' => ucfirst($faker->words(random_int(1, 3), true)),
        'date' => $date,
        'plan_income_date' => $planDate,
        'pay_date' => $planDate,
        'status' => \App\Enums\InvoiceStatus::getRandomValue(),
    ];
});
