<?php

declare(strict_types=1);

namespace App\Domain\Model\Order\Events;

use App\Domain\Model\Order\Order;
use App\Domain\Shared\Bus\DomainEvent;

final class OrderWasPlaced implements DomainEvent
{
    /**
     * @var string
     */
    private string $orderId;

    private \DateTimeImmutable $occurredOn;

    /**
     * OrderWasPlaced constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->orderId = $order->getNumber();
        $this->occurredOn = new \DateTimeImmutable('midnight');
    }

    /**
     * @return string
     */
    public function getAggregateId(): string
    {
        return $this->orderId;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
