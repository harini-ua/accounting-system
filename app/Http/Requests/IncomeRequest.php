<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncomeRequest extends FormRequest
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
            'contract_id' => 'required|exists:contracts,id',
            'account_id' => 'required|exists:accounts,id',
            'plan_date' => 'required|date_format:d-m-Y',
            'plan_sum' => 'required|numeric',
        ];
    }
}
