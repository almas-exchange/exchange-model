<?php

namespace ExchangeModel\Models;

use ExchangeModel\Enum\TransactionTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'transactions';

    protected $hidden = [];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'type' => TransactionTypeEnum::class
    ];

    public function wallet()
    {
        return $this->belongsTo(modelNamespace('Wallet'));
    }
}
