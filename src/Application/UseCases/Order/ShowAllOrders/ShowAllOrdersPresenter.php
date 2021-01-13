<?php

declare(strict_types=1);

namespace App\Application\UseCases\Order\ShowAllOrders;

interface ShowAllOrdersPresenter
{
    /**
     * @param ShowAllOrdersResponse $response
     */
    public function present(ShowAllOrdersResponse $response): void;
}
