<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\AddReviewRequest;
use App\Http\Requests\Rating\UpdateReviewRequest;
use App\Models\Review;
use App\Services\Review\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(private ReviewService $reviewService)
    {
    }
    public function review(AddReviewRequest $request)
    {
        $createdData = $this->reviewService->review($request->validated());
        return $createdData;
    }
    public function update_review(UpdateReviewRequest $request)
    {
        $createdData = $this->reviewService->update_review($request->validated());
        return $createdData;
    }

    public function delete_review($id)
    {
        $deletionResult = $this->reviewService->delete_review($id);

        if ($deletionResult) {
            return $deletionResult;
        } else {
            return response()->json(['message' => 'Error Deleting Review,Please Try Again'], 500);
        }
    }
}
