<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HolidayCreateRequest extends FormRequest
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
            'calendar_year_id' => 'required|exists:calendar_years,id',
            'date' => 'required|date',
            'name' => 'required|string|min:3|max:255',
            'moved_date' => 'nullable|date',
        ];
    }
}
