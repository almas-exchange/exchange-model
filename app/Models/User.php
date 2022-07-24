<?php

namespace ExchangeModel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// start passport-auth traits
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
// end passport-auth traits
use ExchangeModel\Enum\User2faEnum;
use ExchangeModel\Enum\UserGenderEnum;

use function PHPUnit\Framework\isNull;

class User extends Model
{
    use SoftDeletes, Authenticatable, Authorizable;

    protected $table = 'users';

    protected $hidden = [
        'password'
    ];

    protected $guarded = [
        'id',
        'user_group_id',
        'shahkar' ,
        'block',
        'verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'gender' => UserGenderEnum::class,
        '2fa'    => User2faEnum::class,
    ];

    protected $appends = [
        'mobile_mask',
        'email_mask',
        'phone_mask',
        'totp_secret_status'
    ];

    public function userGroup()
    {
        return $this->belongsTo(modelNamespace('UserGroup'));
    }

    public function wallets()
    {
        return $this->hasMany(modelNamespace('Wallet'));
    }

    public function creditCards()
    {
        return $this->hasMany(modelNamespace('CreditCard'));
    }

    public function country()
    {
        return $this->belongsTo(modelNamespace('Country'));
    }

    public function notifications()
    {
        return $this->hasMany(modelNamespace('Notification'));
    }

    public function alerts()
    {
        return $this->hasMany(modelNamespace('Alert'));
    }

    public function referralCodes()
    {
        return $this->hasMany(modelNamespace('ReferralCode'));
    }

    public function referredBy()
    {
        return $this->belongsTo(modelNamespace('User'), 'referral_user_id');
    }

    public function addresses()
    {
        return $this->hasMany(modelNamespace('Address'));
    }

    public function userReward()
    {
        return $this->hasMany(modelNamespace('ReferralReward'), 'user_id');
    }

    public function refferalUserReward()
    {
        return $this->hasMany(modelNamespace('ReferralReward'), 'referral_user_id');
    }

    public function withdrawTrustedAddreses()
    {
        return $this->hasMany(modelNamespace('WithdrawTrustedAddress'));
    }

    public function getMobileMaskAttribute()
    {
        if(! empty($this->mobile)) {
            return substr($this->mobile, 0, 4)
            . str_repeat('*', strlen($this->mobile) - 8)
            . substr($this->mobile, -4);
        }
        return null;
    }

    public function getEmailMaskAttribute()
    {
        if(! empty($this->email)) {
            $explodedMail = explode('@', $this->email);
            
            if(strlen($explodedMail[0]) > 4) {
                return substr($explodedMail[0], 0, 2)
                . str_repeat('*', strlen($explodedMail[0]) - 4)
                . substr($explodedMail[0], -2)
                . '@'
                . $explodedMail[1];
            
            } else {
                return substr($explodedMail[0], 0, 1)
                . str_repeat('*', strlen($explodedMail[0]) - 2)
                . substr($explodedMail[0], -1)
                . '@'
                . $explodedMail[1];
            }
        }
        return null;
    }

    public function getPhoneMaskAttribute()
    {
        if(! empty($this->phone)) {
            return substr($this->phone, 0, 3)
            . str_repeat('*', strlen($this->phone) - 7)
            . substr($this->phone, -4);
        }
        return null;
    }

    public function getTotpSecretStatusAttribute()
    {
        if(! is_null($this->totp_secret)) {
            return true;
        }
        return false;
    }
}
