<?php

namespace App\Http\Requests;

use App\Enums\InvoiceSaveStrategy;
use App\Enums\InvoiceType;
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
            'contract_id' => 'required|exists:App\Models\Contract,id',
            'account_id' => 'required|exists:App\Models\Account,id',
            'sales_manager_id' => [
                'required',
                Rule::exists('users', 'id')->where(static function ($query) {
                    $query->where('position_id', 5);
                })
            ],
            'date' => 'required|date',
            'plan_income_date' => 'required|date',
            'type' => [
                'required',
                Rule::in([InvoiceSaveStrategy::UPDATE, InvoiceSaveStrategy::SEND])
            ],
            'discount' => 'numeric',
            'total' => 'numeric',
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
            //..
        ];

        $itemMessages = (new InvoiceItemUpdateRequest)->messages();

        return array_merge($messages, $itemMessages);
    }
}
