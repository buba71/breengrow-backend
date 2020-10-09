<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Order
 * @package App\Infrastructure\Symfony\Doctrine\Entity
 * @ORM\Entity()
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @var float
     * @ORM\Column(type="float", name="order_amount")
     */
    private float $amount;

    /**
     * @var string
     * @ORM\Column(type="string", name="order_number")
     */
    private string $number;

    /**
     * @var string
     * @ORM\Column(type="string", name="order_status")
     */
    private string $status;

    /**
     * @var Consumer
     * @ORM\ManyToOne(targetEntity="App\Infrastructure\Symfony\Doctrine\Entity\Consumer", inversedBy="orders")
     * @ORM\JoinColumn(nullable=false, name="consumer_id", referencedColumnName="identifier")
     */
    private Consumer $consumer;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return Consumer
     */
    public function getConsumer(): Consumer
    {
        return $this->consumer;
    }

    /**
     * @param Consumer $consumer
     */
    public function setConsumer(Consumer $consumer): void
    {
        $this->consumer = $consumer;
    }
}
