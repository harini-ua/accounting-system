<?php

use Illuminate\Database\Seeder;

class InvoicesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        factory(\App\Modules\Invoice::class, 100)->create();

        $contracts = \App\Modules\Contract::all();
        foreach ($contracts as $contract) {
            factory(\App\Modules\Invoice::class, random_int(2, 5))
                ->create([
                    'contract_id' => $contract->id,
                ]);
        }
    }
}
