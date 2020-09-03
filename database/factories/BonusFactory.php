<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Bonus::class, static function (Faker $faker) {
    return [
        'type' => \App\Enums\BonusType::PERCENT,
    ];
});
