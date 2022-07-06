<?php

namespace ExchangeModel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ExchangeModel\Enum\MxTransactionTypeEnum;

class MxTransaction extends Model
{
    use SoftDeletes;

    protected $table = 'mx_transactions';

    protected $hidden = [];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'type' => MxTransactionTypeEnum::class
    ];

    public function currency()
    {
        return $this->belongsTo(modelNamespace('Currency'));
    }
}