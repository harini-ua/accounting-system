<?php

namespace App\Services;


use App\Account;
use App\MoneyFlow;
use Illuminate\Support\Facades\DB;

/**
 * Class MoneyFlowCalculator
 * @package App\Services
 */
class MoneyFlowCalculator implements Calculable
{
    /**
     * @var MoneyFlow
     */
    private $moneyFlow;

    /**
     * MoneyFlowCalculator constructor.
     * @param MoneyFlow $moneyFlow
     */
    public function __construct(MoneyFlow $moneyFlow)
    {
        $this->moneyFlow = $moneyFlow;
    }

    /**
     * Calculation on creating MoneyFlow
     */
    public function create(): void
    {
        DB::beginTransaction();

        $moneyFlow = $this->moneyFlow;

        $accountFrom = $moneyFlow->accountFrom;
        $accountFrom->balance -= $moneyFlow->sum_from + $moneyFlow->fee;
        $accountFrom->save();

        $accountTo = $moneyFlow->accountTo;
        $accountTo->balance += $moneyFlow->sum_to;
        $accountTo->save();

        DB::commit();
    }

    /**
     * Calculation on deleting MoneyFlow
     */
    public function delete(): void
    {
        DB::beginTransaction();

        $moneyFlow = $this->moneyFlow;

        $accountFrom = $moneyFlow->accountFrom;
        $accountFrom->balance += $moneyFlow->sum_from + $moneyFlow->fee;
        $accountFrom->save();

        $accountTo = $moneyFlow->accountTo;
        $accountTo->balance -= $moneyFlow->sum_to;
        $accountTo->save();

        DB::commit();
    }

    /**
     * Calculation on deleting MoneyFlow
     */
    public function update(): void
    {
        DB::beginTransaction();

        $moneyFlow = $this->moneyFlow;

        $accountFromOriginal = Account::find($moneyFlow->getOriginal('account_from_id'));
        $accountFromOriginal->balance += $moneyFlow->getOriginal('sum_from') + $moneyFlow->getOriginal('fee');
        $accountFromOriginal->save();

        $accountFrom = $moneyFlow->accountFrom()->first();
        $accountFrom->balance -= $moneyFlow->sum_from + $moneyFlow->fee;
        $accountFrom->save();

        $accountToOriginal = Account::find($moneyFlow->getOriginal('account_to_id'));
        $accountToOriginal->balance -= $moneyFlow->getOriginal('sum_to');
        $accountToOriginal->save();

        $accountTo = $moneyFlow->accountTo()->first();
        $accountTo->balance += $moneyFlow->sum_to;
        $accountTo->save();

        DB::commit();
    }
}