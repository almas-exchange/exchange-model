<?php

namespace ExchangeModel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Exchange\Facades\MongoBaseRepositoryFacade;

class Wallet extends Model
{
    use SoftDeletes;

    protected $table = 'wallets';

    protected $hidden = [];

    protected $guarded = [
        'id',
        'user_id',
        'currency_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'buy_freeze', 'sell_freeze', 'total_freeze'
    ];

    public function user()
    {
        return $this->belongsTo(modelNamespace('User'));
    }

    public function currency()
    {
        return $this->belongsTo(modelNamespace('Currency'));
    }

    public function deposits()
    {
        return $this->hasMany(modelNamespace('Deposit'));
    }

    public function irtDeposits()
    {
        return $this->hasMany(modelNamespace('IrtDeposit'));
    }

    public function withdrawals()
    {
        return $this->hasMany(modelNamespace('Withdrawal'));
    }

    public function irtWithdrawals()
    {
        return $this->hasMany(modelNamespace('IrtWithdrawal'));
    }

    public function sellOrders()
    {
        return $this->hasMany(modelNamespace('Order'), 'wallet_id')->where('side', '=', 'sell');
    }

    public function buyOrders()
    {
        return $this->hasMany(modelNamespace('Order'), 'base_wallet_id')->where('side', '=', 'buy');
    }

    public function sellSystemOrders()
    {
        return $this->hasMany(modelNamespace('SystemOrder'), 'wallet_id')->where('side', '=', 'sell');
    }

    public function buySystemOrders()
    {
        return $this->hasMany(modelNamespace('SystemOrder'), 'base_wallet_id')->where('side', '=', 'buy');
    }

    public function getMarketNameAttribute()
    {
        return $this->market->name;
    }

    public function getBuyFreezeAttribute()
    {
        $freeze = 0;
        foreach ($this->makeHidden('buyOrders')->buyOrders as $buyOrder) {
            $buyTable = str_replace(' ', '', strtolower(str_replace('/', '_', $buyOrder->market_name))) . '_order_buy';

            $buyOrders = MongoBaseRepositoryFacade::getRecords($buyTable, ['order_id' => $buyOrder->id]);
            foreach ($buyOrders as $buyOrder) {
                $remain = is_null($buyOrder['limit']) ? $buyOrder['value_remain'] : mulAmount($buyOrder['limit'], $buyOrder['remain']);
                $freeze = addAmount($freeze, $remain);
            }
        }
        return (string)$freeze;
    }

    public function getSellFreezeAttribute()
    {
        $freeze = 0;

        foreach ($this->makeHidden('sellOrders')->sellOrders as $sellOrder) {
            $sellTable = str_replace(' ', '', strtolower(str_replace('/', '_', $sellOrder->market_name))) . '_order_sell';
            $buyOrders = MongoBaseRepositoryFacade::getRecords($sellTable, ['order_id' => $sellOrder->id]);
            $freeze = addAmount($freeze, $buyOrders->sum('value_remain'));

        }

        return (string)$freeze;
    }

    public function getTotalFreezeAttribute()
    {
        return addAmount((string)$this->sell_freeze, (string)$this->buy_freeze);
    }
}
