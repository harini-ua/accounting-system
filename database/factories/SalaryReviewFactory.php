<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\SalaryReview::class, function (Faker $faker) {
    $salaryReview = [];

    $salaryReview['date'] = $faker->dateTimeBetween('-1 year', '+1 year');
    $salaryReview['type'] = $faker->randomElement(\App\Enums\SalaryReviewType::getKeys());
    $salaryReview['sum'] = ceil( $faker->randomFloat(2, 100, 300) / 100 ) * 100;
    $salaryReview['reason'] = $faker->randomElement(\App\Enums\SalaryReviewReason::getKeys());
    $salaryReview['comment'] = $faker->text(200);

    if ($salaryReview['reason'] === 'PROFESSIONAL_GROWTH') {
        $salaryReview['prof_growth'] = $faker->randomElement(\App\Enums\SalaryReviewProfGrowthType::getKeys());
    }

    return $salaryReview;
});
