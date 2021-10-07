<?php

namespace App\Http\Requests;

use App\Enums\SalaryReviewProfGrowthType;
use App\Enums\SalaryReviewReason;
use App\Enums\SalaryReviewType;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\RequiredIf;

class SalaryReviewUpdateRequest extends FormRequest
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
            'date' => 'required|date_format:d-m-Y',
            'type' => ['required', new EnumValue(SalaryReviewType::class)],
            'sum' => 'required|numeric',
            'reason' => ['required', new EnumValue(SalaryReviewReason::class)],
            'comment' => 'nullable|string',
            'prof_growth' => [
                new RequiredIf($this->reason === SalaryReviewReason::PROFESSIONAL_GROWTH),
                new EnumValue(SalaryReviewProfGrowthType::class)
            ],
        ];
    }
}
