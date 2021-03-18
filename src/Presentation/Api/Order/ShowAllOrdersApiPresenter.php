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

        if ($response->getNotifier()->hasErrors()) {
            foreach ($response->getNotifier()->getErrors() as $error) {
                $this->viewModel->addNotification($error->fieldName(), $error->message());
            }
        } else {
            $this->viewModel->modelTransformer($response->getOrders());
        }

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
