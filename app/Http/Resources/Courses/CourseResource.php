<?php

namespace App\Http\Resources\Courses;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'section' => $this->section->name,
            'course_owner' => $this->owner->name,
            'price' => $this->price,
        ];
    }
}