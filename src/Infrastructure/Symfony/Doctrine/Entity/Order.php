<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * Class Order
 * @package App\Infrastructure\Symfony\Doctrine\Entity
 * @ORM\Entity()
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(type="string", name="order_number")
     */
    private string $number;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="date_immutable", name="received_at")
     */
    private \DateTimeImmutable $receivedAt;

    /**
     * @var float
     * @ORM\Column(type="float", name="order_amount")
     */
    private float $amount;

    /**
     * @var int
     * @ORM\Column(type="integer", name="order_status")
     */
    private int $status;

    /**
     * @var string
     * @ORM\Column(type="string", name="consumer_id")
     */
    private string $consumerId;

    /**
     * @var Collection
     * @ORM\OneToMany(
     *     targetEntity="App\Infrastructure\Symfony\Doctrine\Entity\OrderLine",
     *     mappedBy="order",
     *     cascade={"persist", "remove"}
     * )
     */
    private Collection $orderlines;

    /**
     * Order constructor.
     */
    public function __construct()
    {
        $this->orderlines = new ArrayCollection();
        $this->receivedAt = new \DateTimeImmutable();
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string $number
     */
    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDate(): \DateTimeImmutable
    {
        return $this->receivedAt;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getConsumer(): string
    {
        return $this->consumerId;
    }

    /**
     * @param string $consumer
     */
    public function setConsumerId(string $consumer): void
    {
        $this->consumerId = $consumer;
    }

    /**
     * @param OrderLine $orderLine
     * @return $this
     */
    public function addOrderLine(OrderLine $orderLine): self
    {
        if (!$this->orderlines->contains($orderLine)) {
            $this->orderlines->add($orderLine);
        }
        return $this;
    }

    /**
     * @param OrderLine $orderLine
     * @return $this
     */
    public function removeOrderLine(OrderLine $orderLine): self
    {
        if ($this->orderlines->contains($orderLine)) {
            $this->orderlines->removeElement($orderLine);
        }
        return $this;
    }
}
