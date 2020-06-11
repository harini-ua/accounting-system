<?php

namespace App\Services;


class Formatter
{
    /**
     * @param $value
     * @param $accountType
     * @return string
     */
    public static function currency($value, $accountType)
    {
        return $accountType->symbol . ' ' . number_format($value, 2, ',', ' ');
    }
}