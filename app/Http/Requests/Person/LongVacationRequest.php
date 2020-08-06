<?php

namespace App\Http\Requests\Person;

use Illuminate\Foundation\Http\FormRequest;

class LongVacationRequest extends FormRequest
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
            'long_vacation_started_at' => 'required|date_format:d-m-Y',
            'long_vacation_reason' => 'required|string|min:3',
            'long_vacation_compensation' => 'nullable|numeric',
            'long_vacation_comment' => 'nullable|string|min:3',
            'long_vacation_finished_at' => 'nullable|date_format:d-m-Y',
        ];
    }
}
