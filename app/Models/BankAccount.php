<?php

namespace ExchangeModel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'bank_accounts';

    protected $hidden = [];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'bank_name', 'bank_label',
    ];


    public function user()
    {
        return $this->belongsTo(modelNamespace('User'));
    }

    public function irtWithdrawals()
    {
        return $this->hasMany(modelNamespace('IrtWithdrawal'));
    }


    public function getBankNameAttribute()
    {
        $information = getNameWithCard($this->card);
        return $information['label'];
    }

    public function getBankLabelAttribute()
    {
        $information = getNameWithCard($this->card);
        return $information['code'];
    }
}
