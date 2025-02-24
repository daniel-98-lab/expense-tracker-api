<?php

namespace App\Domain\Interfaces;

use App\Domain\Entities\Expense;

interface ExpenseRepositoryInterface
{
    public function delete(int $id, int $userId): bool;
    public function getByFilters(int $userId, ?int $categoryId = null, ?string $search = null): array;
    public function getById(int $id): ?Expense;
    public function create(Expense $expense): Expense;
    public function update(int $id, Expense $expense): ?Expense;
}