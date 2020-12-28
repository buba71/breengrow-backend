<?php

declare(strict_types=1);

namespace App\Domain\Model\Order;

class OrderLine
{
    private string $productId;
    private int $quantity;
    private float $linePrice;

    public function __construct(string $productId, int $quantity, float $linePrice)
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->linePrice = $linePrice;
    }

    /**
     * @return string
     */
    public function getProductId(): string
    {
        return $this->productId;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return float
     */
    public function getLinePrice(): float
    {
        return $this->linePrice;
    }
}
