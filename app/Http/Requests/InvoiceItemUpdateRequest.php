<?php

namespace App\Http\Requests;

use App\Enums\InvoiceItemType;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class InvoiceItemUpdateRequest extends FormRequest
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
            'items.*.title' => 'required|string|max:100',
            'items.*.type' => ['required', new EnumValue(InvoiceItemType::class)],
            'items.*.qty' => 'required|integer',
            'items.*.rate' => 'required|numeric',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'items.*.title.required' => __('The title field is required.'),
            'items.*.type.required' => __('The type field is required.'),
            'items.*.qty.required' => __('The qrt field is required.'),
            'items.*.rate.required' => __('The rate field is required.'),
        ];
    }
}
