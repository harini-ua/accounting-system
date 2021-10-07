<?php

/** @var Factory $factory */

use App\Enums\SalaryReviewProfGrowthType;
use App\Enums\SalaryReviewReason;
use App\Enums\SalaryReviewType;
use App\Models\SalaryReview;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(SalaryReview::class, function (Faker $faker) {
    $salaryReview = [];

    $salaryReview['date'] = $faker->dateTimeBetween('-1 year', '+1 year');

    $salaryReview['type'] = SalaryReviewType::ACTUAL;
    if (Carbon::parse($salaryReview['date']) > Carbon::now()) {
        $salaryReview['type'] = SalaryReviewType::PLANNED;
    }

    $salaryReview['sum'] = ceil($faker->randomFloat(2, 100, 300) / 100) * 100;
    $salaryReview['reason'] = $faker->randomElement(SalaryReviewReason::getKeys());
    $salaryReview['comment'] = $faker->text(200);

    if ($salaryReview['reason'] == 'POOR_PERFORMANCE') {
        $salaryReview['type'] = SalaryReviewType::ACTUAL;
        $salaryReview['sum'] = 0 - $salaryReview['sum'];
        $salaryReview['date'] = $faker->dateTimeBetween('-1 year', 'now');
    }

    if ($salaryReview['reason'] === 'PROFESSIONAL_GROWTH') {
        $salaryReview['prof_growth'] = $faker->randomElement(SalaryReviewProfGrowthType::getKeys());
    }

    return $salaryReview;
});
