<?php

namespace ExchangeModel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddressType extends Model
{
    use SoftDeletes;

    protected $table = 'address_types';

    protected $hidden = [];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function networks()
    {
        return $this->hasMany(modelNamespace('Network'));
    }

    public function addresses()
    {
        return $this->hasMany(modelNamespace('Address'));
    }

    public function mainAddress()
    {
        return $this->addresses()->where('is_main', '=', true)->where('user_id', '=', auth()->user()->id);
    }
}
