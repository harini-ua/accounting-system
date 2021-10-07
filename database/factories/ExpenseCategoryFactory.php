<?php

/** @var Factory $factory */

use App\Models\ExpenseCategory;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(ExpenseCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'comment' => rand(0, 1) ? $faker->sentence : null,
    ];
});
