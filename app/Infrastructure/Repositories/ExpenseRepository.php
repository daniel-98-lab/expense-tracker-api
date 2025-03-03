<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Expense as DomainExpense;
use App\Domain\Interfaces\ExpenseRepositoryInterface;
use App\Infrastructure\Models\Expense as EloquentExpense;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tymon\JWTAuth\Facades\JWTAuth;

class ExpenseRepository implements ExpenseRepositoryInterface
{
    /** 
     * Delete an expense if it belongs to the authenticated user.
     *
     * @param int $id The expense ID.
     * @param int $id The user ID.
     * @return bool True if the expense was deleted, false otherwise.
     * @throws \Exception If the expense does not exist or does not belong to the user.
     */
    public function delete(int $id, int $userId): bool {
    
        $expense = EloquentExpense::where('id', $id)->where('user_id', $userId)->first();
    
        if (!$expense)
            throw new ModelNotFoundException("Expense with ID {$id} not found or does not belong to the user.");
    
        return $expense->delete();
    }

    /**
     * Retrieves all expenses from the database.
     *
     * @param int $userId The user ID to filter by (optional).
     * @param int|null $categoryId The expense ID to filter by (optional).
     * @param string|null $search The search term for expense name (optional).
     * @return DomainExpenses[] An array of DomainExpenses entities.
     */
    public function getByFilters(int $userId, ?int $categoryId = null, ?string $search = null): array {

        $query = EloquentExpense::where('user_id', $userId);

        if ($categoryId !== null)
            $query->where('category_id', $categoryId);

        if ($search !== null)
            $query->where('title', 'like', '%' . $search . '%');

        $expenses = $query->orderBy('title')->get(); // Get collection of results

        $expenses = $expenses->map(function ($expenseData) {
            return new DomainExpense(
                $expenseData['id'],
                $expenseData['user_id'],
                $expenseData['category_id'],
                $expenseData['title'],
                $expenseData['description'],
                $expenseData['amount'],
                $expenseData['date']
            );
        });
        
        return $expenses->toArray();
    }

    /**
     * Retrieves a expense by its ID.
     *
     * @param int $id The ID of the expense to retrieve.
     * @return DomainExpense|null Returns the expense if found, or null if not found.
     */
    public function getById(int $id) : ?DomainExpense {
        $user = JWTAuth::parseToken()->authenticate();

        if (!$user)
            throw new \Exception("Unauthorized: No valid user found.");

        $expense = EloquentExpense::where('user_id', $user->id)
            ->where('id', $id)
            ->first();

        return $expense ? new DomainExpense(
            $expense->id,
            $expense->user_id,
            $expense->category_id,
            $expense->title,
            $expense->description,
            $expense->amount,
            $expense->date
        ) : null;
    }

    /**
     * Creates a new expense in the database.
     *
     * @param DomainExpense $expense The expense entity to create.
     * @return DomainExpense The created expense entity.
     */
    public function create(DomainExpense $expense): DomainExpense
    {
        $eloquentExpense = new EloquentExpense();
        $eloquentExpense->user_id = $expense->userId;
        $eloquentExpense->category_id = $expense->categoryId;
        $eloquentExpense->title = $expense->title;
        $eloquentExpense->description = $expense->description;
        $eloquentExpense->amount = $expense->amount;
        $eloquentExpense->date = $expense->date;
        $eloquentExpense->save();

        return new DomainExpense(
            $eloquentExpense->id,
            $eloquentExpense->user_id,
            $eloquentExpense->category_id,
            $eloquentExpense->title,
            $eloquentExpense->description,
            $eloquentExpense->amount,
            $eloquentExpense->date
        );
    }

    /**
     * Updates an existing expense in the database.
     *
     * @param int $id The ID of the expense to update.
     * @param DomainExpense $expense The expense entity with updated data.
     * @return DomainExpense|null The updated expense entity or null if not found.
     */
    public function update(int $id, DomainExpense $expense): ?DomainExpense
    {
        $eloquentExpense = EloquentExpense::where('user_id', $expense->userId)
            ->where('id', $id)
            ->first();
        
        if (!$eloquentExpense)
            return null;

        $eloquentExpense->user_id = $expense->userId;
        $eloquentExpense->category_id = $expense->categoryId;
        $eloquentExpense->title = $expense->title;
        $eloquentExpense->description = $expense->description;
        $eloquentExpense->amount = $expense->amount;
        $eloquentExpense->date = $expense->date;
        $eloquentExpense->save();

        return new DomainExpense(
            $eloquentExpense->id,
            $eloquentExpense->user_id,
            $eloquentExpense->category_id,
            $eloquentExpense->title,
            $eloquentExpense->description,
            $eloquentExpense->amount,
            $eloquentExpense->date
        );    
    }
}