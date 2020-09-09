<?php

namespace App\Rules;

use App\Models\CalendarYear;
use Illuminate\Contracts\Validation\Rule;

class YearIsGreater implements Rule
{
    /** @var array $years */
    public $years;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->years = CalendarYear::orderBy('name')->get()->pluck('name')->toArray();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return in_array((int) $value, $this->years, true);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The :attribute value invalid or not support.');
    }
}
