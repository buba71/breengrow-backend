<?php

declare(strict_types=1);

namespace App\Presentation\Api\Order\Model;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * Class OderModel
 * @package App\Presentation\Api\Consumer\Model
 * @ApiResource()
 */
class OrderModel
{
    /**
     * @var string|null
     * @ApiProperty()
     */
    public ?string $consumerId;

    /**
     * @var string
     * @ApiProperty()
     */
    public string $hive_siret;

    /**
     * @var string
     * @ApiProperty()
     */
    public string $number;

    /**
     * @var array<OrderLine>
     */
    public array $orderLines = [];

    /**
     * @var int|null
     * @ApiProperty()
     */
    public ?int $status;
}
