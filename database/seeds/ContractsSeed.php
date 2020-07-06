<?php

use Illuminate\Database\Seeder;

class ContractsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $userIds = \App\User::where('position_id', 3)->pluck('id')->toArray();

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
