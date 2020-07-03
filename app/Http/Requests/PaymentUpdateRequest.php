<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentUpdateRequest extends FormRequest
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
            'invoice_id' => 'required|exists:invoices,id',
            'fee' => 'required|regex:^(?:[1-9]\d+|\d)(?:\,\d\d)?$',
            'received_sum' => 'required|regex:^(?:[1-9]\d+|\d)(?:\,\d\d)?$',
            'date' => 'required|date_format:d-m-Y',
        ];
    }
}
