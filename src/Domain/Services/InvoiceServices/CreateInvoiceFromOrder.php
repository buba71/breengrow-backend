<?php

declare(strict_types=1);

namespace App\Domain\Services\InvoiceServices;

use App\Domain\Model\Invoice\Invoice;
use App\Domain\Model\Invoice\InvoiceNumber;
use App\Domain\Model\Order\Order;
use App\Domain\Repository\ConsumerRepository;
use App\Domain\Repository\GrowerRepository;
use App\Domain\Repository\InvoiceRepository;
use App\Domain\Services\ExportDomain;
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
     * @var ExportDomain
     */
    private ExportDomain $pdfGenerator;

    /**
     * @var InvoiceRepository
     */
    private InvoiceRepository $invoiceRepository;

    /**
     * CreateInvoiceFromOrder constructor.
     * @param ConsumerRepository $consumerRepository
     * @param GrowerRepository $growerRepository
     * @param InvoiceRepository $invoiceRepository
     * @param ExportDomain $exportDomain
     */
    public function __construct(
        ConsumerRepository $consumerRepository,
        GrowerRepository $growerRepository,
        InvoiceRepository $invoiceRepository,
        ExportDomain $exportDomain
    ) {
        $this->consumerRepository = $consumerRepository;
        $this->growerRepository = $growerRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->pdfGenerator = $exportDomain;
    }

    /**
     * @param Order $order
     * @return string
     */
    public function execute(Order $order): string
    {
        $billingAddress = $this->consumerRepository->getBillingAddress($order->getConsumerId());

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

        // Create the invoice file or throw an exception if already exist.
        try {
            $pdfFileName = $this->pdfGenerator->export($invoice);
            $this->invoiceRepository->addInvoice($invoice);

            return $pdfFileName;
        } catch (\Exception $exception) {
            return $exception->getMessage() . $exception->getPrevious()->getMessage();
        }
    }
}
