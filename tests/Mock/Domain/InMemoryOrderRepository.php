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

    public function getAllOrders(): array
    {
        return $this->orders;
    }

    public function getOrdersByHive(string $hiveId): array
    {
        return array_filter($this->orders, fn(Order $order) => $order->getHiveSiret() === $hiveId);
    }

    public function getOrdersByConsumer(string $consumerId): array
    {
        return array_filter($this->orders, fn(Order $order) => $order->getConsumerId() === $consumerId);
    }
}
