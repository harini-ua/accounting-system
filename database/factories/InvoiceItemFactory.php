<?php

/** @var Factory $factory */

use App\Enums\InvoiceItemType;
use App\Models\InvoiceItem;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(InvoiceItem::class, static function (Faker $faker, $data) {

    $type = InvoiceItemType::getRandomValue();
    $qty = (InvoiceItemType::HOURLY === $type) ? random_int(50, 160) : 1;
    $rate = (InvoiceItemType::HOURLY === $type) ? random_int(10, 25) : random_int(160, 5000);
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
