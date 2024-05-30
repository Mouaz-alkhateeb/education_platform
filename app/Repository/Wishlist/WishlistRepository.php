<?php

namespace App\Repository\Wishlist;

use App\Models\Wishlist;
use App\Repository\BaseRepositoryImplementation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WishlistRepository extends BaseRepositoryImplementation
{
    public function getFilterItems($filter)
    {
    }

    public function model()
    {
        return Wishlist::class;
    }

    public function show()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())->get();
        return $wishlists;
    }
    public  function add_to_wishlist($data)
    {
        DB::beginTransaction();
        try {

            $existingWish = Wishlist::where('user_id', Auth::id())
                ->where('course_id', $data['course_id'])
                ->first();

            if ($existingWish) {
                return response()->json(['message' => 'Course already exists in wishlist'], 400);
            }
            $wish = new Wishlist();
            $wish->course_id = $data['course_id'];
            $wish->user_id = Auth::id();
            $wish->save();

            DB::commit();
            return $wish;
        } catch (\Throwable $th) {
            DB::rollback();
        }
    }

    public function wishlist_count()
    {
        $count = Wishlist::where('user_id', Auth::id())->count();
        return response()->json(["count" => $count]);
    }

    public function remove_wishlist_item($id)
    {
        $wish = Wishlist::where('id', $id)->where('user_id', Auth::id())->first();
        if ($wish) {
            $wish->delete();
            return response()->json(['message' => 'Course Deleted From Wishlist Successfully'], 200);
        } else {
            return response()->json(['message' => 'Course Not Found In Wishlist'], 404);
        }
    }
}
