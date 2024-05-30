<?php

namespace App\Services\Rating;

use App\Interfaces\Rating\RatingServiceInterface;
use App\Models\Course;
use App\Models\Rating;
use App\Repository\Rating\RatingRepository;
use App\Statuses\CourseStatus;

class RatingService implements RatingServiceInterface
{
    public function __construct(private RatingRepository $ratingRepository)
    {
    }
    public function rating($data)
    {
        return $this->ratingRepository->rating($data);
    }
    public static function  sumCourseRatings($course_id)
    {
        // Validate if the course exists and is active
        $course = Course::where('id', $course_id)->where('status', CourseStatus::ACTIVE)->first();

        if (!$course) {
            return response()->json(['message' => 'The course does not exist or is not active.'], 404);
        }

        // Sum the ratings for the given course
        $averageRating = Rating::where('course_id', $course_id)->avg('stars_rated');

        $roundedAverageRating = round($averageRating * 2) / 2;

        return $roundedAverageRating;
    }
}
