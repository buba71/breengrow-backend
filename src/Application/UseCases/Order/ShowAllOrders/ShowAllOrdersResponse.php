<?php

declare(strict_types=1);

namespace App\Application\UseCases\Order\ShowAllOrders;

use App\Application\UseCases\Response;
use App\Domain\Model\Order\Order;

class ShowAllOrdersResponse extends Response
{
    /**
     * @var array<Order>
     */
    private array $orders;

    /**
     * @return array<Order>
     */
    public function getOrders(): array
    {
        return $this->orders;
    }

    /**
     * @param array<Order> $orders
     */
    public function setOrders(array $orders): void
    {
        $this->orders = $orders;
    }
}
