<?php

namespace ExchangeModel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderTaker extends Model
{
    use SoftDeletes;

    protected $table = 'order_takers';

    protected $hidden = [];

    protected $appends = [
        'type'
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function order()
    {
        return $this->belongsTo(modelNamespace('Order'), 'order_id');
    }

    public function feeCurrency()
    {
        return $this->belongsTo(modelNamespace('Currency'), 'fee_currency_id');
    }

    public function orderMaker()
    {
        return $this->hasOne(modelNamespace('OrderMaker'),'order_maker_id');
    }

    public function getTypeAttribute()
    {
        return 'taker';
    }

    public function getMarketIdAttribute()
    {
        return $this->order->market->id;
    }

    public function getUserIdAttribute()
    {
        return $this->order->wallet->user_id;
    }
}
