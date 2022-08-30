<?php

namespace ExchangeModel\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use MongoDB\BSON\Decimal128;

class MarketInformationDecimal128Cast implements CastsAttributes
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
        return (string)new Decimal128($value);
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
            return new Decimal128(0);
        }

        $market = $model->market;
        $value = match ($key) {
            'high' => bcdiv($value, 1, $market->base_currency_decimal),
            'low' => bcdiv($value, 1, $market->base_currency_decimal),
            'volume' => bcdiv($value, 1, $market->currency_decimal),
            'value' => bcdiv($value, 1, max($market->currency_decimal, $market->base_currency_decimal)),
            'yesterday_price' => bcdiv($value, 1, $market->base_currency_decimal),
            'last_price' => bcdiv($value, 1, $market->base_currency_decimal),
        };
        return new Decimal128($value);
    }
}
