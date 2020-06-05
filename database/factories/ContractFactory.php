<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Modules\Contract::class, static function (Faker $faker) {
    $status = $faker->randomElement([
        \App\Enums\ContractStatus::OPENED,
        \App\Enums\ContractStatus::CLOSED
    ]);

    $data = [
        'name' => $faker->name,
        'comment' => $faker->text,
        'status' => $status,
    ];

    if ($status === \App\Enums\ContractStatus::CLOSED) {
        $data['closed_at'] = now();
    }

    return $data;
});
