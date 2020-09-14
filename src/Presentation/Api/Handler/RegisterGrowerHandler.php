<?php

declare(strict_types=1);

namespace App\Presentation\Api\Handler;

use App\Application\UseCases\Grower\Register\RegisterGrower;
use App\Application\UseCases\Grower\Register\RegisterGrowerRequest;
use App\Presentation\Api\Grower\RegisterGrowerApiPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class RegisterGrowerHandler
 * @package App\Presentation\Api\Handler
 */
final class RegisterGrowerHandler
{
    /**
     * @param RegisterGrowerRequest $data
     * @param RegisterGrower $createGrower
     * @param RegisterGrowerApiPresenter $presenter
     * @return JsonResponse
     * $data parameter come from api platform dataTransformer.
     */
    public function __invoke(
        RegisterGrowerRequest $data,
        RegisterGrower $createGrower,
        RegisterGrowerApiPresenter $presenter
    ): JsonResponse {

        $createGrower->execute($data, $presenter);
        return new JsonResponse($presenter->viewModel()->data, $presenter->viewModel()->status);
    }
}
