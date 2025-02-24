<?php

namespace App\Domain\Entities;

use App\Domain\Utils\Validator;

class Category
{
    public function __construct(
        public ?int $id,
        public string $name
    ) {
      Validator::notEmpty($name, "Name");
    }

    /**
     * Create a new Category Entity
     */
    public static function create(string $name): self
    {
        return new self(null, $name);
    }
}