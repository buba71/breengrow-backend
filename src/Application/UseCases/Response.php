<?php

declare(strict_types=1);

namespace App\Application\UseCases;

use App\SharedKernel\Error\Error;
use App\SharedKernel\Error\Notifier;

abstract class Response
{
    public const HTTP_CREATED = 201;
    public const HTTP_BAD_REQUEST = 400;
    public const HTTP_OK = 200;

    private Notifier $notifier;
    private int $status;

    /**
     * RegisterGrowerResponse constructor.
     */
    public function __construct()
    {
        $this->notifier = new Notifier();
    }

    /**
     * @param Error $error
     */
    public function addError(Error $error): void
    {
        $this->notifier->addError($error);
    }

    /**
     * @return Notifier
     */
    public function getNotifier(): Notifier
    {
        return $this->notifier;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }
}
