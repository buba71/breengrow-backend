<?php

declare(strict_types=1);

namespace App\Application\UseCases\Grower\Register;

use App\Domain\Model\Grower\Grower;
use App\SharedKernel\Error\Error;
use App\SharedKernel\Error\Notifier;

/**
 * Class RegisterGrowerResponse
 * @package App\Application\UseCases\Grower
 */
final class RegisterGrowerResponse
{
    public const HTTP_CREATED = 201;
    public const HTTP_BAD_REQUEST = 400;

    private Grower $grower;
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
     * @param Grower $grower
     */
    public function setGrower(Grower $grower): void
    {
        $this->grower = $grower;
    }

    /**
     * @return Grower
     */
    public function getGrower(): Grower
    {
        return $this->grower;
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
