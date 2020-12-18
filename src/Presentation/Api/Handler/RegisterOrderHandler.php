<?php

declare(strict_types=1);

namespace App\Presentation\Api\Handler;

use App\Application\UseCases\Order\Register\RegisterOrder;
use App\Presentation\Api\Order\RegisterOrderApiPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RegisterOrderHandler
{
    public function __invoke($data, RegisterOrder $useCase, RegisterOrderApiPresenter $presenter): JsonResponse
    {
        $useCase->execute($data, $presenter);

        return new JsonResponse($presenter->viewModel()->data, $presenter->viewModel()->status);
    }
}
