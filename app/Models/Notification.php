<?php

namespace ExchangeModel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'notifications';

    protected $hidden = [];

    protected $guarded = [
        'id'
    ];

    public function user()
    {
        return $this->belongsTo(modelNamespace('User'));
    }

    public function notificationType()
    {
        return $this->belongsTo(modelNamespace('NotificationType'));
    }
}
