<?php

/** @var Factory $factory */


use App\Enums\InvoiceStatus;
use App\Enums\InvoiceType;
use App\Models\Invoice;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Invoice::class, static function (Faker $faker) {

    $discount = (random_int(0, 1) === 1) ? $faker->randomFloat(2, 0, 100) : null;
    $total = $faker->randomFloat(2, 1000, 20000);

    return [
        'number' => $faker->bankAccountNumber,
        'name' => ucfirst($faker->words(random_int(1, 3), true)),
        'date' => $faker->dateTimeBetween('-1 year', 'now'),
        'status' => InvoiceStatus::getRandomValue(),
        'type' => InvoiceType::DEFAULT,
        'discount' => $discount,
        'total' => $total,
        'plan_income_date' => $faker->dateTimeBetween('-1 year', '+3 month'),
        'pay_date' => $faker->dateTimeBetween('-1 year', 'now'),
    ];
});
