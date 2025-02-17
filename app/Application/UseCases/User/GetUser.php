<?php

namespace App\Application\UseCases\User;

use App\Domain\Entities\User;
use App\Domain\Interfaces\UserRepositoryInterface;

class GetUser
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    /**
     * Retrieves a user by ID
     * 
     * @param int id
     * @return User
     */
    public function execute(int $id): ?User 
    {
        return $this->userRepository->getById($id);
    }
}