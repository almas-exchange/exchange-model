<?php

namespace ExchangeModel\Models;

use ExchangeModel\Casts\Decimal128Cast;
use Illuminate\Database\Eloquent\Casts\Attribute;
use ImanRjb\Mongodb\Eloquent\Model;
use MongoDB\BSON\Decimal128;

class MarketInformation extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'markets_info';
    protected $guarded = [];
    protected $casts = [
        'volume'          => Decimal128Cast::class,
        'value'           => Decimal128Cast::class,
        'high'            => Decimal128Cast::class,
        'low'             => Decimal128Cast::class,
        'yesterday_price' => Decimal128Cast::class,
        'last_price'      => Decimal128Cast::class
    ];
}
