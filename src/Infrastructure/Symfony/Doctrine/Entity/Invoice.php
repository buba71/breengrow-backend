<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Invoice
 * @package App\Infrastructure\Symfony\Doctrine\Entity
 * @ORM\Entity()
 */
class Invoice implements DoctrineEntity
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(type="string", name="invoice_number")
     */
    private string $number;

    /**
     * @var string|null
     * @ORM\Column(type="string", name="invoiceFile_path", nullable=true)
     */
    private ?string $invoiceFilePath = null;

    /**
     * @var BillingAddress
     * @ORM\Embedded(class="BillingAddress", columnPrefix=false)
     */
    private BillingAddress $billingAddress;

    /**
     * @var SellerAddress
     * @ORM\Embedded(class="SellerAddress", columnPrefix=false)
     */
    private SellerAddress $sellerAddress;

    /**
     * @var Collection
     * @ORM\OneToMany(
     *     targetEntity="App\Infrastructure\Symfony\Doctrine\Entity\InvoiceLine",
     *     mappedBy="invoice",
     *     cascade={"persist", "remove"}
     * )
     */
    private Collection $invoiceLines;

    /**
     * @var float
     * @ORM\Column(type="float", name="invoice_amount")
     */
    private float $amount;

    public function __construct()
    {
        $this->invoiceLines = new ArrayCollection();
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
     * @return string|null
     */
    public function getFilePath(): ?string
    {
        return $this->invoiceFilePath;
    }

    /**
     * @param string|null $filePath
     */
    public function setFilePath(?string $filePath): void
    {
        $this->invoiceFilePath = $filePath;
    }

    /**
     * @return BillingAddress
     */
    public function getBillingAddress(): BillingAddress
    {
        return $this->billingAddress;
    }

    /**
     * @param BillingAddress $billingAddress
     */
    public function setBillingAddress(BillingAddress $billingAddress): void
    {
        $this->billingAddress = $billingAddress;
    }

    /**
     * @return SellerAddress
     */
    public function getSellerAddress(): SellerAddress
    {
        return $this->sellerAddress;
    }

    /**
     * @param SellerAddress $sellerAddress
     */
    public function setSellerAddress(SellerAddress $sellerAddress): void
    {
        $this->sellerAddress = $sellerAddress;
    }

    /**
     * @return Collection
     */
    public function getInvoiceLines(): Collection
    {
        return $this->invoiceLines;
    }

    /**
     * @param InvoiceLine $invoiceLine
     * @return Invoice
     */
    public function addInvoiceLine(InvoiceLine $invoiceLine): self
    {
        if (!$this->invoiceLines->contains($invoiceLine)) {
            $this->invoiceLines->add($invoiceLine);
        }
        return $this;
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
}
