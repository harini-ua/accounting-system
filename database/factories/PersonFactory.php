<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Person;
use Faker\Generator as Faker;

$factory->define(Person::class, function (Faker $faker) {

    $startDate = $faker->dateTimeBetween('-5 years', 'now');
    $quitedAt = ! rand(0, 3) ? $faker->dateTimeBetween($startDate, 'now') : null;
    $salaryChangedAt = (! $quitedAt) && rand(0, 1) ? $faker->dateTimeBetween($startDate, 'now') : null;
    $longVacationStartedAt = (! $quitedAt) && (! rand(0, 4)) ? $faker->dateTimeBetween($startDate, 'now') : null;
    $longVacationCompensation = $longVacationStartedAt ? $faker->boolean : false;
    $salary = $faker->randomFloat(2, 100, 5000);
    $techLead = $faker->boolean;
    $teamLead = $faker->boolean;
    $bonuses = $faker->boolean;

    return [
        'name' => $faker->name,
        'position_id' => \App\Enums\Position::getRandomValue(),
        'start_date' => $startDate,
        'department' => $faker->jobTitle,
        'skills' => $faker->sentence,
        'certifications' => rand(0, 1) ? $faker->sentence : null,
        // Salary
        'salary' => $salary,
        'currency' => \App\Enums\Currency::getRandomValue(),
        'salary_type' => \App\Enums\SalaryType::getRandomValue(),
        'contract_type' => \App\Enums\PersonContractType::getRandomValue(),
        'contract_type_changed_at' => (! $quitedAt) && rand(0, 1) ? $faker->dateTimeBetween($startDate, 'now') : null,
        'salary_type_changed_at' => (! $quitedAt) && rand(0, 1) ? $faker->dateTimeBetween($startDate, 'now') : null,
        'salary_changed_at' => $salaryChangedAt,
        'salary_change_reason' => $salaryChangedAt ? $faker->sentence : null,
        'last_salary' => $salaryChangedAt ? $salary * 0.75 : null,
        // Additional information
        'growth_plan' => $faker->boolean,
        'tech_lead' => $techLead,
        'tech_lead_reward' => $techLead ? $salary / rand(5, 20) : null,
        'team_lead' => $teamLead,
        'team_lead_reward' => $teamLead ? $salary / rand(5, 20) : null,
        'bonuses' => $bonuses,
        'bonuses_reward' => $bonuses ? rand(5, 20) : null,
        // Long-term vacation
        'long_vacation_started_at' => $longVacationStartedAt,
        'long_vacation_reason' => $longVacationStartedAt ? $faker->sentence : null,
        'long_vacation_compensation' => $longVacationCompensation,
        'long_vacation_compensation_sum' => $longVacationCompensation ? $faker->randomFloat(2, 100, 5000) : null,
        'long_vacation_comment' => $longVacationStartedAt ? $faker->sentence : null,
        'long_vacation_plan_finished_at' => $longVacationStartedAt ? $faker->dateTimeBetween($longVacationStartedAt, 'now') : null,
        // Quit
        'quited_at' => $quitedAt,
        'quit_reason' => $quitedAt ? $faker->sentence : null,
        // Pay data
//        'code' => $faker->numberBetween(1000000),
//        'agreement' => $faker->numberBetween(1000000),
//        'account_number' => $faker->numberBetween(1000000),
//        'recipient_bank' => $faker->words(random_int(1, 2)),
//        'note_salary_pay' => $faker->words(random_int(2, 4)),
    ];
});
