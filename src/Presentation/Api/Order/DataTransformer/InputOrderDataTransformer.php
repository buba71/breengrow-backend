<?php

declare(strict_types=1);

namespace App\Presentation\Api\Order\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Presentation\Api\Order\Model\OrderModel;
use phpDocumentor\Reflection\Types\Mixed_;

final class InputOrderDataTransformer implements DataTransformerInterface
{
  
    /**
     * @param object $object
     * @param string $to
     * @param array<array> $context
     * @return object
     */
    public function transform($object, string $to, array $context = []): object
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
        return OrderModel::class === $to && null !== ($context['input']['class'] ?? null);
    }
}