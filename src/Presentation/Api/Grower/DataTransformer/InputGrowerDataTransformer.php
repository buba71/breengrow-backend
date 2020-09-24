<?php

declare(strict_types=1);

namespace App\Presentation\Api\Grower\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Presentation\Api\Grower\Model\GrowerModel;

final class InputGrowerDataTransformer implements DataTransformerInterface
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
        return GrowerModel::class === $to && null !== ($context['input']['class'] ?? null);
    }
}