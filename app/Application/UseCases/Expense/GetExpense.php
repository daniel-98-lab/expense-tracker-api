<?php

namespace App\Application\UseCases\Expense;

use App\Domain\Entities\Expense;
use App\Domain\Interfaces\ExpenseRepositoryInterface;

class GetExpense
{
    public function __construct(private ExpenseRepositoryInterface $expenseRepository) {}

    /**
     * Retrieves an expense by ID.
     *
     * @param int $id
     * @return Expense
     */
    public function execute(int $id): ?Expense
    {
        return $this->expenseRepository->getById($id);
    }
}