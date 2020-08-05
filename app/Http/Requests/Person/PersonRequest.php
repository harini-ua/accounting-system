<?php

namespace App\Http\Requests\Person;

use App\Enums\Currency;
use App\Enums\PersonContractType;
use App\Enums\Position;
use App\Enums\SalaryType;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class PersonRequest extends FormRequest
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
            'name' => 'required|string|min:3',
            'position_id' => ['required', new EnumValue(Position::class, false)],
            'department' => 'nullable|string|min:3',
            'start_date' => 'required|date_format:d-m-Y',
            'skills' => 'nullable|string|min:3',
            'certifications' => 'nullable|string|min:3',
            'salary' => 'required|numeric',
            'currency' => ['required', new EnumValue(Currency::class)],
            'salary_type' => ['required', new EnumValue(SalaryType::class)],
            'contract_type' => ['required', new EnumValue(PersonContractType::class)],
            'salary_changed_at' => 'nullable|date_format:d-m-Y',
            'salary_change_reason' => 'nullable|string|min:3',
            'last_salary' => 'nullable|numeric',
            'growth_plan' => 'boolean',
            'tech_lead' => 'boolean',
            'team_lead' => 'boolean',
            'bonuses' => 'boolean',
        ];
    }
}