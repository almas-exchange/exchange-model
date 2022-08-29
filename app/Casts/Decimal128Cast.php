<?php

namespace ExchangeModel\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use MongoDB\BSON\Decimal128;

class Decimal128Cast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return string
     */
    public function get($model, $key, $value, $attributes)
    {
        return $value ? (string)new Decimal128($value) : '-';
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     * @return Decimal128
     */
    public function set($model, $key, $value, $attributes)
    {
        if (!$value) {
            return null;
        }

        return new Decimal128($value);
    }
}
