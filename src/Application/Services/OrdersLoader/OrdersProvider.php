<?php

declare(strict_types=1);

namespace App\Application\Services\OrdersLoader;

use App\Domain\Model\Order\Order;
use App\Domain\Repository\OrderRepository;

abstract class OrdersProvider
{
    /**
     * @var OrderRepository
     */
    protected OrderRepository $repository;

    /**
     * OrdersProvider constructor.
     * @param OrderRepository $repository
     */
    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string|null $requestFilter
     * @return array<Order>
     */
    abstract public function getOrders(?string $requestFilter): array;
}
