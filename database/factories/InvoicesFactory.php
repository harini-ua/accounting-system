<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;

$factory->define(\App\Models\Invoice::class, static function (Faker $faker) {

    $discount = (random_int(0, 1) === 1) ? $faker->randomFloat(2, 0, 100) : null;
    $total = $faker->randomFloat(2, 1000, 20000);

    return [
        'number' => $faker->bankAccountNumber,
        'name' => ucfirst($faker->words(random_int(1, 3), true)),
        'date' => $faker->dateTimeBetween('-1 year', 'now'),
        'status' => \App\Enums\InvoiceStatus::getRandomValue(),
        'type' => \App\Enums\InvoiceType::DEFAULT,
        'discount' => $discount,
        'total' => $total,
        'plan_income_date' => $faker->dateTimeBetween('-1 year', '+3 month'),
        'pay_date' => $faker->dateTimeBetween('-1 year', 'now'),
    ];
});
