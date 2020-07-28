<?php

namespace App\Http\Requests;

use App\Enums\InvoiceItemType;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class InvoiceItemCreateRequest extends FormRequest
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
            'title' => 'required|string|max:100',
            'description' => 'string',
            'type' =>  ['required', new EnumValue(InvoiceItemType::class)],
            'qrt' => 'required|integer',
            'rate' => 'required|numeric',
        ];
    }
}
