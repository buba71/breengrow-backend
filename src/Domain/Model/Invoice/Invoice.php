<?php

declare(strict_types=1);

namespace App\Domain\Model\Invoice;

use App\Domain\Shared\Aggregate\AggregateRoot;

final class Invoice extends AggregateRoot
{
    private InvoiceNumber $number;

    /**
     * @var string|null
     */
    private ?string $filePath = null;

    /**
     * @var InvoiceLine[]
     */
    private array $invoiceLines;

    private float $totalAmount;

    /**
     * Invoice constructor.
     * @param InvoiceNumber $invoiceNumber
     * @param float $totalAmount
     */
    public function __construct(InvoiceNumber $invoiceNumber, float $totalAmount)
    {
        $this->number = $invoiceNumber;
        $this->totalAmount = $totalAmount;
    }

    /**
     * @return InvoiceNumber
     */
    public function getNumber(): InvoiceNumber
    {
        return $this->number;
    }

    /**
     * @return string|null
     */
    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    /**
     * @return InvoiceLine[]
     */
    public function getInvoiceLines(): array
    {
        return $this->invoiceLines;
    }

    /**
     * @return float
     */
    public function getTotalAmount(): float
    {
        return $this->totalAmount;
    }

    /**
     * @param string $productDescription
     * @param int $quantity
     * @param float $linePrice
     */
    public function addInvoiceLine(string $productDescription, int $quantity, float $linePrice): void
    {
        $this->invoiceLines[] = new InvoiceLine($productDescription, $quantity, $linePrice);
    }
}
