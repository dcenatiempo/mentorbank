<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getTypeAttribute() {
        $type = 'none';
        if ($this->banker()->first()) { $type = 'banker'; }
        else if ($this->accountHolder()->first()) { $type = 'account_holder'; }
        return $type;
    }

    protected $appends = ['type'];

    // One to one
    public function banker()        { return $this->hasOne('App\Banker'); }
    public function accountHolder() { return $this->hasOne('App\AccountHolder'); }
}
