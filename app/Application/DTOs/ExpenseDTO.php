<?php

namespace App\Application\DTOs;

use App\Domain\Entities\Expense;
use Carbon\Carbon;

class ExpenseDTO
{
    public function __construct(
        public ?int $id,
        public int $userId,
        public int $categoryId,
        public string $title,
        public ?string $description,
        public float $amount,
        public Carbon $date
    ) {
        $this->date = $date->startOfDay();
    }

    /**
     * Creates a ExpenseDTO from a request array
     */
    public static function fromRequest(array $data): self
    {
        return new self(
            null,
            $data['user_id'],
            $data['category_id'],
            $data['title'],
            $data['description'] ?? null,
            $data['amount'],
            new Carbon($data['date'])
        );
    }

    /**
     * Create a response from a Expense entity
     */
    public static function toResponse(Expense $expense) : array 
    {
        return [
            "id"          => $expense->id,
            "user_id"     => $expense->userId,
            "category_id" => $expense->categoryId,
            "title"       => $expense->title,
            "description" => $expense->description,
            "amount"      => $expense->amount,
            "date"        => $expense->date->format('Y-m-d')
        ];    
    }
}