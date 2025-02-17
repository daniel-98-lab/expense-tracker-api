<?php

namespace App\Application\UseCases\User;

use App\Domain\Entities\User;
use App\Domain\Interfaces\UserRepositoryInterface;

class LogoutUser
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    /**
     * Logout User
     */
    public function execute(): null 
    {
        return $this->userRepository->logout();
    }
}