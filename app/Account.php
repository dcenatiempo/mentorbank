<?php

namespace App;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class Account extends Model
{
    protected $fillable = [
        'allow_negative_balance',
        'balance',
        'credit_interest_rate',
        'distribution_day',
        'frequency',
        'goal_balance',
        'interest_rate',
        'last_distribution',
        'low_balance_alert',
        'monthly_transactions',
        'next_distribution',
        'notifications',
        'overdraft_fee',
        'rate_interval',
        'total_transactions',
        'view'
    ];

    protected $casts = [
        'credit_interest_rate' => 'float',
        'interest_rate' => 'float',
        'distribution_day' => 'int'
    ];

    protected $dates = ['next_distribution', 'last_distribution'];

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

    public function calculateNextDistribution($today) {
        $isWeek = 'W' == $this->frequency[2];

        if ($isWeek) {
            $interval = CarbonInterval::create($this->frequency);
            $dif = $this->distribution_day - ($this->last_distribution->dayOfWeek);
            
            $nextDistribution = $this->last_distribution->addDays($dif)->add($interval);

            while($nextDistribution <= $today) {
                $nextDistribution->add($interval);
            }

        } else { // isMonth
            $interval = $this->frequency[1];
            
            $nextDistribution = $this->last_distribution->addMonthsNoOverflow($interval);
            
            while($nextDistribution <= $today) {
                $nextDistribution->addMonthsNoOverflow(1);
            }

            $nextDistribution->day = $nextDistribution->daysInMonth < $this->distribution_day
                ? $nextDistribution->daysInMonth
                : $this->distribution_day;
        }
        
        return $nextDistribution;
    }

    public function getAccruedInterest() {
        $interest = $this->subscribedCategories()->where('category_id', 1)->first()->balance;
        
        return round($interest, 2);;
    }
}