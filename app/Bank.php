<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    // One to many
    public function bankers()        { return $this->hasMany('App\Banker'); }
    public function accounts()       { return $this->hasMany('App\Account'); }
    public function accountHolders() { return $this->hasMany('App\AccountHolder'); }
    public function categories()     { return $this->hasMany('App\Category'); }
    public function transactions()   { return $this->hasManyThrough('App\Transaction', 'App\Account'); }

    public function getAllCategories() {
        $globalCats = Category::getGlobalCategories()
            ->orderBy('id')->get();

        $localBankCats = $this->categories()
            ->orderBy('name')->get();
        
        $allBankCats = $globalCats->merge($localBankCats);

        return $allBankCats;
    }

    public function getAllVisibleCategories() {
        return $this->getAllCategories()->filter(function ($cat) {
            return $cat['hidden'] == false;
        });
    }

    public function getForcedSubscribeCategories() {
        return $this->getAllCategories()->filter(function ($cat) {
            return $cat['force_subscribe'] == true;
        });
    }
}
