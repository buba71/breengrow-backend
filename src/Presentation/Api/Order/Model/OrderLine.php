<?php

declare(strict_types=1);

namespace App\Presentation\Api\Order\Model;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * Class OrderLine
 * @package App\Presentation\Api\Order\Model
 * @ApiResource()
 */
class OrderLine
{
    /**
     * @var string
     * @ApiProperty()
     */
    public string $productId;
    /**
     * @var int
     * @ApiProperty()
     */
    public int $quantity;

    /**
     * @var float
     * @ApiProperty()
     */
    public float $linePrice;
}
