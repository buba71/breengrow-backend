<?php

declare(strict_types=1);

namespace App\Application\UseCases\Order;

use App\Presentation\Api\Order\Model\OrderLine;

abstract class OrderRequest
{
    /**
     * @var string|null
     */
    public ?string $consumerId;

    /**
     * @var string
     */
    public string $hive_siret;

    /**
     * @var string
     */
    public string $number;

    /**
     * @var array<OrderLine>
     */
    public array $orderLines;

    /**
     * @var int|null
     */
    public ?int $status = null;
}
