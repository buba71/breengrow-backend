<?php

declare(strict_types=1);

namespace App\Presentation\Api\Handler;

use App\Application\UseCases\Consumer\Register\RegisterConsumer;
use App\Application\UseCases\Consumer\Register\RegisterConsumerRequest;
use App\Presentation\Api\Consumer\RegisterConsumerApiPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class RegisterConsumerHandler
 * @package App\Presentation\Api\Handler
 */
final class RegisterConsumerHandler
{
    /**
     * @param RegisterConsumerRequest $data
     * @param RegisterConsumer $createConsumer
     * @param RegisterConsumerApiPresenter $presenter
     * @return JsonResponse
     * $data parameter come from api platform dataTransformer.
     */
    public function __invoke(
        RegisterConsumerRequest $data,
        RegisterConsumer $createConsumer,
        RegisterConsumerApiPresenter $presenter
    ): JsonResponse {

        $createConsumer->execute($data, $presenter);
        return new JsonResponse($presenter->viewModel()->data, $presenter->viewModel()->status);
    }
}
