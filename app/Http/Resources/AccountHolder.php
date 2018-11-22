<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountHolder extends JsonResource
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
            'userId' => $this->user_id,
            'bankId' => $this->bank_id,

            // timestamps
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'deletedAt' => $this->deleted_at,

            // data (alphabetical)            
            'pin' => $this->pin,
            'name' => $this->name,
            'birthdate' => $this->birthdate,
            'sex' => $this->sex,
        ];
    }
}
