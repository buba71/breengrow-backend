<?php

declare(strict_types=1);

namespace App\Presentation\Api\Handler;

use App\Application\UseCases\Grower\Show\ShowGrower;
use App\Application\UseCases\Grower\Show\ShowGrowerRequest;
use App\Presentation\Api\Grower\ShowGrowerApiPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ShowGrowerHandler
{

    /**
     * @param ShowGrowerRequest $data
     * @param ShowGrower $useCase
     * @param ShowGrowerApiPresenter $presenter
     * @return JsonResponse
     */
    public function __invoke(
        ShowGrowerRequest $data,
        ShowGrower $useCase,
        ShowGrowerApiPresenter $presenter
    ): JsonResponse {
        $useCase->execute($data, $presenter);

        return new JsonResponse($presenter->viewModel()->data, $presenter->viewModel()->status);
    }
}
