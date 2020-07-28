<?php

namespace App\Http\Requests;

use App\Enums\InvoiceStatus;
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
        return [
            'name' => 'required|string|max:100',
            'contract_id' => 'required|exists:App\Models\Contract,id',
            'account_id' => 'required|exists:App\Models\Account,id',
            'sales_manager_id' => [
                'required',
                Rule::exists('users')->where(static function ($query) {
                    $query->where('position_id', 5);
                })
            ],
            'date' => 'required|date',
            'status' => ['required', new EnumValue(InvoiceStatus::class)],
            'type' => ['required', new EnumValue(InvoiceType::class)],
            'discount' => 'numeric',
            'total' => 'numeric',
            'plan_income_date' => 'required|date',
            'pay_date' => 'required|date',
        ];
    }
}
