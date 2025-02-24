<?php

namespace App\Application\UseCases\Expense;

use App\Domain\Interfaces\ExpenseRepositoryInterface;

class DeleteExpense
{
    public function __construct(private ExpenseRepositoryInterface $expenseRepository) {}

    /**
     * Deletes an expense by ID.
     *
     * @param int $id
     * @param int $userId
     * @return bool
     */
public function execute(int $id, int $userId): bool
    {
        return $this->expenseRepository->delete($id, $userId);
    }
}