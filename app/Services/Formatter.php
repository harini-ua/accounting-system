<?php

namespace App\Services;

use App\Models\AccountType;
use App\Models\Address;

class Formatter
{
    /**
     * @param string      $value
     * @param string|null $symbol
     * @param bool        $html
     *
     * @return string
     */
    public static function currency($value, $symbol = null, $html = false)
    {
        $currency_format = config('general.currency.format');
        $delimiter = config('general.currency.delimiter');
        $value = number_format($value, ...array_values(config('general.number.format')));

        return strtr($currency_format, [
            '{SYMBOL}'    => $html ? '<span class="symbol">'.$symbol.'</span>' : $symbol,
            '{DELIMITER}' => $symbol ? $delimiter : null,
            '{VALUE}'     => $html ? '<span class="value">'.$value.'</span>' : $value,
        ]);
    }

    /**
     * @param Address $address
     * @param string  $type
     *
     * @return string
     */
    public static function address(Address $address, $type = 'invoices')
    {
        $address_format = config($type.'.address.format');

        return strtr($address_format, [
            '{ADDRESS}'   => $address->address,
            '{POST_CODE}' => $address->postal_code,
            '{CITY}'      => $address->city,
            '{STATE}'     => $address->state,
            '{COUNTRY}'   => $address->country,
        ]);
    }
}
