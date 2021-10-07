<?php

namespace App\Helpers;

class InvoiceHelper
{
    /**
     * @param integer $latestId
     *
     * @return string
     */
    public static function serialNumber($latestId)
    {
        $series = config('invoices.serial_number.series');
        $sequence_padding = config('invoices.serial_number.sequence_padding');
        $delimiter = config('invoices.serial_number.delimiter');
        $serial_number_format = config('invoices.serial_number.format');

        $sequence = str_pad((string)++$latestId, $sequence_padding, 0, STR_PAD_LEFT);

        return strtr($serial_number_format, [
            '{SERIES}' => $series,
            '{DELIMITER}' => $delimiter,
            '{SEQUENCE}' => $sequence,
        ]);
    }
}
