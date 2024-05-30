<?php

namespace App\Services\Checkout;

use App\Interfaces\Checkout\CheckoutServiceInterface;
use App\Repository\Checkout\CheckoutRepository;

class CheckoutService implements CheckoutServiceInterface
{
    public function __construct(private CheckoutRepository $checkoutRepository)
    {
    }
    public function place_order($data)
    {
        return $this->checkoutRepository->place_order($data);
    }



    public function my_orders()
    {
        return $this->checkoutRepository->my_orders();
    }
}
