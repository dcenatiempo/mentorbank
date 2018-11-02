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
    public function transactions()         { return $this->hasMany('App\Transaction'); }
    public function interestTransactions() { return $this->hasMany('App\InterestTransaction'); }
    public function histories()            { return $this->hasMany('App\TransactionHistory'); }
    public function recurringTemplates()   { return $this->hasMany('App\RecurringTemplate'); }
    public function notifications()        { return $this->hasMany('App\Notification'); }
    public function subscribedCategories() { return $this->hasMany('App\SubscribedCategory'); } //->where('category_id', '!=', 1); }

    public function calculateBalance() {
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

    public function getMostRecentHistory() {
        $histories = $this->histories;
        if ($histories->isEmpty()) {
            return null;
        }
        // TODO: get the most recent history, I'm not sure if it would be the first one...
        return $histories[0];
    }

    public function scopeCanAccrueInterest($query) {
        return $query->where('balance', '>', 0)
                     ->where('interest_rate', '>', 0);
    }

    public function calculateDailyRate() {
        $rateMap = [
            'year' => 365,
            'month' => 12,
            'week' => 7,
            'day' => 1
        ];

        return $this->interest_rate / $rateMap[$this->rate_interval] / 100;
    }

    public function getDailyAccruedInterest() {
        return round($this->calculateDailyRate() * $this->balance, 2);
    }
    
}
