<?php

declare(strict_types=1);

namespace App\Application\Services\OrdersLoader;

use App\Application\UseCases\Order\ShowAllOrders\ShowAllOrdersResponse;

final class OrdersLoader
{
    /**
     * @var OrdersProvider
     */
    private OrdersProvider $provider;

    /**
     * @var string|null
     */
    private ?string $requestFilter;

    /**
     * @param OrdersProvider $provider
     * @param string|null $requestFilter
     */
    public function setProvider(OrdersProvider $provider, string $requestFilter = null): void
    {
        $this->provider = $provider;
        $this->requestFilter = $requestFilter;
    }

    /**
     * @param ShowAllOrdersResponse $response
     */
    public function execute(ShowAllOrdersResponse $response): void
    {
        $response->setOrders($this->provider->getOrders($this->requestFilter));
        $response->setStatus(ShowAllOrdersResponse::HTTP_OK);
    }
}
