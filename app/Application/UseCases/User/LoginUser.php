<?php

namespace App\Application\UseCases\User;

use App\Domain\Interfaces\UserRepositoryInterface;

class LoginUser
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    /**
     * Authenticates a user with email and password.
     *
     * @param string $email
     * @param string $password
     * @return string
     */
    public function execute(string $email, string $password): ?string
    {
        return $this->userRepository->login($email, $password);
    }
}