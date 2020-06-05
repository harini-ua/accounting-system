<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\Faker\Provider\Payment::class, static function (Faker $faker) {
    return [
        'invoice_id' => 1,
        'fee' => $faker->price(100, 2000, false),
        'received_sum' => '',
        'date' => \Carbon\Carbon::now()->addWeeks(random_int(1, 52))->format('Y-m-d')
    ];
});
