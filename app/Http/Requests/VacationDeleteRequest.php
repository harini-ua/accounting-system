<?php

namespace App\Http\Requests;

use App\Enums\VacationPaymentType;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class VacationDeleteRequest extends FormRequest
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
            'date' => 'required|date_format:d-m-Y',
            'payment_type' => ['required', new EnumValue(VacationPaymentType::class)],
            'person_id' => 'required|exists:people,id',
        ];
    }
}
