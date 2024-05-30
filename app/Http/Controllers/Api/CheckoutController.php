<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\CreateCheckoutRequest;
use App\Services\Checkout\CheckoutService;

class CheckoutController extends Controller
{

    public function __construct(private CheckoutService $checkoutService)
    {
    }
    public function place_order(CreateCheckoutRequest $request)
    {
        $createdData = $this->checkoutService->place_order($request->validated());
        return $createdData;
    }

    public function my_orders()
    {
        $deletionResult = $this->checkoutService->my_orders();
        return $deletionResult;
    }
}
