<?php

namespace App\Interfaces\Checkout;


interface CheckoutServiceInterface
{
    public function place_order($data);
}
