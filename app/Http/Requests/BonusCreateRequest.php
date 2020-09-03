<?php

namespace App\Http\Requests;

use App\Enums\BonusType;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class BonusCreateRequest extends FormRequest
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
            'person_id' => 'required|exists:people,id',
            'type' => ['required', new EnumValue(BonusType::class)],
            'value' => 'required|numeric',
        ];
    }
}
