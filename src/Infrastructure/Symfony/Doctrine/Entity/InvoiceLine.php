<?php


namespace App\Infrastructure\Symfony\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class InvoiceLine
 * @package App\Infrastructure\Symfony\Doctrine\Entity
 * @ORM\Entity()
 */
class InvoiceLine
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", name="id")
     */
    private int $id;

    /**
     * @var Invoice
     * @ORM\ManyToOne(
     *     targetEntity="App\Infrastructure\Symfony\Doctrine\Entity\Invoice",
     *      inversedBy="invoiceLines"
     * )
     * @ORM\JoinColumn(name="invoice_number", referencedColumnName="invoice_number")
     */
    private Invoice $invoice;

    /**
     * @var string
     * @ORM\Column(type="string", name="product_description")
     */
    private string $productDescription;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private int $quantity;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private float $linePrice;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Invoice
     */
    public function getInvoice(): Invoice
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
    public function getLinePrice(): float
    {
        return $this->linePrice;
    }

    /**
     * @param float $linePrice
     */
    public function setLinePrice(float $linePrice): void
    {
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
     * @param string $productDescription
     */
    public function setProductDescription(string $productDescription): void
    {
        $this->productDescription = $productDescription;
    }
}
