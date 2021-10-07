<?php

use App\Models\Address;
use App\Models\Bank;
use App\Models\Client;
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
        factory(Client::class, 100)->create()
            ->each(static function (Client $client) {
                $client->addresses()->save(factory(Address::class)->make());
                if (random_int(0, 1)) {
                    $client->bank()->save(factory(Bank::class)->make());
                }
            }
            );
    }
}
