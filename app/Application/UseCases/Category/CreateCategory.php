<?php

namespace App\Application\UseCases\Category;

use App\Application\DTOs\CategoryDTO;
use App\Domain\Entities\Category;
use App\Domain\Interfaces\CategoryRepositoryInterface;

class CreateCategory
{
    public function __construct(private CategoryRepositoryInterface $categoryRepository) {}


    /**
     * Creates a new Category
     * 
     * @param CategoryDTO category
     * @return Category
     */
    public function execute(CategoryDTO $categoryDTO): Category
    {
       $category = Category::create($categoryDTO->name);
       return $this->categoryRepository->create($category);
    }
}