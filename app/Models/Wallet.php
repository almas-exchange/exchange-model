<?php

namespace ExchangeModel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Wallet extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
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

    public function sellMarkets()
    {
        return $this->hasMany(modelNamespace('Market'), 'currency_id', 'currency_id');
    }

    public function buyMarkets()
    {
        return $this->hasMany(modelNamespace('Market'), 'base_currency_id', 'currency_id');
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

    public function transactions()
    {
        return $this->hasMany(modelNamespace('Transaction'));
    }

    public function getMarketNameAttribute()
    {
        return $this->market->name;
    }

    public function getBuyFreezeAttribute()
    {
        $freeze = 0;
        foreach ($this->makeHidden('buyMarkets')->buyMarkets as $market) {
            $buyTable = str_replace(' ', '', strtolower(str_replace('/', '_', $market->name))) . '_order_buy';
            $buyOrders = DB::connection('mongodb')->table($buyTable)->where(['base_wallet_id' => $this->id])->get();

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
        foreach ($this->makeHidden('sellMarkets')->sellMarkets as $market) {
            $sellTable = str_replace(' ', '', strtolower(str_replace('/', '_', $market->name))) . '_order_sell';
            $sellOrders = DB::connection('mongodb')->table($sellTable)->where(['wallet_id' => $this->id])->get();

            foreach ($sellOrders as $sellOrder) {
                $freeze = addAmount($freeze, $sellOrder['remain']);
            }
        }


        return (string)$freeze;
    }

    public function getTotalFreezeAttribute()
    {
        return addAmount((string)$this->sell_freeze, (string)$this->buy_freeze);
    }
}
