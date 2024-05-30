<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\AddRatingRequest;
use App\Services\Rating\RatingService;

class RatingController extends Controller
{
    public function __construct(private RatingService $ratingService)
    {
    }
    public function rating(AddRatingRequest $request)
    {
        $createdData = $this->ratingService->rating($request->validated());
        return $createdData;
    }
}
