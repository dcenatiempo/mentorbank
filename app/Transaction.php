<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SubscribedCategory;

class Transaction extends Model
{
    protected $guarded = [ ];
    protected $casts = [
        'split' => 'array'
   ];

   protected $dates = ['date'];

    // Many to one
    public function account() { return $this->belongsTo('App\Account'); }

    public function updateBalances() {
        $split = $this->split;

        // update account balance
        $account = $this->account;

        if ($this->type == 'deposit') {
            $account->balance += $this->net_amount;
        } else if ($this->type == 'withdrawal') {
            $account->balance -= $this->net_amount;
        } // if transfer, do nothing
        $account->monthly_transactions++;
        $account->total_transactions++;
        $account->save();

        // update subscribed category balances
        foreach($split as $item) {
            $subedCat = SubscribedCategory::where('account_id', '=', $this->account_id)
                    ->where('category_id', '=', $item['category_id'])
                    ->first();
            $subedCat->balance += $item['amount'];
            $subedCat->monthly_transactions++;
            $subedCat->total_transactions++;
            $subedCat->save();
        }
    }
}
