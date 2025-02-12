<?php

namespace App\Application\UseCases\Category;

use App\Domain\Interfaces\CategoryRepositoryInterface;

class GetAllCategory
{
    public function __construct(private CategoryRepositoryInterface $categoryRepository) {}

    /**
     * Retrieves all categories
     * 
     * @return Category[]
     */
    public function execute(): array 
    {
        return $this->categoryRepository->getAll();
    }
}