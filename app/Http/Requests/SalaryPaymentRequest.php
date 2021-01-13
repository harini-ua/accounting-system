<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalaryPaymentRequest extends FormRequest
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
            'calendar_month_id' => 'required|exists:calendar_months,id',
            'person_id' => 'required|exists:people,id',
            'account_id' => 'required|exists:accounts,id',
            'worked_days' => 'nullable|integer|min:0|max:31',
            'worked_hours' => 'required|numeric|max:744|min:0',
            'earned' => 'required|numeric|max:1000000|min:0',
            'overtime_hours' => 'nullable|numeric|max:744|min:0',
            'bonuses' => 'nullable|json',
            'vacations' => 'nullable|integer|min:0|max:31',
            'vacation_compensation' => 'nullable|numeric|max:1000000|min:0',
            'monthly_bonus' => 'nullable|numeric|max:1000000|min:0',
            'fines' => 'nullable|numeric|max:1000000|min:0',
            'tax_compensation' => 'nullable|numeric|max:1000000|min:0',
            'other_compensation' => 'nullable|numeric|max:1000000|min:0',
            'other_compensation_description' => 'nullable|string',
            'total_usd' => 'required|numeric|max:1000000|min:0',
            'currency' => 'required|numeric|max:1000000|min:0',
            'payment_date' => 'nullable|date_format:d-m-Y',
            'comments' => 'nullable|string',
        ];
    }
}
