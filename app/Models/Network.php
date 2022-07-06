<?php

namespace ExchangeModel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Network extends Model
{
    use SoftDeletes;

    protected $table = 'networks';

    protected $hidden = [];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function currencies()
    {
        return $this->belongsToMany(modelNamespace('Currency'))
            ->withPivot([
                'deposit_status', 'withdrawal_status',
                'mx_balance', 'contract', 'decimal', 'withdrawal_fee'
            ]);
    }

    public function addressType()
    {
        return $this->belongsTo(modelNamespace('AddressType'));
    }

    public function deposits()
    {
        return $this->hasMany(modelNamespace('Deposit'));
    }

    public function withdrawals()
    {
        return $this->hasMany(modelNamespace('Withdrawal'));
    }

    public function withdrawTrustedAddreses()
    {
        return $this->hasMany(modelNamespace('Withdrawal'));
    }
}
