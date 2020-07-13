<?php

namespace App\Http\Requests;

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
            'account_from_id' => 'required|exists:accounts,id',
            'sum_from' => ['required', 'numeric', new MoneyFlowSumFrom($this->get('account_from_id'))],
            'account_to_id' => 'required|exists:accounts,id',
            'sum_to' => ['required', 'numeric', new MoneyFlowSumFrom($this->get('account_from_id'))],
            'date' => 'required|date_format:d-m-Y',
            'currency_rate' => 'nullable|numeric',
            'fee' => 'nullable|numeric',
            'comment' => 'nullable|string',
        ];
    }
}
