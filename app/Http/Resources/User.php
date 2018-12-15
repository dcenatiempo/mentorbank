<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $banker = $this->banker;
        return [
            // keys
            'id' => $this->id,

            // timestamps
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            // data (alphabetical)
            'email' => $this->email,
            'emailVerifiedAt' => $this->email_verified_at,
            'name' => $this->name,
            'type' => $this->type,
            'pin' => $banker ? $banker->pin : null,
            // 'rememberToken' => $this->remember_token
        ];
    }
}
