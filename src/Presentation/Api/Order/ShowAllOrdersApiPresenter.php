<?php

declare(strict_types=1);

namespace App\Presentation\Api\Order;

use App\Application\UseCases\Order\ShowAllOrders\ShowAllOrdersPresenter;
use App\Application\UseCases\Order\ShowAllOrders\ShowAllOrdersResponse;

final class ShowAllOrdersApiPresenter implements ShowAllOrdersPresenter
{
    private ShowAllOrdersApiViewModel $viewModel;

    /**
     * @param ShowAllOrdersResponse $response
     */
    public function present(ShowAllOrdersResponse $response): void
    {
        $this->viewModel = new ShowAllOrdersApiViewModel();

        $this->viewModel->modelTransformer($response->getOrders());
        $this->viewModel->status = $response->getStatus();
    }

    /**
     * @return ShowAllOrdersApiViewModel
     */
    public function viewModel(): ShowAllOrdersApiViewModel
    {
        return $this->viewModel;
    }
}
