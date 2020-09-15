<?php

namespace App\Http\Requests\Person;

use App\Enums\SalaryType;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class ChangeSalaryTypeRequest extends FormRequest
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
            'salary_type_changed_at' => 'required|date_format:d-m-Y',
            'salary_type' => ['required', new EnumValue(SalaryType::class)],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'salary_type_changed_at.required' => 'asdfasdfasdfasdfas'
        ];
    }
}
