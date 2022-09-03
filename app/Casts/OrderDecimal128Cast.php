<?php

namespace ExchangeModel\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use MongoDB\BSON\Decimal128;

class OrderDecimal128Cast implements CastsAttributes
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
        return $value ? (string)new Decimal128($value) : null;
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
        if (!$value || $value == 0) {
            return null;
        }

        $market = $model->market;
        $value = match ($key) {
            'limit' => bcdiv($value, 1, $market->base_currency_decimal),
            'amount' => bcdiv($value, 1, $market->currency_decimal),
            'value' => bcdiv($value, 1, max($market->currency_decimal, $market->base_currency_decimal)),
            'init_price' => bcdiv($value, 1, $market->base_currency_decimal),
            'average_limit' => bcdiv($value, 1, $market->base_currency_decimal),
            'execution_value' => bcdiv($value, 1, max($market->currency_decimal, $market->base_currency_decimal)),
            'execution_amount' => bcdiv($value, 1, $market->currency_decimal),
        };
        return (string)new Decimal128($value);
    }
}
