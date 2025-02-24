<?php

namespace App\Application\UseCases\Expense;

use App\Domain\Entities\Expense;
use App\Domain\Interfaces\ExpenseRepositoryInterface;
use App\Application\DTOs\ExpenseDTO;

class CreateExpense
{
    public function __construct(private ExpenseRepositoryInterface $expenseRepository) {}

    /**
     * Creates a new expense.
     *
     * @param ExpenseDTO $expenseDTO
     * @return Expense
     */
    public function execute(ExpenseDTO $expenseDTO): Expense
    {
        $expense = Expense::create(
            $expenseDTO->userId,
            $expenseDTO->categoryId,
            $expenseDTO->title,
            $expenseDTO->description,
            $expenseDTO->amount,
            $expenseDTO->date
        );
        return $this->expenseRepository->create($expense);
    }
}
