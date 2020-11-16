<?php

declare(strict_types=1);

namespace App\Presentation\Api\Handler;

use App\Application\UseCases\Grower\AddProducts\AddProductsToHive;
use App\Application\UseCases\Grower\AddProducts\AddProductsToHiveGrowerRequest;
use App\Presentation\Api\Grower\AddProductsToHiveGrowerApiPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

final class UpdateGrowerHandler
{
    /**
     * @param AddProductsToHiveGrowerRequest $data
     * @param string $id
     * @param AddProductsToHiveGrowerApiPresenter $presenter
     * @param AddProductsToHive $useCase
     * @return JsonResponse
     */
    public function __invoke(
        AddProductsToHiveGrowerRequest $data,
        string $id,
        AddProductsToHiveGrowerApiPresenter $presenter,
        AddProductsToHive $useCase
    ): JsonResponse {

        $useCase->execute($data, $id, $presenter);

        return new JsonResponse($presenter->viewModel()->data, $presenter->viewModel()->status);
    }
}
