<?php

namespace App\Domain\Entities;

use App\Domain\Utils\Validator;

class User
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $email,
        public string $password
    ) {
        Validator::notEmpty($name, "Name");
        Validator::notEmpty($email, "Email");
        Validator::notEmpty($password, "Password");
        Validator::isEmail($email);
        Validator::minEightLength($password, "Password");
    }

    /**
     * Create a new User Entity
     */
    public static function create(string $name, string $email, string $password): self
    {
        return new self(null, $name, $email, $password);
    }
}