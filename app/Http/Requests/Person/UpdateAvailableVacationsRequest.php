<?php

namespace App\Http\Requests\Person;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAvailableVacationsRequest extends FormRequest
{
    /**
     * @var mixed
     */
    private $available_vacations;

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
            'available_vacations' => 'required|integer|max:999'
        ];
    }
}
