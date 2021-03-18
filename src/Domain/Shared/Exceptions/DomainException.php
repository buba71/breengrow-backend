<?php

declare(strict_types=1);

namespace App\Domain\Shared\Exceptions;

abstract class DomainException extends \DomainException
{
    public function __construct()
    {
        parent::__construct($this->getErrorMessage());
    }

    /**
     * @return string
     */
    abstract public function getErrorCode(): string;

    /**
     * @return string
     */
    abstract public function getErrorMessage(): string;

}