<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Wallet;
use Faker\Generator as Faker;

$factory->define(Wallet::class, function (Faker $faker) {
    static $i = 1;
    return [
        'name' => 'Wallet ' . $i++,
        'wallet_type_id' => 1,
    ];
});
