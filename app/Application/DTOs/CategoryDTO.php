<?php

namespace App\Application\DTOs;

use App\Domain\Entities\Category;

class CategoryDTO
{
    public function __construct(
        public ?int $id,
        public string $name
    ) {}
    
    /**
     * Creates a CategoryDTO from a request array
     */
    public static function fromRequest(array $data): self
    {
        return new self(
            null,
            $data['name']
        );
    }


    /**
     * Creates a response array from a Category entity.
     */
    public static function toResponse(Category $category): array
    {
        return [
            "id"    => $category->id,
            "name"  => $category->name
        ];
    }
}

