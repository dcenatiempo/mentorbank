<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionHistory extends Model
{
    // Many to one
    public function account() { return $this->belongsTo('App\Account'); }
}
