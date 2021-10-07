<?php

/** @var Factory $factory */

use App\Models\Client;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Client::class, static function (Faker $faker) {
    return [
        'name' => $faker->name,
        'company_name' => $faker->company,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
    ];
});
