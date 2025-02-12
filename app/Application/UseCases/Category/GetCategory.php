<?php

namespace App\Application\UseCases\Category;

use App\Domain\Entities\Category;
use App\Domain\Interfaces\CategoryRepositoryInterface;

class GetCategory
{
    public function __construct(private CategoryRepositoryInterface $categoryRepository) {}

    /**
     * Retrieves a category by ID.
     * 
     * @param int id
     * @return Category
     */
    public function execute(int $id): ?Category
    {
        return $this->categoryRepository->getById($id);
    }
}