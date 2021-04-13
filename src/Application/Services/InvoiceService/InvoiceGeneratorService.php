<?php

declare(strict_types=1);

namespace App\Application\Services\InvoiceService;

use App\Domain\Model\Order\Events\OrderWasPlaced;
use App\Domain\Repository\OrderRepository;
use App\Domain\Services\ExportDomain;
use App\Domain\Services\InvoiceServices\CreateInvoiceFromOrder;

/**
 * Class InvoiceGeneratorService
 * @package App\Application\Services\InvoiceGeneratorService
 * Need to be rename to invoiceGeneratorService
 */
final class InvoiceGeneratorService
{
    /**
     * @var CreateInvoiceFromOrder
     */
    private CreateInvoiceFromOrder $domainService;

    /**
     * @var OrderRepository
     */
    private OrderRepository $orderRepository;

    private ExportDomain $pdfGenerator;

    /**
     * InvoiceGeneratorService constructor.
     * @param CreateInvoiceFromOrder $domainService
     * @param ExportDomain $exportDomain
     * @param OrderRepository $orderRepository
     */
    public function __construct(
        CreateInvoiceFromOrder $domainService,
        ExportDomain $exportDomain,
        OrderRepository $orderRepository
    ) {
        $this->domainService = $domainService;
        $this->orderRepository = $orderRepository;
        $this->pdfGenerator = $exportDomain;
    }

    /**
     * @param OrderWasPlaced $orderWasPlaced
     * OrderWasPlaced Event handler
     * This service create an invoice from order placed and generate the related invoice pdf file.
     * @return string
     */
    public function __invoke(OrderWasPlaced $orderWasPlaced): string
    {
        $order = $this->orderRepository->getOrderById($orderWasPlaced->getAggregateId());

        // Generate invoice and associate order with invoice created through event.
        $invoice = $this->domainService->execute($order);
        $order->joinInvoice($invoice);

        $this->orderRepository->update($order);

        try {
            // return invoice file name.
            return $this->pdfGenerator->export($invoice);
        } catch (\Exception $exception) {
            return $exception->getMessage() . $exception->getPrevious()->getMessage();
        }
    }
}
