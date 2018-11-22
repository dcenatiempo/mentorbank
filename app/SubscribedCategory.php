<?php

namespace App;
use DB;
use App\Transaction;

use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\SubscribedCategory as SubscribedCategoryResource;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class SubscribedCategory extends Model
{
    protected $guarded = [ ];

    // Many to one
    public function account() { return $this->belongsTo('App\Account'); }
    public function category() { return $this->belongsTo('App\Category'); }

    public static function boot() {
        parent::boot();

        static::creating(function($subedCat)
        {
            // Log::debug('In subedCat create boot');
        });

        static::updating(function($subedCat)
        {
            // Log::debug('In subedCat update boot');
        });

        static::deleting(function($subedCat)
        {
            // Log::debug('In subedCat delete boot');

            // If a subscribed category that is being deleted has a balance,
            // then transfer that balance to 'Uncategorized' before deleting
            if (0 == $subedCat->balance) {
                return;
            }

            $transferCat = SubscribedCategory::where('category_id', 2)->where('account_id', $subedCat->account_id)->first();
            $transferCat->balance += $subedCat->balance;


            $split = [
                [
                    'amount' => -$subedCat->balance,
                    'category_id' => $subedCat->id
                ], [
                    'amount' => $subedCat->balance,
                    'category_id' => $transferCat->category_id
                ]
            ];
            
            $transaction = Transaction::create([
                'memo' => 'Transfer balance before category deletion',
                'type' => 'transfer',
                'net_amount' => $subedCat->balance,
                'split' => $split,
                'account_id' => $subedCat->account_id,
                'date' => Carbon::now()
            ]);

        });
    }
    
    public static function bankCatsWithBalances($bankId) {
        $accountIds = Bank::find($bankId)->accounts->pluck('id');
        $categories = [];
        foreach($accountIds as $id) {
            $categories[$id] = SubscribedCategoryResource::collection(Account::find($id)->subscribedCategories);
        }
        
        return $categories;
    }

    public function scopeInterestOnly($query) {
        return $query->where('category_id', '=', 1);
    }
}
