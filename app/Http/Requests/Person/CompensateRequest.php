<?php

namespace App\Http\Requests\Person;

use Illuminate\Foundation\Http\FormRequest;

class CompensateRequest extends FormRequest
{
    /**
     * @var mixed
     */
    private $month;

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
            'month' => 'required|integer|min:1|max:12'
        ];
    }
}
