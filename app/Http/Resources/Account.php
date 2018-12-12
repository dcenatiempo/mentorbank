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
            'balance' => round($this->balance, 2),
            'creditInterestRate' => $this->credit_interest_rate,
            'distributionDay' => $this->distribution_day,
            'frequency' => $this->frequency,
            'goalBalance' => $this->goal_balance,
            'interestRate' => $this->interest_rate,
            'interestAccrued' => $this->getAccruedInterest(),
            'lastDistribution' => $this->last_distribution,
            'lowBalanceAlert' => $this->low_balance_alert,
            'monthlyTransactions' => $this->monthly_transactions,
            'nextDistribution' => $this->next_distribution,
            'notifications' => $this->notifications,
            'overdraftFee' => $this->overdraft_fee,
            'rateInterval' => $this->rate_interval,
            'totalTransactions' => $this->total_transactions,
            'view' => $this->view,

            // Related resources
            'accountHolder' => new AccountHolderResource($this->accountHolder),
            'subscribedCategories' => SubscribedCategoryResource::collection($this->subscribedCategories),
            'transactions' => TransactionResource::collection($this->transactions()->orderby('created_at', 'desc')->get()),
            'histories' => TransactionHistoryResource::collection($this->histories),
        ];
    }
}
