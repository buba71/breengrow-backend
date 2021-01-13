<?php

declare(strict_types=1);

namespace App\Presentation\Api\Consumer\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Application\UseCases\Consumer\Show\ShowConsumerRequest;
use App\Presentation\Api\Consumer\Model\ConsumerModel;

final class ShowConsumerDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    /**
     * @param string $resourceClass
     * @param string|null $operationName
     * @param array[] $context
     * @return bool
     */
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return ConsumerModel::class === $resourceClass;
    }

    /**
     * @param string $resourceClass
     * @param string $id
     * @param string|null $operationName
     * @param array[] $context
     * @return ShowConsumerRequest
     */
    public function getItem(
        string $resourceClass,
        $id,
        string $operationName = null,
        array $context = []
    ): ShowConsumerRequest {
        $consumerRequest = new ShowConsumerRequest();
        $consumerRequest->id = $id;

        return $consumerRequest;
    }
}