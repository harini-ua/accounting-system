<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Person;
use Faker\Generator as Faker;

$factory->define(Person::class, function (Faker $faker) {

    $startDate = $faker->dateTimeBetween('-5 years', 'now');
    $quitedAt = ! rand(0, 3) ? $faker->dateTimeBetween($startDate, 'now') : null;
    $salaryChangedAt = (! $quitedAt) && rand(0, 1) ? $faker->dateTimeBetween($startDate, 'now') : null;
    $longVacationStartedAt = (! $quitedAt) && rand(0, 2) ? $faker->dateTimeBetween($startDate, 'now') : null;

    return [
        'name' => $faker->name,
        'position_id' => \App\Enums\Position::getRandomValue(),
        'start_date' => $startDate,

        'salary' => $faker->randomFloat(2, 100, 5000),
        'currency' => $faker->randomFloat(2, 23, 33),
        'salary_type' => \App\Enums\SalaryType::getRandomValue(),
        'contract_type' => \App\Enums\PersonContractType::getRandomValue(),
        'salary_type_changed_at' => (! $quitedAt) && rand(0, 1) ? $faker->dateTimeBetween($startDate, 'now') : null,
        'salary_changed_at' => $salaryChangedAt,
        'salary_change_reason' => $salaryChangedAt ? $faker->sentence : null,

        'growth_plan' => $faker->boolean,
        'tech_lead' => $faker->boolean,
        'team_lead' => $faker->boolean,

        'long_vacation_started_at' => $longVacationStartedAt,
        'long_vacation_reason' => $longVacationStartedAt ? $faker->sentence : null,
        'long_vacation_compensation' => $longVacationStartedAt ? $faker->randomFloat(2, 100, 5000) : null,
        'long_vacation_comment' => $longVacationStartedAt ? $faker->sentence : null,
        'long_vacation_finished_at' => $longVacationStartedAt ? $faker->dateTimeBetween($longVacationStartedAt, 'now') : null,

        'quited_at' => $quitedAt,
        'quit_reason' => $quitedAt ? $faker->sentence : null,
    ];
});
