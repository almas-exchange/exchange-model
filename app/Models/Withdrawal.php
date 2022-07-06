<?php

namespace ExchangeModel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ExchangeModel\Enum\WithdrawalTypeEnum;

class Withdrawal extends Model
{
    use SoftDeletes;

    protected $table = 'withdrawals';

    protected $hidden = [];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'type' => WithdrawalTypeEnum::class
    ];

    public function wallet()
    {
        return $this->belongsTo(modelNamespace('Wallet'));
    }

    public function network()
    {
        return $this->belongsTo(modelNamespace('Network'));
    }
}
