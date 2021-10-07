<?php

/** @var Factory $factory */

use App\Models\Wallet;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Wallet::class, function (Faker $faker) {
    static $i = 1;
    return [
        'name' => 'Wallet ' . $i++,
        'wallet_type_id' => 1,
    ];
});
