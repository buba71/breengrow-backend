<?php

declare(strict_types=1);

namespace App\Presentation\Api\Consumer\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Presentation\Api\Consumer\Model\ConsumerModel;

class InputConsumerDataTransformer implements DataTransformerInterface
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
        return ConsumerModel::class === $to && null !== ($context['input']['class'] ?? null);
    }
}
