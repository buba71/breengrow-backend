<?php

declare(strict_types=1);

namespace App\Presentation\Api\Handler;

use App\Application\UseCases\Consumer\Show\ShowConsumer;
use App\Application\UseCases\Consumer\Show\ShowConsumerRequest;
use App\Presentation\Api\Consumer\ShowConsumerApiPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ShowConsumerHandler
{
    public function __invoke(
        ShowConsumerRequest $data,
        ShowConsumer $useCase,
        ShowConsumerApiPresenter $presenter
    ): JsonResponse {
        $useCase->execute($data, $presenter);

        return new JsonResponse($presenter->viewModel()->data, $presenter->viewModel()->status);
    }
}
