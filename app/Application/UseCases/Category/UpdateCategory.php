<?php

namespace App\Application\UseCases\Category;

use App\Application\DTOs\CategoryDTO;
use App\Domain\Entities\Category;
use App\Domain\Interfaces\CategoryRepositoryInterface;

class UpdateCategory
{
    public function __construct(private CategoryRepositoryInterface $categoryRepository) {}

    /**
     * Update Category.
     * 
     * @param int id
     * @param CategoryDTO category
     * @return ?Category
     */
    public function execute(int $id, CategoryDTO $categoryDTO): ?Category
    {
        $category = Category::create($categoryDTO->name);
        return $this->categoryRepository->update($id, $category);
    }
}