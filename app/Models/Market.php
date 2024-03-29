<?php

namespace ExchangeModel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Market extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'markets';

    protected $hidden = [
        'order_transactions'
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'last_price',
        'queue_name'
    ];

    public function currency()
    {
        return $this->belongsTo(modelNamespace('Currency'), 'currency_id');
    }

    public function baseCurrency()
    {
        return $this->belongsTo(modelNamespace('Currency'), 'base_currency_id');
    }

    public function orders()
    {
        return $this->hasMany(modelNamespace('Order'));
    }

    public function orderBooks()
    {
        return $this->hasMany(modelNamespace('OrderBook'));
    }

    public function marketInformation()
    {
        return $this->hasOne(modelNamespace('MarketInformation'));
    }

    public function systemOrders()
    {
        return $this->hasMany(modelNamespace('SystemOrder'));
    }

    public function orderTransactions()
    {
        return $this->hasManyThrough(modelNamespace('OrderMaker'), modelNamespace('Order'), 'market_id', 'order_id')->orderBy('id', 'desc');
    }

    public function orderTransactionsByLimit($limit = 20)
    {
        return $this->hasManyThrough(modelNamespace('OrderMaker'), modelNamespace('Order'), 'market_id', 'order_id')->orderBy('id', 'desc')->limit($limit);
    }

    public function usersFavorite()
    {
        return $this->belongsToMany(modelNamespace('User'), 'favorite_markets', 'market_id', 'user_id');
    }

    public function getLastPriceAttribute()
    {
        return Cache::rememberForever(strtolower(str_replace('/', '_', $this->name)) . '_price', function () {
            if ($this->orderTransactions->count() > 0) {
                return $this->orderTransactions->first()->limit;
            } else {
                return 0;
            }
        });
    }

    public function getQueueNameAttribute()
    {
        return str_replace(' ', '', strtolower(str_replace('/', '_', $this->name)));
    }
}
