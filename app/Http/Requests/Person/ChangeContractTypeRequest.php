<?php

namespace App\Http\Requests\Person;

use App\Enums\PersonContractType;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class ChangeContractTypeRequest extends FormRequest
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
            'contract_type_changed_at' => 'required|date_format:d-m-Y',
            'contract_type' => ['required', new EnumValue(PersonContractType::class)],
        ];
    }
}
