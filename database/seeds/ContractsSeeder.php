<?php

use App\Enums\Position;
use App\Models\Client;
use App\Models\Contract;
use App\Models\Person;
use Illuminate\Database\Seeder;

class ContractsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $userIds = Person::where('position_id', Position::SalesManager)->pluck('id')->toArray();

        $clientIds = Client::all()->pluck('id');
        foreach ($clientIds as $clientId) {
            shuffle($userIds);
            factory(Contract::class, random_int(3, 6))
                ->create([
                    'client_id' => $clientId,
                    'sales_manager_id' => $userIds[0],
                ]);
        }
    }
}
