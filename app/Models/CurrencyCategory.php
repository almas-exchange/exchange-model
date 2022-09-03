<?php

namespace ExchangeModel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurrencyCategory extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'currency_categories';

    protected $hidden = [];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function currencies()
    {
        return $this->belongsToMany(modelNamespace('Currency'), 'currency_currency_category', 'currency_category_id', 'currency_id');
    }
}
