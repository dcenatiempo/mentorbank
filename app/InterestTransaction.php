<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InterestTransaction extends Model
{
    // Many to one
    public function account() { return $this->belongsTo('App\Account'); }

    protected $fillable = [
        'amount', 'category_id', 'account_id'
    ];
}
