<?php

namespace App\Http\Requests\Person;

use Illuminate\Foundation\Http\FormRequest;

class MakeFormerRequest extends FormRequest
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
            'quited_at' => 'required|date_format:d-m-Y',
            'quit_reason' => 'nullable|string|min:3',
        ];
    }
}