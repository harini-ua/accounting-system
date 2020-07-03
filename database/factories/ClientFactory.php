<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Client::class, static function (Faker $faker) {
    return [
        'name' => $faker->name,
        'company_name' => $faker->company,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
    ];
});
