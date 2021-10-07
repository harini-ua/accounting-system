<?php

use App\Models\Account;
use App\Models\Contract;
use App\Models\Income;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class IncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $incomes = [];
        $contractIds = Contract::pluck('id')->toArray();
        $accountIds = Account::pluck('id')->toArray();
        $createdAt = Carbon::now();

        foreach ($contractIds as $contractId) {
            $contractIncomes = factory(Income::class, random_int(5, 10))->make([
                'contract_id' => $contractId,
                'account_id' => static function () use ($accountIds) {
                    return $accountIds[array_rand($accountIds)];
                },
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ])->toArray();

            $incomes = array_merge($incomes, $contractIncomes);
        }

        Income::insert($incomes);
    }
}
