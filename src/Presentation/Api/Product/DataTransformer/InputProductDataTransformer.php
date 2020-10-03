<?php

declare(strict_types=1);

namespace App\Presentation\Api\Product\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Presentation\Api\Product\Model\ProductModel;

final class InputProductDataTransformer implements DataTransformerInterface
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
        return ProductModel::class === $to && null !== ($context['input']['class'] ?? null);
    }
}
