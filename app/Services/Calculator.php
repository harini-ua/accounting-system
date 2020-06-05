<?php


namespace App\Services;


use App\MoneyFlow;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Calculator
 * @package App\Services
 */
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
