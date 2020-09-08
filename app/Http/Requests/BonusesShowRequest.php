<?php

namespace App\Http\Requests;

use App\Enums\Currency;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BonusesShowRequest extends FormRequest
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
            'year' => 'required_with:month|digits:4|integer|min:1900|max:'.(date('Y')+1),
            'month' => 'integer|between:1,12',
            'currency' => Rule::in(Currency::getValues())
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $msg = [];
        foreach ($validator->errors()->messages() as $key => $messages) {
            foreach ($messages as $message) {
                $msg[] = $message;
            }
        }
        toast(trim(implode("\t\n", $msg)),'warning');
    }
}
