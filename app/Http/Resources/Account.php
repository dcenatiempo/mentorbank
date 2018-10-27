<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AccountHolder as AccountHolderResource;
use App\Http\Resources\SubscribedCategory as SubscribedCategoryResource;
use App\Http\Resources\Transaction as TransactionResource;
use App\Http\Resources\TransactionHistory as TransactionHistoryResource;
use App\SubscribedCategory;

class Account extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $subedCats = SubscribedCategory::withBalances($this->id);

        // return parent::toArray($request);
        return [
            // keys
            'id' => $this->id,
            'accountHolderId' => $this->account_holder_id,
            'bankId' => $this->bank_id,

            // timestamps
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'deletedAt' => $this->deleted_at,

            // data (alphabetical)            
            'allowNegativeBalance' => $this->allow_negative_balance,
            'balance' => $this->getBalance(),
            'creditInterestRate' => $this->credit_interest_rate,
            'distributionDay' => $this->distribution_day,
            'frequency' => $this->frequency,
            'goalBalance' => $this->goal_balance,
            'interestRate' => $this->interest_rate,
            'lowBalanceAlert' => $this->low_balance_alert,
            'notifications' => $this->notifications,
            'overdraftFee' => $this->overdraft_fee,
            'rateDisplayInterval' => $this->rate_display_interval,
            'view' => $this->view,

            // Related resources
            'accountHolder' => new AccountHolderResource($this->accountHolder),
            'subscribedCategories' => SubscribedCategoryResource::collection($subedCats),
            'transactions' => TransactionResource::collection($this->transactions),
            'histories' => TransactionHistoryResource::collection($this->histories),
        ];
    }
}
