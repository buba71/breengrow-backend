<?php

declare(strict_types=1);

namespace App\Presentation\Api\Handler;

use App\Application\UseCases\Order\ShowAllOrders\ShowAllOrders;
use App\Presentation\Api\Order\ShowAllOrdersApiPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ShowAllOrdersHandler
{
    /**
     * @param array<string>|null $data
     * @param ShowAllOrders $useCase
     * @param ShowAllOrdersApiPresenter $presenter
     * @return JsonResponse
     */
    public function __invoke(?array $data, ShowAllOrders $useCase, ShowAllOrdersApiPresenter $presenter): JsonResponse
    {
        $useCase->execute($data, $presenter);

        return new JsonResponse($presenter->viewModel()->data, $presenter->viewModel()->status);
    }
}
