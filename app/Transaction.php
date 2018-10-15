<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [ ];
    protected $casts = [
        'split' => 'array'
   ];
    // Many to one
    public function account() { return $this->belongsTo('App\Account'); }
}
