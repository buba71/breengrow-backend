<?php

declare(strict_types=1);

namespace App\Application\Services\OrdersLoader;

use App\Application\UseCases\Order\ShowAllOrders\ShowAllOrdersResponse;

class LoadOrdersResolver
{
    /**
     * @var HiveOrdersProvider
     */
    private HiveOrdersProvider $hiveOrders;

    /**
     * @var ConsumerOrdersProvider
     */
    private ConsumerOrdersProvider $consumerOrders;

    /**
     * @var AllOrdersProvider
     */
    private AllOrdersProvider $allOrders;

    /**
     * LoadOrdersResolver constructor.
     * @param HiveOrdersProvider $hiveOrders
     * @param ConsumerOrdersProvider $consumerOrders
     * @param AllOrdersProvider $allOrders
     */
    public function __construct(
        HiveOrdersProvider $hiveOrders,
        ConsumerOrdersProvider $consumerOrders,
        AllOrdersProvider $allOrders
    ) {
        $this->hiveOrders = $hiveOrders;
        $this->consumerOrders = $consumerOrders;
        $this->allOrders = $allOrders;
    }

    /**
     * @param array<string> $request
     * @param ShowAllOrdersResponse $response
     */
    public function getStrategy(array $request, ShowAllOrdersResponse $response): void
    {
        $provider = new OrdersLoader();

        switch (true) {
            case array_key_exists('hiveSiret', $request):
                $provider->setProvider($this->hiveOrders, $request['hiveSiret']);
                break;
            case array_key_exists('consumerId', $request):
                $provider->setProvider($this->consumerOrders, $request['consumerId']);
                break;
            default:
                $provider->setProvider($this->allOrders);
                break;
        }

        $provider->execute($response);
    }
}
