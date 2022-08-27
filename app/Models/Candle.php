<?php

namespace App\Models;

use ExchangeModel\Casts\Decimal128Cast;
use Illuminate\Database\Eloquent\Casts\Attribute;
use ImanRjb\Mongodb\Eloquent\Model;
use MongoDB\BSON\Decimal128;

class Candle extends Model
{
    protected $connection = 'mongodb';
    protected $guarded = [];
    protected $casts = [
        'open'   => Decimal128Cast::class,
        'high'   => Decimal128Cast::class,
        'low'    => Decimal128Cast::class,
        'close'  => Decimal128Cast::class,
        'volume' => Decimal128Cast::class,
        'value'  => Decimal128Cast::class
    ];


    public function setDynamicTable($dynamicType)
    {
        return $this->setTable($dynamicType);
    }

}
