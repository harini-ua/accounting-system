<?php

use Illuminate\Database\Seeder;

class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        factory(\App\Models\Client::class, 100)->create()
            ->each(static function (\App\Models\Client $client) {
                $client->addresses()->save(factory(\App\Models\Address::class)->make());
                if (random_int(0, 1)) {
                    $client->bank()->save(factory(\App\Models\Bank::class)->make());
                }
            }
        );
    }
}
