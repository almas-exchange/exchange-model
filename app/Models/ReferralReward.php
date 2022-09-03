<?php

namespace ExchangeModel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReferralReward extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'referral_rewards';

    protected $hidden = [];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function currency()
    {
        return $this->belongsTo(modelNamespace('Currency'),'currency_id');
    }

    public function user()
    {
        return $this->belongsTo(modelNamespace('User'),'user_id');
    }

    public function referralUser()
    {
        return $this->belongsTo(modelNamespace('User'),'referral_user_id');
    }
}