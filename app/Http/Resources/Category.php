<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
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
            // 'bankId' => $this->bank_id,

            // timestamps
            // 'createdAt' => $this->created_at,
            // 'updatedAt' => $this->updated_at,
            // 'deletedAt' => $this->deleted_at,

            // data (alphabetical)
            'archived' => $this->archived,
            'forceSubscribe' => $this->force_subscribe,
            'hidden' => $this->hidden,
            'notifications' => $this->notifications,
            'name' => $this->name,
            'isGlobal' => $this->is_global,
            'subscribedCount' => $this->subscribed_count
        ];

    }
}
