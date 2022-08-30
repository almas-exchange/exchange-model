<?php

namespace ExchangeModel\Models;


use ExchangeModel\Casts\MarketInformationDecimal128Cast;
use ImanRjb\Mongodb\Eloquent\Model;

class MarketInformation extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'markets_info';
    protected $guarded = [];
    protected $casts = [
        'volume'          => MarketInformationDecimal128Cast::class,
        'value'           => MarketInformationDecimal128Cast::class,
        'high'            => MarketInformationDecimal128Cast::class,
        'low'             => MarketInformationDecimal128Cast::class,
        'yesterday_price' => MarketInformationDecimal128Cast::class,
        'last_price'      => MarketInformationDecimal128Cast::class
    ];

    public function market()
    {
        return $this->belongsTo(modelNamespace('Market'), 'market_id');
    }
}
