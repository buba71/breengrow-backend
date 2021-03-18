<?php

declare(strict_types=1);

namespace App\Application\Services\OrdersLoader;

use App\Application\UseCases\Order\ShowAllOrders\ShowAllOrdersResponse;
use App\Domain\Model\Order\OrdersNotfoundException;
use App\SharedKernel\Error\Error;

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
        try {
            $orders = $this->provider->getOrders($this->requestFilter);
            $response->setOrders($orders);
            $response->setStatus(ShowAllOrdersResponse::HTTP_OK);
        } catch (OrdersNotfoundException $exception) {
            $response->getNotifier()->addError(new Error('orders', $exception->getErrorMessage()));
            $response->setStatus(ShowAllOrdersResponse::HTTP_NOT_FOUND);
        }
    }
}
