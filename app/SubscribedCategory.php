<?php

namespace App;
use DB;
use App\Transaction;

use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\SubscribedCategory as SubscribedCategoryResource;

class SubscribedCategory extends Model
{
    protected $guarded = [ ];
    
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
