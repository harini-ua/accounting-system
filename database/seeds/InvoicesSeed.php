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
        $contracts = \App\Models\Contract::all('id');
        $accounts = \App\Models\Account::all('id');
        $salesManagers = \App\User::where('position_id', \App\Enums\Position::SalesManager())->get('id');
        $createdAt = \Illuminate\Support\Carbon::now();

        $invoices = [];

        foreach ($contracts as $contract) {
            $contractInvoices = factory(\App\Models\Invoice::class, random_int(2, 5))
                ->make([
                    'contract_id' => $contract->id,
                    'account_id' => $accounts->random()->id,
                    'sales_manager_id' => $salesManagers->random()->id,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ])->toArray();

            $invoices = array_merge($invoices, $contractInvoices);
        }

        $invoices = collect($invoices)->map(static function($item, $key) {
            $item['number'] = \App\Helpers\InvoiceHelper::serialNumber($key);
            return $item;
        });

        \App\Models\Invoice::insert($invoices->toArray());
    }
}
