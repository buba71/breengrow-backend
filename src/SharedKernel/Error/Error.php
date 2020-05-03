<?php

declare(strict_types=1);

namespace App\SharedKernel\Error;

final class Error
{
    private ?string $fieldName;
    private string $message;

    /**
     * Error constructor.
     * @param string|null $fieldName
     * @param string $message
     */
    public function __construct(?string $fieldName, string $message)
    {
        $this->fieldName = $fieldName;
        $this->message = $message;
    }

    public function fieldName(): ?string
    {
        return $this->fieldName;
    }

    public function message(): string
    {
        return $this->message;
    }
}
