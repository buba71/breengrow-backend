<?php

declare(strict_types=1);

namespace App\Domain\Model\Order;

/**
 * Class Order
 * @package App\Domain\Model\Order
 * Entity
 */
class Order
{

    /**
     * @var float
     */
    private float $amount;

    /**
     * @var string
     */
    private string $number;

    /**
     * @var string
     */
    private string $status;


    /**
     * Order constructor.
     * @param float $amount
     * @param string $number
     * @param string $status
     */
    public function __construct(
        float $amount,
        string $number,
        string $status

    ) {
        $this->amount = $amount;
        $this->number = $number;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}
