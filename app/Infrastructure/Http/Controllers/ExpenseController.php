<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\ExpenseDTO;
use App\Application\UseCases\Expense\CreateExpense;
use App\Application\UseCases\Expense\DeleteExpense;
use App\Application\UseCases\Expense\GetExpense;
use App\Application\UseCases\Expense\GetExpensesByFilters;
use App\Application\UseCases\Expense\UpdateExpense;
use App\Infrastructure\Http\Requests\ExpenseRequest;
use App\Infrastructure\Http\Responses\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ExpenseController
{
    public function __construct(
        private CreateExpense $createExpense,
        private DeleteExpense $deleteExpense,
        private GetExpense $getExpense,
        private GetExpensesByFilters $getExpensesByFilters,
        private UpdateExpense $updateExpense,
    ) {}

    

    /**
     * Remove the specified resource from storage
     * 
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user)
                return ApiResponse::error('Unauthorized', "No valid user found.", 401);

            if ($this->deleteExpense->execute((int) $id, $user->id))
                return ApiResponse::success(['message' => 'Expense deleted successfully']);

            return ApiResponse::error('Expense Not Found', "The expense with ID {$id} was not found.", 404);

        } catch (\Throwable $th) {
            return ApiResponse::error('Bad Request', $th->getMessage(), 400);
        }
    }

    /**
     * Display a listing of the resource.
     * 
     * @return JsonResponse
     */
    public function getByFilters(Request $request): JsonResponse
    {
        $user = JWTAuth::parseToken()->authenticate();

        if (!$user)
            return ApiResponse::error('Unauthorized', "No valid user found.", 401);

        $categoryId = $request->query('category_id');
        $searchTerm = $request->query('search');

        $expenses = $this->getExpensesByFilters->execute($user->id, $categoryId, $searchTerm);

        return ApiResponse::successCollection(
            'expenses',
            array_map(fn($c) => [
                'id' => $c->id,
                'user_id' => $c->user_id,
                'category_id' => $c->category_id,
                'title' => $c->title,
                'description' => $c->description,
                'amount' => $c->amount,
                'date' => $c->date
            ], $expenses)
        );
    }

    /**
     * Display the specified resource.
     * 
     * @param string id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $user = JWTAuth::parseToken()->authenticate();

        if (!$user)
            return ApiResponse::error('Unauthorized', "No valid user found.", 401);

        $expense = $this->getExpense->execute($id);

        if(!$expense)
            return ApiResponse::error('Expense Not Found', "The expense with ID {$id} was not found.", 404);

        return ApiResponse::successResource(
            'expenses',
            $expense->id,
            [
                'user_id' => $expense->userId,
                'category_id' => $expense->categoryId,
                'title' => $expense->title,
                'description' => $expense->description,
                'amount' => $expense->amount,
                'date' => $expense->date
            ]
        );
    }

    /**
     * Store a newly created expense.
     */
    public function store(ExpenseRequest $request): JsonResponse
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user)
                return ApiResponse::error('Unauthorized', "No valid user found.", 401);    

                $expenseDTO = new ExpenseDTO(
                    null,
                    (int) $request['data.attributes.user_id'],
                    (int) $request['data.attributes.category_id'],
                    (string) $request['data.attributes.title'],
                    isset($request['data.attributes.description']) ? (string) $request['data.attributes.description'] : null,
                    (float) $request['data.attributes.amount'],
                    Carbon::parse($request['data.attributes.date'])
                );

            $expense = $this->createExpense->execute($expenseDTO);

            return ApiResponse::successResource(
                'expenses',
                $expense->id,
                [
                    'user_id' => $expense->userId,
                    'category_id' => $expense->categoryId,
                    'title' => $expense->title,
                    'description' => $expense->description,
                    'amount' => $expense->amount,
                    'date' => $expense->date
                ]
            );

        } catch (\Exception $e) {
            return ApiResponse::error('Expense Update Error', $e->getMessage(), 400);
        }
    }

    /**
     * Update an existing expense.
     */
    public function update(ExpenseRequest $request, string $id): JsonResponse
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user)
                throw new \Exception("Unauthorized: No valid user found.");

                $expenseDTO = new ExpenseDTO(
                    null,
                    (int) $request['data.attributes.user_id'],
                    (int) $request['data.attributes.category_id'],
                    (string) $request['data.attributes.title'],
                    isset($request['data.attributes.description']) ? (string) $request['data.attributes.description'] : null,
                    (float) $request['data.attributes.amount'],
                    Carbon::parse($request['data.attributes.date'])
                );

                $expense = $this->updateExpense->execute($id, $expenseDTO);

            if (!$expense) {
                return ApiResponse::error('Expense Not Found', "Expense with ID {$id} not found.", 404);
            }

            return ApiResponse::successResource(
                'expenses',
                $expense->id,
                [
                    'user_id' => $expense->userId,
                    'category_id' => $expense->categoryId,
                    'title' => $expense->title,
                    'description' => $expense->description,
                    'amount' => $expense->amount,
                    'date' => $expense->date
                ]
            );
        } catch (\Exception $e) {
            return ApiResponse::error('Expense Update Error', $e->getMessage(), 400);
        }
    }
}
