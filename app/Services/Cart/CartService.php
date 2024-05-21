<?php

namespace App\Services\Cart;

use App\Interfaces\Cart\CartServiceInterface;
use App\Repository\Cart\CartRepository;

class CartService implements CartServiceInterface
{
    public function __construct(private CartRepository $cartRepository)
    {
    }
    public function enroll_in_course($data)
    {
        return $this->cartRepository->enroll_in_course($data);
    }
    public function show()
    {
        return $this->cartRepository->show();
    }

    public function delete_cart_course(int $id)
    {
        return $this->cartRepository->delete_cart_course($id);
    }
}
