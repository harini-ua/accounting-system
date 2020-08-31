<?php

use App\Enums\Position;
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
        $userIds = \App\Models\Person::where('position_id', Position::SalesManager)->pluck('id')->toArray();

        $clientIds = \App\Models\Client::all()->pluck('id');
        foreach ($clientIds as $clientId) {
            shuffle($userIds);
            factory(\App\Models\Contract::class, random_int(3, 6))
                ->create([
                    'client_id' => $clientId,
                    'sales_manager_id' => $userIds[0],
                ]);
        }
    }
}
