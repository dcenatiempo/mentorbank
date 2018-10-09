<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $guarded = [ ];
    protected $casts = [
        'credit_interest_rate' => 'float',
        'interest_rate' => 'float'
    ];

    // One to one (inverse)
    public function accountHolder()     { return $this->belongsTo('App\AccountHolder'); }
    public function bank()              { return $this->belongsTo('App\Bank'); }

    // One to many
    public function transactions()      { return $this->hasMany('App\Transaction'); }
    public function histories()         { return $this->hasMany('App\History'); }
    public function recurringTempates() { return $this->hasMany('App\RecurringTemplate'); }
    public function notifications()     { return $this->hasMany('App\Notification'); }

    // Many to many
    public function categories()        { return $this->belongsToMany('App\Category'); }
}
