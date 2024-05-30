<?php

namespace App\Repository\Rating;

use App\Models\Course;
use App\Models\Order;
use App\Models\Rating;
use App\Repository\BaseRepositoryImplementation;
use App\Statuses\CourseStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RatingRepository extends BaseRepositoryImplementation
{
    public function getFilterItems($filter)
    {
    }

    public function model()
    {
        return Rating::class;
    }

    public function rating($data)
    {
        DB::beginTransaction();
        try {
            $stars_rated = $data['course_rating'];
            $course_id = $data['course_id'];

            // Check if the course is active
            $course_check = Course::where('id', $course_id)->where('status', CourseStatus::ACTIVE)->first();

            if (!$course_check) {
                return response()->json(['message' => 'The link you followed was broken.'], 404);
            }

            // Check if the user has purchased the course
            $verified_purchase = Order::where('user_id', Auth::id())
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->where('order_items.course_id', $course_id)
                ->exists();

            if (!$verified_purchase) {
                return response()->json(['message' => 'You cannot rate this course without purchasing it.'], 403);
            }

            // Check if the user has already rated the course
            $exists_rating = Rating::where('user_id', Auth::id())->where('course_id', $course_id)->first();

            if ($exists_rating) {
                // Update existing rating
                $exists_rating->stars_rated = $stars_rated;
                $exists_rating->save();
            } else {
                // Create new rating
                Rating::create([
                    'user_id' => Auth::id(),
                    'course_id' => $course_id,
                    'stars_rated' => $stars_rated
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Course rating successfully submitted.'], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => 'An error occurred while submitting the rating.'], 500);
        }
    }
}
