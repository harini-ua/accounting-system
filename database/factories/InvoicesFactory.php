<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;

$factory->define(\App\Models\Invoice::class, static function (Faker $faker) {
    return [
        'number' => $faker->bankAccountNumber,
        'name' => ucfirst($faker->words(random_int(1, 3), true)),
        'date' => $faker->dateTimeBetween('-1 year', 'now'),
        'plan_income_date' => $faker->dateTimeBetween('-1 year', '+3 month'),
        'pay_date' => $faker->dateTimeBetween('-1 year', 'now'),
        'status' => \App\Enums\InvoiceStatus::getRandomValue(),
    ];
});
