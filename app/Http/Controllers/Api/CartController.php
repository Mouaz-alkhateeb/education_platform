<?php

namespace App\Http\Controllers\Api;

use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\CreateCartRequest;
use App\Http\Resources\Cart\CartResource;
use App\Services\Cart\CartService;

class CartController extends Controller
{
    public function __construct(private CartService $courseService)
    {
    }
    public function enroll_in_course(CreateCartRequest $request)
    {

        $createdData = $this->courseService->enroll_in_course($request->validated());

        $returnData = CartResource::make($createdData);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "Done")
        );
    }
    public function show()
    {
        $reservationData = $this->courseService->show();
        $returnData = CartResource::collection($reservationData);
        return ApiResponseHelper::sendResponse(
            new Result($returnData,  "DONE")
        );
    }

    public function delete_cart_course($id)
    {
        $deletionResult = $this->courseService->delete_cart_course($id);

        if ($deletionResult) {
            return $deletionResult;
        } else {
            return response()->json(['message' => 'Error Deleting Course From Cart,Please Try Again'], 500);
        }
    }


    public function cart_count()
    {
        $deletionResult = $this->courseService->cart_count();
        return $deletionResult;
    }
}
