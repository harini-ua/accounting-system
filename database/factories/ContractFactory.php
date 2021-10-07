<?php

/** @var Factory $factory */

use App\Enums\ContractStatus;
use App\Models\Contract;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Contract::class, static function (Faker $faker) {
    $status = $faker->randomElement([
        ContractStatus::OPENED,
        ContractStatus::CLOSED
    ]);

    $data = [
        'name' => $faker->name,
        'comment' => $faker->text,
        'status' => $status,
    ];

    if ($status === ContractStatus::CLOSED) {
        $data['closed_at'] = now();
    }

    return $data;
});
