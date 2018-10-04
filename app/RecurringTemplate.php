<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecurringTemplate extends Model
{
    // Many to one
    public function account() { return $this->belongsTo('App\Account'); }
}
