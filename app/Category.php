<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [ 'hidden', ];
    protected $hidden = [ 'hidden', 'created_at', 'updated_at', 'deleted_at', 'bank_id'];
    
    protected $appends = ['archived'];
    public function getArchivedAttribute() {
        return $this->deleted_at != null;
    }

    // One to one (inverse)
    public function bank() { return $this->belongsTo('App\Bank'); }

    // Many to many
    public function accounts() { return $this->belongsToMany('App\Account'); }

    public static function getGlobalCategories() {
        return Category::
            where('standard', '=', true)
            ->where('bank_id', '=', null)
            ->get();
    }
}
