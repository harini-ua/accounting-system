<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ExpenseCategory;
use Faker\Generator as Faker;

$factory->define(ExpenseCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'comment' => rand(0, 1) ? $faker->sentence : null,
    ];
});
