<?php

namespace App\Services\Users;

use App\Interfaces\Users\UserServiceInterface;
use App\Repository\Users\UserRepository;

class UserService implements UserServiceInterface
{
    public function __construct(private UserRepository $userRepository)
    {
    }
    public function create_user($data)
    {
        return $this->userRepository->create_user($data);
    }
}