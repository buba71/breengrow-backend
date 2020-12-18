<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class OrderLine
 * @ORM\Entity()
 * @package App\Infrastructure\Symfony\Doctrine\Entity
 */
class OrderLine
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", name="id")
     */
    private int $id;

    /**
     * @var Order
     * @ORM\ManyToOne(
     *     targetEntity="App\Infrastructure\Symfony\Doctrine\Entity\Order",
     *     inversedBy="orderlines")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="order_number")
     */
    private Order $order;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private string $productId;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private int $quantity;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private float $price;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @param Order $order
     */
    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }

    /**
     * @return string
     */
    public function getProductId(): string
    {
        return $this->productId;
    }

    /**
     * @param string $productId
     */
    public function setProductId(string $productId): void
    {
        $this->productId = $productId;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
}
