<?php

declare(strict_types=1);

namespace App\Tests\Mock\Domain;

use App\Domain\Model\Invoice\Invoice;
use App\Domain\Repository\InvoiceRepository;

/**
 * Class InMemoryInvoiceRepository
 * @package App\Tests\Mock\Domain
 */
final class InMemoryInvoiceRepository implements InvoiceRepository
{
    /**
     * @var Invoice[]
     */
    private array $invoices = [];

    /**
     * @param Invoice $invoice
     * @return void
     */
    public function addInvoice(Invoice $invoice): void
    {
        $this->invoices[] = $invoice;
    }

    /**
     * @return Invoice[]
     */
    public function getAllInvoices(): array
    {
        return $this->invoices;
    }

    /**
     * @return Invoice|null
     */
    public function getLastRecord(): ?Invoice
    {
        $invoices = $this->invoices;
        return array_pop($invoices);
    }
}
