<?php

/** @var Factory $factory */

use App\Enums\VacationPaymentType;
use App\Enums\VacationType;
use App\Models\Vacation;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Vacation::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTimeThisYear,
        'type' => VacationType::getRandomValue(),
        'payment_type' => VacationPaymentType::getRandomValue(),
    ];
});
