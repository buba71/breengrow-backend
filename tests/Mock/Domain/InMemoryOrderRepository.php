<?php

declare(strict_types=1);

namespace App\Tests\Mock\Domain;

use App\Domain\Model\Order\Order;
use App\Domain\Repository\OrderRepository;

/**
 * Class InMemoryOrderRepository
 * @package App\Tests\Mock\Domain
 */
final class InMemoryOrderRepository implements OrderRepository
{
    /**
     * @var Order[]
     */
    private array $orders = [];


    /**
     * @param Order $order
     * @return void
     */
    public function addOrder(Order $order): void
    {
        $this->orders[] = $order;
    }

    /**
     * @return Order[]
     */
    public function getAllOrders(): array
    {
        return $this->orders;
    }

    /**
     * @param string $hiveId
     * @return Order[]
     */
    public function getOrdersByHive(string $hiveId): array
    {
        return array_filter($this->orders, fn(Order $order) => $order->getHiveSiret() === $hiveId);
    }

    /**
     * @param string $consumerId
     * @return Order[]
     */
    public function getOrdersByConsumer(string $consumerId): array
    {
        return array_filter($this->orders, fn(Order $order) => $order->getConsumerId() === $consumerId);
    }

    /**
     * @param string $orderId
     * @return Order
     */
    public function getOrderById(string $orderId): Order
    {
        // TODO: Implement getOrderById() method.
    }
}
