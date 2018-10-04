<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banker extends Model
{
    // Many to one
    public function bank() { return $this->belongsTo('App\Bank'); }

    // One to one (inverse)
    public function user() { return $this->belongsTo('App\User'); }
}
