<?php

declare(strict_types=1);

namespace App\Presentation\Api\Grower\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\SerializerAwareDataProviderInterface;
use ApiPlatform\Core\DataProvider\SerializerAwareDataProviderTrait;
use App\Application\UseCases\Grower\Show\ShowGrowerRequest;
use App\Presentation\Api\Grower\Model\GrowerModel;
use Psr\Container\ContainerInterface;

/**
 * Class GrowerDataProvider
 * @package App\Presentation\Api\Grower\DataProvider
 */
final class GrowerDataProvider implements ItemDataProviderInterface
{
    /**
     * @param string $resourceClass
     * @param string $id
     * @param string|null $operationName
     * @param array<array> $context
     * @return ShowGrowerRequest
     */
    public function getItem(
        string $resourceClass,
        $id,
        string $operationName = null,
        array $context = []
    ): ShowGrowerRequest {
        $growerRequest = new ShowGrowerRequest();
        $growerRequest->id = $id;

        return $growerRequest;
    }

    /**
     * @param string $resourceClass
     * @param string|null $operationName
     * @param array<array> $context
     * @return bool
     */
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return GrowerModel::class === $resourceClass;
    }
}
