<?php

namespace App\Http\Requests;

use App\Enums\Currency;
use App\Rules\YearIsGreater;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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
            'year' => ['required_with:month', 'digits:4', 'integer', 'min:1900', new YearIsGreater],
            'month' => 'integer|between:1,12',
            'currency' => Rule::in(Currency::getValues())
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'year.digits' => __('The :attribute value invalid or not support.'),
            'year.integer' => __('The :attribute value invalid or not support.'),
            'year.min' => __('The :attribute value invalid or not support.'),
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $msg = [];
        foreach ($validator->errors()->messages() as $key => $messages) {
            foreach ($messages as $message) {
                $msg[] = $message;
            }
        }
        toast(trim(implode("\t\n", $msg)), 'warning');
    }
}
