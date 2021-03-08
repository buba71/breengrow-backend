<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Invoice\Invoice;

interface InvoiceRepository
{
    /**
     * @param Invoice $invoice
     * @return mixed
     */
    public function addInvoice(Invoice $invoice);

    /**
     * @return Invoice[]
     */
    public function getAllInvoices(): array;

    /**
     * @return Invoice|null
     */
    public function getLastRecord(): ?Invoice;
}
