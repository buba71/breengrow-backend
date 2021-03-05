<?php

declare(strict_types=1);

namespace App\Domain\Services\InvoiceServices;

use App\Domain\Model\Invoice\Invoice;
use App\Domain\Model\Invoice\InvoiceNumber;
use App\Domain\Model\Order\Order;
use App\Domain\Repository\GrowerRepository;
use App\Domain\Repository\InvoiceRepository;
use App\SharedKernel\SystemClock\SystemClock;

final class CreateInvoiceFromOrder
{
    private GrowerRepository $growerRepository;
    /**
     * @var InvoiceNumberGenerator
     */
    private InvoiceNumberGenerator $numberGenerator;

    /**
     * @var InvoiceRepository
     */
    private InvoiceRepository $invoiceRepository;

    /**
     * CreateInvoiceFromOrder constructor.
     * @param GrowerRepository $growerRepository
     * @param InvoiceRepository $invoiceRepository
     */
    public function __construct(
        GrowerRepository $growerRepository,
        InvoiceRepository $invoiceRepository
    ) {
        $this->growerRepository = $growerRepository;
        $this->invoiceRepository = $invoiceRepository;
    }

    /**
     * @param Order $order
     * @return Invoice
     */
    public function execute(Order $order)
    {
        $invoice = new Invoice(
            InvoiceNumber::generate($this->invoiceRepository, new SystemClock()),
            $order->getAmount()
        );

        foreach ($order->getOrderLines() as $orderLine) {
            $product = $this->growerRepository->getProductHiveById($orderLine->getProductId());
            $invoice->addInvoiceLine($product->getDescription(), $orderLine->getQuantity(), $orderLine->getLinePrice());
        }

        $this->invoiceRepository->addInvoice($invoice);
        return $invoice;
    }
}
