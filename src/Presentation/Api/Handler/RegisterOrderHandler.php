<?php

declare(strict_types=1);

namespace App\Presentation\Api\Handler;

use App\Application\UseCases\Order\Register\RegisterOrder;
use App\Application\UseCases\Order\Register\RegisterOrderRequest;
use App\Presentation\Api\Order\RegisterOrderApiPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RegisterOrderHandler
{
  
    /**
     * @param RegisterOrderRequest $data
     * @param RegisterOrder $useCase
     * @param RegisterOrderApiPresenter $presenter
     * @return JsonResponse
     */
    public function __invoke(
        RegisterOrderRequest $data,
        RegisterOrder $useCase,
        RegisterOrderApiPresenter $presenter
    ): JsonResponse {
        $useCase->execute($data, $presenter);

        return new JsonResponse($presenter->viewModel()->data, $presenter->viewModel()->status);
    }
}
