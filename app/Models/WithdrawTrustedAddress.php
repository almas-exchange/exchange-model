<?php

namespace ExchangeModel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WithdrawTrustedAddress extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'withdraw_trusted_addresses';

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

    public function network()
    {
        return $this->belongsTo(modelNamespace('Network'));
    }

    public function currency()
    {
        return $this->belongsTo(modelNamespace('Currency'));
    }
}
