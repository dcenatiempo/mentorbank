<?php

namespace App;
use DB;
use App\Transaction;

use Illuminate\Database\Eloquent\Model;

class SubscribedCategory extends Model
{
    protected $guarded = [ ];
    
    public static function getCategoryBalance($accountId) {

    }

    public static function withBalances($accountId) {
        $categories =  SubscribedCategory::where('account_id', '=', $accountId)->get();
        $transactions = Transaction::where('account_id', '=', $accountId)->get();

        
        if (!$transactions) {
            $categories = $categories->map(function ($cat) {
                $cat->balance = 0;
                return $cat;
            });

            return $categories;
        }

        $balances = [];

        // create an aray of balances [ category_id => balance ]
        foreach($transactions as $transaction) {
            $split = json_decode($transaction->split);
            foreach($split as $item) {
                if (isset($balances[$item->category_id])) {
                    $balances[$item->category_id] += $item->amount;
                } else {
                    $balances[$item->category_id] = $item->amount;
                }
            }
            // if ($transaction->type == 'transfer') {
            //     $from = $split[0]->category_id;
            //     $to = $split[1]->category_id;
            //     if (isset($balances[$from])) {
            //         $balances[$from] -= $split[0]->amount;
            //     } else {
            //         $balances[$from] = 0 - $split[0]->amount;
            //     }
            //     if (isset($balances[$to])) {
            //         $balances[$to] += $split[1]->amount;
            //     } else {
            //         $balances[$to] = $split[1]->amount;
            //     }
            // }
            // if ($transaction->type == 'deposit') {
            //     foreach($split as $item) {
            //         if (isset($balances[$item->category_id])) {
            //             $balances[$item->category_id] += $item->amount;
            //         } else {
            //             $balances[$item->category_id] = $item->amount;
            //         }
            //     }
            // }
            // if ($transaction->type == 'withdrawal') {
            //     foreach($split as $item) {
            //         if (isset($balances[$item->category_id])) {
            //             $balances[$item->category_id] -= $item->amount;
            //         } else {
            //             $balances[$item->category_id] = -$item->amount;
            //         }
            //     }
            // } 
        }

        foreach ($categories as $cat) {
            $exists = isset($balances[$cat->category_id]);
            $cat->balance = $exists ? $balances[$cat->category_id] : 0;
        }

        return $categories;
    }
}
