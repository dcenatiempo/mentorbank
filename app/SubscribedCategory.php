<?php

namespace App;
use DB;
use App\Transaction;

use Illuminate\Database\Eloquent\Model;

class SubscribedCategory extends Model
{
    protected $guarded = [ ];
    
    public static function getAllCategoryBalances($accountId) {
        // $subscribedCategories = SubscribedCategory::where('account_id', '=', $accountId)->pluck('category_id');
        $cats = [];
        $transactions = Transaction::where('account_id', '=', $accountId)->get();
        foreach($transactions as $transaction) {
            $split = json_decode($transaction->split);
            if ($transaction->type == 'transfer') {
                $from = $split[0]->category_id;
                $to = $split[1]->category_id;
                if (isset($cats[$from])) {
                    $cats[$from] -= $split[0]->amount;
                } else {
                    $cats[$from] = 0 - $split[0]->amount;
                }
                if (isset($cats[$to])) {
                    $cats[$to] += $split[1]->amount;
                } else {
                    $cats[$to] = $split[1]->amount;
                }
            }
            if ($transaction->type == 'deposit') {
                foreach($split as $item) {
                    if (isset($cats[$item->category_id])) {
                        $cats[$item->category_id] += $item->amount;
                    } else {
                        $cats[$item->category_id] = $split[0]->amount;
                    }
                }
            }
            if ($transaction->type == 'withdrawal') {
                foreach($split as $item) {
                    if (isset($cats[$item->category_id])) {
                        $cats[$item->category_id] -= $item->amount;
                    } else {
                        $cats[$item->category_id] = -$split[0]->amount;
                    }
                }
            } 
        }
        return $cats;
    }
}
