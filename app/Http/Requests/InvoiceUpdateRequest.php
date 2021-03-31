<?php

namespace App\Http\Requests;

use App\Enums\InvoiceStatus;
use App\Enums\Position;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvoiceUpdateRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:100',
            'contract_id' => 'required|exists:contracts,id',
            'account_id' => 'required|exists:accounts,id',
            'sales_manager_id' => ['required',
                Rule::exists('people', 'id')->where(static function ($query) {
                    $query->where('position_id', Position::SalesManager);
                })
            ],
            'date' => 'required|date',
            'status' => ['required', new EnumValue(InvoiceStatus::class)],
            'plan_income_date' => 'required|date',
            'discount' => 'nullable|numeric',
            'total' => 'nullable|numeric',
        ];

        $itemRules = (new InvoiceItemUpdateRequest)->rules();

        return array_merge($rules, $itemRules);
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $messages = [
            'contract_id.required' => 'The contract field is required.',
            'account_id.required' => 'The account field is required.',
            'sales_manager_id.required' => 'The sales manager field is required.',
        ];

        $itemMessages = (new InvoiceItemUpdateRequest)->messages();

        return array_merge($messages, $itemMessages);
    }
}
