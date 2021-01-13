<?php

namespace App\Services\Calculators;

use App\Models\Account;
use App\Models\MoneyFlow;
use Illuminate\Support\Facades\DB;

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

        /** @var Account $accountFrom */
        $accountFrom = $moneyFlow->accountFrom()->first();
        $accountFrom->balance -= $moneyFlow->sum_from + $moneyFlow->fee;
        $accountFrom->save();

        $accountToOriginal = Account::find($moneyFlow->getOriginal('account_to_id'));
        $accountToOriginal->balance -= $moneyFlow->getOriginal('sum_to');
        $accountToOriginal->save();

        /** @var Account $accountTo */
        $accountTo = $moneyFlow->accountTo()->first();
        $accountTo->balance += $moneyFlow->sum_to;
        $accountTo->save();

        DB::commit();
    }
}
