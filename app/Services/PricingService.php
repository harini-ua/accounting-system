<?php

namespace App\Services;

class PricingService
{
    /**
     * Apply discount to price
     *
     * @param float $target
     * @param float $discount
     * @param int   $decimals
     * @param bool  $rate
     *
     * @return float
     */
    public static function applyDiscount(float $target, float $discount, int $decimals, bool $rate = false): float
    {
        if ($rate) {
            return round($target * (1 - $discount / 100), $decimals);
        }

        return round($target - $discount, $decimals);
    }

    /**
     * Apply tax to price
     *
     * @param float $target
     * @param float $tax
     * @param int   $decimals
     * @param bool  $rate
     *
     * @return float
     */
    public static function applyTax(float $target, float $tax, int $decimals, bool $rate = false): float
    {
        if ($rate) {
            return round($target * (1 + $tax / 100), $decimals);
        }

        return round($target + $tax, $decimals);
    }

    /**
     * Apply quantity to price
     *
     * @param float $target
     * @param float $quantity
     * @param int   $decimals
     *
     * @return float
     */
    public static function applyQuantity(float $target, float $quantity, int $decimals): float
    {
        return round($target * $quantity, $decimals);
    }
}
