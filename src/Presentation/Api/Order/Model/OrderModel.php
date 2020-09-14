<?php

declare(strict_types=1);

namespace App\Presentation\Api\Order\Model;

use ApiPlatform\Core\Annotation\ApiProperty;

/**
 * Class OderModel
 * @package App\Presentation\Api\Consumer\Model
 */
class OrderModel
{
    public const ORDER_PROCESSING = 0;
    public const ORDER_IN_TRANSIT = 1;
    public const ORDER_DELIVERED = 2;
    public const ORDER_RETURNED = 3;
    public const ORDER_PROBLEM = 4;

    /**
     * @var string
     * @ApiProperty()
     */
    public string $number;

    /**
     * @var float
     * @ApiProperty()
     */
    public float $amount;

    /**
     * @var string
     * @ApiProperty()
     */
    public string $status;
}
