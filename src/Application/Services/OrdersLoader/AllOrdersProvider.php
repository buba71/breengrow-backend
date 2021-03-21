<?php

declare(strict_types=1);

namespace App\Application\Services\OrdersLoader;

use App\Domain\Model\Order\Order;
use App\Domain\Model\Order\OrdersNotfoundException;

final class AllOrdersProvider extends OrdersProvider
{
    /**
     * @param string|null $requestFilter
     * @return Order[]
     */
    public function getOrders(?string $requestFilter): array
    {
        $orders = $this->repository->getAllOrders();

        if (count($orders) === 0) {
            throw new OrdersNotfoundException();
        }

        return $orders;
    }
}
