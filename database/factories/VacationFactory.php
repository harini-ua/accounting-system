<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Vacation;
use Faker\Generator as Faker;

$factory->define(Vacation::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTimeThisYear,
        'type' => \App\Enums\VacationType::getRandomValue(),
        'payment_type' => \App\Enums\VacationPaymentType::getRandomValue(),
    ];
});
