<?php

namespace App\Services;

use App\Models\AccountType;
use App\Models\Address;

class Formatter
{
    /**
     * @param string      $value
     * @param string|null $symbol
     *
     * @return string
     */
    public static function currency($value, $symbol = null)
    {
        $currency_format = config('general.currency.format');
        $delimiter = config('general.currency.delimiter');

        return strtr($currency_format, [
            '{SYMBOL}'    => $symbol,
            '{DELIMITER}' => $symbol ? $delimiter : null,
            '{VALUE}'     => number_format($value, 2, ',', ' '),
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
