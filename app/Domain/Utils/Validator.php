<?php

namespace App\Domain\Utils;

class Validator
{
    /**
     * Validates that the provided value is not null.
     * 
     * @param mixed $value The value to check.
     * @param string $parameter The name of the parameter for error messaging.
     * @throws \InvalidArgumentException if the value is null.
     */
    public static function notNull(mixed $value, string $parameter): void
    {
        if (is_null($value)) {
            throw new \InvalidArgumentException("$parameter cannot be null.");
        }
    }

    /**
     * Validates that the provided string is not empty after trimming whitespace.
     * 
     * @param string $value The string to check.
     * @param string $parameter The name of the parameter for error messaging.
     * @throws \InvalidArgumentException if the string is empty.
     */
    public static function notEmpty(string $value, string $parameter): void
    {
        if (trim($value) === '') {
            throw new \InvalidArgumentException("$parameter cannot be empty.");
        }
    }

    /**
     * Validates that the provided number is positive.
     * 
     * @param float|int $value The number to check.
     * @param string $parameter The name of the parameter for error messaging.
     * @throws \InvalidArgumentException if the number is not positive.
     */
    public static function positiveNumber(float|int $value, string $parameter): void
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException("$parameter must be positive.");
        }
    }

    /**
     * Validates that provided value has minimum 8 characters
     * @param string $value The string to check.
     * @param string $parameter The name of the parameter for error messaging.
     * @throws \InvalidArgumentException if the value has not minimum 8 characters.
     */
    public static function minEightLength(string $value, string $parameter): void
    {
        if (strlen($value) < 8) {
            throw new \InvalidArgumentException("$parameter must be at least 8 characters long.");
        }        
    }

    /**
     * Validates that provided value is email
     * @param string $value The string to check
     * @throws \InvalidArgumentException if the value is not email.
     */
    public static function isEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email format.');
        }
    }
}