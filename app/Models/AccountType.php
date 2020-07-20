<?php

namespace App\Models;

use App\Services\Formatter;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AccountType
 * @package App
 */
class AccountType extends Model
{
    const UAH = 1;
    const USD = 2;
    const EUR = 3;
    const DEPOSIT_UAH = 4;

    protected $appends = ['accountsSum', 'invoicedSum', 'receivedSum'];

    protected $hidden = ['accountsSum', 'invoicedSum', 'receivedSum'];

    /*
     * ***********************************
     * Accessors
     * ***********************************
     */

    /**
     * @return int|string
     */
    public function getAccountsSumAttribute()
    {
        return $this->getRelatedSum('accountsSum');
    }

    /**
     * @return int|string
     */
    public function getInvoicedSumAttribute()
    {
        return $this->getRelatedSum('invoicedSum');
    }

    /**
     * @return int|string
     */
    public function getReceivedSumAttribute()
    {
        return $this->getRelatedSum('receivedSum');
    }

    /*
     * ***********************************
     * Relations
     * ***********************************
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function accountsSum()
    {
        return $this->hasOne(Account::class)
            ->selectRaw('sum(balance) as sum, account_type_id')
            ->groupBy('account_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invoicedSum()
    {
        return $this->hasOne(Account::class)
            ->selectRaw('sum(invoice_items.total) as sum, account_type_id')
            ->join('invoices', 'invoices.account_id', '=', 'accounts.id')
            ->join('invoice_items', 'invoice_items.invoice_id', '=', 'invoices.id')
            ->whereNull('invoices.deleted_at')
            ->whereNull('invoice_items.deleted_at')
            ->groupBy('account_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function receivedSum()
    {
        return $this->hasOne(Account::class)
            ->selectRaw('sum(payments.received_sum) as sum, account_type_id')
            ->join('invoices', 'invoices.account_id', '=', 'accounts.id')
            ->join('payments', 'payments.invoice_id', '=', 'invoices.id')
            ->whereNull('invoices.deleted_at')
            ->whereNull('payments.deleted_at')
            ->groupBy('account_type_id');
    }

    /*
     * ***********************************
     * Other
     * ***********************************
     */

    /**
     * @param string $relation
     * @return int|string
     */
    private function getRelatedSum(string $relation)
    {
        if (!array_key_exists($relation, $this->relations)) {
            $this->load($relation);
        }

        $related = $this->getRelation($relation);

        return $related ? Formatter::currency($related->sum, $this) : 0;
    }
}
