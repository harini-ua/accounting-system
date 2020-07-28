<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\InvoiceItem::class, static function (Faker $faker, $data) {

    $type = \App\Enums\InvoiceItemType::getRandomValue();
    $qty = (\App\Enums\InvoiceItemType::HOURLY === $type) ? random_int(50, 160) : 1;
    $rate = (\App\Enums\InvoiceItemType::HOURLY === $type) ? random_int(10, 25) : random_int(160, 5000);
    $sum = $rate * $qty;

    return [
        'title' => ucfirst($faker->words(random_int(1, 3), true)),
        'description' => ucfirst($faker->words(random_int(5, 10), true)),
        'qty' => $qty,
        'rate' => $rate,
        'sum' => $sum,
        'type' => $type,
    ];
});
