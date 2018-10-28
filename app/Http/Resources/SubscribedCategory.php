<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscribedCategory extends JsonResource
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
            'accountId' => $this->account_id,
            'categoryId' => $this->category_id,

            // timestamps
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            // data (alphabetical)
            'goalBalance' => $this->goal_balance,
            'lowBalanceAlert' => $this->low_balance_alert,
            'notifications' => $this->notifications,
            'balance' => $this->balance ? round($this->balance, 2) : 0
        ];
    }
}
