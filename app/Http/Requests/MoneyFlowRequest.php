<?php

namespace App\Http\Requests;

use App\Rules\MoneyFlowFee;
use App\Rules\MoneyFlowSumFrom;
use Illuminate\Foundation\Http\FormRequest;

class MoneyFlowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'wallet_from_id' => ['required', 'numeric', 'not_in:0', 'exists:wallet,id'],
            'account_from_id' => ['required', 'numeric', 'not_in:0', 'exists:accounts,id'],
            'sum_from' => ['required', 'numeric', new MoneyFlowSumFrom($this)],
            'wallet_to_id' => ['required', 'numeric', 'numeric', 'not_in:0', 'exists:wallet,id'],
            'account_to_id' => ['required', 'numeric', 'numeric', 'not_in:0', 'exists:accounts,id'],
            'sum_to' => ['required', 'numeric'],
            'date' => 'required|date_format:d-m-Y',
            'currency_rate' => 'nullable|numeric',
            'fee' => ['nullable', 'numeric', new MoneyFlowFee($this)],
            'comment' => 'nullable|string',
        ];
    }
}
