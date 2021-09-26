<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinalPayslipCreateRequest extends FormRequest
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
            'person_id' => 'required|exists:people,id',
            'last_working_day' => 'required|date_format:d-m-Y',
            'worked_hours' => 'required|numeric|max:744|min:0',
            'monthly_bonus' => 'nullable|numeric|max:1000000|min:0',
            'fines' => 'nullable|numeric|max:0|min:-1000000',
            'other_compensation' => 'nullable|numeric|max:1000000|min:0',
            'comments' => 'nullable|string',
            'paid' => 'nullable|boolean',
        ];
    }
}
