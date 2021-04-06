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
     * @ORM\Column(type="string", name="consumer_id", nullable=false)
     */
    private string $consumerId;

    /**
     * @var string
     * @ORM\Column(type="string", name="company_siret", nullable=false)
     */
    private string $companySiret;

    /**
     * @var Invoice|null
     * @ORM\OneToOne(targetEntity="App\Infrastructure\Symfony\Doctrine\Entity\Invoice", cascade={"persist", "remove"})
     * @ORM\JoinColumn(referencedColumnName="invoice_number")
     */
    private ?Invoice $invoice = null;

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
     * @return \DateTimeImmutable
     */
    public function getReceivedAt(): \DateTimeImmutable
    {
        return $this->receivedAt;
    }

    /**
     * @param \DateTimeImmutable $receivedAt
     */
    public function setReceivedAt(\DateTimeImmutable $receivedAt): void
    {
        $this->receivedAt = $receivedAt;
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
     * @return string
     */
    public function getCompanySiret(): string
    {
        return $this->companySiret;
    }

    /**
     * @param string $companySiret
     */
    public function setCompanySiret(string $companySiret): void
    {
        $this->companySiret = $companySiret;
    }

    /**
     * @return Invoice|null
     */
    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    /**
     * @param Invoice $invoice
     */
    public function setInvoice(Invoice $invoice): void
    {
        $this->invoice = $invoice;
    }

    /**
     * @return Collection
     */
    public function getOrderlines(): Collection
    {
        return $this->orderlines;
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
