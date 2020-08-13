<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalendarMonthUpdateRequest extends FormRequest
{
    /**
     * @var string
     */
    private $field;
    /**
     * @var int
     */
    private $value;

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
            'field' => 'required|in:calendar_days,holidays,weekends',
            'value' => 'required|integer|min:0|max:31'
        ];
    }
}
