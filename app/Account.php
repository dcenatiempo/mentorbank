<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $guarded = [ ];
    protected $casts = [
        'credit_interest_rate' => 'float',
        'interest_rate' => 'float'
    ];

    // One to one (inverse)
    public function accountHolder()     { return $this->belongsTo('App\AccountHolder'); }
    public function bank()              { return $this->belongsTo('App\Bank'); }

    // One to many
    public function transactions()      { return $this->hasMany('App\Transaction'); }
    public function histories()         { return $this->hasMany('App\TransactionHistory'); }
    public function recurringTemplates() { return $this->hasMany('App\RecurringTemplate'); }
    public function notifications()     { return $this->hasMany('App\Notification'); }

    // Many to many
    public function subscribedCategories()        { return $this->hasMany('App\SubscribedCategory'); }

    public function getBalance() {
        // Get most recent history balance
        $history = $this->getMostRecentHistory();
        $historyBalance = $history ? $history->ending_balance : 0;

        // Add up all account balances
        $transactions = $this->transactions;
        
        $transactionSum = $transactions->reduce(function($sum, $item) {
            if ($item->type == 'deposit') {
                return $sum + $item->net_amount;
            } else if ($item->type == 'withdrawal') {
                return $sum - $item->net_amount;
            } // else $item->type == 'transfer'
            return $sum;
        }, 0);

        // Grand Total
        return $historyBalance + $transactionSum;
    }

    public function getCategoryBalances() {
        // TODO: returns an array/object? of category balances for a single account
    }

    public function getMostRecentHistory() {
        $histories = $this->histories;
        if ($histories->isEmpty()) {
            return null;
        }
        // TODO: get the most recent history, I'm not sure if it would be the first one...
        return $histories[0];
    }


    
}
