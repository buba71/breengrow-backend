<?php

declare(strict_types=1);

namespace App\Presentation\Api\Order\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Presentation\Api\Order\Model\OrderModel;

final class OrderCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    /**
     * @param string $resourceClass
     * @param string|null $operationName
     * @param array<array> $context
     * @return array<string>|null
     */
    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): ?array
    {
        return $context['filters'] ?? null;
    }

    /**
     * @param string $resourceClass
     * @param string|null $operationName
     * @param array<array> $context
     * @return bool
     */
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return OrderModel::class === $resourceClass;
    }
}