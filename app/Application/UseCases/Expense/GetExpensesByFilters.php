<?php

namespace App\Application\UseCases\Expense;

use App\Domain\Interfaces\ExpenseRepositoryInterface;

class GetExpensesByFilters
{
    public function __construct(private ExpenseRepositoryInterface $expenseRepository) {}

    /**
     * Retrieves expenses based on filters.
     *
     * @param int|null $userId
     * @param int|null $categoryId
     * @param string|null $search
     * @return array
     */
    public function execute(int $userId, ?int $categoryId = null, ?string $search = null): array
    {
        return $this->expenseRepository->getByFilters($userId, $categoryId, $search);
    }
}