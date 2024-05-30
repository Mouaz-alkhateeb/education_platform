<?php

namespace App\Http\Controllers\Api;

use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Controllers\Controller;
use App\Http\Requests\Wishlist\AddToWishlistRequest;
use App\Http\Requests\Wishlist\DeleteFromWishlistRequest;
use App\Http\Resources\Wishlist\WishlistResource;
use App\Services\Wishlist\WishlistService;

class WishlistController extends Controller
{
    public function __construct(private WishlistService $wishlistService)
    {
    }

    public function show()
    {
        $deletionResult = $this->wishlistService->show();
        $returnData = WishlistResource::collection($deletionResult);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "Done")
        );
    }

    public function add_to_wishlist(AddToWishlistRequest $request)
    {
        try {
            $createdData = $this->wishlistService->add_to_wishlist($request->validated());

            if (isset($createdData->original) && $createdData->original['message'] == 'Course already exists in wishlist') {
                return ApiResponseHelper::sendResponse(
                    new Result(null, null, 'Course already exists in wishlist', false)
                );
            }

            $returnData = WishlistResource::make($createdData);
            return ApiResponseHelper::sendResponse(
                new Result($returnData, null, 'Course Added To Wishlist Successfully..!!')
            );
        } catch (\Throwable $th) {
            return ApiResponseHelper::sendResponse(
                new Result(null, null, 'Failed to add course to wishlist', false)
            );
        }
    }

    public function wishlist_count()
    {
        $result = $this->wishlistService->wishlist_count();
        return $result;
    }

    public function remove_wishlist_item($id)
    {
        $deletionResult = $this->wishlistService->remove_wishlist_item($id);

        if ($deletionResult) {
            return $deletionResult;
        } else {
            return response()->json(['message' => 'Error Deleting Course From Wishlist,Please Try Again'], 500);
        }
    }
}
