<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\InvoiceItem::class, static function (Faker $faker) {
    $sum = $faker->randomFloat(2, 100, 10000);
    $discount = $sum / 20;
    return [
        'title' => ucfirst($faker->words(random_int(1, 3), true)),
        'description' => ucfirst($faker->words(random_int(5, 10), true)),
        'sum' => $sum,
        'discount' => $discount,
        'total' => $sum - $discount,
        'type' => \App\Enums\InvoiceItemType::getRandomValue(),
    ];
});
