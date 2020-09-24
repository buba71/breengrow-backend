<?php

declare(strict_types=1);

namespace App\Application\UseCases\Deliverer\Register;

use App\Domain\Model\Deliverer\Deliverer;
use App\SharedKernel\Error\Error;
use App\SharedKernel\Error\Notifier;

final class RegisterDelivererResponse
{
    public const HTTP_CREATED = 201;
    public const HTTP_BAD_REQUEST = 400;

    /**
     * @var Notifier
     */
    private Notifier $notifier;

    /**
     * @var Deliverer
     */
    private Deliverer $deliverer;

    /**
     * @var int
     */
    private int $status;

    /**
     * RegisterDelivererResponse constructor.
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
     * @return Deliverer
     */
    public function getDeliverer(): Deliverer
    {
        return $this->deliverer;
    }

    /**
     * @param Deliverer $deliverer
     */
    public function setDeliverer(Deliverer $deliverer): void
    {
        $this->deliverer = $deliverer;
    }

    /**
     * @return Notifier
     */
    public function getNotifier(): Notifier
    {
        return $this->notifier;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }
}
