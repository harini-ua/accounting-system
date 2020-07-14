<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Carbon;

class Date implements CastsAttributes
{
    /** @var string $format */
    protected $format;

    /**
     * Date constructor.
     *
     * @param string $format
     */
    public function __construct($format = 'd-m-Y')
    {
        $this->format = $format;
    }

    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     *
     * @return string
     */
    public function get($model, $key, $value, $attributes)
    {
        return Carbon::parse($value)->format($this->format);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     *
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        return Carbon::parse($value);
    }
}
