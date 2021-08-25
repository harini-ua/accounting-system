<?php

namespace App\Rules;

use App\Http\Requests\MoneyFlowRequest;
use App\Models\Account;
use Illuminate\Contracts\Validation\Rule;

class MoneyFlowSumFrom implements Rule
{
    private $request;

    /**
     * Create a new rule instance.
     *
     * @param MoneyFlowRequest $request
     *
     * @return void
     */
    public function __construct(MoneyFlowRequest $request)
    {
        $this->request = $request;
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
//        if($this->request->account_from_id){
//            return false;
//        }
        if ($this->request->money_flow) {
            return Account::find($this->request->account_from_id)->balance + $this->request->money_flow->sum_from >= $value;
        }

        return Account::find($this->request->account_from_id)->balance >= $value;
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
