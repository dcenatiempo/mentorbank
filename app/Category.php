<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    
    protected $guarded = [ 'id', 'hidden', ];
    // protected $hidden = [ 'hidden', 'created_at', 'updated_at', 'deleted_at', 'bank_id'];
    
    protected $appends = ['archived', 'subscribed_count'];

    public function getArchivedAttribute() {
        return $this->deleted_at != null;
    }

    public function getSubscribedCountAttribute() {
        return $this->subscribedCategories()->count();
    }

    // One to one (inverse)
    public function bank() { return $this->belongsTo('App\Bank'); }

    // Many to many
    public function accounts() { return $this->belongsToMany('App\Account'); }
    public function subscribedCategories() { return $this->hasMany('App\SubscribedCategory'); }

    // public static function boot() {
    //     parent::boot();

    //     static::creating(function($category)
    //     {
    //         //
    //     });

    //     static::updating(function($category)
    //     {
    //         //
    //     });

    //     static::deleting(function($category)
    //     {
    //         //
    //     });
    // }

    public static function getGlobalCategories() {
        return Category::
            where('is_global', '=', true)
            ->where('bank_id', '=', null);
    }

    public function isInUse() {
        $isInUse = false;

        // is category in use in any bank transactions?
        $transactions = $this->bank->transactions;
        foreach($transactions as $transaction) {
            foreach($transaction->split as $split) {
                if ($split['category_id'] == $this->id) {
                    $isInUse = true;
                    break 2;
                }
            }
        }
        
        // if no uses, check if in use in transaction history
        if (!$isInUse) {
            // TODO
        }

        return $isInUse;
    }
}
