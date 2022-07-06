<?php

namespace ExchangeModel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreditCard extends Model
{
    use SoftDeletes;

    protected $table = 'credit_cards';

    protected $hidden = [];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(modelNamespace('User'));
    }

    public function irtWithdrawals()
    {
        return $this->hasMany(modelNamespace('IrtWithdrawal'));
    }
}
