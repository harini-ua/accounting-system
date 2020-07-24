<?php

namespace App\Services;

use App\Models\Address;

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

    /**
     * @param Address $address
     *
     * @return string
     */
    public static function address(Address $address)
    {
        $address_format = config('invoices.address.format');

        return strtr($address_format, [
            '{ADDRESS}'   => $address->address,
            '{POST_CODE}' => $address->postal_code,
            '{CITY}'      => $address->city,
            '{STATE}'     => $address->state,
            '{COUNTRY}'   => $address->country,
        ]);
    }
}