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
        $contracts = \App\Modules\Contract::all('id');
        $accounts = \App\Account::all('id');
        $salesManagers = \App\User::where('position_id', \App\Enums\Position::SalesManager())->get('id');
        $createdAt = \Illuminate\Support\Carbon::now();

        $invoices = [];

        foreach ($contracts as $contract) {
            $contractInvoices = factory(\App\Modules\Invoice::class, random_int(2, 5))
                ->make([
                    'contract_id' => function() use ($contract) {
                        return $contract->id;
                    },
                    'account_id' => function() use ($accounts) {
                        return $accounts->random()->id;
                    },
                    'sales_manager_id' => function() use ($salesManagers) {
                        return $salesManagers->random()->id;
                    },
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ])->toArray();

            $invoices = array_merge($invoices, $contractInvoices);
        }

        \App\Modules\Invoice::insert($invoices);
    }
}
