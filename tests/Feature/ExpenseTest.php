<?php

namespace Tests\Feature;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    use DatabaseTransactions;

    /**
     *
     * @return void
     */
    public function testExpense()
    {
        $expenseCategory = factory(ExpenseCategory::class)->create();
        $wallet = factory(Wallet::class)->create();
        $wallet->createAccounts();
        $account = $wallet->accounts->first();

        $data = [
            'plan_date' => Carbon::now(),
            'purpose' => 'sdjfk dfjk dkj',
            'real_sum' => 1000,
            'account_id' => $account->id,
            'expense_category_id' => $expenseCategory->id,
        ];

        // create expense
        $expense = Expense::create($data);

        $this->assertDatabaseHas('accounts', [
            'id' => $account->id,
            'balance' => -$data['real_sum'],
        ]);

        // delete expense
        $expense->delete();

        $this->assertDatabaseHas('accounts', [
            'id' => $account->id,
            'balance' => 0,
        ]);
    }
}
