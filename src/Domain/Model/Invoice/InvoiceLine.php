<?php

declare(strict_types=1);

namespace App\Domain\Model\Invoice;

final class InvoiceLine
{
    /**
     * @var string
     */
    private string $productDescription;

    /**
     * @var int
     */
    private int $quantity;

    /**
     * @var float
     */
    private float $linePrice;

    /**
     * InvoiceLine constructor.
     * @param string $productDescription
     * @param int $quantity
     * @param float $linePrice
     */
    public function __construct(string $productDescription, int $quantity, float $linePrice)
    {
        $this->productDescription = $productDescription;
        $this->quantity = $quantity;
        $this->linePrice = $linePrice;
    }

    /**
     * @return string
     */
    public function getProductDescription(): string
    {
        return $this->productDescription;
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
