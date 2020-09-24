<?php

declare(strict_types=1);

namespace App\Presentation\Api\Handler;

use App\Application\UseCases\Deliverer\Register\RegisterDeliverer;
use App\Application\UseCases\Deliverer\Register\RegisterDelivererRequest;
use App\Presentation\Api\Deliverer\RegisterDelivererApiPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class RegisterDelivererHandler
 * @package App\Presentation\Api\Handler
 */
final class RegisterDelivererHandler
{

    /**
     * @param RegisterDelivererRequest $data
     * @param RegisterDeliverer $createDeliverer
     * @param RegisterDelivererApiPresenter $presenter
     * @return JsonResponse
     */
    public function __invoke(
        RegisterDelivererRequest $data,
        RegisterDeliverer $createDeliverer,
        RegisterDelivererApiPresenter $presenter
    ): JsonResponse {
        $createDeliverer->execute($data, $presenter);

        return new JsonResponse($presenter->viewModel()->data, $presenter->viewModel()->status);
    }
}
