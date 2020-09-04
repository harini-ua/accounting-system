<?php

namespace App\Http\Requests;

use App\Enums\VacationPaymentType;
use App\Enums\VacationType;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class VacationRequest extends FormRequest
{
    /**
     * @var mixed
     */
    private $payment_type;

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
            'type' => ['required', new EnumValue(VacationType::class)],
            'payment_type' => ['required', new EnumValue(VacationPaymentType::class)],
            'person_id' => 'required|exists:people,id',
        ];
    }
}
