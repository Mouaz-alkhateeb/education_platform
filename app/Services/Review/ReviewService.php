<?php

namespace App\Services\Review;

use App\Interfaces\Review\ReviewServiceInterface;
use App\Repository\Rating\RatingRepository;
use App\Repository\Review\ReviewRepository;

class ReviewService implements ReviewServiceInterface
{
    public function __construct(private ReviewRepository $reviewRepository)
    {
    }
    public function review($data)
    {
        return $this->reviewRepository->review($data);
    }
    public function update_review($data)
    {
        return $this->reviewRepository->update_review($data);
    }
    public function delete_review($id)
    {
        return $this->reviewRepository->delete_review($id);
    }
}
