<?php

namespace ExchangeModel\Models;

use ExchangeModel\Casts\Decimal128Cast;
use Illuminate\Database\Eloquent\Casts\Attribute;
use ImanRjb\Mongodb\Eloquent\Model;
use MongoDB\BSON\Decimal128;


class SystemOrderMongo extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'markets_system_orders';
    protected $guarded = [];
    protected $casts = [
        'stop_limit' => Decimal128Cast::class,
        'stop_price' => Decimal128Cast::class,
        'stop_value' => Decimal128Cast::class,
    ];


}
