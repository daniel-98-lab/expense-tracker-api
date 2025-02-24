<?php

namespace App\Application\UseCases\Expense;

use App\Domain\Entities\Expense;
use App\Domain\Interfaces\ExpenseRepositoryInterface;
use App\Application\DTOs\ExpenseDTO;

class UpdateExpense
{
    public function __construct(private ExpenseRepositoryInterface $expenseRepository) {}

    /**
     * Update a expense.
     *
     * @param int id
     * @param ExpenseDTO expenseDTO
     * @return ?Expense
     */
    public function execute(int $id, ExpenseDTO $expenseDTO): Expense
    {
        $expense = Expense::create(
            $expenseDTO->userId,
            $expenseDTO->categoryId,
            $expenseDTO->title,
            $expenseDTO->description,
            $expenseDTO->amount,
            $expenseDTO->date
        );
        return $this->expenseRepository->update($id, $expense);
    }
}
