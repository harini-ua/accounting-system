<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferUpdateRequest extends FormRequest
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
            'employee_id' => 'required|unique:offers,employee_id,'.$this->offer->id,
            'start_date' => 'required|date_format:d-m-Y',
            'trial_period' => 'nullable|integer|between:1,12',
            'bonuses' => 'nullable|integer|between:1,100',
            'salary' => 'required|numeric|max:1000000|min:0',
            'salary_review' => 'boolean',
            'sum' => 'exclude_unless:salary_review,1|required_with:salary_review|numeric|max:1000000|min:0',
            'salary_after_review' => 'exclude_unless:salary_review,1|required_with:salary_review|numeric|max:1000000|min:0',
            'additional_conditions' => 'string',
        ];
    }
}
