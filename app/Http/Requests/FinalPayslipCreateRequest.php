<?php

namespace App\Http\Requests;

use App\Models\Person;
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
        $rule = [];
        $person = Person::find($this->person_id);
        if ($person) {
            $rule[] = "after:$person->start_date";
        }

        return [
            'person_id' => 'required|exists:people,id',
            'last_working_day' => array_merge(['required', 'date', 'date_format:d-m-Y'], $rule),
            'worked_hours' => 'required|numeric|max:744|min:0',
            'monthly_bonus' => 'nullable|numeric|max:1000000|min:0',
            'fines' => 'nullable|numeric|max:0|min:-1000000',
            'other_compensation' => 'nullable|numeric|max:1000000|min:0',
            'comments' => 'nullable|string',
            'paid' => 'nullable|boolean',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $message = 'The last working day must be a date after person start date';

        $person = Person::find($this->person_id);
        if ($person) {
            $message .= ": $person->start_date";
        }

        return [
            'last_working_day.after' => $message,
        ];
    }
}
