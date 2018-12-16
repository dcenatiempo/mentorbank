<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SubscribedCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Bank extends Model
{
    // One to many
    public function bankers()        { return $this->hasMany('App\Banker'); }
    public function accounts()       { return $this->hasMany('App\Account'); }
    public function accountHolders() { return $this->hasMany('App\AccountHolder'); }
    public function categories()     { return $this->hasMany('App\Category'); }
    public function transactions()   { return $this->hasManyThrough('App\Transaction', 'App\Account'); }
    public function interestTransactions()   { return $this->hasManyThrough('App\InterestTransaction', 'App\Account'); }

    protected $dates = ['plan_expires'];

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

    public function getTotalAccruedInterest() {
        $interest = SubscribedCategory::where('category_id', 1)
            ->whereIn('account_id', $this->accounts()->pluck('id')->toArray());
        $interest = $interest->pluck('balance')->sum();

        return round($interest, 2);    
    }

    public function shouldDowngrade() {
        // is the account holder on a free plan or past grace period
        if ('free' == $this->plan_type || $this->isPastGracePeriod()) {
        
            // does the account holder have more than 1 account or 3 categories
            $numAccounts = count($this->accounts);
            if ($numAccounts > 1) {
                return true;
            }
               
            $numCats = count($this->categories);
            if ($numCats > 3) {
                return true;
            }
        }

        return false;
    }

    private function isPastGracePeriod() {
        if (!$this->plan_expires) {
            return false;
        }
        $expires = $this->plan_expires;
        $now = Carbon::create();
        if ($expires > $now) {
            return false;
        }

        $dif = $now->diff($expires)->days;
        if ($dif < 30) {
            return false;
        }

        return true;
    }

    private function isExpired() {
        if (!$this->plan_expires) {
            return false;
        }
        $expires = $this->plan_expires;
        $now = Carbon::create();
        if ($expires > $now) {
            return false;
        }
        return true;
    }
}
