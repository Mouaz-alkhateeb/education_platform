<?php

namespace App\Http\Resources\Sections;

use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'parent' => $this->parent,
            'image' => $this->image ? url($this->image) : null,
        ];
    }
}
