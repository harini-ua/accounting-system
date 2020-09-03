<?php

namespace App\Http\Requests;

use App\Enums\ContractStatus;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class ContractCreateRequest extends FormRequest
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
            'client_id' => 'required|exists:clients,id',
            'name' => 'required|string|min:3',
            'commend' => 'string',
            'sales_manager_id' => 'required|exists:people,id',
            'status' => ['required', new EnumValue(ContractStatus::class)]
        ];
    }
}
