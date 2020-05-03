<?php

declare(strict_types=1);

namespace App\SharedKernel\Error;

final class Notifier
{
    /**
     * @var array<Error>
     */
    private array $errors = [];

    /**
     * @param Error $error
     */
    public function addError(Error $error): void
    {
        $this->errors[] = $error;
    }

    /**
     * @return array<Error>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return count($this->errors) > 0 ? true : false;
    }

}