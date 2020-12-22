<?php

declare(strict_types=1);

namespace App\Application\UseCases\Order\Register;

use App\Application\UseCases\Response;
use App\Domain\Model\Order\Order;

/**
 * Class RegisterOrderResponse
 * @package App\Application\UseCases\Order\Register
 */
final class RegisterOrderResponse extends Response
{
    /**
     * @var Order
     */
    private Order $order;

    /**
     * @param Order $order
     */
    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }
}
