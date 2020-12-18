<?php

declare(strict_types=1);

namespace App\Tests\Mock\Domain;

use App\Domain\Model\Order\Order;
use App\Domain\Repository\OrderRepository;

final class InMemoryOrderRepository implements OrderRepository
{
    private array $orders = [];


    public function addOrder(Order $order)
    {
        $this->orders[] = $order;
    }

    public function getAllOrders()
    {
        return $this->orders;
    }
}
