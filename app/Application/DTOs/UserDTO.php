<?php

namespace App\Application\DTOs;

use App\Domain\Entities\User;

class UserDTO
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $email
    ) {}

    /**
     * Creates a UserDTO from a request array
     */
    public static function fromRequest(array $data): self
    {
        return new self(
            null,
            $data['name'],
            $data['email']
        );
    }

    /**
     * Creates an array from a User entity
     */
    public static function toResponse(User $user): array
    {
        return [
            "id"    => $user->id,
            "name"  => $user->name,
            "email" => $user->email
        ];
    }
}