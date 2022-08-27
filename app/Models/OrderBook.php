<?php

namespace ExchangeModel\Models;

use ExchangeModel\Casts\Decimal128Cast;
use Illuminate\Database\Eloquent\Casts\Attribute;
use ImanRjb\Mongodb\Eloquent\Model;
use MongoDB\BSON\Decimal128;


class OrderBook extends Model
{
    protected $connection = 'mongodb';
    protected $guarded = [];
    protected $casts = [
        'limit'      => Decimal128Cast::class,
        'stop_price' => Decimal128Cast::class
    ];


    public function setDynamicTable($dynamicType)
    {
        return $this->setTable($dynamicType);
    }

}
