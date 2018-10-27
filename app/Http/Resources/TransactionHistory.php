<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionHistory extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            // keys
            'id' => $this->id,
            'accountHolderId' => $this->account_id,

            // timestamps
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            // data (alphabetical)
            'month' => $this->month,
            'endingBalance' => $this->ending_balance,
            'interestEarned' => $this->interest_earned,
            'transactions' => $this->transactions
        ];
    }
}
