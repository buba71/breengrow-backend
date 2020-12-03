<?php

declare(strict_types=1);

namespace App\Presentation\Api\Handler;

use App\Application\UseCases\Grower\ShowAlls\ShowAllGrowers;
use App\Presentation\Api\Grower\ShowAllGrowersApiPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ShowAllGrowersHandler
{
    public function __invoke(ShowAllGrowers $useCase, ShowAllGrowersApiPresenter $presenter): JsonResponse
    {
        $useCase->execute($presenter);

        return new JsonResponse($presenter->viewModel()->data, $presenter->viewModel()->status);
    }
}
