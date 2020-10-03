<?php

declare(strict_types=1);

namespace App\Presentation\Api\Handler;

use App\Application\UseCases\Product\Register\RegisterProduct;
use App\Application\UseCases\Product\Register\RegisterProductRequest;
use App\Presentation\Api\Product\RegisterProductApiPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class RegisterProductHandler
 * @package App\Presentation\Api\Handler
 */
final class RegisterProductHandler
{
    /**
     * @param RegisterProductRequest $data
     * @param RegisterProduct $registerProduct
     * @param RegisterProductApiPresenter $presenter
     * @return JsonResponse
     */
    public function __invoke(
        RegisterProductRequest $data,
        RegisterProduct $registerProduct,
        RegisterProductApiPresenter $presenter
    ): JsonResponse {
        $registerProduct->execute($data, $presenter);

        return new JsonResponse($presenter->viewModel()->data, $presenter->viewModel()->status);
    }
}
