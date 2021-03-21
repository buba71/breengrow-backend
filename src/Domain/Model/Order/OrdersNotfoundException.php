<?php

declare(strict_types=1);

namespace App\Domain\Model\Order;

use App\Domain\Shared\Exceptions\DomainException;

final class OrdersNotfoundException extends DomainException
{

    /**
     * @return string
     */
    public function getErrorCode(): string
    {
        return 'no_order';
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return 'no orders found';
    }
}