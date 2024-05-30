<?php

namespace App\Http\Resources\Courses;

use App\Http\Resources\Review\ReviewResource;
use App\Models\Review;
use App\Services\Rating\RatingService;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'section' => $this->section->name,
            'course_owner' => $this->owner->name,
            'price' => $this->price,
            'description' => $this->description,
            'image' => $this->image ? url($this->image) : null,
            'rating' => RatingService::sumCourseRatings($this->id),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
        ];
    }
}
