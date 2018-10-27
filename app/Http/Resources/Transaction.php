<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Transaction extends JsonResource
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

            // timestamps
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            // data (alphabetical)  
            'date' => $this->date,
            'memo' => $this->memo,
            'netAmount' => $this->net_amount,
            'split' => $this->split,
            'type' => $this->type
        ];
    }
}
