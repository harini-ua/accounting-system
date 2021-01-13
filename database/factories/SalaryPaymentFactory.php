<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SalaryPayment;
use Faker\Generator as Faker;

$factory->define(SalaryPayment::class, function (Faker $faker) {
    return [
        'worked_hours' => $faker->randomFloat(2, 110, 170),
        'overtime_hours' => rand(0, 3) ? $faker->randomFloat(2, 1, 20) : null,
        'monthly_bonus' => rand(0, 3) ? $faker->randomFloat(2, 10, 200) : null,
        'fines' => rand(0, 3) ? $faker->randomFloat(2, 10, 200) : null,
        'tax_compensation' => rand(0, 1) ? 472.3 : null,
        'other_compensation' => rand(0, 1) ? 10 : null,
        'comments' => rand(0, 1) ? $faker->sentence : null,
        'total_usd' => $faker->randomFloat(2, 100, 5000), //todo: count real value
        'vacations' => rand(0, 1) ? rand(1, 5) : null,
    ];
});
