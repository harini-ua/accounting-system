<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Offer::class, function (Faker $faker) {
    $trialPeriod = random_int(1, 2);
    $salary_review = random_int(0, 1);

    $attributes['trial_period'] = $trialPeriod;
    $attributes['end_trial_period_date'] = \Carbon\Carbon::now()->addMonths($trialPeriod);
    $attributes['salary_review'] = $salary_review;

    if ($salary_review) {
        $attributes['sum'] = $faker->randomFloat(2, 100, 500);
        $attributes['salary_after_review'] = $faker->randomFloat(2, 1000, 2500);
    }

    $attributes['additional_conditions'] = ucfirst($faker->words(random_int(5, 10), true));

    return $attributes;
});
