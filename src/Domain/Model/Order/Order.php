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
    public const ORDER_DELIVERED = 0;
    public const ORDER_IN_TRANSIT = 1;
    public const ORDER_PAID = 2;
    public const ORDER_PROBLEM = 3;
    public const ORDER_PROCESSING = 4;
    public const ORDER_RETURNED = 5;
    public const ORDER_SHIPPED = 6;
    public const ORDER_PENDING = 7;

    /**
     * @var float
     */
    private float $amount;

    /**
     * @var string
     */
    private string $consumerId;

    /**
     * @var string
     * Adding an order id and order number properties can make sense too. In case
     * we would like to have two different uses of them. Here, order number and order id are the same.
     */
    private string $number;

    /**
     * @var array
     */
    private array $orderLines;

    /**
     * @var \DateTimeImmutable
     */
    private \DateTimeImmutable $receivedAt;

    /**
     * @var int|null
     */
    private ?int $status;


    /**
     * Order constructor.
     * @param string $consumerId
     * @param string $number
     * @param int|null $status
     */
    public function __construct(string $consumerId, string $number, ?int $status)
    {
        $this->consumerId = $consumerId;
        $this->number = $number;
        $this->receivedAt = new \DateTimeImmutable('midnight');
        $this->status = $status;
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
    public function getConsumerId(): string
    {
        return $this->consumerId;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return array
     */
    public function getOrderLines(): array
    {
        return $this->orderLines;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param string $productId
     * @param int $quantity
     * @param float $linePrice
     */
    public function addOrderLine(string $productId, int $quantity, float $linePrice): void
    {
        $this->orderLines[] = new OrderLine($productId, $quantity, $linePrice);
        $this->processAmount();
    }

    private function processAmount(): void
    {
        $totalAmount = array_reduce(
            $this->orderLines,
            fn($accumulator, $orderline) => $accumulator += $orderline->getLinePrice()
        );
        $this->amount = round($totalAmount, 2);
    }
}
