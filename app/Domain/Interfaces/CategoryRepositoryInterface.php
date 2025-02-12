<?php

namespace App\Domain\Interfaces;

use App\Domain\Entities\Category;

interface CategoryRepositoryInterface
{
    public function delete(int $id): bool;
    public function getAll(): array;
    public function getById(int $id): ?Category;
    public function create(Category $category): Category;
    public function update(int $id, Category $category): ?Category;
}