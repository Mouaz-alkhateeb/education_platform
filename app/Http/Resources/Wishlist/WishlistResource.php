<?php

namespace App\Http\Resources\Wishlist;

use Illuminate\Http\Resources\Json\JsonResource;

class WishlistResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'course_id' => $this->course_id,
        ];
    }
}
