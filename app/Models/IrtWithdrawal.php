<?php

namespace ExchangeModel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IrtWithdrawal extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'irt_withdrawals';

    protected $hidden = [];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function creditCard()
    {
        return $this->belongsTo(modelNamespace('CreditCard'));
    }

    public function wallet()
    {
        return $this->belongsTo(modelNamespace('Wallet'));
    }
}
