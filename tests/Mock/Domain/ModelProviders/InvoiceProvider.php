<?php

declare(strict_types=1);

namespace App\Tests\Mock\Domain\ModelProviders;

use App\Domain\Model\Invoice\Invoice;
use App\Domain\Model\Invoice\InvoiceNumber;
use App\Tests\Mock\Domain\InMemoryConsumerRepository;
use App\Tests\Mock\Domain\InMemoryGrowerRepository;

final class InvoiceProvider
{
    /**
     * @param int $counter
     * @return Invoice
     */
    public static function provideInvoice(int $counter = 0): Invoice
    {
        $invoiceDate = new \DateTimeImmutable('2021-03-09');
        $invoiceNumber =  new InvoiceNumber((1000 + $counter), $invoiceDate);
        $growerRepository = new InMemoryGrowerRepository();
        $consumerRepository = new InMemoryConsumerRepository();

        $invoice =  new Invoice(
            $invoiceNumber,
            4.99,
            $consumerRepository->getBillingAddress('consumerId'),
            $growerRepository->getHiveAddress('hiveSiret')
        );
        $invoice->addInvoiceLine('description', 1, 4.99);

        return $invoice;
    }
}
