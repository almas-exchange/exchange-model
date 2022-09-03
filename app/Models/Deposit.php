<?php

namespace ExchangeModel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ExchangeModel\Enum\DepositTypeEnum;

class Deposit extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'deposits';

    protected $hidden = [];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'type' => DepositTypeEnum::class
    ];

    public function wallet()
    {
        return $this->belongsTo(modelNamespace('WithdrawTrustedAddress'));
    }

    public function network()
    {
        return $this->belongsTo(modelNamespace('Network'));
    }
}
