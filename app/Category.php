<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // One to one (inverse)
    public function bank() { return $this->belongsTo('App\Bank'); }

    // Many to many
    public function accounts() { return $this->belongsToMany('App\Account'); }
}
