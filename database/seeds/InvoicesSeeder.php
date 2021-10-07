<?php

use App\Enums\Position;
use App\Helpers\InvoiceHelper;
use App\Models\Account;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Person;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class InvoicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $contracts = Contract::all('id');
        $accounts = Account::all('id');
        $salesManagers = Person::where('position_id', Position::SalesManager())->get('id');
        $createdAt = Carbon::now();

        $invoices = [];

        foreach ($contracts as $contract) {
            $contractInvoices = factory(Invoice::class, random_int(2, 5))
                ->make([
                    'contract_id' => $contract->id,
                    'account_id' => $accounts->random()->id,
                    'sales_manager_id' => $salesManagers->random()->id,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ])->toArray();

            $invoices = array_merge($invoices, $contractInvoices);
        }

        $invoices = collect($invoices)->map(static function ($item, $key) {
            $item['number'] = InvoiceHelper::serialNumber($key);
            return $item;
        });

        Invoice::insert($invoices->toArray());
    }
}
