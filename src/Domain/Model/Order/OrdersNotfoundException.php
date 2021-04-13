<?php

declare(strict_types=1);

namespace App\Domain\Model\Order;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class OrdersNotfoundException extends NotFoundHttpException
{
    /**
     * OrdersNotfoundException constructor.
     */
    public function __construct()
    {
        parent::__construct($this->getErrorMessage());
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return 'no orders found';
    }
}
