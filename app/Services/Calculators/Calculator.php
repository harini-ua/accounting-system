<?php

namespace App\Services\Calculators;

use App\Models\Expense;
use App\Models\MoneyFlow;
use Illuminate\Database\Eloquent\Model;

class Calculator
{
    /**
     * @param Model $model
     * @return Calculable
     */
    public static function getCalculator(Model $model): Calculable
    {
        if ($model instanceof MoneyFlow) {
            return new MoneyFlowCalculator($model);
        }

        if ($model instanceof Expense) {
            return new ExpenseCalculator($model);
        }
    }

    /**
     * @param Model $model
     */
    public static function create(Model $model): void
    {
        $moneyFlowCalculator = self::getCalculator($model);
        $moneyFlowCalculator->create();
    }

    /**
     * @param Model $model
     */
    public static function delete(Model $model): void
    {
        $moneyFlowCalculator = self::getCalculator($model);
        $moneyFlowCalculator->delete();
    }

    /**
     * @param Model $model
     */
    public static function update(Model $model)
    {
        $moneyFlowCalculator = self::getCalculator($model);
        $moneyFlowCalculator->update();
    }
}
