<?php

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class ClientsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = new Faker();

        factory(\App\Modules\Client::class, 100)->create()
            ->each(static function (\App\Modules\Client $client) use ($faker) {
                $client->addresses()->save(factory(\App\Modules\Address::class)->make());
            }
        );
    }
}
