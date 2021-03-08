<?php

declare(strict_types=1);

namespace App\Application\UseCases\Order\ShowAllOrders;

use App\Application\Services\OrdersLoader\LoadOrdersResolver;

final class ShowAllOrders extends LoadOrdersResolver
{
    /**
     * @param array<string> $requestFilters
     * @param ShowAllOrdersPresenter $presenter
     */
    public function execute(array $requestFilters, ShowAllOrdersPresenter $presenter): void
    {
        $response = new ShowAllOrdersResponse();

        $this->getStrategy($requestFilters, $response);

        $presenter->present($response);
    }
}
