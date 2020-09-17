<?php

declare(strict_types=1);

namespace App\Presentation\Api\Deliverer\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Domain\Model\Deliverer\Deliverer;
use App\Presentation\Api\Deliverer\Model\DelivererModel;

final class InputDelivererDataTransformer implements DataTransformerInterface
{

    /**
     * @param object $object
     * @param string $to
     * @param array<array> $context
     * @return object
     */
    public function transform($object, string $to, array $context = [])
    {
        return $object;
    }

    /**
     * @param array<array>|object $data
     * @param string $to
     * @param array<array> $context
     * @return bool
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return DelivererModel::class === $to && null !== ($context['input']['class'] ?? null);
    }
}
