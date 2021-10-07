<?php

/** @var Factory $factory */

use App\Models\LongVacation;
use App\Models\Person;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(LongVacation::class, function (Faker $faker) {
    return [
        //
    ];
});

$factory->afterCreating(Person::class, function ($person, $faker) {

    if (rand(0, 1)) return;

    $startDate = $person->start_date;
    $quitedAt = !rand(0, 3) ? $faker->dateTimeBetween($startDate, 'now') : null;

    $longVacationStartedAt = (!$quitedAt) && (!rand(0, 4)) ? $faker->dateTimeBetween($startDate, 'now') : null;

    if ($longVacationStartedAt) {
        $longVacationCompensation = $faker->boolean;
        $person->longVacations()->save(
            factory(LongVacation::class)->make([
                'long_vacation_started_at' => $longVacationStartedAt,
                'long_vacation_reason' => $faker->sentence,
                'long_vacation_compensation' => $longVacationCompensation,
                'long_vacation_compensation_sum' => $longVacationCompensation ? $faker->randomFloat(2, 100, 5000) : null,
                'long_vacation_comment' => $faker->sentence,
                'long_vacation_plan_finished_at' => $faker->dateTimeBetween($longVacationStartedAt, 'now'),
                'long_vacation_finished_at' => rand(0, 1) ? $faker->dateTimeBetween($longVacationStartedAt, 'now') : null,
            ])
        );
    }

});
