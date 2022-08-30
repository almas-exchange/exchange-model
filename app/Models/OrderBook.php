<?php

namespace ExchangeModel\Models;


use ExchangeModel\Casts\OrderBookDecimal128Cast;
use ImanRjb\Mongodb\Eloquent\Model;


class OrderBook extends Model
{
    protected $connection = 'mongodb';
    protected $guarded = [];
    protected $casts = [
        'limit'        => OrderBookDecimal128Cast::class,
        'value'        => OrderBookDecimal128Cast::class,
        'amount'       => OrderBookDecimal128Cast::class,
        'init_price'   => OrderBookDecimal128Cast::class,
        'stop_price'   => OrderBookDecimal128Cast::class,
        'remain'       => OrderBookDecimal128Cast::class,
        'value_remain' => OrderBookDecimal128Cast::class,

    ];


    public function setDynamicTable($dynamicType)
    {
        return $this->setTable($dynamicType);
    }

    public function market()
    {
        return $this->belongsTo(modelNamespace('Market'), 'market_id');
    }

}
