<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpensesRequest extends FormRequest
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
            'plan_date' => 'required|date_format:d-m-Y',
            'purpose' => 'required|string|min:3',
            'plan_sum' => 'nullable|numeric',
            'real_sum' => 'nullable|numeric',
            'account_id' => 'required|exists:accounts,id',
            'expense_category_id' => 'required|exists:expense_categories,id',
        ];
    }
}
