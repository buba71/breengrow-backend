<?php

declare(strict_types=1);

namespace App\Application\UseCases\Consumer\Register;

use App\Domain\Model\Consumer\Consumer;
use App\SharedKernel\Error\Error;
use App\SharedKernel\Error\Notifier;

final class RegisterConsumerResponse
{
    public const HTTP_CREATED = 201;
    public const HTTP_BAD_REQUEST = 400;

    private Consumer $consumer;
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
     * @param Consumer $consumer
     */
    public function setConsumer(Consumer $consumer): void
    {
        $this->consumer = $consumer;
    }

    /**
     * @return Consumer
     */
    public function getConsumer(): Consumer
    {
        return $this->consumer;
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
