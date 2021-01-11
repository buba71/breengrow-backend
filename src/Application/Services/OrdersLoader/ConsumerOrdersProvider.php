<?php

declare(strict_types=1);

namespace App\Application\Services\OrdersLoader;

use App\Domain\Model\Order\Order;

final class ConsumerOrdersProvider extends OrdersProvider
{
    /**
     * @param string|null $requestFilter
     * @return Order[]
     */
    public function getOrders(?string $requestFilter): array
    {
        return $this->repository->getOrdersByConsumer($requestFilter);
    }
}
