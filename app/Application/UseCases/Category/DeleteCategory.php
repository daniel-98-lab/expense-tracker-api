<?php

namespace App\Application\UseCases\Category;

use App\Domain\Interfaces\CategoryRepositoryInterface;

class DeleteCategory
{
    public function __construct(private CategoryRepositoryInterface $categoryRepository) {}

    /**
     * Deletes a category by ID.
     * 
     * @param int id
     * @return bool
     */
    public function execute(int $id): bool
    {
        return $this->categoryRepository->delete($id);
    }
}