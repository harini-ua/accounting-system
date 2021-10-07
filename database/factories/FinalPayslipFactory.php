<?php

/** @var Factory $factory */

use App\Models\FinalPayslip;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(FinalPayslip::class, function (Faker $faker) {
    return [
        'working_days' => $faker->numberBetween(1, 100),
        'worked_days' => $faker->numberBetween(1, 100),
        'working_hours' => $faker->numberBetween(100, 1000),
        'worked_hours' => $faker->numberBetween(100, 1000),
        'basic_salary' => $faker->randomFloat(2, 1000, 2500),
        'earned' => $faker->randomFloat(2, 1000, 2500),
        'vacations' => $faker->numberBetween(1, 10),
        'vacation_compensation' => $faker->randomFloat(2, 100, 1000),
        'leads' => $faker->randomFloat(2, 100, 500),
        'monthly_bonus' => $faker->randomFloat(2, 100, 500),
        'fines' => $faker->randomFloat(2, 100, 500),
        'tax_compensation' => $faker->randomFloat(2, 100, 500),
        'other_compensation' => $faker->randomFloat(2, 100, 500),
        'total_usd' => $faker->randomFloat(2, 100, 4000),
        'total_uah' => $faker->randomFloat(2, 100, 100000),
        'paid' => $faker->boolean,
        'comments' => $faker->text(),
    ];
});
