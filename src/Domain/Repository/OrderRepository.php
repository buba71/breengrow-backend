<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Order\Order;

interface OrderRepository
{
    /**
     * @param Order $order
     * @return mixed
     */
    public function addOrder(Order $order);

    /**
     * @return array<Order>
     */
    public function getAllOrders(): array;

    /**
     * @param string $hiveId
     * @return array<Order>
     */
    public function getOrdersByHive(string $hiveId): array;

    /**
     * @param string $consumerId
     * @return array<Order>
     */
    public function getOrdersByConsumer(string $consumerId): array;

    /**
     * @param string $orderId
     * @return Order
     */
    public function getOrderById(string $orderId): Order;
}
