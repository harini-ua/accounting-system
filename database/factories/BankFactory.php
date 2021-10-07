<?php

/** @var Factory $factory */

use App\Models\Bank;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Bank::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'address' => $faker->address,
        'account' => $faker->bankAccountNumber,
        'iban' => $faker->iban(),
        'swift' => $faker->swiftBicNumber,
    ];
});
