<?php

namespace App\Domain\Entities;

use App\Domain\Utils\Validator;
use Carbon\Carbon;

class Expense
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
        Validator::notNull($userId, "User ID");
        Validator::notNull($categoryId, "Category ID");
        Validator::notEmpty($title, "Title");
        Validator::positiveNumber($amount, "Amount");
    }

    /**
     * Create a new Expense Entity
     */
    public static function create(
        int $userId, 
        int $categoryId, 
        string $title, 
        ?string $description, 
        float $amount, 
        Carbon $date
    ): self {
        return new self(null, $userId, $categoryId, $title, $description, $amount, $date);
    }
}