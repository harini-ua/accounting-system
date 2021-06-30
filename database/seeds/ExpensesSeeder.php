<?php

use Illuminate\Database\Seeder;
use App\Models\ExpenseCategory;
use App\Models\Expense;
use App\Models\Account;
use Illuminate\Support\Carbon;

class ExpensesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $allExpenses = [];
        $accountIds = Account::pluck('id')->toArray();
        $expenseCategories = factory(ExpenseCategory::class, 20)->create();

        foreach ($expenseCategories as $expenseCategory) {
            $createdAt = Carbon::now()->subDays(random_int(1, 365));
            $expenses = factory(Expense::class, random_int(0, 20))
                ->make([
                    'account_id' => function() use ($accountIds) {
                        return $accountIds[array_rand($accountIds)];
                    },
                    'expense_category_id' => $expenseCategory->id,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ])->toArray();

            $allExpenses = array_merge($allExpenses, $expenses);
        }

        Expense::insert($allExpenses);
    }
}
