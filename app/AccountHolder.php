<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountHolder extends Model
{
    // One to one
    public function account() { return $this->hasOne('App\Account'); }
    
    // One to one (inverse)
    public function user() { return $this->belongsTo('App\User'); }

    // Many to one
    public function bank() { return $this->belongsTo('App\Bank'); }
}
