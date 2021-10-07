<?php

/** @var Factory $factory */

use App\Models\Certification;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Certification::class, function (Faker $faker) {
    return [
        'name' => ucfirst($faker->words(random_int(2, 3), true)),
        'subject' => ucfirst($faker->words(random_int(3, 4), true)),
        'cost' => $faker->randomFloat(2, 10, 200),
        'availability' => ucfirst($faker->words(random_int(3, 4), true)),
        'sum_award' => $faker->randomFloat(2, 10, 200),
    ];
});
