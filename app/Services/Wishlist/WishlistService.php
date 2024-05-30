<?php

namespace App\Services\Wishlist;

use App\Interfaces\Wishlist\WishlistServiceInterface;
use App\Repository\Wishlist\WishlistRepository;

class WishlistService implements WishlistServiceInterface
{
    public function __construct(private WishlistRepository $wishlistRepository)
    {
    }

    public function show()
    {
        return $this->wishlistRepository->show();
    }

    public function add_to_wishlist($data)
    {
        return $this->wishlistRepository->add_to_wishlist($data);
    }
    public function wishlist_count()
    {
        return $this->wishlistRepository->wishlist_count();
    }

    public function remove_wishlist_item($id)
    {
        return $this->wishlistRepository->remove_wishlist_item($id);
    }
}
