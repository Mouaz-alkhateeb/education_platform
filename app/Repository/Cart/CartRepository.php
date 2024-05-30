<?php

namespace App\Repository\Cart;

use App\Models\Cart;
use App\Models\Course;
use App\Repository\BaseRepositoryImplementation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartRepository extends BaseRepositoryImplementation
{
    public function getFilterItems($filter)
    {
        $records = Cart::query();
        return $records->get();
    }

    public function model()
    {
        return Cart::class;
    }

    public function enroll_in_course($data)
    {
        DB::beginTransaction();
        try {
            $course_check = Course::where('id', $data['course_id'])->first();
            if ($course_check) {
                $cartItem = Cart::where('course_id', $data['course_id'])->where('user_id', Auth::id())->first();
                if ($cartItem) {
                    DB::commit();
                    return $cartItem->load(['user']);
                } else {
                    $itemCart = new Cart();
                    $itemCart->course_id = $data['course_id'];
                    $itemCart->user_id = Auth::id();
                    $itemCart->save();

                    DB::commit();
                    return $itemCart->load(['user']);
                }
            } else {
                return response()->json(['error' => 'Course not found'], 404);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error('Failed to enroll in course: ' . $th->getMessage());
            return response()->json(['error' => 'Failed to enroll in course'], 500);
        }
    }

    public function show()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();
        return $cartItems->load('user');
    }

    public function delete_cart_course(int $id)
    {

        if (Auth::check()) {
            if (Cart::where('course_id', $id)->where('user_id', Auth::id())->exists()) {
                $cart_course = Cart::where('course_id', $id)->where('user_id', Auth::id())->first();

                $cart_course->delete();
                return response()->json(["status" => "Course Deleted From Cart Successfully..!!"]);
            } else {
                return response()->json(["status" => "Course not found in cart..!!"]);
            }
        } else {
            return response()->json(["status" => "Login To Continue..!!"]);
        }
    }

    public function cart_count()
    {
        $count = Cart::where('user_id', Auth::id())->count();
        return response()->json(["count" => $count]);
    }
}
