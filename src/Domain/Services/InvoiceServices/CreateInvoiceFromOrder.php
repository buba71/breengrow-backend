<?php

declare(strict_types=1);

namespace App\Domain\Services\InvoiceServices;

use App\Domain\Model\Invoice\Invoice;
use App\Domain\Model\Invoice\InvoiceNumber;
use App\Domain\Model\Order\Order;
use App\Domain\Repository\GrowerRepository;
use App\Domain\Repository\InvoiceRepository;
use App\Domain\Services\ExportDomain;
use App\SharedKernel\SystemClock\SystemClock;

final class CreateInvoiceFromOrder
{
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
     * @param GrowerRepository $growerRepository
     * @param InvoiceRepository $invoiceRepository
     * @param ExportDomain $exportDomain
     */
    public function __construct(
        GrowerRepository $growerRepository,
        InvoiceRepository $invoiceRepository,
        ExportDomain $exportDomain
    ) {
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
        $invoice = new Invoice(
            InvoiceNumber::generate($this->invoiceRepository, new SystemClock()),
            $order->getAmount()
        );

        foreach ($order->getOrderLines() as $orderLine) {
            $product = $this->growerRepository->getProductHiveById($orderLine->getProductId());
            $invoice->addInvoiceLine($product->getDescription(), $orderLine->getQuantity(), $orderLine->getLinePrice());
        }



        try {
            $pdfFileName = $this->pdfGenerator->export($invoice);
            $this->invoiceRepository->addInvoice($invoice);

            return $pdfFileName;
        } catch (\Exception $exception) {
            return $exception->getMessage() . $exception->getPrevious()->getMessage();
        }
    }
}
