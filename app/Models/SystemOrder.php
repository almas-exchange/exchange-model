<?php

namespace ExchangeModel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ExchangeModel\Enum\SystemOrderSideEnum;
use ExchangeModel\Enum\SystemOrderTypeEnum;

class SystemOrder extends Model
{
    use SoftDeletes;

    protected $table = 'system_orders';

    protected $hidden = [];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'market_name', 'market_name_fa', 'is_market'
    ];

    protected $casts = [
        'side' => SystemOrderSideEnum::class,
        'type' => SystemOrderTypeEnum::class,
    ];

    public function market()
    {
        return $this->belongsTo(modelNamespace('Market'), 'market_id');
    }

    public function wallet()
    {
        return $this->belongsTo(modelNamespace('Wallet'), 'wallet_id');
    }

    public function baseWallet()
    {
        return $this->belongsTo(modelNamespace('Wallet'), 'base_wallet_id');
    }

    public function order()
    {
        return $this->hasOne(modelNamespace('Order'), 'system_order_id');
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
        return is_null($this->stop_limit);
    }
}
