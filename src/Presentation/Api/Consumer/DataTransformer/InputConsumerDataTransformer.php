<?php

declare(strict_types=1);

namespace App\Presentation\Api\Consumer\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Presentation\Api\Consumer\Model\ConsumerModel;

class InputConsumerDataTransformer implements DataTransformerInterface
{

    /**
     * @inheritDoc
     */
    public function transform($object, string $to, array $context = [])
    {
        return $object;
    }

    /**
     * @inheritDoc
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return ConsumerModel::class === $to && null !== ($context['input']['class'] ?? null);
    }
}