<?php

namespace ExchangeModel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ExchangeModel\Enum\CurrencyTypeEnum;

class Currency extends Model
{
    use SoftDeletes;

    protected $table = 'currencies';

    protected $hidden = [
        'wallet_id'
    ];

    protected $guarded = [
        'id',
        'wallet_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'type' => CurrencyTypeEnum::class,
    ];

    public function wallets()
    {
        return $this->hasMany(modelNamespace('Wallet'));
    }

    public function markets()
    {
        return $this->hasMany(modelNamespace('Market'), 'currency_id');
    }

    public function baseMarkets()
    {
        return $this->hasMany(modelNamespace('Market'), 'base_currency_id');
    }

    public function networks()
    {
        return $this->belongsToMany(modelNamespace('Network'))
            ->withPivot([
                'deposit_status', 'withdrawal_status',
                'mx_balance', 'contract', 'decimal', 'withdrawal_fee'
            ]);
    }

    public function mxTransactions()
    {
        return $this->hasMany(modelNamespace('MxTransaction'));
    }

    public function orderMakers()
    {
        return $this->hasMany(modelNamespace('OrderMaker'), 'fee_currency_id');
    }

    public function orderTakers()
    {
        return $this->hasMany(modelNamespace('OrderTaker'), 'fee_currency_id');
    }

    public function referralReward()
    {
        return $this->hasMany(modelNamespace('ReferralReward'), 'currency_id');
    }

    public function withdrawTrustedAddreses()
    {
        return $this->hasMany(modelNamespace('WithdrawTrustedAddress'));
    }

    public function categories()
    {
        return $this->belongsToMany(modelNamespace('CurrencyCategory'), 'currency_currency_category', 'currency_id', 'currency_category_id');
    }
}
