<?php

namespace ExchangeModel\Models;

use ExchangeModel\Casts\OrderDecimal128Cast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use ExchangeModel\Enum\OrderSideEnum;
use ExchangeModel\Enum\OrderStatusEnum;

class Order extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'orders';

    protected $hidden = [
        'orderMakers', 'orderTakers', 'wallet', 'base_wallet'
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'average_limit', 'fee',
        'execution_value', 'execution_amount',
        'order_transactions',
        'remain', 'remain_value',
        'market_name', 'market_name_fa',
        'is_market', 'touch'
    ];

    protected $casts = [
        'limit'            => OrderDecimal128Cast::class,
        'amount'           => OrderDecimal128Cast::class,
        'value'            => OrderDecimal128Cast::class,
        'init_price'       => OrderDecimal128Cast::class,
        'side'             => OrderSideEnum::class,
        'status'           => OrderStatusEnum::class,
        'average_limit'    => OrderDecimal128Cast::class,
        'execution_value'  => OrderDecimal128Cast::class,
        'execution_amount' => OrderDecimal128Cast::class,
    ];

    public function market()
    {
        return $this->belongsTo(modelNamespace('Market'), 'market_id');
    }

    public function orderMakers()
    {
        return $this->hasMany(modelNamespace('OrderMaker'));
    }

    public function orderTakers()
    {
        return $this->hasMany(modelNamespace('OrderTaker'));
    }

    public function wallet()
    {
        return $this->belongsTo(modelNamespace('Wallet'), 'wallet_id');
    }

    public function baseWallet()
    {
        return $this->belongsTo(modelNamespace('Wallet'), 'base_wallet_id');
    }

    public function systemOrder()
    {
        return $this->belongsTo(modelNamespace('SystemOrder'), 'system_order_id');
    }

    public function getOrderTransactionsAttribute()
    {
        $all = $this->load(['orderTakers', 'orderMakers']);
        $collection = new Collection();
        $collection->add($all->orderTakers);
        $collection->add($all->orderMakers);
        return $collection->flatten()->sortBy('created_at', null, 'desc');
    }

    public function getAverageLimitAttribute()
    {
        return ($this->orderTransactions->count() > 0) ? $this->orderTransactions->avg('limit') : null;
    }

    public function getFeeAttribute()
    {
        return ($this->orderTransactions->count() > 0) ? $this->orderTransactions->sum('fee') : null;
    }

    public function getExecutionValueAttribute()
    {
        return ($this->orderTransactions->count() > 0) ? $this->orderTransactions->sum('value') : null;
    }

    public function getExecutionAmountAttribute()
    {
        return ($this->orderTransactions->count() > 0) ? $this->orderTransactions->sum('amount') : null;
    }

    public function getRemainAttribute()
    {
        if (is_null($this->amount) || is_null($this->execution_amount)) {
            return null;
        }
        return subAmount($this->amount, $this->execution_amount);
    }

    public function getRemainValueAttribute()
    {
        if (is_null($this->remain) || is_null($this->limit)) {
            return null;
        }
        return mulAmount($this->remain, $this->limit);
    }

    public function getMarketNameAttribute()
    {
        return $this->makeHidden('market')->market->name;
    }

    public function getMarketNameFaAttribute()
    {
        return $this->makeHidden('market')->market->name_fa;
    }

    public function getIsMarketAttribute()
    {
        return is_null($this->limit);
    }

    public function getTouchAttribute()
    {
        return ($this->orderTransactions->count() > 0);
    }
}
