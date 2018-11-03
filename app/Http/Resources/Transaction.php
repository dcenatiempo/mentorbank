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
            'netAmount' => round($this->net_amount, 2),
            'split' => $this->formatSplit($this->split),
            'type' => $this->type
        ];
    }

    private function formatSplit($split) {
        return collect($split)->map(function ($item) {
            return [
                'amount' => $item['amount'],
                'categoryId' => $item['category_id']
            ];
        });
    }
}
