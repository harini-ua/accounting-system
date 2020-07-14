<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientCreateRequest extends FormRequest
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
            'email' => 'required|email|unique:clients,email',
            'phone' => 'required|string|unique:clients,phone',
            'country' => 'nullable|string|min:2',
            'address' => 'nullable|string|min:3',
            'city' => 'nullable|string|min:1',
            'state' => 'nullable|string|min:2',
            'postal_code' => 'nullable|integer',
        ];
    }
}
