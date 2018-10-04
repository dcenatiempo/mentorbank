<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    // Many to one
    public function account() { return $this->belongsTo('App\Account'); }
}
