<?php

namespace App\Repository\Review;

use App\Models\Course;
use App\Models\Order;
use App\Models\Rating;
use App\Models\Review;
use App\Repository\BaseRepositoryImplementation;
use App\Statuses\CourseStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewRepository extends BaseRepositoryImplementation
{
    public function getFilterItems($filter)
    {
    }

    public function model()
    {
        return Review::class;
    }

    public function review($data)
    {
        DB::beginTransaction();
        try {
            $user_review = $data['user_review'];
            $course_id = $data['course_id'];
            $course_check = Course::where('id', $course_id)->where('status', CourseStatus::ACTIVE)->first();
            if ($course_check) {
                Review::create([
                    "user_id" => Auth::id(),
                    "course_id" => $course_id,
                    "user_review" => $user_review
                ]);
                DB::commit();

                return response()->json(['message' => 'Thank You For Writing a Review.'], 200);
            } else {
                DB::rollback();
                return response()->json(['message' => 'The link you followed was broken..!'], 500);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => 'An error occurred while submitting the review.'], 500);
        }
    }

    public function update_review($data)
    {
        $user_review = $data['user_review'];
        $review_id = $data['review_id'];
        if ($user_review != '') {
            $review = Review::where('id', $review_id)->where('user_id', Auth::id())->first();
            if ($review) {
                $review->user_review = $user_review;
                $review->update();
                return response()->json(['message' => 'Review Updateed Successfully..!'], 200);
            } else {
                return response()->json(['message' => 'The link You Followed Was broken..!'], 500);
            }
        } else {
            return response()->json(['message' => 'You Cannot Submit With Empty Review..!'], 400);
        }
    }

    public function delete_review($id)
    {
        $review = Review::where('id', $id)->first();

        if ($review) {
            $review->delete();
            return response()->json(['message' => 'Review Delete Successfully'], 200);
        } else {
            return response()->json(['message' => 'Review Not Found'], 404);
        }
    }
}
