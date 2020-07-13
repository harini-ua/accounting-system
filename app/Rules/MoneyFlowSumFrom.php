<?php

namespace App\Rules;

use App\Models\Account;
use Illuminate\Contracts\Validation\Rule;

class MoneyFlowSumFrom implements Rule
{
    private $account_from_id;

    /**
     * Create a new rule instance.
     *
     * @param $account_from_id
     *
     * @return void
     */
    public function __construct($account_from_id)
    {
        $this->account_from_id = $account_from_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Account::find($this->account_from_id)->balance >= $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Not enough money on this account.';
    }
}
