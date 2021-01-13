<?php

namespace App\Services\Calculators;

use App\Models\Account;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;

class ExpenseCalculator implements Calculable
{
    /**
     * @var Expense
     */
    private $expense;

    /**
     * ExpenseCalculator constructor.
     * @param Expense $expense
     */
    public function __construct(Expense $expense)
    {
        $this->expense = $expense;
    }

    /**
     * Calculation on creating Expense
     */
    public function create(): void
    {
        $account = $this->expense->account;
        $account->balance -= $this->expense->real_sum;
        $account->save();
    }

    /**
     * Calculation on updating Expense
     */
    public function update(): void
    {
        DB::beginTransaction();

        $expense = $this->expense;

        $accountOriginal = Account::find($expense->getOriginal('account_id'));
        $accountOriginal->balance += $expense->getOriginal('real_sum');
        $accountOriginal->save();

        $account = $expense->account;
        $account->balance -= $expense->real_sum;
        $account->save();

        DB::commit();
    }

    /**
     * Calculation on deleting Expense
     */
    public function delete(): void
    {
        $account = $this->expense->account;
        $account->balance += $this->expense->real_sum;
        $account->save();
    }
}
