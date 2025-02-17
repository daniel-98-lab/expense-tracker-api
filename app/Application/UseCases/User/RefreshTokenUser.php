<?php

namespace App\Application\UseCases\User;

use App\Domain\Interfaces\UserRepositoryInterface;

class RefreshTokenUser
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    /**
     * Refresh user token
     */
    public function execute(): ?string
    {
        return $this->userRepository->refreshToken();
    }
}