<?php

declare(strict_types=1);

namespace App\Domain\Services\InvoiceServices;

use App\Domain\Model\Consumer\BillingAddressNotFoundException;
use App\Domain\Model\Invoice\Invoice;
use App\Domain\Model\Invoice\InvoiceNumber;
use App\Domain\Model\Order\Order;
use App\Domain\Repository\ConsumerRepository;
use App\Domain\Repository\GrowerRepository;
use App\Domain\Repository\InvoiceRepository;
use App\SharedKernel\SystemClock\SystemClock;

final class CreateInvoiceFromOrder
{
    /**
     * @var ConsumerRepository
     */
    private ConsumerRepository $consumerRepository;

    /**
     * @var GrowerRepository
     */
    private GrowerRepository $growerRepository;

    /**
     * @var InvoiceRepository
     */
    private InvoiceRepository $invoiceRepository;

    /**
     * CreateInvoiceFromOrder constructor.
     * @param ConsumerRepository $consumerRepository
     * @param GrowerRepository $growerRepository
     * @param InvoiceRepository $invoiceRepository
     */
    public function __construct(
        ConsumerRepository $consumerRepository,
        GrowerRepository $growerRepository,
        InvoiceRepository $invoiceRepository
    ) {
        $this->consumerRepository = $consumerRepository;
        $this->growerRepository = $growerRepository;
        $this->invoiceRepository = $invoiceRepository;
    }

    /**
     * @param Order $order
     * @return Invoice
     */
    public function execute(Order $order)
    {
        $billingAddress = $this->consumerRepository->getBillingAddress($order->getConsumerId());

        if (!$billingAddress) {
            throw new BillingAddressNotFoundException();
        }

        $sellerAddress = $this->growerRepository->getHiveAddress($order->getHiveSiret());

        $invoice = new Invoice(
            InvoiceNumber::generate($this->invoiceRepository, new SystemClock()),
            $order->getAmount(),
            $billingAddress,
            $sellerAddress
        );

        foreach ($order->getOrderLines() as $orderLine) {
            $product = $this->growerRepository->getProductHiveById($orderLine->getProductId());
            $invoice->addInvoiceLine($product->getDescription(), $orderLine->getQuantity(), $orderLine->getLinePrice());
        }

        return $invoice;
    }
}
