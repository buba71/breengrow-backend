<?php

declare(strict_types=1);

namespace App\Domain\Model\Invoice;

use App\Domain\Shared\Aggregate\AggregateRoot;

final class Invoice extends AggregateRoot
{
    /**
     * @var InvoiceNumber
     */
    private InvoiceNumber $number;

    /**
     * @var string
     */
    private string $fileName;

    /**
     * @var BillingAddress
     */
    private BillingAddress $billingAddress;

    /**
     * @var SellerAddress
     */
    private SellerAddress $sellerAddress;

    /**
     * @var InvoiceLine[]
     */
    private array $invoiceLines;

    /**
     * @var float
     */
    private float $totalAmount;

    /**
     * Invoice constructor.
     * @param InvoiceNumber $invoiceNumber
     * @param float $totalAmount
     * @param BillingAddress $billingAddress
     * @param SellerAddress $sellerAddress
     */
    public function __construct(
        InvoiceNumber $invoiceNumber,
        float $totalAmount,
        BillingAddress $billingAddress,
        SellerAddress $sellerAddress
    ) {
        $this->number = $invoiceNumber;
        $this->billingAddress = $billingAddress;
        $this->fileName = $this->buildFileName($this->number);
        $this->sellerAddress = $sellerAddress;
        $this->totalAmount = $totalAmount;
    }

    /**
     * @param InvoiceNumber $invoiceNumber
     * @return string
     */
    private function buildFileName(InvoiceNumber $invoiceNumber): string
    {
        return str_replace(
            '-',
            '',
            str_replace(' ', '', (string)$invoiceNumber)
        );
    }

    /**
     * @return InvoiceNumber
     */
    public function getNumber(): InvoiceNumber
    {
        return $this->number;
    }

    /**
     * @return BillingAddress
     */
    public function getBillingAddress(): BillingAddress
    {
        return $this->billingAddress;
    }

    /**
     * @return SellerAddress
     */
    public function getSellerAddress(): SellerAddress
    {
        return $this->sellerAddress;
    }

    /**
     * @return string|null
     */
    public function getFileName(): ?string
    {
        return $this->fileName;
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
