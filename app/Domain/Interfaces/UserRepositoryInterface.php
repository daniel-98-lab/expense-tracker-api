<?php

namespace App\Domain\Interfaces;

use App\Domain\Entities\User;

interface UserRepositoryInterface
{
    public function getById(int $id): ?User;
    public function login(string $email, string $password): ?string;
    public function logout(): null;
    public function refreshToken(): ?string;
}