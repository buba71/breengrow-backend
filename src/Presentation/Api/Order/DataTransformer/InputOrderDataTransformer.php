<?php

declare(strict_types=1);

namespace App\Presentation\Api\Order\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Presentation\Api\Order\Model\OrderModel;

final class InputOrderDataTransformer implements DataTransformerInterface
{

    public function transform($object, string $to, array $context = [])
    {
        return $object;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return OrderModel::class === $to && null !== ($context['input']['class'] ?? null);
    }
}