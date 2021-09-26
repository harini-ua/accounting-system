<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientUpdateRequest extends FormRequest
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
            'company_name' => 'required|string|min:2',
            'email' => ['required', 'email', Rule::unique('clients')->ignore($this->client->id)->whereNull('deleted_at')],
            'phone' => ['required', 'string', Rule::unique('clients')->ignore($this->client->id)->whereNull('deleted_at')],
            // address
            'country' => 'nullable|string|min:2',
            'address' => 'nullable|string|min:3',
            'city' => 'nullable|string|min:1',
            'state' => 'nullable|string|min:2',
            'postal_code' => 'nullable|string|min:3',
            // bank
            'bank_name' => 'nullable|string|min:3',
            'bank_address' => 'nullable|string|min:3',
            'account' => 'nullable|string|min:3|max:100',
            'iban' => 'nullable|iban',
            'swift' => 'nullable|bic',
        ];
    }
}
